<?php
use Faker\Generator as Faker;

$factory->define(\App\Reward::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'description' => $faker->paragraphs(rand(1, 2), true),
        'event_id' => App\Event::all()->random()->id
    ];
});
