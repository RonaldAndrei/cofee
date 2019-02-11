<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Help_Controller extends Controller
{
    public function help_cadastro($atributo){

        return view('cadastro.cadastro_help', compact('atributo'));
    }

    public function help_estoque($atributo){

        return view('estoque.estoque_help', compact('atributo'));
    }
}