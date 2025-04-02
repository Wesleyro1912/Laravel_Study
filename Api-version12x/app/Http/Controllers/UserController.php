<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller {
    
    public function __construct(){

    }

    // === View de cadastro ===
    public function create(){
        // Carregar view
        return view('users.create');
    }


    // === Cadastro de usuário ===
    public function store(UserRequest $request){
        try {
            // Cadastro
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            return redirect()->route('user.create')->with('success', 'Usuário cadastrado com sucesso!');

        } catch ( Exception $e){
            return back()->withInput()->with('error', 'Não foi possível realizar o cadastro do usuário!');
        }
       
    }
}
