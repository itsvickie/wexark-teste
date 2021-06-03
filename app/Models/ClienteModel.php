<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'email',
        'telefone',
        'data_nascimento',
        'senha',
        'rua_endereco',
        'numero_endereco',
        'complemento_endereco',
        'bairro_endereco',
        'cep_endereco',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $table = 'cliente';
}
