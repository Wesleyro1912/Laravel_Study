@extends('layouts.admin')

@section('content')   

        <div class="content">
            <div class="content-title">
                <h1 class="page-title">Listar Usuários</h1>
                <a href="{{ route('user.create') }}" class="btn-success">Cadastrar</a>
            </div>

            <x-alert />
            {{ dd($users) }}
           
        </div>
@endsection
