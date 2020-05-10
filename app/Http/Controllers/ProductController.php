<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\DeliveryAddress;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrdersProduct;
use Auth;
use Session;
use Image;
use DB;
use Paystack;

class ProductController extends Controller
{
    public function addProduct(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['category_id'])){
            
            return redirect()->back()->with('flash_message_error','Choose a Category');
            
        }
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name =  $data['product_name'];
            $product->product_code =  $data['product_code'];
            $product->product_color =  $data['product_color'];
            $product->product_color =  $data['product_color'];

            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else{
                $product->description = '';
            }
            if(!empty($data['care'])){
                $product->care = $data['care'];
            }else{
                $product->care = '';
            }
            if(!empty($data['status'])){
                $status = '0';
            }else{
                $status  = '1';
            }

            if(!empty($data['feature_item'])){
                $feature_item = '0';
            }else{
                $feature_item = '1';
            }

            $product->price =  $data['price'];
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path =  'images/backend_images/products/small/'.$filename;
                    // Resize Images

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    // store image name
                    $product->image = $filename;
                }
            }

            $product->status = $status;
            $product->feature_item = $feature_item;

            $product->save();
            return redirect()->back()->with('flash_message_success','Product has been added');
           
        }
        
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' selected disabled>select</option>";
        foreach($categories as $cat){
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();

            foreach ($sub_categories as $sub_cat){
                $categories_dropdown .= "<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }

      
        return view('admin.products.add-product', compact('categories','categories_dropdown'));
    }



    public function viewProducts(){
        $products = Product::orderBy('id', 'DESC')->get();
        foreach($products as $key => $val){
        $category_name = Category::where(['id'=>$val->category_id])->first();
        $products[$key]->category_name = $category_name->name;
        }
        return view('admin.products.view-products', compact('products','category_name'));
    }



    public function editProduct(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();

            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path =  'images/backend_images/products/small/'.$filename;
                    // Resize Images

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    
                }
            }else if(!empty($data['current_image'])){
                $filename = $data['current_image'];
            }else{
                $filename = '';
            }

            if(empty($data['description'])){
                $data['description'] = '';
            }

            if(empty($data['care'])){
                $data['care'] = '';
            }

            if(empty($data['status'])){
                $status = '0';
            } else{
                $status = '1';
            }

            if(!empty($data['feature_item'])){
                $feature_item = '0';
            }else{
                $feature_item = '1';
            }

        

            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
            'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'care'=>$data['care'],'description'=>$data['description'],
             'price'=>$data['price'], 'status'=>$status, 'feature_item'=>$feature_item, 'image'=>$filename]);

            return redirect()->back()->with('flash_message_success', 'Product has been updated succesfully!');
            


        }




        // Get Product Details start //
		$productDetails = Product::where(['id'=>$id])->first();
		// Get Product Details End //

		// Categories drop down start //
		$categories = Category::where(['parent_id' => 0])->get();

		$categories_dropdown = "<option value='' disabled>Select</option>";
		foreach($categories as $cat){
			if($cat->id==$productDetails->category_id){
				$selected = "selected";
			}else{
				$selected = "";
			}
			$categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
			$sub_categories = Category::where(['parent_id' => $cat->id])->get();
			foreach($sub_categories as $sub_cat){
				if($sub_cat->id==$productDetails->category_id){
					$selected = "selected";
				}else{
					$selected = "";
				}
				$categories_dropdown .= "<option value='".$sub_cat->id."' ".$selected.">&nbsp;&nbsp;--&nbsp;".$sub_cat->name."</option>";	
			}	
		}
		// Categories drop down end //

		return view('admin.products.edit_product')->with(compact('productDetails','categories_dropdown'));
    }


    public function deleteProductImage($id = null){
        $productImage = Product::where(['id' => $id])->first();

        // Get Product Image Paths
        $large_image_path = "images/backend_images/products/large/";
        $medium_image_path = "images/backend_images/products/medium/";
        $small_image_path = "images/backend_images/products/small/";

        // Delete large images
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
 
         // Delete large images
         if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

         // Delete large images
         if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        

        Product::where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success', 'Product image has been deleted succesfuly!');
    }


    public function deleteProduct($id = null){
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product hhas been dleted succesfully');
    }


    public function addAttributes(Request $request, $id = null){
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
        if($request->isMethod('post')){
            $data = $request->all();

            foreach($data['sku'] as $key => $val){
                if(!empty($val)){
                    // SKU Check
                    $attrCountSKU = ProductsAttribute::where('sku', $val)->count();
                    if($attrCountSKU>0){
                        return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'SKU already exists! please add another sku');
                    }

                    // prevent duplicate size check
                    $attrCountSizes = ProductsAttribute::where(['product_id'=>$id, 'size'=>$data['size'][$key]])->count();

                    if($attrCountSizes>0){
                        return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'Size already exists! please add another Size');
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                    

                }
            }

            return redirect('admin/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes added successfully');


        }
        return view('admin.products.add_attributes', compact('productDetails'));
    }


    public function deleteAttribute($id = null){
        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Attribute hhas been dleted succesfully');
    }

    public function products($url=null){
        // 404 page
        $countCategory = Category::where(['url'=>$url])->count();
        if($countCategory==0){
            abort(404);
        }

        $categories = Category::with('categories')->where(['parent_id'=>1])->get();

        $categoryDetails = Category::where(['url' => $url])->first();

        if($categoryDetails->parent_id==1){
            $subCategories = Category::where(['parent_id'=>$categoryDetails->id])->get();

            foreach($subCategories as $subcat){
                $cat_ids[] = $subcat->id;
                
            }
            $productsAll = Product::whereIn('category_id', $cat_ids)->where('status',1)->get();
            
        }else{
            $productsAll = Product::where(['category_id' => $categoryDetails->id])->get();

        }

        return view('products.listing')->with(compact('productsAll','categories','categoryDetails','cat_ids'));
    }

    public function product($id = null){
        // show 404 page if product is disabled
        $productsCount = Product::where(['id'=>$id, 'status'=>1])->count();
        if($productsCount == 0){
           abort(404); 
        }
        // get product details
        $productDetails = Product::with('attributes')->where('id',$id)->first();

        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        $relatedProducts = Product::where('id', '!=', $id)->where(['category_id'=>$productDetails->category_id])->get();

        // foreach($relatedProducts->chunk(3) as $chunk){
        //     foreach($chunk as $item){
        //         echo $item; echo "<br>";
        //     }
        //     echo "<br><br><br>";
        // }
        $productAltImages = ProductsImage::where('product_id', $id)->get();
        $productAltImages = json_decode(json_encode($productAltImages));


        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');


        // echo "<pre>", print_r($productAltImages); die;

        return view('products.detail')->with(compact('productDetails','categories','productAltImages',
        'total_stock','relatedProducts'));


        // get produc alternate images'
    }

    public function getProductPrice(Request $request){
        $data = $request->all();

        $proArr = explode("-",$data['idSize']);

        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();

        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;

    }

    public function addImages(Request $request, $id=null){
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();

        // $categoryDetails = Category::where(['id'=>$productDetails->category_id])->first();
        // $category_name = $categoryDetails->name;

        if($request->isMethod('post')){
            $data = $request->all();
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                foreach($files as $file){
                    // Upload Images after Resize
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large'.'/'.$fileName;
                    $medium_image_path = 'images/backend_images/products/medium'.'/'.$fileName;  
                    $small_image_path = 'images/backend_images/products/small'.'/'.$fileName;  
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);
                    $image->image = $fileName;  
                    $image->product_id = $data['product_id'];
                    $image->save();
                }   
            }

            return redirect('admin/add-images/'.$id)->with('flash_message_success', 'Product Images has been added successfully');

        }


        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
   
        $productsImg = ProductsImage::where(['product_id' => $id])->get();
        $productsImg = json_decode(json_encode($productsImg));

        $productsImages = "";
        foreach($productsImg as $img){
        $productsImages .= "<tr>
          <td>".$img->id."</td>
          <td>".$img->product_id."</td>
          <td><img width='150px' src='/images/backend_images/products/small/$img->image'></td>
          <td><a rel='$img->id' rel1='delete-alt-image' href='javascript:'  class='btn btn-danger btn-mini deleteRecord' title='Delete Product Image'>Delete</a>
          </td>
        </tr>";
        }
        

        return view('admin.products.add_images')->with(compact('productDetails','productsImages'));
    }

    public function deleteAltImage($id = null){
        $productImage = ProductsImage::where(['id' => $id])->first();

        // Get Product Image Paths
        $large_image_path = "images/backend_images/products/large/";
        $medium_image_path = "images/backend_images/products/medium/";
        $small_image_path = "images/backend_images/products/small/";

        // Delete large images
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
 
         // Delete large images
         if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

         // Delete large images
         if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        

        ProductsImage::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product alternate image has been deleted succesfuly!');
    }

    public function editAttributes(Request $request,$id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data['idAttr'] as $key => $attr){
               ProductsAttribute::where(['id'=>$data['idAttr'][$key]])->
               update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);    
            }

            return redirect()->back()->with('flash_message_success', 'Products Attributes updated successfully');
        }
    }

    public function addtocart(Request $request){

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
        /*echo "<pre>"; print_r($data); die;*/

        // Check Product Stock is available or not
        $product_size = explode("-",$data['size']);
        $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$product_size[1]])->first();

        if($getProductStock->stock<$data['quantity']){
            return redirect()->back()->with('flash_message_error','Required Quantity is not available!');
        }

        if(empty(Auth::user()->email)){
            $data['user_email'] = '';    
        }else{
            $data['user_email'] = Auth::user()->email;
        }

        $session_id = Session::get('session_id');
        if(!isset($session_id)){
            $session_id = str_random(40);
            Session::put('session_id',$session_id);
        }

        $sizeIDArr = explode('-',$data['size']);
        $product_size = $sizeIDArr[1];

        if(empty(Auth::check())){
            $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_color' => $data['product_color'],'size' => $product_size,'session_id' => $session_id])->count();
            if($countProducts>0){
                return redirect()->back()->with('flash_message_error','Product already exist in Cart!');
            }
        }else{
            $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_color' => $data['product_color'],'size' => $product_size,'user_email' => $data['user_email']])->count();
            if($countProducts>0){
                return redirect()->back()->with('flash_message_error','Product already exist in Cart!');
            }    
        }
        

        $getSKU = ProductsAttribute::select('sku')->where(['product_id' => $data['product_id'], 'size' => $product_size])->first();
                
        DB::table('cart')
        ->insert(['product_id' => $data['product_id'],'product_name' => $data['product_name'],
            'product_code' => $getSKU['sku'],'product_color' => $data['product_color'],
            'price' => $data['price'],'size' => $product_size,'quantity' => $data['quantity'],'user_email' => $data['user_email'],'session_id' => $session_id]);

        return redirect('cart')->with('flash_message_success','Product has been added in Cart!');
    }    

    public function cart(){
        if(Auth::check()){
            $user_email = Auth::user()->email;
            $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
        }else{
            $session_id = Session::get('session_id');
            $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();    
        }

        foreach($userCart as $key => $product){
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }

        return view('products.cart', compact('userCart'));
    }


    public function deleteCartProduct($id = null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
       DB::table('cart')->where('id',$id)->delete();

       return redirect('cart')->with('flash_message_success', 'Product has been removed succesfully');

    }

    public function applyCoupon(Request $request){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
 
        $couponCount = Coupon::where('coupon_code', $data['coupon_code'])->count();

        if($couponCount == 0){
            return redirect()->back()->with('flash_message_error', 'Coupon is not valid');
        }else{
            //  PERFORM checks for coupon if its active or not

            //  get coupon details
            $couponDetails = Coupon::where('coupon_code', $data['coupon_code'])->first();

            // if coupon is Inactive
            if($couponDetails->status==0){
                return redirect()->back()->with('flash_message_error', 'This coupon is no longer active');
            }
            

            // If coupon is Expired 
            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('y-m-d');

            if($expiry_date < $current_date){
                return redirect()->back()->with('flash_message_error', 'This coupon is has expired');
            }
            
            // Get Cart Total Amount
            $session_id = Session::get('session_id');



            if(Auth::check()){
                $user_email = Auth::user()->email;
                $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
            }else{
                $session_id = Session::get('session_id');
                $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();    
            }


            $total_amount = 0;

            foreach($userCart as $item){
                $total_amount = $total_amount + ($item->price * $item->quantity);
            }


            // check if amount type is fixed or percentage
           
            if($couponDetails->amount_type=="Fixed"){
                $couponAmount = $couponDetails->amount;
            }else{
                $couponAmount = $total_amount * ($couponDetails->amount/100);
            }

            //  Add Coupon Code & Amount in Session
            Session::put('CouponAmount', $couponAmount);
            Session::put('CouponCode', $data['coupon_code']);

            return redirect()->back()->with('flash_message_success', 'Coupon code succesfully applied. You are awaiting discount');

        }
    }


    public function updateCartQuantity($id=null, $quantity=null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $getCartDetails = DB::table('cart')->where('id', $id)->first();

        $getAttributeStock = ProductsAttribute::where('sku', $getCartDetails->product_code)->first();
        
        echo $getAttributeStock->stock;

        $updated_quantity = $getCartDetails->quantity+$quantity;
        if($getAttributeStock->stock >= $updated_quantity){
            DB::table('cart')->where('id', $id)->increment('quantity', $quantity);
        
            return redirect('cart')->with('flash_message_success', 'Product has been updated succesfully');
        }else{
            return redirect('cart')->with('flash_message_error', 'Product quantity is not available!');
        }

        

    }

    public function checkout(Request $request){
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $countries = Country::get();

        //Check if Shipping Address exists
        $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails = array();
        if($shippingCount>0){
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        }

        // Update cart table with user email
        $session_id = Session::get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            // Return to Checkout page if any of the field is empty
            if(empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) || empty($data['billing_state']) || empty($data['billing_country']) || empty($data['billing_postalcode']) || empty($data['billing_mobile']) || empty($data['shipping_name']) || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country']) || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])){
                    return redirect()->back()->with('flash_message_error','Please fill all fields to Checkout!');
            }

            // Update User details
            User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],'pincode'=>$data['billing_pincode'],'country'=>$data['billing_country'],'mobile'=>$data['billing_mobile']]);

            if($shippingCount>0){
                // Update Shipping Address
                DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'pincode'=>$data['shipping_pincode'],'country'=>$data['shipping_country'],'mobile'=>$data['shipping_mobile']]);
            }else{
                // Add New Shipping Address
                $shipping = new DeliveryAddress;
                $shipping->user_id = $user_id;
                $shipping->user_email = $user_email;
                $shipping->name = $data['name'];
                $shipping->address = $data['shipping_address'];
                $shipping->city = $data['shipping_city'];
                $shipping->state = $data['shipping_state'];
                $shipping->postal_code = $data['shipping_postalcode'];
                $shipping->country = $data['shipping_country'];
                $shipping->mobile = $data['shipping_mobile'];
                $shipping->save();
            }

          

            return redirect()->action('ProductController@orderReview');
        }

        return view('products.checkout')->with(compact('userDetails','countries','shippingDetails','meta_title'));
    }

    public function orderReview(){
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id', $user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
        
        foreach($userCart as $key => $product){
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }

        return view('products.order_review', compact('userDetails','shippingDetails','userCart'));
    }

    public function placeOrder(Request $request){
         if($request->isMethod('post')){
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
           
            //  get shipping address of user
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();
            


            if  (empty($data['coupon_code'])){
                $data['coupon_code'] = '';
            }
            if  (empty($data['coupon_amount'])){
                $data['coupon_amount'] = '';
            }

            $order =  new Order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->postalcode = $shippingDetails->postalcode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $data['coupon_code'];
            $order->coupon_amount = $data['coupon_amount'];
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->grand_total = $data['grand_total'];
            $order->save();


            $order_id = DB::getPdo()->lastInsertId();

            $cartProducts = DB::table('cart')->where(['user_email'=>$user_email])->get();

            foreach($cartProducts as $pro){
                $cartPro = new OrdersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_code = $pro->product_code;
                $cartPro->product_name = $pro->product_name;
                $cartPro->product_color = $pro->product_color;
                $cartPro->product_size = $pro->size; 
                $cartPro->product_price = $pro->price;
                $cartPro->product_qty = $pro->quantity;
                $cartPro->product_id = $pro->product_id;
                $cartPro->save();

            }

            Session::put('order_id', $order_id);
            Session::put('grand_total', $data['grand_total']);
            

            if($data['payment_method']=="COD"){

                $productDetails = Order::with('orders')->where('id',$order_id)->first();
                $productDetails = json_decode(json_encode($productDetails),true);
                /*echo "<pre>"; print_r($productDetails);*/ /*die;*/

                $userDetails = User::where('id',$user_id)->first();
                $userDetails = json_decode(json_encode($userDetails),true);
                /*echo "<pre>"; print_r($userDetails); die;*/
                /* Code for Order Email Start */
                $email = $user_email;
                $messageData = [
                    'email' => $email,
                    'name' => $shippingDetails->name,
                    'order_id' => $order_id,
                    'productDetails' => $productDetails,
                    'userDetails' => $userDetails
                ];
                Mail::send('emails.order',$messageData,function($message) use($email){
                    $message->to($email)->subject('Order Placed - Phoenix Website');    
                });
                /* Code for Order Email Ends */

                // COD - Redirect user to thanks page after saving order
                return redirect('/thanks');
            }else{
                // Paystack - Redirect user to paystack page after saving order
                return redirect('/stack');
            }
            

        }
    }

    public function thanks(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email', $user_email)->delete();
        return view('products.thanks');
    }

    public function paystack(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email', $user_email)->delete();
        return view('products.paystack');
    }

    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $orderDetails = Paystack::getPaymentData();

        
    }
   
    public function userOrders(){
        $user_id = Auth::user()->id;
        $orders = Order::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get();
        /*$orders = json_decode(json_encode($orders));
        echo "<pre>"; print_r($orders); die;*/
        return view('products.user_orders')->with(compact('orders'));
    }

    

    public function userOrderDetails($order_id){
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        /*echo "<pre>"; print_r($orderDetails); die;*/
        return view('products.user_order_details')->with(compact('orderDetails'));
    }
    
    public function viewOrders(){
        $orders = Order::with('orders')->orderBy('id','DESC')->get();
        

        return view('admin.orders.view_orders')->with(compact('orders'));
    }

    public function viewOrderDetails($order_id){
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();

    
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();

        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
    }


    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            return redirect()->back()->with('flash_message_success','Order Status has been updated successfully!');
        }
    }


    














}