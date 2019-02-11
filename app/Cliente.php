<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
   protected $fillable = [
        'id', 
        'id_pessoa_fisica',
        'id_pessoa_juridica',
    ];
}
