<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa_juridica extends Model
{
    protected $fillable = [
    	'cnpj',
        'nome_fantasia', 
        'razao_social', 
        'inscricao_estadual',
        'telefone', 
        'telefone_sec', 
        'email',
        'cep', 
        'logradouro', 
        'numero',
        'bairro',
        'cidade',
        'uf',
        'tipo',
        'ativo'
    ];
}
