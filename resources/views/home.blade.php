@extends('layouts.app2')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="well well-lg">
                <div>
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="/cadastro/produto"><span class="glyphicon glyphicon-folder-open" aria-hidden="true" style="font-size: 30px;"></span><br>Cadastros</a></li>
                        <li><a href="/estoque/show"><span class="glyphicon glyphicon-home" aria-hidden="true" style="font-size: 30px;"></span><br>Estoque</a></li>
                        <li><a href="/contas/resumo"><span class="glyphicon glyphicon-usd" aria-hidden="true" style="font-size: 30px;"></span><br>Contas</a></li>
                    </ul>
                </div>
            </div>
<!--
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Seja bem vindo!
                </div>
            </div>
-->
        </div>
    </div>
</div>
@endsection