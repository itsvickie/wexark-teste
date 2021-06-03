<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoPasteisController extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_pedido',
        'id_pastel'
    ];

    public $timestamps = false;

    protected $table = 'pedido_pasteis';
}
