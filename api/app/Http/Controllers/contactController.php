<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\Contact;
use Illuminate\Http\Request;

class contactController extends Controller
{
    public function contactSave(Request $request){

        
        $rules=[
                 'name'              =>      'required|string|max:20',
                 'email'             =>      'required|email',
                 'message'          =>      'required|string|min:6',
                 
        ];
        $validator = Validator::make($request->all(),$rules);
         if($validator->fails()){
             return response()->json($validator->errors(),400);
         }
         $contact = Contact::create(array_merge(
             $validator->validated(),
 
         )); 
         
         return response()->json($contact,201);
         //return $validator->errors();
     }
}
