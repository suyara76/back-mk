<?php

namespace App\Http\Service\Foto;

use App\Models\Empresa\EmpresaModel;
use App\Models\Empresa\EmpresaServicoModel;
use App\Models\Foto\FotoModel;
use App\Models\Logo\LogoModel;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class FotoService
{
    protected $fotoModel;
    protected $logoModel;

    public function __construct(FotoModel $fotoModel, LogoModel $logoModel)
    {
        $this->fotoModel = $fotoModel;
        $this->logoModel = $logoModel;
    }

    public function uploadLogoEmpresa(Request $request, $id){
        $attributes = $request->all();

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        $arquivoExistente =  LogoModel::where('filename', $filename)
                                      ->where('empresa_id', $id)->first();
        
        if(!is_null($arquivoExistente)){
            return response()->json([
                'resposta'    => 'Arquivo '. $filename. ' já exite nesta empresa',
                'success' => false
            ], 200);
        }

        $path = 'logos-empresas/'. $id;

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

        if (!$file = LogoModel::create($input)) {
            return response()->json([
                'resposta' => 'Não foi possível fazer upload do arquivo',
                'success'  => false
            ], 200);
        }

        return response()->json([
            'file'    => $file,
            'success' => true
        ], 201);

        return $this->empresaModel->create($attributes);
    }

    public function logoFindById($id){
        $fotoEmpresaGroup = LogoModel::where('empresa_id', $id)->first();

        $path = $fotoEmpresaGroup->path.'/'.$fotoEmpresaGroup->filename;
        $name = $fotoEmpresaGroup->filename;

        return [
            'foto_id'=> $fotoEmpresaGroup->id,
            'nome'   => $name,
            'tipo'   => Storage::mimeType($path),
            'base64' => base64_encode(Storage::get($path, $name))
        ];
    }

    public function deleteLogoEmpresa($id){
        $file = LogoModel::find($id);

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