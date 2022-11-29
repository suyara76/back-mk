<?php

namespace App\Models\TipoServico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoServicoModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'status_servico',
    ];

    protected $table = 'tipo_servico';
}