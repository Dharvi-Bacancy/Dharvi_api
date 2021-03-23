<?php

namespace App\Http\Controllers;

use App\Models\Youtube;
use Illuminate\Http\Request;

class youtubeController extends Controller
{
    public function updateLink(Request $request) {
        $id=1;
        if (Youtube::where('id', $id)->exists()) {
            $youtube = Youtube::find($id);
            $youtube->link = is_null($request->link) ? $youtube->link : $request->link;
            $youtube->save();
    
            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "link not found"
            ], 404);
            
        }
    }
    public function getLink(){
        $id=1;
        $link=Youtube::find($id);
        return response()->json($link->link,200);
    }
}
