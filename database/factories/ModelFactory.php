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

function randDate()
{
    return \Carbon\Carbon::now()
        ->subDays(rand(1, 100))
        ->subHours(rand(1, 23))
        ->subMinutes(rand(1, 60));
}

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    $createdAt = randDate();

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => app('hash')->make(123456),
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});

$factory->define(App\Models\Agent::class, function (Faker\Generator $faker) {
    $createdAt = randDate();

    return [
        'username' =>$faker->safeEmail,
        'name' => $faker->userName,
        'id_card_number' => $faker->phoneNumber,
        'mobile' => $faker->phoneNumber,
        'province' => $faker->city,
        'city' => $faker->city,
        'password' => app('hash')->make(123456),
/*        'created_at' => $createdAt,
        'updated_at' => $createdAt,*/
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    $userIds = App\Models\User::pluck('id')->toArray();
    $createdAt = randDate();

    return [
        'user_id' => $faker->randomElement($userIds),
        'title' => $faker->sentence(),
        'content' => $faker->text,
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});

$factory->define(App\Models\Comment::class, function (Faker\Generator $faker) {
    $userIds = App\Models\User::pluck('id')->toArray();
    $postIds = App\Models\Post::pluck('id')->toArray();
    $createdAt = randDate();

    return [
        'user_id' => $faker->randomElement($userIds),
        'post_id' => $faker->randomElement($postIds),
        'content' => $faker->text,
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});
