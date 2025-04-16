<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>
</head>
<body>
    <h2>Usuário</h2>

    ID: {{ $user->id }}<br>
    Nome: {{ $user->name }}<br>
    E-mail: {{ $user->email }}<br>
    Data de Cadastro: {{ $user->created_at }}<br>
</body>
</html>