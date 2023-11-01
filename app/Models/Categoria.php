<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Categoria extends SIACModel
{
    protected $table = 'Categoria';
    protected $primaryKey = 'Id';

    public function itens()
    {
        return $this->hasMany(Item::class, 'CategoriaId', 'Id');
    }

}
