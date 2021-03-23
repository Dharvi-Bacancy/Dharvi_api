<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\News_update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class news_updateController extends Controller
{
    public function newsUpdateSave(Request $request){

        
        $rules=[
                 'news_update'              =>      'required|string|min:6',     
        ];
        $validator = Validator::make($request->all(),$rules);
         if($validator->fails()){
             return response()->json($validator->errors(),400);
         }
         $news_update = News_update::create(array_merge(
             $validator->validated(),
 
         )); 
         
         return response()->json($news_update,201);
         //return $validator->errors();
        }
     function get_news(){
         $news_update= News_update::all();
         return response()->json($news_update);
     }
     
     function delete_news($id){ 
        News_update::destroy($id);
        return response()->json(['message' => "sucessfully delete"]);
    }

    function edit_news($id,Request $request){
        $rules=[
            'news_update'              =>      'required|string|min:6',     
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
           return response()->json($validator->errors(),400);
        } 
        $news=News_update::findOrFail($id);
        
        $news->update($request->all());
        return response()->json(['message' => "sucessfully edit"]);
    }

    function deleteall_news(){ 
        if(DB::table('news_update')->delete())
        {
            return response()->json(['message' => "all data sucessfully delete"]);
        }
        else
        {
            return response()->json(['messageee' => "all data  not sucessfully delete"]);
        }
        
        
    }


}
