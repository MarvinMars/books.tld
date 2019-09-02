<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'name' => strtoupper($faker->name),
        'isbn' => $faker->unique()->isbn10,
    ];
});
