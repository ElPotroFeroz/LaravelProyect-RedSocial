<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Image;
use App\Models\Coment;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create() {
        return view('image.create');
    }
    
    public function save(Request $request) {
        //Validation
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|image'
        ]);
        //Collect the data into a variables
        $image_path = $request->file('image_path');
        $description = $request->input('description');
        
        //Create Image object and set values to it
        $image = new Image();
        $user = \Auth::user();
        
        $image->user_id = $user->id;
        $image->image_path = null;
        $image->description = $description;
        
        //Upload the image
        if($image_path) {
            $image_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->putFileAs('', $image_path, $image_name);
            $image->image_path = $image_name;
        }
        $image->save();
        
        //Redirect to the page
        return redirect()->route('home')->with([
            'message' => 'La imagen ha sido guardada correctamente'
        ]);
    }
    
    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename);
        return (new Response($file, 200))
        ->header('Content-Type', Storage::disk('images')->mimeType($filename));
    }
    
    public function detail($id) {
        $image = Image::find($id);
        
        return view('image.detail', [
            'image' => $image
        ]);
    }
    
    public function delete($id) {
        $image = Image::find($id);
        $user = \Auth::user();
        $coments = Coment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();
        
        if($user && $image && $image->user->id == $user->id) {
            //Delete coments of the image
            if($coments && count($coments) >= 1) {
                foreach($coments as $coment) {
                    $coment->delete();
                }
            }
            //Delete likes of the image
             if($likes && count($likes) >= 1) {
                foreach($likes as $like) {
                    $like->delete();
                }
            }
            //Delete image file in storage
            Storage::disk('images')->delete($image->image_path);
            //Delete image in db
            $image->delete();
            
            $message = array('message' => 'Imagen eliminada correctamente');
        } else {
            $message = array('message' => 'La imagen no ha podido eliminarse');
        }
        return redirect()->route('home')
                         ->with($message);
    }
    
    public function edit($id){
        //Method to go to the view for update
        $image = Image::find($id);
        $user = \Auth::user();
        
        if($image && $user && $image->user->id == $user->id) {
            return view('image.edit', [
                'image' => $image
            ]);
        } else {
            return redirect()->route('home');
        }
    }
    
    public function update(Request $request) {
        //Method to update in the database  
        //Validation
        $validate = $this->validate($request, [
            'description' => 'required'
        ]);
        //Collect data
        $image_id = $request->input('image_id');
        $description = $request->input('description');
        //Get object
        $image = Image::find($image_id);
        //Set data
        $image->description = $description;
        //Update in db
        $image->update();
        
        return redirect()->route('image.detail', [
            'id' => $image_id
        ])->with(['message' => "Imagen actualizada exitosamente"]);
        
    }
}
