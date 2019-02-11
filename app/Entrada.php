<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
	protected $table = 'entrada';
    protected $fillable = [
    	'id',
    	'id_usuario',
    	'id_fornecedor',
    	'data_entrada',
    	'serie_nf',
    	'num_nota_fiscal',
    	'motivo'
    ];
}
