<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Mail\UserPdfMail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    // Listar os usuários
    public function index(Request $request)
    {
        // Recuperar os registros do banco dados
        // $users = User::orderByDesc('id')->paginate(10);
        $users = User::when(
            $request->filled('name'),
            fn($query) =>
            $query->whereLike('name', '%' . $request->name . '%')
        )
            ->when(
                $request->filled('email'),
                fn($query) =>
                $query->whereLike('email', '%' . $request->email . '%')
            )
            ->when(
                $request->filled('start_date_registration'),
                fn($query) =>
                $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
            )
            ->when(
                $request->filled('end_date_registration'),
                fn($query) =>
                $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
            )
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Carregar a VIEW
        return view('users.index', [
            'users' => $users,
            'name' => $request->name,
            'email' => $request->email,
            'start_date_registration' => $request->start_date_registration,
            'end_date_registration' => $request->end_date_registration,
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

    public function generatePdfUsers(Request $request)
    {

        try {
            // Recuperar os registros do banco dados
            $users = User::when(
                $request->filled('name'),
                fn($query) =>
                $query->whereLike('name', '%' . $request->name . '%')
            )
                ->when(
                    $request->filled('email'),
                    fn($query) =>
                    $query->whereLike('email', '%' . $request->email . '%')
                )
                ->when(
                    $request->filled('start_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
                )
                ->when(
                    $request->filled('end_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
                )
                ->orderByDesc('name')
                ->get();

            // Somar total de registros
            $totalRecords = $users->count('id');

            // Verificar se a quantidade de registros ultrapassa o limite para gerar PDF
            $numberRecordsAllowed = 5;
            if ($totalRecords > $numberRecordsAllowed) {
                // Redirecionar o usuário, enviar a mensagem de erro
                return redirect()->route('user.index', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'start_date_registration' => $request->start_date_registration,
                    'end_date_registration' => $request->end_date_registration,
                ])->with('error', "Limite de registros ultrapassado para gerar PDF. O limite é de $numberRecordsAllowed registros!");
            }

            // Carregar a string com o HTML/conteúdo e determinar a orientação e o tamanho do arquivo
            $pdf = Pdf::loadView('users.generate-pdf-users', ['users' => $users])->setPaper('a4', 'portrait');

            // Fazer o download do arquivo
            return $pdf->download('listar_usuarios.pdf');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            Log::error('Erro ao gerar o PDF: ' . $e->getMessage());
            return redirect()->route('user.index')->with('error', 'PDF não gerado!');
        }
    }

    // === Gerar CSV ===
    public function generateCsvUsers(Request $request) {
    
        // Recuperar os registros do banco dados
        $users = User::when(
            $request->filled('name'),
            fn($query) =>
            $query->whereLike('name', '%' . $request->name . '%')
        )
            ->when(
                $request->filled('email'),
                fn($query) =>
                $query->whereLike('email', '%' . $request->email . '%')
            )
            ->when(
                $request->filled('start_date_registration'),
                fn($query) =>
                $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
            )
            ->when(
                $request->filled('end_date_registration'),
                fn($query) =>
                $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
            )
            ->orderByDesc('name')
            ->get();

        // Somar total de registros
        $totalRecords = $users->count('id');

        // Verificar se a quantidade de registros ultrapassa o limite para gerar CSV
        $numberRecordsAllowed = 5;
            if ($totalRecords > $numberRecordsAllowed) {
                // Redirecionar o usuário, enviar a mensagem de erro
                return redirect()->route('user.index', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'start_date_registration' => $request->start_date_registration,
                    'end_date_registration' => $request->end_date_registration,
                ])->with('error', "Limite de registros ultrapassado para gerar CSV. O limite é de $numberRecordsAllowed registros!");
            }

        // Criar um arquivo temporario
        $csvFileName = tempnam(sys_get_temp_dir(), 'csv_' . Str::ulid());

        // Abrir o arquivo na forma de escrita
        $openFile = fopen($csvFileName, 'w');

        // Criar o cabeçalho do Excel
        $header = ['id', 'Nome', 'E-mail', 'Data de Cadastrado'];

        // Escrever o cabeçalho no arquivo
        fputcsv($openFile, $header, ';');

        // Ler os registros recuperados do banco de dados
        foreach( $users as $user) {

            // Criar o array com os dados da linha do Excel
            $userArray = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s'),
            ];

            // Escrever o conteúdo no arquivo
            fputcsv($openFile, $userArray, ';');
        }

        // Fechar o arquivo após a escrita
        fclose($openFile);

        //  Realizar o download do arquivo
        return response()->download($csvFileName, 'list_users_' . Str::ulid() . '.csv');
        
        
    }
}
