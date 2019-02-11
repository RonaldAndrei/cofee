@extends('layouts.app')

@section('content')

<script type="text/javascript">

    // var url = "http://localhost:8000/";

    function modal_confirmar(id){

        $.ajax({
            dataType: 'json',
            url: url+'api/busca_compra_id_detalhes.php',
            data: {busca:id}
        }).done(function(data){
            
            var descricao = data[0].descricao;

            if(data[0].confirmado == '1'){
                var status = "Confirmado";
            }else{
                var status = "Pendente";

                $('#modal_detalhes').html('<div align="center"><p class="p_center">Confirmar a compra de '+descricao+'?</div><div align="center"><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close" onclick="confirma_compra('+id+')"><span aria-hidden="true">Confirmar compra</span></button><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button></div>'); 
            }              
        });
    }

    function confirma_compra(id){
        
        var id_solicitacao = id;
        var id_usuario_confirma = "<?php print Auth::user()->id ?>";

        $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/confirma_compra_item.php',
                data:{id_solicitacao:id_solicitacao, id_usuario_confirma:id_usuario_confirma}
            }).done(function(){
                location.reload();
            });
    }

</script>

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
                                    <li style = "padding-left: 5px;"><a href="/estoque/retirada"><span class="glyphicon glyphicon-menu-right"></span>   Solicitações retirada</a></li> 
                                    <li class="subactive"><a href="#"><span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span> Solicitações compra</a></li>
                                    <!-- <li style = "padding-left: 5px;"><a href="/estoque/solicita_retirada"> <span class="glyphicon glyphicon-menu-right"></span> Solicitar retirada</a></li> -->
                                </ul>
                            </li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Solicitações de compra</div>
                        <div class="panel-body">

                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td>
                                    <form method="post" action="/estoque/compra/busca" class="form-inline" role="search">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" value="{{$busca}}" placeholder="Produto ou solicitante" autofocus="true" autocomplete="off">
                                        </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                    <td>
                                    <form method="get" action="/estoque/compra" class="form-inline">
                                        <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                        {{ csrf_field() }}
                                    </form>
                                    </td>
                                </table>
                            </div>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Saldo</th>
                                        <th>Mínimo</th>
                                        <th>Solicitante</th>
                                        <th>Data solicitação</th>
                                        <th>Data confirmação</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($solicitacoes)
                                    @foreach($solicitacoes as $solicitacao)
                                    <tbody>
                                        <tr>
                                            <td>{{$solicitacao->descricao}}</td>
                                            <td>{{$solicitacao->saldo}}</td>
                                            <td>{{$solicitacao->minimo}}</td>
                                            <td>{{$solicitacao->solicitante}}</td>
                                            <td>{{$solicitacao->data_solicitacao}}</td>
                                            <td>{{$solicitacao->data_confirmacao}}</td>
                                            <td>@if($solicitacao->confirmado)Confirmado
                                                <div style="display: inline-flex; float: right;">
                                                    <button type="submit" class="btn btn-icon add" disabled><span class="glyphicon glyphicon-ok"></span></button>
                                                </div>
                                                @else Pendente
                                                <div style="display: inline-flex; float: right;">
                                                    <button type="submit" class="btn btn-icon add" data-toggle="modal" data-target="#detail_item" onclick="modal_confirmar('{{$solicitacao->id}}')"><span class="glyphicon glyphicon-ok"></span></button>
                                                </div>
                                                @endif</td>
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

<div class="modal fade" id="detail_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Detalhes da solicitação</div>
                <div class="panel-body">
                    <div id="modal_detalhes" class="modal-body" style="color: #1E3973;">
                    <!-- conteudo js -->
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

@endsection
