@extends('layouts.admin')

@section('content')
    <h1>Bem-vindo(a)!</h1>

    <a href="{{ route('user.create') }}">Cadastrar</a>
@endsection
