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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/*
 * Timetables Factory
 */
$factory->define(App\Models\Timetable::class, function(Faker\Generator $faker) {
    $amPm = rand(0,1);
    return[
        'day' 				=> rand(1,5), // 1 = lunes - 5 = viernes
        'turn' 				=> $amPm, // 0 = matutino - 1=vespertino
        'from' 				=> ($amPm == 0) ? '09:00' : '16:00',
        'until' 			=> ($amPm == 0) ? '12:00' : '19:00',
        'delta' 	        => (rand(0,1) == 0) ? '0:15' : '0:10',
        'professional_id'   => null,
    ];

});