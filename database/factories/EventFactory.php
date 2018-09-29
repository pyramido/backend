<?php
use Faker\Generator as Faker;

$factory->define(\App\Event::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'description' => $faker->paragraphs(rand(2, 5), true),
        'date' => $faker->dateTimeBetween('-30 days', '+60 days'),
        'author_id' => App\User::all()->random()->id,
        'contact_email' => $faker->boolean(60) ? $faker->safeEmail : null
    ];
});
