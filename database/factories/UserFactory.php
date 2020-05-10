<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Profile;
use App\Article;
use App\Tag;
use App\Role;
use App\Country;
use App\Comment;

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->biasedNumberBetween($min = 1, $max = 20,
        $function = 'sqrt'),
        'country_id' => $faker->randomDigit,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});


$factory->define(Article::class, function (Faker $faker){
    return[
        'user_id' => User::all()->random()->id,
        'title' => $faker->sentence,
        'body'  => $faker->paragraph(random_int(3,5))
    ];
});


$factory->define(Profile::class, function (Faker $faker){
    return[
        'user_id' => User::all()->random()->id,
        'city' => $faker->city,
        'about' => $faker->paragraph(random_int(3,5))
    ];
});

$factory->define(Tag::class, function(Faker $faker){
    return [
        'tag' => $faker->word
    ];
});

$factory->define(Role::class, function(Faker $faker){
    return [
        'name' => $faker->word
    ];
});


$factory->define(Country::class, function(Faker $faker){
    return [
        'name' => $faker->word
    ];
});


$factory->define(App\Comment::class, function(Faker $faker){
    return [
        'user_id' => $faker->biasedNumberBetween($min = 1, $max = 10, $function = 'sqrt'),
        'body' => $faker->paragraph(random_int(3,5)),
        'commentable_id' => $faker->randomDigit,
        'commentable_type' => function(){
            $input = ['App\Article', 'App\Profile'];
            $model = $input[mt_rand(0, count($input) -1)];
            return $model;
        }
    ];
});


