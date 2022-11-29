<?php

namespace App\Http\Service\Empresa;

use App\Models\Empresa\EmpresaModel;
use App\Models\Empresa\EmpresaServicoModel;
use App\Models\Foto\FotoModel;
use App\Models\Logo\LogoModel;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class EmpresaService
{
    protected $empresaModel;
    protected $empresaServicoModel;

    public function __construct(EmpresaModel $empresaModel, EmpresaServicoModel $empresaServicoModel)
    {
        $this->empresaModel = $empresaModel;
        $this->empresaServicoModel = $empresaServicoModel;
    }

    public function register(Request $request){
        $attributes = $request->all();

        // $ano_fundacao = implode('-', array_reverse(explode('/', substr($attributes['ano_fundacao'], 0, 10)))).substr($attributes['ano_fundacao'], 10);
        // $data_formatada = new DateTime($ano_fundacao);

        // $attributes['ano_fundacao'] = $data_formatada->format('Y-m-d');

        return $this->empresaModel->create($attributes);
    }

    public function list(){
        $empresasGroup = $this->empresaModel->all();

        foreach ($empresasGroup as $empresaKey) {
            $arquivo = LogoModel::where('empresa_id', $empresaKey->id)->first();

            $path = $arquivo->path.'/'.$arquivo->filename;
            $name = $arquivo->filename;

            $empresaKey->logo = [
                'logo_id'=> $arquivo->id,
                'nome'   => $name,
                'tipo'   => Storage::mimeType($path),
                'base64' => base64_encode(Storage::get($path, $name))
            ];
        }

        return $empresasGroup;
    }

    public function findById($id){
        $empresaDTO = $this->empresaModel->find($id);

        $logo = LogoModel::where('empresa_id', $id)->first();
        $path = $logo->path.'/'.$logo->filename;
        $name = $logo->filename;

        $empresaDTO->logo = [
            'logo_id'=> $logo->id,
            'nome'   => $name,
            'tipo'   => Storage::mimeType($path),
            'base64' => base64_encode(Storage::get($path, $name))
        ];

        return $empresaDTO;
    }

    public function alter(Request $request, $id){
        $attributes = $request->all();

        $this->empresaModel->find($id)->update($attributes);

        return response()->json([
            "message" => "Registro alterado com sucesso!",
            "status" => TRUE,
        ], 200);
    }

    public function vincularTiposServicos(Request $request,  $id){
        $attributes = $request->all();

        try {
            $this->empresaServicoModel->where('empresa_id', $id)->delete();

            foreach ($attributes['servicos'] as $servicoKey) {
                $this->empresaServicoModel->create([
                    'empresa_id' => $id,
                    'servico_id' => $servicoKey['value'],
                ]);
            }

            return response()->json([
                'message' => 'Registro feito com sucesso!',
                'status' => true,
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
                'status' => false,
            ], 400);
        }
        
    }

    public function uploadFoto(Request $request,  $id){
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        $arquivoExistente =  FotoModel::where('filename', $filename)
                                      ->where('empresa_id', $id)->first();
        
        if(!is_null($arquivoExistente)){
            return response()->json([
                'resposta'    => 'Arquivo '. $filename. ' já exite nesta empresa',
                'success' => false
            ], 200);
        }

        $path = 'fotos-empresas/'. $id;

        $upload = $request->file->storeAs($path.'/', $filename);
        if ( !$upload )
            return redirect()
                ->back()
                ->with('error', 'Falha ao fazer upload')
                ->withInput();

        $input['nome'] = $filename;
        $input['filename'] = $filename;
        $input['mime'] = $file->getClientMimeType();
        $input['path'] = $path;
        $input['status_foto'] = 1;
        $input['empresa_id'] = $id;

        if (!$file = FotoModel::create($input)) {
            return response()->json([
                'resposta' => 'Não foi possível fazer upload do arquivo',
                'success'  => false
            ], 200);
        }

        return response()->json([
            'file'    => $file,
            'success' => true
        ], 201);
    }

    public function carregarFotosEmpresas($id){
        $fotoEmpresaGroup = FotoModel::where('empresa_id', $id)->get();

        $resultGroup = [];

        foreach ($fotoEmpresaGroup as $fotoEmpresaKey) {
            $path = $fotoEmpresaKey->path.'/'.$fotoEmpresaKey->filename;
            $name = $fotoEmpresaKey->filename;

            array_push($resultGroup, [
                'foto_id'   => $fotoEmpresaKey->id,
                'nome'   => $name,
                'tipo'   => Storage::mimeType($path),
                'base64' => base64_encode(Storage::get($path, $name))
            ]);
        }

        return $resultGroup;
    }

    public function deletarFotosEmpresas($id){
        $file = FotoModel::find($id);

        if(is_null($file)){
            return response()->json([
                'message'   => 'Record not found in Data Table',
            ], 404);
        }

        $path = $file->path.'/'.$file->filename;
        $name = $file->filename;

        // Primeiro se deleta o arquivo do banco de dados
        if (!$file->delete()) {
            return response()->json([
                'message'   => 'Não foi possível deletar o arquivo no Banco de Dados',
            ], 404);
        }

        // Segundo deleta do storage da aplicação

        if (!$del = Storage::delete($path)) {
            return response()->json([
                'message'   => 'Arquivo deletado no Banco de Dados, porém não no storage da Aplicação',
            ], 200);
        }

        return true;
    }
}