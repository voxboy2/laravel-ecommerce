@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a><a href="#" class="current">Edit Banner</a> </div>

    @include('flash_message')
        
    <h1>Banner</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Banner</h5>
          </div>
          <div class="widget-content nopadding">
              
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/edit-banner/'.$bannerDetails->id) }}" name="edit_banner" id="edit_banner" novalidate="novalidate">
            @csrf

                <div class="control-group">
                <label class="control-label">Banner Image</label>
                <div class="controls">
                  <div class="uploader" id="uniform-undefined"><input name="image" id="image" type="file" size="19" style="opacity: 0;"><span class="filename">No file selected</span><span class="action">Choose File</span></div>
       
                  @if(!empty($bannerDetails->image))
                    <input type="hidden" name="current_image" value="{{ $bannerDetails->image }}"> 
                  @endif
                  
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Title</label>
                <div class="controls">
                <input type="text" name="title" id="title" value="{{ $bannerDetails->title }}">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Link</label>
                <div class="controls">
                <input type="text" name="link" id="link" value="{{ $bannerDetails->link }}">
                </div>
              </div>
             

              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1" @if($bannerDetails->status=="1") checked @endif>
                </div>
              </div>
              
              <div class="form-actions">
                <input type="submit" value="Edit banner" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection