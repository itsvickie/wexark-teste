<?php

namespace App\Http\Controllers;

use App\Models\TipoPastelModel;
use Illuminate\Http\Request;

class TipoPastelController extends Controller
{
    public function listAll()
    {
        return response()->json(TipoPastelModel::all(), 200);
    }
}
