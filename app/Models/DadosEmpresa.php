<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class DadosEmpresa extends SIACModel
{
    protected $table = 'DadosEmpresa';
    protected $primaryKey = 'Id';

    public function configBanco()
    {
        return $this->hasMany(configBanco::class, 'DadosEmpresaId', 'Id');
    }

}
