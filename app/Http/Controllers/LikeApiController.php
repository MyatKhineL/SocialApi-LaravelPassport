<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeApiController extends Controller
{
    public function like(Request $request){

        $user_id = Auth::id();
        $feed_id = $request->feed_id;
//        return $this->islike($user_id,$feed_id);
        if(!$this->islike($user_id,$feed_id)){
            $like = new Like();
            $like->user_id = Auth::id();
            $like->feed_id = $request->feed_id;

            $like->save();

            return response()->json([
                'status'=>200,
                'message'=>'success',
                'data'=>$like,

            ]);

        }
        return response()->json([
            'status'=>500,
            'message'=>'fail',
            'data'=>'already like',

        ]);

    }


    public function islike($user_id,$feed_id){
        $like = Like::where('user_id',$user_id,)->where('feed_id',$feed_id)->count();
        if($like){
            return true;
        }else{
            return  false;
        }

    }

    public function unlike(){
        $like_id = request()->like_id;
        Like::where('id',$like_id)->delete();
        return response()->json([
            'status'=>200,
            'message'=>'success',
            'data'=>'Unlike',

        ]);
    }
}
