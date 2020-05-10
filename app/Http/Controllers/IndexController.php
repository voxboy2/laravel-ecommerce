<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;

class IndexController extends Controller
{
    public function index(){

        // $productsAll = Product::get();

        $productsAll = Product::orderBy('ID', 'DESC')->where('status',1)->where('feature_item',1)->get();

        // $productsAll = Product::inRandomOrder()->where('status',1)->get();
        
        // $productsAll = Product::orderBy('id', 'DESC')->get();




        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        $banners = Banner::where('status', '1')->get();

        return view('index')->with(compact('productsAll', 'categories','banners'));
    }
}
