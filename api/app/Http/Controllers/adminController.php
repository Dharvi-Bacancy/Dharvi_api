<?php

namespace App\Http\Controllers;
use App\Models\Accounttype;
use Illuminate\Http\Request;
use App\Models\RegisterModel;
use App\Models\Validate_email;
use Validator;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    function userlist(Request $request){
        // $data=DB::table('register')->paginate(1);
        $data = DB::table('register')
            ->join('accounttype', 'register.id', '=', 'accounttype.register_model_id')
            ->select('register.id','register.name','register.email','register.username','register.type', 'accounttype.account_type', 'accounttype.date')
            ->where('register.email', 'like', '%' .$request->search. '%')
            ->orWhere('register.username', 'like', '%' .$request->search. '%')
            ->paginate(4);
        return response()->json(['data' => $data]);
    }
    // function searchaccounttype($type,Request $request){
    //     $data = DB::table('register')
    //         ->join('accounttype', 'register.id', '=', 'accounttype.register_model_id')
    //         ->select('register.*', 'accounttype.accounttype', 'accounttype.date')
    //         ->where('accounttype.accounttype', $type)
    //         ->where('register.email', 'like', '%' .$request->search. '%')
    //         ->orWhere('register.username', 'like', '%' .$request->search. '%')
    //         ->paginate(1);
    //     return response()->json(['data' => $data]);
    // }
    function searchaccounttype($type,Request $request){
        $search=$request->search;
        $data = DB::table('register')
            ->join('accounttype', 'register.id', '=', 'accounttype.register_model_id')
            ->select('register.id','register.name','register.email','register.username','register.type', 'accounttype.account_type', 'accounttype.date')
            ->where('accounttype.account_type', $type)->where(function($query) use ($search){
               $query->where('register.email', 'like', '%' .$search. '%')
                     ->orWhere('register.username', 'like', '%' .$search. '%');
            })
            ->paginate(4);
        return response()->json(['data' => $data]);
    }

    function edituser($id,Request $request){
        $rules=[
            'account_type'              =>      'required|string',
            
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        DB::table('accounttype')->where('register_model_id', $id)->update(['account_type' => $request->input('account_type')]);
        return response()->json('Update successfully',201);
        
    }
    function deleteuser($id){
        DB::table('validate_email')->where('register_model_id', $id)->delete();
        DB::table('accounttype')->where('register_model_id', $id)->delete();
        
        $register = RegisterModel::findOrFail($id);
        $register->delete();
        return response()->json(['message' => "sucessfully delete"]);
    }

    function totaluser(){
        $count=DB::table('accounttype')->where('account_type','subscribe')->count();
        return response()->json($count);
    }
    
}
