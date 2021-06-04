<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PastelModel extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'id',
        'nome',
        'preco',
        'path_foto',
        'id_tipo',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $table = 'pastel';
}
