<?php

namespace App\Http\Controllers;

use App\Mail\SendMailUser;
use App\Models\ClienteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->only([
                'nome',
                'email',
                'telefone',
                'data_nascimento',
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

        if($validator->fails()) return response()->json(['message' => $validator->errors()->first()], 400);

        $email = $request->input('email');

        if(ClienteModel::where('email', $email)->withTrashed()->first()) return response()->json(['message' => 'E-mail já cadastrado!']);

        ClienteModel::create([
            'nome' => $request->input('nome'),
            'email' => $request->input('email'),
            'telefone' => $request->input('telefone'),
            'data_nascimento' => $request->input('data_nascimento'),
            'rua_endereco' => $request->input('rua_endereco'),
            'numero_endereco' => $request->input('numero_endereco'),
            'complemento_endereco' => $request->input('complemento_endereco'),
            'bairro_endereco' => $request->input('bairro_endereco'),
            'cep_endereco' => $request->input('cep_endereco'),
        ]);

        Mail::send(new SendMailUser([
            'name' => $request->input('nome'),
            'email' => $request->input('email')
        ]));

        return response()->json(['message' => 'Cliente cadastrado com sucesso!'], 201);
    }

    public function listOne($id)
    {
        $cliente = ClienteModel::find($id);

        if(!$cliente) return response()->json(['message' => 'Cliente informado não cadastrado!']);

        $res = [
            'nome' => $cliente['nome'],
            'email' => $cliente['email'],
            'telefone' => $cliente['telefone'],
            'data_nascimento' => $cliente['data_nascimento'],
            'rua_endereco' => $cliente['rua_endereco'],
            'numero_endereco' => $cliente['numero_endereco'],
            'bairro_endereco' => $cliente['bairro_endereco'],
            'cep_endereco' => $cliente['cep_endereco']
        ];

        if($cliente['complemento_endereco']) $res = array_merge($res, ['complemento_endereco' => $cliente['complemento_endereco']]);

        return response()->json($res, 200);
    }

    public function update(Request $request, $id)
    {
        $cliente = ClienteModel::find($id);

        if(!$cliente) return response()->json(['message' => 'Cliente informado não cadastrado!'], 404);

        if($request->input('nome')) $cliente->nome = $request->input('nome');
        if($request->input('email')) $cliente->email = $request->input('email');
        if($request->input('telefone')) $cliente->telefone = $request->input('telefone');
        if($request->input('data_nascimento')) $cliente->data_nascimento = $request->input('data_nascimento');
        if($request->input('senha')) $cliente->senha = Hash::make($request->input('senha'));
        if($request->input('rua_endereco')) $cliente->rua_endereco = $request->input('rua_endereco');
        if($request->input('numero_endereco')) $cliente->numero_endereco = $request->input('numero_endereco');
        if($request->input('complemento_endereco')) $cliente->complemento_endereco = $request->input('complemento_endereco');
        if($request->input('bairro_endereco')) $cliente->bairro_endereco = $request->input('bairro_endereco');
        if($request->input('cep_endereco')) $cliente->cep_endereco = $request->input('cep_endereco');

        $cliente->save();

        return response()->json(['message' => 'Cliente atualizado com sucesso!'], 200);
    }

    public function delete($id)
    {
        $cliente = ClienteModel::find($id);

        if(!$cliente) return response()->json(['message' => 'Cliente informado não cadastrado!'], 404);

        $cliente->delete();

        return response()->json(['message' => 'Cliente excluído com sucesso!'], 200);
    }
}
