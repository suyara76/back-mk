<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaServicoModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'servico_id',
    ];
    
    protected $table = 'empresa_servico';
}