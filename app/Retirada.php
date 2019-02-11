<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retirada extends Model
{
	protected $table = 'solicitacao_produto';
    protected $fillable = [
    	'id',
    	'id_usuario_solicitante',
    	'id_usuario_aprova',
    	'data_solicitacao',
    	'data_aprovacao',
    	'observacao',
    	'status'
    ];
}
