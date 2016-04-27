<?php

$factory->define(Starred\User::class, function (Faker\Generator $faker) {
    return [
        'login' => $faker->name,
        'avatar' => $faker->imageUrl(),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Starred\Token::class, function (Faker\Generator $faker) {
    return [
        'token' => str_random(10),
        'auth' => str_random(20)
    ];
});
