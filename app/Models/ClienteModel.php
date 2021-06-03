<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteModel extends Model
{
    use HasFactory;
    use SoftDeletes;

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
