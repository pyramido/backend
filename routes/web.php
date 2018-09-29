<?php
Route::get('/', function () {
    return 'Nothing to see here.';
});

Route::group(['prefix' => 'deploy'], function () {
    Route::get('/', function () {
        echo '<form method="post" action="/deploy/gitlab">' .
            csrf_field() .
            '<input name="token" type="password" /><button type="submit">Submit</button></form>';
        return;
    });

    Route::post('/gitlab', function () {
        Log::channel('deploy')->info("Got deployment request from {$_SERVER['REMOTE_ADDR']}");

        error_reporting(-1);

        $client_token = isset($_SERVER['HTTP_X_GITLAB_TOKEN'])
            ? $_SERVER['HTTP_X_GITLAB_TOKEN']
            : false;
        $client_token = $client_token ? $client_token : request('token');

        if (
            $client_token &&
            config('pyramido.gitlab_deploy_token') &&
            $client_token == config('pyramido.gitlab_deploy_token')
        ) {
            Log::channel('deploy')->info("Token OK. Starting deployment.");

            ignore_user_abort(true);
            set_time_limit(0);

            ob_start(); // Buffer all upcoming output...
            echo "Deploying in background. You'll receive an email once it's done.";
            header("HTTP/1.1 200 OK");
            header("Connection: close");
            header("Content-Length: " . ob_get_length());
            ob_end_flush();

            if (ob_get_level() > 0) {
                ob_flush();
            }

            flush();

            if (session_id()) {
                session_write_close();
            }

            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }

            chdir(env('DEPLOY_PATH', base_path()));

            putenv('PATH=');
            putenv('HOME=/home/pyramido');

            // The commands
            $commands = array(
                'echo $PATH',
                'echo $PWD',
                'whoami',
                '/usr/bin/git pull',
                '/usr/bin/git status',
                '/opt/cpanel/composer/bin/composer install',
                '/opt/cpanel/composer/bin/composer dump-autoload',
                '/usr/local/bin/php artisan migrate',
                '/usr/local/bin/php artisan config:cache'
            );

            // Run the commands for output
            echo '<pre>';
            $output = '';
            foreach ($commands as $command) {
                // Run it
                $tmp = shell_exec($command . ' 2>&1');
                // Output
                $currentOutput = "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
                $currentOutput .= htmlentities(trim($tmp)) . "\n";
                $output .= $currentOutput;
                echo $currentOutput;
            }

            echo '</pre>';

            Log::channel('deploy')->info("Deployment done. Sending email.");

            Mail::to('keven@nevek.co')->send(new \App\Mail\DeployMail($output));
        } else {
            Log::channel('deploy')->error("Invalid token, got {$client_token}");
            return response('Invalid request', 403);
        }
    });
});
