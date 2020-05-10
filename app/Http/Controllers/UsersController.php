<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\VerifyUser;

use Auth;
use Session;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;



use Illuminate\Http\Request;

class UsersController extends Controller
{
     public function register(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();

            $usersCount = User::where('email',$data['email'])->count();

            if($usersCount>0){
                return redirect()->back()->with('flash_message_error', 'Email already exists!');
            }else {
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->save();
                 
                // create verfied user
               

                // send email
                // Send Confirmation Email
                $email = $data['email'];
                $messageData = ['email'=>$data['email'],'name'=>$data['name'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.confirmation',$messageData,function($message) use($email){
                    $message->to($email)->subject('Confirm your Phoenix Account');
                });

                return redirect()->back()->with('flash_message_success','Please confirm your email to activate your account!');

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    Session::put('frontSession',$data['email']);

                    if(!empty(Session::get('session_id'))){
                        $session_id = Session::get('session_id');
                        DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                    }

                    return redirect('/cart');
                }
    		}	
    	}
    }


    public function forgotPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            
            // echo "<pre>"; print_r($data); die;
            $userCount = User::where('email', $data['email'])->count();

            if($userCount == 0){
                return redirect()->back()->with('flash_message_error', 'This email does not exist');
            }

            // Get user Details
            $userDetails = User::where('email', $data['email'])->first();

            // Generate Random Password
            $random_password = str_random(8);

            // Encode/Secure Password
            $new_password = bcrypt($random_password);

            // Update Password
            User::where('email', $data['email'])->update(['password'=>$new_password]);

            // Send Forgot Password EMail
            $email = $data['email'];
            $name = $userDetails->name;
            $messageData = [
                'email'=>$email,
                'name'=>$name,
                'password'=>$random_password         
            ];
            Mail::send('emails.forgotpassword', $messageData, function($message)use($email){
                $message->to($email)->subject('New Password - Phoneix Website');
            });

            return redirect('login-register')->with('flash_message_success','Please check your email for new password!');


        }

        return view('users.forgot_password');
    }

   
    
    public function login(Request $request){
        if($request->isMethod('post')){

            
            $data = $request->all();
            if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
                Session::put('frontSession', $data['email']);
                return redirect('/cart');
            }else{
                return redirect()->back()->with('flash_message_error', 'Invalid Username or Password');
            }
        }
    }


    public function checkEmail(Request $request){

        $data = $request->all();
        $usersCount = User::where('email',$data['email'])->count();

        if($usersCount>0){
            echo "false";
        }else {
            echo "true"; die;
        }
    }


    public function userLoginRegister(){
        return view('users.login_register');
    }

  

    public function logout(){
        Auth::logout();
        Session::forget('frontSession');
        Session::forget('session_id');
        return redirect('/');
    }

    public function confirmAccount($email){
        $email = base64_decode($email);
        $userCount = User::where('email',$email)->count();
        if($userCount > 0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status == 1){
                return redirect('login-register')->with('flash_message_success','Your Email account is already activated. You can login now.');
            }else{
                User::where('email',$email)->update(['status'=>1]);

                // Send Welcome Email
                $messageData = ['email'=>$email,'name'=>$userDetails->name];
                Mail::send('emails.welcome',$messageData,function($message) use($email){
                    $message->to($email)->subject('Welcome to Phoenix Website');
                });

                return redirect('login-register')->with('flash_message_success','Your Email account is activated. You can login now.');
            }
        }else{
            abort(404);
        }
    }
    
    public function account(Request $request){
        $user_id  = Auth::user()->id;
        $userDetails = User::find($user_id);
        $countries = Country::get();
      

        if($request->isMethod('post')){
            $data = $request->all();

              
        if(empty($data['name'])){
            return redirect()->back()->with('flash_message_error', 'Please fill in your name to update account');
        }


        // setting default values
        if(empty($data['address'])){
            $data['address'] = "";
        }

        if(empty($data['city'])){
            $data['city'] = "";
        }
        if(empty($data['state'])){
            $data['state'] = "";
        }
        if(empty($data['country'])){
            $data['country'] = "";
        }
        if(empty($data['pincode'])){
            $data['pincode'] = "";
        }
        if(empty($data['mobile'])){
            $data['mobile'] = "";
        }


        
            $user = User::find($user_id);
            $user->name = $data['name']; 
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->postalcode = $data['postalcode'];
            $user->mobile = $data['mobile'];

            $user->save();

            return redirect()->back()->with('flash_message_success', 'Your account details has been updated successfully');



        }
        return view('users.account', compact('countries','userDetails'));
    }

    public function chkUserPassword(Request $request){
        $data = $request->all();

        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where('id', $user_id)->first();

        if(Hash::check($current_password,$check_password->password)){
            echo "true"; die;
        }else{
            echo "false"; die;
        }
    }
   
    public function updatePassword(Request $request){
       if($request->isMethod('post')){
           $data = $request->all();
           $old_pwd = User::where('id',Auth::User()->id)->first();
           $current_pwd = $data['current_pwd'];
           if(Hash::check($current_pwd, $old_pwd->password)){
              $new_pwd = bcrypt($data['new_pwd']);
              User::where('id', Auth::User()->id)->update(['password'=>$new_pwd]);
              return redirect()->back()->with('flash_message_success', 'Password Update Successfully!'); 
           }else{
               return redirect()->back()->with('flash_message_error', 'Current Password incorrect!'); 
           }
      }
    }

}
