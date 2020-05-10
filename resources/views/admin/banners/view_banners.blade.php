@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
<div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a><a href="#" class="current">Add Banner</a> </div>

   @include('flash_message')
    <h1>Banner </h1>
</div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Banners</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Banner ID</th>
                  <th>Banner Title</th>
                  <th>Link</th>
                 
           
                  <th>Image</th>
                  <th>Actions</th>

                </tr>
              </thead>
              <tbody>
               @foreach($banners as $banner)
                <tr class="gradeX">
                  <td>{{ $banner->id }}</td>
                  <td>{{ $banner->title }}
                  <td>{{ $banner->link }}</td>
                  
                  <td>
                  @if(!empty($banner->image))
                  <img src="{{ asset('/images/frontend_images/banners/'.$banner->image) }}" style="width:250px;">


               @endif 
                  </td>
                  <td class="center">
                  <a href="{{ url('/admin/edit-banner',$banner->id) }}" class="btn btn-primary btn-mini">Edit</a>

                  <a id="delbanner" rel="{{ $banner->id }}" rel1="delete-banner" href="javascript:"  class="btn btn-danger btn-mini deleteRecord">Delete</a>
                </tr>


                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



            




@endsection