<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPastelModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao'
    ];

    public $timestamps = false;
    
    protected $table = 'tipo_pastel';
}
