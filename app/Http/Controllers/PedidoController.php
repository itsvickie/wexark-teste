<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\PastelModel;
use App\Models\PedidoModel;
use App\Models\PedidoPasteisModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->only(['id_cliente', 'id_pasteis']),
            [
                'id_cliente' => 'required|int',
                'id_pasteis' => 'required'
            ],
            [
                'id_cliente.required' => 'O código do Cliente é obrigatório!',
                'id_cliente.int' => 'O código do Cliente é do tipo inteiro!',
                'id_pasteis.required' => 'O código do Pastel é obrigatório!'
            ]
        );

        if($validator->fails()) return response()->json(['message' => $validator->errors()->first()], 400);

        $cliente = ClienteModel::find($request->input('id_cliente'));

        if(!$cliente) return response()->json(['message' => 'O Cliente informado não está cadastrado!'], 404);

        $pedido = PedidoModel::create(['id_cliente' => $cliente['id']]);

        $pasteis = $request->input('id_pasteis');

        foreach($pasteis as $pastel){
            PedidoPasteisModel::create([
                'id_pedido' => $pedido['id'],
                'id_pastel' => $pastel['id']
            ]);
        }

        // Após a criação do pedido, o sistema deve disparar um email para o cliente
        // contendo os detalhes do seu pedido.


        return response()->json(['message' => 'Pedido criado com sucesso!'], 201);
    }

    public function listAll()
    {
        $pedidos = PedidoModel::get(['id', 'id_cliente', 'created_at']);

        return response()->json($pedidos, 200);
    }

    public function listOne($id)
    {
        $pedido = PedidoModel::where('id', $id)->first(['id_cliente', 'created_at']);

        if(!$pedido) return response()->json(['message' => 'Pedido informado não cadastrado!'], 404);

        $pedido_pasteis = PedidoPasteisModel::where('id_pedido', $id)->get(['id_pastel']);

        $pasteis = PastelModel::whereIn('id', $pedido_pasteis)->get(['id', 'nome', 'preco']);

        return response()->json([
            'id_cliente' => $pedido['id_cliente'],
            'data_criacao_pedido' => $pedido['created_at'],
            'pasteis_produto' => $pasteis
        ], 200);
    }

    public function delete($id)
    {
        $pedido = PedidoModel::find($id);

        if(!$pedido) return response()->json(['message' => 'Pedido informado não cadastrado!'], 404);

        $pedido->delete();

        return response()->json(['message' => 'Pedido excluído com sucesso!'], 200);
    }
}
