<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends SIACModel
{
    protected $table = 'Item';
    protected $primaryKey = 'Id';

	public function categoria()
	{
		return $this->belongsTo(Categoria::class, 'CategoriaId', 'Id');
	}

	public static function codigoDeBarrasExiste($codigoBarras) {
		$count = Item::where('CodigoBarras', $codigoBarras)->count();
		return ($count > 0);
	}
}
