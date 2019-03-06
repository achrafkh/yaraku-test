<?php

use App\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(rand(5, 10), $variableNbWords = true),
        'author' => $faker->name,
    ];
});
