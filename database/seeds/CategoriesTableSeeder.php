<?php

use App\Models\Category;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;




class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::Create([
            'name'    => 'Dress',
            'description'  => 'This is the root category, don\'t delete this one',
            'parent_id'   => 0,
            'status'      => 1,
            'url'         => 'dress'
        ]);

        Category::Create([
            'name'    => 'Phones',
            'description'  => 'This is the root category, don\'t delete this one',
            'parent_id'   => 0,
            'status'      => 1,
            'url'         => 'root'
        ]);

        Category::Create([
            'name'    => 'Electronics',
            'description'  => 'This is the root category, don\'t delete this one',
            'parent_id'   => 0,
            'status'      => 1,
            'url'         => 'electronics'
        ]);


        // factory('App\Models\Category', 3)->create();
        // // we call the factory to create 10 fake categories
    }
}
