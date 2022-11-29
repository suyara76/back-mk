<?php

namespace App\Models\Foto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoModel extends Model
{
    use HasFactory;
    protected $table = 'foto';

    protected $fillable = [
        'nome',
        'filename',
        'mime',
        'path',
        'size',
        'status_foto',
        'empresa_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
