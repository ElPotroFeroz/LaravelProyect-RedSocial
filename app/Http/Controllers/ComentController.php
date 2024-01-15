<?php

namespace App\Http\Controllers;
use App\Models\Coment;

use Illuminate\Http\Request;

class ComentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function save(Request $request) {
        //Validate
        $validate = $this->validate($request, [
           'image_id' => 'integer|required',
           'content' => 'string|required'
        ]);
        //Collect data
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');
        //Set values to the new object
        $coment = new Coment();
        $coment->user_id = $user->id;
        $coment->image_id = $image_id;
        $coment->content = $content;
        //Save in db
        $coment->save();   
        //Redirect
        return redirect()->route('image.detail', ['id' => $image_id])
                ->with([
                   'message' => 'Comentario guardado' 
                ]);
    }
    
    public function delete($id) {
        //Collect data of the user
        $user = \Auth::user();
        //Get object of the coment
        $coment = Coment::find($id);
        //Check if user is the owner of the coment or of the image
        if($user && ($coment->user_id == $user->id || $coment->image->user_id == $user->id)) {
            $coment->delete();
            
            return redirect()->route('image.detail', ['id' => $coment->image->id])
                ->with([
                   'message' => 'Comentario eliminado correctamente' 
                ]);
        } else {
            return redirect()->route('image.detail', ['id' => $coment->image->id])
                ->with([
                   'message' => 'Error al intentar eliminar el comentario' 
                ]);
        }
    }
}
