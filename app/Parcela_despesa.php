<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parcela_despesa extends Model
{
    protected $table = 'parcelas_despesa';
    protected $fillable = [
        'id',
        'id_conta_pagar',
        'id_forma_pagamento',
        'valor_parcela',
        'valor_pago',
        'num_parcela',
        'data_vencimento',
        'data_pagamento',
        'status'
    ];
}