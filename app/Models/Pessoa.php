<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pessoa extends Model
{
    protected $fillable = [
        'nome',
        'documento',
        'email',
        'celular_whatsapp'
    ];

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class);
    }
}
