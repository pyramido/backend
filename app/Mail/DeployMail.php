<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeployMail extends Mailable
{
    use Queueable, SerializesModels;

    public $output;

    public function __construct($output)
    {
        $this->output = $output;
    }

    public function build()
    {
        return $this->subject("New Auto Deploy on Pyramido Api")->view('emails.deploy');
    }
}
