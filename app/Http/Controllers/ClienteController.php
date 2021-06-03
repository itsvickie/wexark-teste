<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function create(Request $request)
    {
        $cliente = Validator::make(
            $request->only([
                'nome',
                'email',
                'telefone',
                'data_nascimento',
                'senha',
                'rua_endereco',
                'numero_endereco',
                'complemento_endereco',
                'bairro_endereco',
                'cep_endereco'
            ]),
            [
                'nome' => 'required|string|max:100',
                'email' => 'required|email|string|max:100',
                'telefone' => 'required|string|min:11|max:11',
                'data_nascimento' => 'required|date_format:Y-m-d|after:1900-01-01|before:today',
                'senha' => 'required|string|min:8',
                'rua_endereco' => 'required|string|max:100',
                'numero_endereco' => 'required|int',
                'complemento_endereco' => 'string|max:255',
                'bairro_endereco' => 'required|string|max:50',
                'cep_endereco' => 'required|string|min:8|max:8'
            ],
            [
                'nome.required' => 'O campo de Nome é obrigatório!',
                'nome.string' => 'O campo de Nome é do tipo texto!',
                'nome.max' => 'O campo de Nome deve ter no máximo 100 caracteres!',
                'email.required' => 'O campo de Email é obrigatório!',
                'email.email' => 'O email informado é inválido!',
                'email.string' => 'O campo de Email é do tipo texto!',
                'email.max' => 'O campo de Email deve ter no máximo 100 caracteres!',
                'telefone.required' => 'O campo de Telefone é obrigatório!',
                'telefone.string' => 'O campo de Telefone é do tipo texto!',
                'telefone.min' => 'O campo de Telefone deve ter no mínimo 11 caracteres!',
                'telefone.max' => 'O campo de Telefone deve ter no máximo 11 caracteres!',
                'data_nascimento.required' => 'O campo de Data de Nascimento é obrigatório!',
                'data_nascimento.date_format' => 'Data de Nascimento inválida! Formato: YYYY-mm-dd',
                'data_nascimento.after' => 'Data de Nascimento inválida!',
                'data_nascimento.before' => 'Data de Nascimento inválida!',
                'senha.required' => 'O campo de Senha é obrigatório!',
                'senha.string' => 'O campo de Senha é do tipo texto!',
                'senha.min:8' => 'O campo de Senha deve ter no mínimo 8 caracteres!',
                'rua_endereco.required' => 'O campo de Rua é obrigatório!',
                'rua_endereco.string' => 'O campo de Rua é do tipo texto!',
                'rua_endereco.max' => 'O campo de Rua deve ter no máximo 100 caracteres!',
                'numero_endereco.required' => 'O campo de Número é obrigatório!',
                'numero_endereco.int' => 'O campo de Número é do tipo inteiro!',
                'complemento_endereco.string' => 'O campo de Complemento é do tipo texto!',
                'complemento_endereco.max' => 'O campo de Complemento deve ter no máximo 255 caracteres!',
                'bairro_endereco.required' => 'O campo de Bairro é obrigatório!',
                'bairro_endereco.string' => 'O campo de Bairro é do tipo texto!',
                'bairro_endereco.max' => 'O campo de Bairro deve ter no máximo 50 caracteres!',
                'cep_endereco.required' => 'O campo de CEP é obrigatório!',
                'cep_endereco.string' => 'O campo de CEP é do tipo texto!',
                'cep_endereco.min' => 'O campo de CEP deve ter no mínimo 8 caracteres!',
                'cep_endereco.max' => 'O campo de CEP deve ter no máximo 8 caracteres!'
            ]
        );

        if($cliente->fails()){
            return response()->json(['message' => $cliente->errors()->first()], 400);
        }

        $email = $request->input('email');

        if(ClienteModel::where('email', $email)->first()) return response()->json(['message' => 'E-mail já cadastrado!']);

        ClienteModel::create([
            'nome' => $request->input('nome'),
            'email' => $request->input('email'),
            'senha' => Hash::make($request->input('senha')),
            'telefone' => $request->input('telefone'),
            'data_nascimento' => $request->input('data_nascimento'),
            'rua_endereco' => $request->input('rua_endereco'),
            'numero_endereco' => $request->input('numero_endereco'),
            'complemento_endereco' => $request->input('complemento_endereco'),
            'bairro_endereco' => $request->input('bairro_endereco'),
            'cep_endereco' => $request->input('cep_endereco'),
        ]);

        return response()->json(['message' => 'Cliente cadastrado com sucesso!'], 201);
    }
}
