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

    // === Lista de usuários ===
    public function index() {

        // Recuperar os dados
        $users = User::orderBydesc('id')->paginate(10);

        // Carregar a view
        return view('users.index', ['users' => $users]);
    }

    // === View de edição ===
    public function edit(User $user){
        // Carregar view
        return view('users.edit', ['user' => $user]);
    }

    // === Edição de usuário ===
    public function update(UserRequest $request, User $user){

        try {
            $user_>update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return redirect()->route('user.edit')->with('success', 'Usuário edidato com sucesso!');

        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Não foi possível realizar o cadastro do usuário!');
        }
    }
}
