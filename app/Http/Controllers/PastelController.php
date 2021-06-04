<?php

namespace App\Http\Controllers;

use App\Http\Resources\PastelResource;
use App\Models\PastelModel;
use App\Models\TipoPastelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PastelController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->only([
                'nome',
                'preco',
                'foto',
                'id_tipo'
            ]),
            [
                'nome' => 'required|string|max:100',
                'preco' => 'required|numeric|between:0,999999.99',
                'foto' => 'required|mimes:jpeg,png,jpg',
                'id_tipo' => 'required'
            ],
            [
                'nome.required' => 'O Nome do Pastel é obrigatório!',
                'nome.string' => 'O Nome do Pastel é do tipo texto!',
                'nome.max:100' => 'O nome do Pastel deve ter no máximo 100 caracteres!',
                'preco.required' => 'O Preço é obrigatório!', 
                'preco.numeric' => 'O Preço é do tipo numérico!', 
                'preco.between' => 'O Preço deve ser entre 0 e 999999.99!',
                'foto.required' => 'A Foto é obrigatória!',
                'foto.mimes' => 'A Foto deve ser enviada em um dos formatos: .jpeg, .png, .jpg!',
                'id_tipo.required' => 'O Tipo do Pastel é obrigatório!'
            ]
        );

        if($validator->fails()) return response()->json(['message' => $validator->errors()->first()], 400);

        $id_tipo = $request->input('id_tipo');

        if(!TipoPastelModel::find($id_tipo)) return response()->json(['message' => 'Tipo de Pastel informado não cadastrado!'], 404);

        $foto_pastel = $request->file('foto');

        $foto_nome = time() . md5($foto_pastel->getClientOriginalName()) . '.' . $foto_pastel->getClientOriginalExtension();
        $foto_pastel->move(public_path('storage/pastel'), $foto_nome);

        PastelModel::create([
            'nome' => $request->input('nome'),
            'preco' => $request->input('preco'),
            'path_foto' => $foto_nome,
            'id_tipo' => $id_tipo
        ]);

        return response()->json(['message' => 'Pastel cadastrado com sucesso!'], 201);
    }

    public function listOne($id)
    {
        $pastel = DB::selectOne("SELECT
                                    p.nome AS nome_pastel,
                                    p.preco AS preco_pastel,
                                    p.path_foto AS foto,
                                    t.id AS id_tipo,
                                    t.descricao AS desc_tipo
                                FROM
                                    pastel p
                                INNER JOIN
                                    tipo_pastel t ON
                                    p.id_tipo = t.id
                                WHERE
                                    p.id = {$id}
                                AND
                                    p.deleted_at IS NULL");

        if(!$pastel) return response()->json(['message' => 'Pastel informado não cadastrado!'], 404);

        return response()->json([
            'nome_pastel' => $pastel->nome_pastel,
            'preco_pastel' => $pastel->preco_pastel,
            'path_foto' => url("storage/pastel/$pastel->foto"),
            'id_tipo' => $pastel->id_tipo,
            'desc_tipo' => $pastel->desc_tipo
        ], 200);
    }

    public function listAll()
    {
        $pastel = DB::select("SELECT
                                p.id AS id_pastel,
                                p.nome AS nome_pastel,
                                p.preco AS preco_pastel,
                                p.path_foto AS foto,
                                t.id AS id_tipo,
                                t.descricao AS desc_tipo
                            FROM
                                pastel p
                            INNER JOIN
                                tipo_pastel t ON
                                p.id_tipo = t.id
                            WHERE
                                p.deleted_at IS NULL");

        if(!$pastel) return response()->json(['message' => 'Não há pastéis cadastrados!'], 404);

        return response()->json(PastelResource::collection($pastel), 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->only([
                'nome',
                'preco',
                'foto'
            ]),
            [
                'nome' => 'string|max:100',
                'preco' => 'numeric|between:0,999999.99',
                'foto' => 'mimes:jpeg,png,jpg'
            ],
            [
                'nome.string' => 'O Nome do Pastel é do tipo texto!',
                'nome.max:100' => 'O nome do Pastel deve ter no máximo 100 caracteres!',
                'preco.numeric' => 'O Preço é do tipo numérico!', 
                'preco.between' => 'O Preço deve ser entre 0 e 999999.99!',
                'foto.mimes' => 'A Foto deve ser enviada em um dos formatos: .jpeg, .png, .jpg!'
            ]
        );

        if($validator->fails()) return response()->json(['message' => $validator->errors()->first()], 400);
        
        $pastel = PastelModel::find($id);

        if(!$pastel) return response()->json(['message' => 'Pastel informado não cadastrado!'], 404);

        if($request->input('nome')) $pastel->nome = $request->input('nome');
        if($request->input('preco')) $pastel->nome = $request->input('preco');
        if($request->input('id_tipo')) $pastel->id_tipo = $request->input('id_tipo');

        if($request->file('foto')){
            $foto = $request->file('foto');

            $foto_nome = time() . md5($foto->getClientOriginalName()) . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('storage/pastel/'), $foto_nome);

            $pastel->path_foto = $foto_nome;
        }

        $pastel->save();

        return response()->json([
            'nome' => $pastel['nome'],
            'preco' => $pastel['preco'],
            'foto' => url('storage/pastel/' . $pastel['path_foto']),
            'id_tipo' => $pastel['id_tipo']
        ], 200);
    }

    public function delete($id)
    {
        $pastel = PastelModel::find($id);

        if(!$pastel) return response()->json(['message' => 'Pastel informado não cadastrado!'], 404);

        $pastel->delete();

        return response()->json(['message' => 'Pastel comido com sucesso!'], 418);
    }
}
