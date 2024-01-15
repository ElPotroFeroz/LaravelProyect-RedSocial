<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function config() {
        return view('user.config');
    }
    
    public function update(Request $request) {
        //Conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;
        
        //Validar el formulario
        $validate = $this->validate($request,[
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/'],
            'surname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        ]);
        
        //Recoger los datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
        //Asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;
        
        //Subir imagen
        $image_path = $request->file('image_path');
        if($image_path) {
            //Poner nombre unico a la imagen
            $image_name = time().$image_path->getClientOriginalName();
            // Almacenar la imagen en el disco 'users' usando el método store
            Storage::disk('users')->putFileAs('', $image_path, $image_name);
            //Setear el objeto user
            $user->image = $image_name;
        }
        
        //Hacer consulta y actualizar en la base de datos
        $user->update();
        
        return redirect()->route('config')
                ->with(['message' => 'Usuario actualizado correctamente']);
    }
    
    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
    
    public function profile($id) {
        $user = User::find($id);
        
        return view('user.profile', [
            'user' => $user
        ]);
    }
    
    public function search(Request $request) {
        //Validate form
        $validate = $this->validate($request,[
            'nick' => ['required', 'string']
        ]);
        $nick = $request->input('nick');
        $users = User::where('nick', 'LIKE', '%'.$nick.'%')
                                ->orderBy('id', 'desc')
                                ->get();
        return view('user.search', [
            'users' => $users
        ]);                        
    }
}
