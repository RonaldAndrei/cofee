<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa_fisica extends Model
{
    protected $fillable = [
        'nome', 
        'cpf', 
        'rg',
        'orgao_expedidor',
        'sexo', 
        'data_nascim', 
        'telefone',
        'telefone_sec', 
        'email', 
        'cep',
        'logradouro',
        'complemento',
        'numero',
        'bairro', 
        'cidade', 
        'uf',
        'tipo',
        'ativo'
    ];
}
