<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    protected $table = 'contas_pagar';
    protected $fillable = [
        'id',
        'id_categoria',
        'id_fornecedor',
        'descricao',
        'valor',
        'valor_pago',
        'qtd_parcelas',
        'qtd_parcelas_pagas',
        'status'
    ];
}
