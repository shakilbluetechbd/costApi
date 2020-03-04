<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\income;
use Faker\Generator as Faker;

$factory->define(income::class, function (Faker $faker) {
    return [
        'name'=>$faker->word,
        'value'=>$faker->numberBetween(100,1000),
        'date'=>$faker->date,
        'details'=>$faker->paragraph,
        'user_id' => function(){
        	return App\User::all()->random();
        },
    ];
});
