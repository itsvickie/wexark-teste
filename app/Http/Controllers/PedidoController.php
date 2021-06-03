<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\PedidoModel;
use App\Models\PedidoPasteisController;
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
            PedidoPasteisController::create([
                'id_pedido' => $pedido['id'],
                'id_pastel' => $pastel['id']
            ]);
        }

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

        $pedido_itens = PedidoPasteisController::where('id_pedido', $id)->get(['id']);

        $res = [
            'id_cliente' => $pedido['id_cliente'],
            'data_criacao_pedido' => $pedido['created_at'],
            'pasteis' => $pedido_itens
        ];

        return response()->json($res, 200);
    }
}
