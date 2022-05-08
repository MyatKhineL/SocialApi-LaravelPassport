<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedApiController extends Controller
{
    public function feed(){
        $feeds = Feed::latest('id')->with('user')->get();
        return $feeds;
    }

    public function create(Request $request){

            $request->validate([
               "description"=>"required|min:3",
                "image"=>"required|file|mimes:jpg,png"
            ]);

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


   public function createcomment(Request $request){
        $request->validate([
            'feed_id'=>'required',
            'comment'=>'required',
        ]);
        $comment = new Comment();
        $comment->user_id=Auth::id();
        $comment->feed_id=$request->feed_id;
        $comment->comment = $request->comment;
        $comment->save();

       return response()->json([
           'status'=>200,
           'message'=>'success',
           'data'=>$comment,

       ]);


   }

   public function getComment(){
           $r = Validator::make(request()->all(),[
               'feed_id'=>'required'
           ]);
           if($r->fails()){
               return response()->json([
                   'status'=>500,
                   'message'=>'fail',
                   'data'=>$r,

               ]);
           }
           $feed_id = request()->feed_id;

           //$comments = Feed::find($feed_id)->comment;
           $comments = Comment::where('feed_id',$feed_id)->with('user')->paginate(2);

       return response()->json([
           'status'=>200,
           'message'=>'success',
           'data'=>$comments,

       ]);

   }

    public function deleteComment()
    {
        $r = Validator::make(request()->all(), [
            'comment_id' => 'required'
        ]);
        if ($r->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'fail',
                'data' => $r,

            ]);
        }
        $comment_id = request()->comment_id;
        Comment::where('id',$comment_id)->delete();

        return response()->json([
            'status'=>200,
            'message'=>'success',
            'data'=>null,

        ]);
    }
}
