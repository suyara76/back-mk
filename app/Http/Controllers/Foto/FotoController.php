<?php

namespace App\Http\Controllers\Foto;

use App\Http\Controllers\Controller;
use App\Http\Service\Foto\FotoService;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    protected $empresaService;

    public function __construct(FotoService $fotoService)
    {
        $this->fotoService = $fotoService;
    }

    public function uploadLogoEmpresa(Request $request, $id)
    {
        return $this->fotoService->uploadLogoEmpresa($request, $id);
    }

    public function logoFindById($id)
    {
        return $this->fotoService->logoFindById($id);
    }

    public function deleteLogoEmpresa($id)
    {
        return $this->fotoService->deleteLogoEmpresa($id);
    }
}
