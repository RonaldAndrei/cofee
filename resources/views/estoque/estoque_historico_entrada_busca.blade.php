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
                        <li><a href="/estoque/show">Estoque<span class="sr-only">(current)</span></a></li>
                        <li class="active"><a href="#">Entrada<span class="sr-only">(current)</span></a></li>
                            <ul class="nav nav-pills nav-stacked">
                                <li class="subactive"><a href="#"> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Histórico entradas</a></li>
                            </ul>
                        <li><a href="/estoque/retirada">Retirada<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Entradas de produto</div>
                        <div class="panel-body">

                            <div style="float: left;">
                                <table>
                                    <td><a href="/estoque/entrada"><button type="submit" class="btn btn-primary">Nova entrada</button></td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="post" action="/estoque/entrada/busca" class="form-inline" role="search">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Número ou responsável" autofocus="true" autocomplete="off">
                                        </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="get" action="/estoque/historico_entrada" class="form-inline">
                                        <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                </table>
                            </div>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nº entrada</th>
                                        <th>Responsável</th>
                                        <th>Data</th>
                                        <th>Tipo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($entradas)
                                    @foreach($entradas as $entrada)
                                    <tbody>
                                        <tr>
                                            <td>{{$entrada->id}}</td>
                                            <td>{{$entrada->responsavel}}</td>
                                            <td>{{$entrada->data_entrada}}</td>
                                            <td>@if($entrada->motivo=='')Compra
                                                @else Retorno
                                                @endif</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                    <form method="get" action="/estoque/entrada/detalhes/{{$entrada->id}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                @endif
                            </TABLE>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
