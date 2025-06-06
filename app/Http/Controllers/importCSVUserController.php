<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CsvRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class importCSVUserController extends Controller
{
    // === Importa os dados do excel de usuários ===
    public function importCsvUsers(CsvRequest $request) {
        try {

            // Validar o arquivo
            $csvimport = $request->file;

            // Criar o array cm as colunas no banco de dados
            $headers = ['name', 'email', 'password'];

            // Receber o arquivo, ler os dados e converter a string em array
            $filleData = array_map('str_getcsv', file($csvimport->file('file')));

            // Definir o separador dos valores csv
            $separator = ';';

            // Criar array para armazenar e-mails duplicados encontrados
            $numberRegisteredRecords = 0;

            // Percorrer cada linha do arquivo CSV
            foreach ($filleData as $row) {

                // Separar os valores da linha utilizando o separador
                $values = explode($separator, $row[0]);

                // verificar se a quatidade de valores de corresponde ao número de colunas esperados
                if (count($values) !== count($headers)){
                    continue;
                }

                // Combinar os valores com os nomes das colunas (cabeçalhos)
            } 

        } catch (Exception $e) { 
            // Redirecionar o usuário, enviar a mensagem de erro
            Log::error('Erro ao gerar o PDF: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Dados não importados!');
        }
    }
}
