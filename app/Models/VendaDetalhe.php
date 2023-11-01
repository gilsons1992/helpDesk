<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class VendaDetalhe extends SIACModel
{
    protected $table = 'VendaDetalhe';
    protected $primaryKey = 'Id';

    public function item()
	{
		return $this->belongsTo(Item::class, 'ItemId', 'Id');
	}

}
