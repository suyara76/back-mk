<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Service\Empresa\EmpresaService;
use Exception;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    protected $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->empresaService->list();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            return response()->json($this->empresaService->register($request), 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ],404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->empresaService->findById($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->empresaService->alter($request, $id);
    }

    public function vincularTiposServicos(Request $request, $id){
        $this->empresaService->vincularTiposServicos($request, $id);
    }

    public function uploadFoto(Request $request, $id){
        $this->empresaService->uploadFoto($request, $id);
    }

    public function carregarFotosEmpresas($id){
        return $this->empresaService->carregarFotosEmpresas($id);
    }

    public function deletarFotosEmpresas($id){
        return $this->empresaService->deletarFotosEmpresas($id);
    }
}
