<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PastelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id_pastel' => $this->id_pastel,
            'nome_pastel' => $this->nome_pastel,
            'preco_pastel' => $this->preco_pastel,
            'path_foto' => url("storage/pastel/$this->foto"),
            'id_tipo' => $this->id_tipo,
            'desc_tipo' => $this->desc_tipo
        ];
    }
}
