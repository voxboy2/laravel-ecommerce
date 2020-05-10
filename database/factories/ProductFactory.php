<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class,function (Faker $faker) {
    return [
        'category_id' => 1,

        'product_name' => $faker->name,

        'product_code' => $faker->name,

        'product_color' => $faker->name,

        'description' => $faker->realText(100),

        'care' => $faker->realText(100),

        'price' => $faker->randomFloat,

        'image' => $faker->image('public/images/backend_images/products'),

        'status' => 1
        
    ];
});
