<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'user_id'=>\App\User::all()->pluck('id')->random(),
        'title'=>rtrim($faker->sentence(rand(3,5)),'.'),
        'body'=>$faker->paragraph(rand(3,8),true),
    ];
});
