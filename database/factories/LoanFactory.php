<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\loan;
use Faker\Generator as Faker;

$factory->define(loan::class, function (Faker $faker) {
    return [
        'name'=>$faker->word,
        'value'=>$faker->numberBetween(100,1000),
        'date'=>$faker->date,
        'details'=>$faker->paragraph,
    ];
});
