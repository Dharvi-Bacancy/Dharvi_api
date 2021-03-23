<?php

namespace App\Http\Controllers;

use Validator;
use App\Mail\ForgotMail;
use Illuminate\Http\Request;
use App\Models\RegisterModel;
use App\Models\Validate_email;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class forgotPasswordController extends Controller
{
    public function forgot_password(Request $request){
        $register = RegisterModel::whereEmail($request->email)->first();
        
        if($register==null){
            return response()->json('User not exists',400);
        }
        //$user = RegisterModel::find($request->email);
        
        // $reminder = Reminder::exists($user) ? : Reminder::create($user);
        // $this->sendEmail($user,$reminder->code);
        Mail::to($register->email)->send(new ForgotMail($register));
        return response()->json('Check your mail to create new password',200);
    }
    
    function forgot_page($token){
        $verifyUser = Validate_email::where('token', $token)->first();
        $user = $verifyUser->user;
        
        return view('forgot_password',compact('user'));
        //return $this->view('api/view_forgot_password');
    }
    function new_password($id,Request $request){
        $rules=[
            'new_password'          =>      'required',
            'confirm_password'          =>      'required|string',          
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $register = RegisterModel::findOrFail($id);  
        $register->password = Hash::make($request->new_password);  
        $register->save();
        return response()->json('Password update successfully',200);
    }
}
