@extends('layouts.frontLayout.front_design')

@section('content')
<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
				<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							<div class="panel panel-default">
							<?php ?>
							@foreach($categories as $cat)
							@if($cat->status=="1")
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#{{ $cat->id }}">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											{{ $cat->name }}
										</a>
									</h4>

								</div>
							@endif
								<div id="{{ $cat->id }}" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
										@foreach($cat->categories as $subcat)
										@if($subcat->status=="1")
											<li><a href="{{ asset('/products/'.$subcat->url) }}">{{ $subcat->name }} </a></li>

										@endif
										</ul>
										@endforeach
									</div>
								</div>
								@endforeach
							</div>
						
						</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Brands</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<li><a href="#"> <span class="pull-right">(50)</span>Acne</a></li>
									<li><a href="#"> <span class="pull-right">(56)</span>Grüne Erde</a></li>
									<li><a href="#"> <span class="pull-right">(27)</span>Albiro</a></li>
									<li><a href="#"> <span class="pull-right">(32)</span>Ronhill</a></li>
									<li><a href="#"> <span class="pull-right">(5)</span>Oddmolly</a></li>
									<li><a href="#"> <span class="pull-right">(9)</span>Boudestijn</a></li>
									<li><a href="#"> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
								</ul>
							</div>
						</div><!--/brands_products-->
						
						<div class="price-range"><!--price-range-->
							<h2>Price Range</h2>
							<div class="well text-center">
								 <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
								 <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
							</div>
						</div><!--/price-range-->
						
						<div class="shipping text-center"><!--shipping-->
							<img src="{{ asset('images/frontend_images/home/shipping.jpg') }}" alt="" />
						</div><!--/shipping-->
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
						<div class="view-product">
								<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
								<a id="mainImgLarge" href="{{ asset('/images/backend_images/product/large/'.$productDetails->image) }}">
									<img style="width:300px" id="mainImg" src="{{ asset('/images/backend_images/products/medium/'.$productDetails->image) }}" alt="" />
								</a>
								</div>
							</div>



							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
									<div class="item active thumbnails">
												@foreach($productAltImages as $altimg)
													<a href="{{ asset('images/backend_images/products/medium/'.$altimg->image) }}" data-standard="{{ asset('images/backend_images/products/small/'.$altimg->image) }}">
										  				<img class="changeImage" style="width:80px; cursor:pointer" src="{{ asset('images/backend_images/products/small/'.$altimg->image) }}" alt="">
													</a>
												@endforeach
										</div>
									</div>								
							</div>

						</div>
						<div class="col-sm-7">
							<form name="addtocartForm" id="addtocartForm" method="post" action="{{ url('add-cart') }}">
							@csrf
							<input type="hidden" name="product_id" value="{{ $productDetails->id }}">
							<input type="hidden" name="product_name" value="{{ $productDetails->product_name }}">
							<input type="hidden" name="product_code" value="{{ $productDetails->product_code }}">
							<input type="hidden" name="product_color" value="{{ $productDetails->product_color}}">
							<input type="hidden" name="price" id="price" value="{{ $productDetails->price }}">

							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{ $productDetails->product_name }}</h2>
								<p>Code: {{ $productDetails->product_code }}</p>

								<p>					
								<select id="selSize" name="size" style="width:150px;">
											<option value="">Select</option>
											@foreach($productDetails->attributes as $sizes)
											<option value="{{ $productDetails->id }}-{{ $sizes->size }}">{{ $sizes->size }}</option>
											@endforeach
								</select>
								</p>

								

								<img src="images/product-details/rating.png" alt="" />
								<span>
									<span id="getPrice">NGN {{ $productDetails->price }}</span>
									<label>Quantity:</label>
									<input type="text" name="quantity" value="1" />
									 @if($total_stock>0)
									<button type="submit" class="btn btn-fefault cart" id="cartButton">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
									@endif
								</span>
								<p><b>Availability:</b><span id="Availability">@if($total_stock > 0)  In Stock  @else  out of stock  @endif</p></span>
								<p><b>Condition:</b> New</p>
								<p><b>Brand:</b> E-SHOPPER</p>
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
                            </form>
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#description" data-toggle="tab">Description</a></li>
								<li><a href="#care" data-toggle="tab">Material $ care</a></li>
								<li><a href="#delivery" data-toggle="tab">Delivery Options</a></li>
								<!-- <li class="active"><a href="#reviews" data-toggle="tab">Reviews (5)</a></li> -->
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="description" >
								<div class="col-sm-12">
                                    <p>{{ $productDetails->description }}</p>
								</div>
							</div>
							
							<div class="tab-pane fade" id="care" >
							<div class="col-sm-12">
                                    <p> <p>{{ $productDetails->care }}</p></p>
								</div>
							</div>
							
							<div class="tab-pane fade" id="delivery" >
							<div class="col-sm-12">
                                    <p>100% Original Products Cash on delivery</p>
								</div>
							</div>
							
							<!-- <div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
									<ul>
										<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
										<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
									</ul>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
									<p><b>Write Your Review</b></p>
									
									<form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
										<textarea name="" ></textarea>
										<b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
										<button type="button" class="btn btn-default pull-right">
											Submit
										</button>
									</form>
								</div>
							</div> -->
							
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<?php $count=1; ?>
								@foreach($relatedProducts->chunk(3) as $chunk)
							<div <?php if($count==1){?> class="Item active" <?php } else {?>
							       class="item" <?php } ?>>
									@foreach($chunk as $item)	
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img style="width:230px;" src="{{ asset('images/backend_images/products/small/'.$item->image) }}" alt="" />
													<h2>NGN {{ $item->price }}</h2>
													<p>{{ $item->product_name }}</p>
													<a href="{{ url('product/'.$item->id) }}"><button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
												</div>
											</div>
										</div>
							        </div>
									@endforeach
							</div>
								<?php $count++; ?>
								@endforeach
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>
	








@endsection