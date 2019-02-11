@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Estoque</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                            <li class="active"><a href="#">Estoque<span class="sr-only">(current)</span></a></li>
                            <li><a href="/estoque/historico_entrada">Entrada<span class="sr-only">(current)</span></a></li>
                            <li><a href="/estoque/retirada">Retirada<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Produtos em estoque</div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td>
                                    <form method="post" action="busca" class="form-inline" role="search">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Código, descrição, marca ou departamento" value="{{$busca}}" autofocus>
                                        </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                    <td>
                                    <form method="get" action="show" class="form-inline">
                                        <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                </table>
                            </div>
                        </div>
                        <div>
                            <h3 align="center">Nenhum resultado encontrado para <strong>'{{$busca}}'</strong>!</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
