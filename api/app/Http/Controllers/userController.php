<?php

namespace App\Http\Controllers;

use Validator;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use App\Models\RegisterModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{
    function edit_user($id,Request $request){
        $register = RegisterModel::findOrFail($id);
        
        $rules=[
            'email'             =>      'required|email|unique:register,email,'.$register->id,
            'username'          =>      'required|string|min:6|unique:register,username,'.$register->id,            
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $register = RegisterModel::findOrFail($id);
        
        
        
        if($register->email ==  $request->email){
            $register->update(['email' => $request->email]);
            $register->update(['username' => $request->username]);
            return response()->json('Update successfully1',201);
        }
        else{
            
            $register->email = $request->email;
            $register->username = $request->username;
            $register->email_verified = 0 ; 
            $register->save();
           Mail::to($register->email)->send(new VerifyMail($register));
           return response()->json('Update successfully',201);
        }
    }
    function change_password($id,Request $request){
        $rules=[
            'old_password'          =>      'required',
            'new_password'          =>      'required|string|min:6',          
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $register = RegisterModel::findOrFail($id);
        if((Hash::check($request->old_password, $register->password)) == false){
            return response()->json('Check your old password',400);
        }
        else if((Hash::check($request->new_password, $register->password)) == true){
            return response()->json('Please enter a password which is not similar then current password',400);
        }
        else{
            $register->password = Hash::make($request->new_password);  
            $register->save();
            return response()->json('Password update successfully',200);
        }
       
    }
    public function registerId($id){
            return response()->json(RegisterModel::find($id),200);
    }
}


