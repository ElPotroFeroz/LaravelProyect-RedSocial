<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $user = \Auth::user();
        $likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')
                              ->paginate(3);
        
        return view('like.index', [
            'likes' => $likes
        ]);
    }
    
    public function like($image_id) {
        //Collect data of the user and the image
        $user = \Auth::user();
        //Check if the like already exists
        $isset_like = Like::Where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->count();
        //Confirm with an if the isset_like
        if($isset_like == 0) {
            //Create a like object
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;
            //save
            $like->save();
            
            return response()->json([
                'like' => $like
            ]);
        } else {
            return response()->json([
                'message' => 'Ya has dado like a esta publicación'
            ]);
        }    
    }
    
    public function dislike($image_id) {
        //Collect data of the user and the image
        $user = \Auth::user();
        //Check if the like already exists
        $like = Like::Where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->first();
        //Confirm with an if the isset_like
        if($like) {
            //delete the like
            $like->delete();
            
            return response()->json([
                'message' => 'Te ha dejado de gustar la publicación'
            ]);
        } else {
            return response()->json([
                'message' => 'No has dado like a esta publicación'
            ]);
        }    
    }
}
