<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_cliente',
        'id_pastel',
        'created_at',
        'updated_at'
    ];

    protected $table = 'pedido';
}
