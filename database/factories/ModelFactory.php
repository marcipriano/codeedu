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

$factory->define(App\Entities\OAuthClient::class, function (Faker\Generator $faker) {
    return [
        'id' => bcrypt(str_random(10)),
        'name' => $faker->name,
        'secret' => bcrypt(str_random(10))
    ];
});

$factory->define(App\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Entities\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});

$factory->define(App\Entities\Project::class, function (Faker\Generator $faker) {
    return [
        'owner_id' => rand(1, 11),
        'client_id' => rand(1, 10),
        'name' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description' => $faker->sentence,
        'progress' => rand(1, 100),
        'status' => rand(1, 3),
        'due_date' => $faker->dateTime('now'),
    ];
});

$factory->define(App\Entities\ProjectNote::class, function (Faker\Generator $faker) {
    return [
        'project_id' => rand(1, 10),
        'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'note' => $faker->paragraph,
    ];
});

$factory->define(App\Entities\ProjectTask::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'project_id' => rand(1, 10),
        'start_date' => $faker->dateTime('now'),
        'due_date' => $faker->dateTime('+5 week'),
        'status' => rand(1, 3),
    ];
});

$factory->define(App\Entities\ProjectMember::class, function (Faker\Generator $faker) {
    return [
        'project_id' => rand(1, 10),
        'member_id' => rand(1, 10),
    ];
});