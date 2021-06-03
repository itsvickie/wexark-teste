<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastelModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'preco',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $table = 'pastel';
}
