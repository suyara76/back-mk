<?php

namespace App\Http\Service\TipoServico;

use App\Models\TipoServico\TipoServicoModel;
use Illuminate\Http\Request;

class TipoServicoService
{
    protected $tipoServicoModel;

    public function __construct(TipoServicoModel $tipoServicoModel)
    {
        $this->tipoServicoModel = $tipoServicoModel;
    }

    public function register(Request $request){
        $attributes = $request->all();
        
        $this->tipoServicoModel->create($attributes);

        return response()->json([
            "message" => "Registro feito com sucesso!"
        ], 200);
    }

    public function list(){
        return $this->tipoServicoModel->all();
    }

    public function findById($id){
        return $this->tipoServicoModel->find($id);
    }

    public function alter(Request $request, $id){
        $attributes = $request->all();

        $this->tipoServicoModel->find($id)->update($attributes);

        return response()->json([
            "message" => "Registro alterado com sucesso!"
        ], 200);
    }
}