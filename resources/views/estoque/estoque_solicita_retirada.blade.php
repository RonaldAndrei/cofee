@extends('layouts.app2')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('input_search').focus();
    };
   
    function getPageDataEnter(event) {
        if(event.keyCode == 13){
            getPageData();
        } 
    }

    function getPageData() {
        var busca = document.getElementById('input_search');
        if(busca.value === ''){
            clearPageData();
        }else{

            $('#tabela_produtos').empty();
            $.ajax({
                dataType: 'json',
                url: url+'api/busca_produtos_retirada.php',
                data: {busca:busca.value}
            }).done(function(data){
                if(data==0){
                    $('#tabela_produtos').append('<tr><td colspan="5"><p align="center">Nenhum resultado encontrado!</p></td>');
                }
                for(var i=0; data.length>i; i++){
                    var id = data[i].id;
                    var codigo_barras = data[i].codigo_barras;
                    var descricao = data[i].descricao;
                    var nome_marca = data[i].nome_marca;
                    var nome_departamento = data[i].nome_departamento;
                    var saldo = data[i].saldo;
                    $('#tabela_produtos').append('<tr><td>'+codigo_barras+'</td><td>'+descricao+'</td><td>'+nome_marca+'</td><td>'+nome_departamento+'</td><td>'+saldo+'</td><td><div style="display: inline-flex; float: right;"><button type="submit" class="btn btn-icon add" data-toggle="modal" data-target="#create-item" onclick="dados_modal('+id+')"><span class="glyphicon glyphicon-plus"></span></button></div></td></tr>');  
                }

            });
        }
    }

    function clearPageData(){
        $("#input_search").val('');
        $('#tabela_produtos').empty();
        document.getElementById('input_search').focus();
    }

    function dados_modal(id){

        var id_solicitacao_produto = "<?php print $retirada->id ?>";
        var id_produto = id;

        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/consulta_produto_solicitado.php',
            data: {id_produto:id_produto, id_solicitacao_produto:id_solicitacao_produto}
        }).done(function(data){
            $('#modal_retirada').empty();
            if(data==1){
                $('#modal_retirada').html('<div align="center" role="alert">Este produto já foi solicitado!</div><br><br><div align="center"><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button></div>');
            }else if(data==0){ 
                $.ajax({
                    dataType: 'json',
                    url: url+'api/busca_produto_id.php',
                    data: {busca:id}
                }).done(function(data){
                    var id = data[0].id;
                    var codigo_barras = data[0].codigo_barras;
                    var descricao = data[0].descricao;
                    var nome_marca = data[0].nome_marca;
                    var nome_departamento = data[0].nome_departamento;
                    var saldo = data[0].saldo;

                    $('#modal_retirada').html('<form class="form-horizontal"><div class="form-group"><label for="codigo_barras" class="col-md-4 control-label">Código</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="codigo_barras" type="text" class="form-control" name="codigo_barras" value="'+codigo_barras+'" readonly></div><label for="descricao" class="col-md-4 control-label">Descrição</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="descricao" type="text" class="form-control" name="descricao" value="'+descricao+'" readonly></div><label for="marca" class="col-md-4 control-label">Marca</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="marca" type="text" class="form-control" name="marca" value="'+nome_marca+'" readonly></div><label for="departamento" class="col-md-4 control-label">Departamento</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="departamento" type="text" class="form-control" name="departamento" value="'+nome_departamento+'" readonly></div><label for="saldo" class="col-md-4 control-label">Saldo</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="saldo" type="text" class="form-control" name="saldo" value="'+saldo+'" readonly></div><label for="quantidade" class="col-md-4 control-label">Quantidade</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="quantidade" type="number" min="1" max="99999" class="form-control" name="quantidade" autocomplete="off" onkeyup="calcula_saldo()" required></div><div align="center"><button id="btn_inserir" type="button" class="btn crud-submit btn-primary" onclick="solicita_produto('+id+')" data-dismiss="modal" aria-label="Close">Retirar</button><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></div></div></form>');    
                });
            }
        });
    }

    function calcula_saldo(){
        var saldo =  parseInt(document.getElementById('saldo').value);
        var qtd_solicitada =  parseInt(document.getElementById('quantidade').value);

        if(qtd_solicitada>saldo){
            document.getElementById("btn_inserir").disabled = true; 
        }else if(qtd_solicitada<=0 || qtd_solicitada>99999){
            document.getElementById("btn_inserir").disabled = true;
        }else{
            document.getElementById("btn_inserir").disabled = false;
        }
    }

    function solicita_produto(id){
        var id_retirada = "<?php print $retirada->id ?>";
        var id_produto = id;
        var qtd_solicitada = document.getElementById('quantidade').value;

        if(id_retirada != '' && id_produto != '' && qtd_solicitada != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/create_item_retirada.php',
                data:{id_retirada:id_retirada, id_produto:id_produto, qtd_solicitada:qtd_solicitada}
            }).done(function(data){
                $('#tabela_item_retirada').empty();
                if(data.length == 0){
                    document.getElementById("btn_salvar").disabled = true;
                }else{
                    document.getElementById("btn_salvar").disabled = false;
                }
                for(var i=0; data.length>i; i++){  
                    var id = data[i].id;
                    var descricao_produto = data[i].descricao_produto;
                    var qtd_solicitada = data[i].qtd_solicitada;
                    var saldo_produto = (data[i].qtd_produto - qtd_solicitada);
                    var minimo_produto = data[i].minimo_produto;
                    $('#tabela_item_retirada').append('<tr><td>'+descricao_produto+'</td><td>'+qtd_solicitada+'</td><td>'+saldo_produto+'</td><td>'+minimo_produto+'</td><td><div style="display: inline-flex; float: right;"><button type="submit" class="btn btn-icon remove" onclick="delete_produto('+id+')"><span class="glyphicon glyphicon-trash"></span></button></div></td></tr>');  
                }
            });
        }
    }

    function delete_produto(id){
        var id_retirada = "<?php print $retirada->id ?>";
        $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/delete_item_retirada.php',
                data:{id_retirada:id_retirada, id:id}
            }).done(function(data){
                $('#tabela_item_retirada').empty();
                if(data=="0"){
                    document.getElementById("btn_salvar").disabled = true;
                }else{
                    document.getElementById("btn_salvar").disabled = false;
                }     
                for(var i=0; data.length>i; i++){
                    var id = data[i].id;
                    var descricao_produto = data[i].descricao_produto;
                    var qtd_solicitada = data[i].qtd_solicitada;
                    var saldo_produto = (data[i].qtd_produto - qtd_solicitada);
                    var minimo_produto = data[i].minimo_produto;
                    $('#tabela_item_retirada').append('<tr><td>'+descricao_produto+'</td><td>'+qtd_solicitada+'</td><td>'+saldo_produto+'</td><td>'+minimo_produto+'</td><td><div style="display: inline-flex; float: right;"><button type="submit" class="btn btn-icon remove" onclick="delete_produto('+id+')"><span class="glyphicon glyphicon-trash"></span></button></div></td></tr>');  
                }
            });
    }

    function delete_retirada(id){

        $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/delete_retirada.php',
                data:{id_retirada:id}
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
                            <li><a><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                            <li><a>Estoque<span class="sr-only">(current)</span></a></li>
                            <li><a>Entrada<span class="sr-only">(current)</span></a></li>
                            <li class="active"><a>Retirada<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked">
                                    <li style = "padding-left: 10px;"><a> <span class="glyphicon glyphicon-menu-right"></span>  Solicitações retirada</a></li> 
                                    <li style = "padding-left: 10px;"><a> <span class="glyphicon glyphicon-menu-right"></span> Solicitações compra</a></li>
                                    <li class="subactive" ><a> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span> Solicitar retirada</a></li>
                                </ul>
                            </li>
                            <li><a>Relatórios<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Solicitar produtos do estoque<div style="float: right; font-size: 17pt;"><a target="_blank" href="/estoque/retirada_produto/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td style="float: left;">
                                        <label class="col-md-3 control-label" style="min-width: 100px; padding-bottom: 1em;" for="num_nota_fiscal">Procurar</label>
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding-bottom: : 1em; margin-right: 1em;">
                                                <input style="min-width: 300px;" type="text" id="input_search" name="input_search" class="form-control" placeholder="Código, descrição, marca ou departamento" onkeypress="getPageDataEnter(event)">
                                            </div>
                                            <td>
                                                <button type="submit" class="btn btn-icon" onclick="getPageData()"><span class="glyphicon glyphicon-search"></span></button>
                                                <button type="submit" class="btn btn-icon" onclick="clearPageData()"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            </td>
                                        </div>
                                        <td>
                                        <label class="col-md-5 control-label" for="num_nota_fiscal" style="min-width: 100px;">Nº solicitação</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="num_nota_fiscal" value="{{$retirada->id}}" readonly style="min-width: 200px;">
                                        </div>
                                        </td>
                                        {{ csrf_field() }}
                                    </td>
                                </table>
                            </div>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                        <th>Marca</th>
                                        <th>Departamento</th>
                                        <th>Saldo</th>
                                        <th></th>
                                    </tr>
                                </thead>   
                                <tbody id="tabela_produtos">
                                    <!-- conteudo js -->
                                </tbody>     
                            </TABLE>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Lista de produtos solicitados</div>
                        <div class="panel-body">
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Qtd. solicitada</th>
                                        <th>Saldo</th>
                                        <th>Mínimo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tabela_item_retirada">
                                    <!-- conteudo js -->
                                </tbody>
                            </TABLE>
                        </div>
                    </div>

                    <form method="GET" action="retirada">
                        <div class="form-group">
                            <div align="center">
                                <button id="btn_salvar" type="submit" class="btn btn-primary" disabled="true">
                                    Salvar solicitação
                                </button>
                                <button type="submit" class="btn btn-danger" onclick="delete_retirada({{$retirada->id}})">
                                    Cancelar solicitação
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Create Item Modal -->
<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div class="panel panel-default">
            <div class="panel-heading">Retirar item</div>
            <div class="panel-body">

            <div id="modal_retirada" class="modal-body" style="color: #1E3973">
            <!-- conteudo js -->
            </div>

            </div>
        </div>
        
        </div>
    </div>
</div>

@endsection
