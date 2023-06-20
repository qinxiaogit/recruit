<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SuperAdmin;
use Faker\Generator as Faker;

$factory->define(SuperAdmin::class, function (Faker $faker) {

    return [
        'username' => $faker->word,
        'password' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
