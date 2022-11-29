<?php

namespace App\Models\Logo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoModel extends Model
{
    use HasFactory;
    protected $table = 'logo';

    protected $fillable = [
        'nome',
        'filename',
        'mime',
        'path',
        'size',
        'status_logo',
        'empresa_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
