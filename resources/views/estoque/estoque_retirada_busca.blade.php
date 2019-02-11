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
                            <li><a href="/estoque/historico_entrada">Entrada<span class="sr-only">(current)</span></a></li>
                            <li class="active"><a>Retirada<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="subactive"><a href="/estoque/retirada"> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Solicitações retirada</a></li> 
                                    <li style = "padding-left: 5px;"><a href="/estoque/compra"> <span class="glyphicon glyphicon-menu-right"></span> Solicitações compra</a></li>
                                   <!--  <li style = "padding-left: 5px;"><a href="/estoque/solicita_retirada"> <span class="glyphicon glyphicon-menu-right"></span> Solicitar retirada</a></li> -->
                                </ul>
                            </li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Solicitações de retirada</div>
                        <div class="panel-body">

                            <div style="float: left;">
                                <table>
                                    <td><a href="/estoque/solicita_retirada"><button type="submit" class="btn btn-primary">Solicitar retirada</button></td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="post" action="/estoque/retirada/busca" class="form-inline" role="search">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar: número ou solicitante" value="{{$busca}}" autofocus="true" autocomplete="off">
                                        </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                    <td style="padding-bottom: 1em;">
                                    <form method="get" action="/estoque/retirada" class="form-inline">
                                        <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                </table>
                            </div>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nº solicitação</th>
                                        <th>Solicitante</th>
                                        <th>Data solicitação</th>
                                        <th>Usuário aprovador</th>
                                        <th>Data aprovação</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($solicitacoes)
                                    @foreach($solicitacoes as $solicitacao)
                                    <tbody>
                                        <tr>
                                            <td>{{$solicitacao->id}}</td>
                                            <td>{{$solicitacao->solicitante}}</td>
                                            <td>{{$solicitacao->data_solicitacao}}</td>
                                            <td>{{$solicitacao->aprovador}}</td>
                                            <td>{{$solicitacao->data_aprovacao}}</td>
                                            <td>@if($solicitacao->status=='p')Pendente
                                                @else Finalizada
                                                @endif</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                    <form method="get" action="/estoque/retirada/detalhes/{{$solicitacao->id}}">
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
