<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources\css\app.css'])
    <title>Formulário de Cadastro</title>
</head>
<body>
    <div class="flex flex">
        <h1>Cadastrar Usuário</h1>

        @if (session('success'))
            <p style="color: #086">
                {{ session('success') }}
            </p>
        @endif

        @if (session('error'))
            <p style="color: #f00">
                {{ session('error') }}
            </p>
        @endif

        <form action="{{ route('user.store')}}" method="POST">
            @csrf
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" placeholder="Nome completo do usuário" value="{{ old('name') }}" required><br><br>

            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" placeholder="E-mail do usuário" value="{{ old('email') }}" required><br><br>

            <label for="password">Senha</label>
            <input type="password" name="password" id="password" placeholder="Senha do usuário" value="{{ old('password') }}" required><br><br>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
    
</body>
</html>