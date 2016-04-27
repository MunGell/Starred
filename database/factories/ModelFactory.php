<?php

$factory->define(Starred\User::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->unique()->randomDigit,
        'login' => $faker->name,
        'avatar' => $faker->imageUrl(),
    ];
});

$factory->define(Starred\Token::class, function (Faker\Generator $faker) {
    return [
        'token' => str_random(10),
        'auth' => str_random(20)
    ];
});

$factory->define(Starred\Tag::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
    ];
});

$factory->define(Starred\Repository::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->numberBetween(1,100),
        'name' => $faker->slug(10),
        'full_name' => $faker->slug(10),
        'url' => $faker->url,
        'description' => $faker->text(100),
    ];
});
