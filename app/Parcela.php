<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $table = 'parcelas';
    protected $fillable = [
        'id',
        'id_conta_pagar',
        'id_conta_receber',
        'id_forma_pagamento',
        'valor_parcela',
        'valor_pago',
        'num_parcela',
        'data_vencimento',
        'data_pagamento',
        'status'
    ];
}