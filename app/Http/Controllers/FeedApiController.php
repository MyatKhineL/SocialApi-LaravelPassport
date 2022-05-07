<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedApiController extends Controller
{


    public function create(Request $request){

            

            $image = $request->file('image');
            $image_name = uniqid() .$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs("public/images", $image_name);

            $feed = new Feed();
            $feed->description = $request->description;
            $feed->user_id = Auth::id();
            $feed->image = $image_name;
            $feed->save();



        return response()->json([
            'status'=>200,
            'message'=>'success',
            'data'=>$feed,

        ]);

     }
}
