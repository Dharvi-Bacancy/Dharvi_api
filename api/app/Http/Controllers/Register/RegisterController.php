<?php

namespace App\Http\Controllers\Register;

use Validator;
use App\Mail\VerifyMail;
use App\Models\Accounttype;
use Illuminate\Http\Request;
use App\Models\RegisterModel;
use App\Models\Validate_email;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register(){
        return response()->json(RegisterModel::get(),200);
    }
    // public function __construct() {
    //     $this->middleware('auth:api', ['except' => ['login', 'register']]);
    // }
    // public function registerId($id){
    //     return response()->json(RegisterModel::find($id),200);
    // }
    public function registerSave(Request $request){

        
       $rules=[
                'name'              =>      'required|string|max:20',
                'email'             =>      'required|email|unique:register,email',
                'username'          =>      'required|string|min:6|unique:register,username',
                'password'          =>      'required|string|min:6',
                
       ];
       $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $register = RegisterModel::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]

        )); 
        $validate_email = Validate_email::create([
            'register_model_id' => $register->id,
            'token' => sha1(time())
          ]);
        $accounttype = Accounttype::create([
            'register_model_id' => $register->id,
            'account_type' => 'unsubscribe',
            'date' => '-'
        ]);

        Mail::to($register->email)->send(new VerifyMail($register));
        return response()->json('Register successfully',201);
        //return $validator->errors();
    }
    public function verifyUser($token)
   {
        
        $verifyUser = Validate_email::where('token', $token)->first();
        if(isset($verifyUser)){
        $user = $verifyUser->user;
        
            if($user->email_verified==0) {
                $verifyUser->user->email_verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }   
        } else {
             return redirect('api/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('api/login')->with('status', $status);
}
public function __construct() {
    $this->middleware('auth:api', ['except' => ['login','verifyUser','registerSave','register']]);
}
public function login(Request $request){
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);
    $email= $request->email;
    
    $data= RegisterModel::where("email","$email")->first();
  

    if ($validator->fails()) {
        
        return response()->json($validator->errors(), 422);
        
    }
    if($data == null){
        return response()->json(['error' => 'wrong login details'], 401); 
    }

    if (! $token = auth()->attempt($validator->validated())) {
        if (($data->email_verified ==0)){
            
           return response()->json(['error' => 'Check your username and password'], 401);
       
        }
        else{
            return response()->json(['error' => 'Check your username and password'], 401);
        }
    }
    if($data->email_verified ==1){
        return $this->createNewToken($token);
    }
    else{
        Mail::to($data->email)->send(new VerifyMail($data));
        return response()->json(['error' => 'please verify email']);
        
    }
    
}

protected function createNewToken($token){
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
        'register' => auth('api')->user()
    ]);
}


    // public function registerUpdate(Request $request,RegisterModel $register){
    //     $register->update($request->all());
    //     return response()->json($register,200);
    // }
    // public function registerDelete(Request $request,RegisterModel $register){
    //     $register->delete();
    //     return response()->json(null,204);
    // }
    // public function login(){
    //     return response()->json('hii',200);
    // }

}
