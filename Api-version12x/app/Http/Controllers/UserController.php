<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Mail\UserPdfMail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
           $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');

        } catch ( Exception $e){
            return back()->withInput()->with('error', 'Não foi possível realizar o cadastro do usuário!');
        }
    }

    // === Lista de usuários ===
    public function index(Request $request) {

        // Recuperar os dados
        $users = User::when(
            $request->filled('name'),
            fn($query) => $query->whereLike('name', '%' . $request->name . '%'),

        )->when(
            $request->filled('email'),
            fn($query) => $query->whereLike('email', '%' . $request->email . '%'),
            
        )->orderByDesc('id')->paginate(1)->withQueryString();

        // Carregar a view
        return view('users.index', [
            'users' => $users,
            'name' =>  $request->name,
            'email' =>  $request->email,
        ]);
    }

    // === View de edição ===
    public function edit(User $user){
        // Carregar view
        return view('users.edit', ['user' => $user]);
    }

    // === Edição de usuário ===
    public function update(UserRequest $request, User $user){

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return redirect()->route('user.show', ['user' => $user])->with('success', 'Usuário edidato com sucesso!');

        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Não foi possível realizar a edição do usuário!');
        }
    }

     // === View de visualizar um unico usuário ===
     public function show(User $user){
        // Carregar view
        return view('users.show', ['user' => $user]);
    }

    // === Delete de usuário ===
    public function destroy(User $user){
        try{

            $user->delete();
            return redirect()->route('user.index')->with('success', 'Usuário excluido com sucesso!');

        } catch (Exception $e) {
            return redirect()->route('user.index')->with('error', 'Não foi possível realizar o delete do usuário!');
        }
    }

    // === Gerar pdf ===
    public function generatePdf(User $user){
        try {
            $pdf = Pdf::loadView('users.gerenate-pdf', ['user' => $user])->setPaper('a4', 'portrait');
            
            $pdfPath = storage_path("app/public/view_user_{$user->id}.pdf");

            $pdf->save($pdfPath);

            Mail::to($user->email)->send(new UserPdfMail($pdfPath, $user));

            if(file_exists($pdfPath)){
                unlink($pdfPath);
            }

            return redirect()->route('user.show', ['user' => $user])->with('success', 'PDF enviado com sucesso!');

        } catch (Exception $e) {
            return redirect()->route('user.show', ['user' => $user])->with('error', 'Não foi possível gerar o PDF e enviar pelo e-mail!');
        }
        
    }
}
