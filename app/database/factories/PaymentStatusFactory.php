<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\PaymentStatus;
use Faker\Generator as Faker;

$factory->define(PaymentStatus::class, function (Faker $faker) {
    return [
        'code'=>$faker->word,
        'label'=>$faker->word,
        'description'=>$faker->sentences
    ];
});
