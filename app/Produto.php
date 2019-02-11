<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [ 
        'id_produto', 
        'id_marca', 
        'id_departamento',
        'descricao',
        'codigo_barras',
        'saldo',
        'unidade_medida',
        'posicao',
        'corredor',
        'prateleira',
        'minimo',
        'ativo',
        'observacao'
    ];
}
