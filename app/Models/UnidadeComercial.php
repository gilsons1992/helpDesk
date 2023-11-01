<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class UnidadeComercial extends SIACModel
{
    protected $table = 'unidadecomercial';
    protected $primaryKey = 'Id';

    public function itens()
    {
        return $this->hasMany(Item::class, 'UnidadeComercialId', 'Id');
    }

	public static function codigoExiste($codigo) {
		$count = UnidadeComercial::where('Codigo', $codigo)->count();
		return ($count > 0);
	}
}
