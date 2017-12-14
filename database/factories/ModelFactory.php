<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Carbon\Carbon;

$factory->define(App\Domains\Vouchers\Voucher::class, function (Faker\Generator $faker) {
    return [
        'end_date' => Carbon::now()->addDays(2),
    ];
});

$factory->define(App\Domains\Recipients\Recipient::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(App\Domains\Offers\Offer::class, function (Faker\Generator $faker) {
    $number = $faker->randomFloat(2, 0, 100);
    if (ceil($number) >= 100) {
        $number = 100.;
    }
    return [
        'name' => $faker->name,
        'discount' => $number
    ];
});
