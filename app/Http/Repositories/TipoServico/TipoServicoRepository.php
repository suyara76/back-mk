<?php

namespace App\Http\Repositories\TipoServico;

use App\Models\TipoServico\TipoServicoModel;

class TipoServicoRespository
{
    protected $tipoServicoModel;

    public function __construct(TipoServicoModel $tipoServicoModel)
    {
        $this->tipoServicoModel = $tipoServicoModel;
    }

    public function all(){
        return $this->tipoServicoModel->all();
    }

    public function save(array $attributes)
    {
        $this->tipoServicoModel->create($attributes);
    }
}