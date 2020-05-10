<?php

use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'category_id' => 1,

            'product_name' => 'gucci',

            'product_code' => 'gucciikxkx0090ixm',

            'product_color' => 'black',

            'description' => 'lorem mmmann nnsn.,lorem mmmann nnsn,lorem mmmann nnsn
            lorem mmmann nnsn,lorem mmmann nnsn,lorem mmmann nnsn,lorem mmmann nnsn',

            'care' => 'lorem mmmann nnsn.,lorem mmmann nnsn,lorem mmmann nnsn
            lorem mmmann nnsn,lorem mmmann nnsn,lorem mmmann nnsn,lorem mmmann nnsn',

            'price' => 900000,

            'image' => 'gucci',

            'status' => '',

        ]);

        factory('App\Models\Product', 25)->create();
    }
}
