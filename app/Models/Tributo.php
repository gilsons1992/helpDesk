<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tributo extends SIACModel
{
    protected $table = 'Tributo';
    protected $primaryKey = 'Id';

    public function itens()
    {
        return $this->hasMany(Item::class, 'TributoId', 'Id');
    }

}
