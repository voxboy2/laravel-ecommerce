/*price range*/

$('#sl2').slider();

var RGBChange = function() {
  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
};	
	
/*scroll to top*/

$(document).ready(function(){
$(function () {
	$.scrollUp({
		scrollName: 'scrollUp', // Element ID
		scrollDistance: 300, // Distance from top/bottom before showing element (px)
		scrollFrom: 'top', // 'top' or 'bottom'
		scrollSpeed: 300, // Speed back to top (ms)
		easingType: 'linear', // Scroll to top easing (see http://easings.net/)
		animation: 'fade', // Fade, slide, none
		animationSpeed: 200, // Animation in speed (ms)
		scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
				//scrollTarget: false, // Set a custom target element for scrolling to the top
		scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
		scrollTitle: false, // Set a custom <a> title if required.
		scrollImg: false, // Set true to use image
		activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
		zIndex: 2147483647 // Z-Index for the overlay
	});
});
});

$(document).ready(function(){

// Change Price with Size
$("#selSize").change(function(){
	var idSize = $(this).val();
	if(idSize==""){
		return false;
	}
	$.ajax({
		type:'get',
		url:'/get-product-price',
		data:{idSize:idSize},
		success:function(resp){
			var arr = resp.split('#');
			$("#getPrice").html("NGN "+arr[0]);
			$("#price").val(arr[0]);
			if(arr[1]==0){
				$("#cartButton").hide();
				$("#Availability").text("Out Of Stock");
			}else{
				$("#cartButton").show();
				$("#Availability").text("In Stock");
			}
			
			
		},error:function(){
			alert("Error");
		}
	});
});

});

$(document).ready(function(){
// Change Image
$(".changeImage").click(function(){
	var image = $(this).attr('src');
	$("#mainImg").attr("src", image);
	/*$("#mainImgLarge").attr("href", image);*/

	// Instantiate EasyZoom instances
	var $easyzoom = $('.easyzoom').easyZoom();

	// Setup thumbnails example
	var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

	$('.thumbnails').on('click', 'a', function(e) {
		var $this = $(this);

		e.preventDefault();

		// Use EasyZoom's `swap` method
		api1.swap($this.data('standard'), $this.attr('href'));
	});

	// Setup toggles example
	var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

	$('.toggle').on('click', function() {
		var $this = $(this);

		if ($this.data("active") === true) {
			$this.text("Switch on").data("active", false);
			api2.teardown();
		} else {
			$this.text("Switch off").data("active", true);
			api2._init();
		}
	});

});
});

$().ready(function(){
   $('#registerForm').validate({
	   rules:{
		   name:{
			   required:true,
			   minlength:2,
			   accept: "[a-zA-Z]+"
		   },
		   password:{
			   required:true,
			   minlength:6
		   },
		   email:{
			   required:true,
			   email:true,
			   remote:"/check-email"

		   }
	   },
	   messages:{
		   name:{
			   required:"Please enter your First Name",
			   minlength: "Your Name must be atleast 2 characters long",
			   accept: "Your Name must contain letters only",
		   },
		   password:{
			   required:"Please Provide your Password",
			   minlength: "Your Password must be atleast 6 characters long",
			   
		   },
		   email:{
			   required: "Please enter your Email",
			   email: "Please enter valid Email",
			   remote: "A user with that email already exists!"
		   }
	   }
   });

   $('#loginForm').validate({
	rules:{
		email:{
			required:true,
			email:true,
		},
		password:{
			required:true,
			minlength:6
		},
	},
	messages:{
		email:{
			required: "Please enter your Email",
			email: "Please enter valid Email",
		},

		password:{
			required:"Please Provide your Password",
		
			
		},
	}
});

//    check current user password
   $('#current_pwd').keyup(function(){
	   var current_pwd = $(this).val();
	   $.ajax({
		   headers: {
			   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		   },
		   type:'get',
		   url:'/check-user-pwd',
		   data:{current_pwd:current_pwd},
		   success:function(resp){
			   if(resp=="false"){
				   $("#chkPwd").html("<font color='red'>Current Password is incorrect</font>");
			   }else if(resp=="true"){
				$("#chkPwd").html("<font color='green'>Current Password is correct</font>");
			   }
		   },error:function(){
               alert("Error");
		   }
	   });

   });

   $('#myPassword').passtrength({
	   minChars:4,
	   passwordToggle:true,
	   tooltip:true,
	   eyeImg : "/images/frontend_images/eye.svg"
   });

   $('#accountForm').validate({
	rules:{
		name:{
			required:true,
			minlength:2,
			accept: "[a-zA-Z]+"
		},
	},
	messages:{
		name:{
			required:"Please enter your Name",
			minlength: "Your Name must be atleast 2 characters long",
			accept: "Your Name must contain letters only",
		},
	}
});
	
//   copy billig address to shipping address
   $('#copyAddress').click(function(){
	   if(this.checked){
			$("#shipping_name").val($("#billing_name").val());z
			$("#shipping_address").val($("#billing_address").val());
			$("#shipping_city").val($("#billing_city").val());
			$("#shipping_state").val($("#billing_state").val());
			
			$("#shipping_postal_code").val($("#billing_postal_code").val());
            $("#shipping_mobile").val($("#billing_mobile").val());
            $("#shipping_country").val($("#billing_country").val());
	   }
	   else{
		$("#shipping_name").val('');
		$("#shipping_address").val('');
		$("#shipping_city").val('');
		$("#shipping_state").val('');
		$("#shipping_postal_code").val('');
		$("#shipping_mobile").val('');
		$("#shipping_country").val('');
	   }
   });


   

});


function selectPaymentMethod(){
	if($('#Paystack').is(':checked') || $('#COD').is(':checked')){

	}else{
		alert("Please select payment method");
		return false;
	}

}