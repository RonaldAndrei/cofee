<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
	protected $table = 'contas_receber';
    protected $fillable = [
    	'id',
        'id_categoria',
        'id_cliente',
        'descricao',
        'valor',
        'valor_pago',
        'qtd_parcelas',
        'qtd_parcelas_pagas',
        'status'
    ];
}
