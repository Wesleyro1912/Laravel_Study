@extends('layouts.admin')

@section('content')   

        <div class="content">
            <div class="content-title">
                <h1 class="page-title">Detalhes do Usuário</h1>
                <a href="{{ route('user.index') }}" class="btn-primary">Listar</a>
            </div>

            <x-alert />

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Informações do Usuário</h2>
                <div class="text-gray-700">
                    
                    <div class="mb-1">
                        <span class="font-bold">ID:</span>
                        <span>{{ $user->id }}</span>
                    </div>

                    <div class="mb-1">
                        <span class="font-bold">Nome:</span>
                        <span>{{ $user->name }}</span>
                    </div>

                    <div class="mb-1">
                        <span class="font-bold">E-mail:</span>
                        <span>{{ $user->email }}</span>
                    </div>

                    <div class="mb-1">
                        <span class="font-bold">Criado em:</span>
                        <span>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}</span>
                    </div>

                    <div class="mb-1">
                        <span class="font-bold">Editado em:</span>
                        <span>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s')  }}</span>
                    </div>
                </div>
            </div>
        </div>
@endsection
