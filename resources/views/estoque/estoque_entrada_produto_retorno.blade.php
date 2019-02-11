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
                url: url+'api/busca_produtos.php',
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

        var id_entrada = "<?php print $entrada->id ?>";
        var id_produto = id;

        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/consulta_produto_inserido.php',
            data: {id_produto:id_produto, id_entrada:id_entrada}
        }).done(function(data){
            $('#modal_entrada').empty();
            if(data==1){
                $('#modal_entrada').html('<div align="center" role="alert">Este produto já foi inserido!</div><br><br><div align="center"><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button></div>');
            }else if(data==0){          
                $.ajax({
                    dataType: 'json',
                    url: url+'api/busca_produto_id.php',
                    data: {busca:id_produto}
                }).done(function(data){
                    var id = data[0].id;
                    var codigo_barras = data[0].codigo_barras;
                    var descricao = data[0].descricao;
                    var nome_marca = data[0].nome_marca;
                    var nome_departamento = data[0].nome_departamento;

                    $('#modal_entrada').html('<form class="form-horizontal"><div class="form-group"><label for="codigo_barras" class="col-md-4 control-label">Código</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="codigo_barras" type="text" class="form-control" name="codigo_barras" value="'+codigo_barras+'" readonly></div><label for="descricao" class="col-md-4 control-label">Descrição</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="descricao" type="text" class="form-control" name="descricao" value="'+descricao+'" readonly></div><label for="marca" class="col-md-4 control-label">Marca</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="marca" type="text" class="form-control" name="marca" value="'+nome_marca+'" readonly></div><label for="departamento" class="col-md-4 control-label">Departamento</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="departamento" type="text" class="form-control" name="departamento" value="'+nome_departamento+'" readonly></div><label for="quantidade" class="col-md-4 control-label">Quantidade</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="quantidade" type="number" min="1" max="99999" class="form-control" name="quantidade" autocomplete="off" onkeyup="calcula_saldo()" required></div><div align="center"><button id="btn_inserir" type="button" class="btn crud-submit btn-primary" onclick="insere_produto('+id+')" data-dismiss="modal" aria-label="Close">Inserir</button><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></div></div></form>');    
                });
            }
        });
    }

    function calcula_saldo(){
        var quantidade =  parseInt(document.getElementById('quantidade').value);

        if(quantidade<=0 || quantidade>99999){
            document.getElementById("btn_inserir").disabled = true;
        }else{
            document.getElementById("btn_inserir").disabled = false;
        }
    }

    function insere_produto(id){
        var id_entrada = "<?php print $entrada->id ?>";
        var id_produto = id;
        var quantidade_produto = document.getElementById('quantidade').value;

        if(id_entrada != '' && id_produto != '' && quantidade_produto != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/create_item_entrada.php',
                data:{id_entrada:id_entrada, id_produto:id_produto, quantidade_produto:quantidade_produto}
            }).done(function(data){
                $('#tabela_item_entrada').empty();

                if(data.length == 0){
                    document.getElementById("btn_salvar").disabled = true;
                }else{
                    document.getElementById("btn_salvar").disabled = false;
                }

                for(var i=0; data.length>i; i++){
                    var id = data[i].id;
                    var id_entrada = data[i].id_entrada;
                    var descricao_produto = data[i].descricao_produto;
                    var quantidade_produto = data[i].quantidade;
                    var saldo = data[i].quantidade_produto;
                    $('#tabela_item_entrada').append('<tr><td>'+descricao_produto+'</td><td>'+quantidade_produto+'</td><td>'+saldo+'</td><td><div style="display: inline-flex; float: right;"><button type="submit" class="btn btn-icon remove" onclick="delete_produto('+id+')"><span class="glyphicon glyphicon-trash"></span></button></div></td></tr>');  
                }
            });
        }
    }

    function delete_produto(id){
        var id_entrada = "<?php print $entrada->id ?>";

        $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/delete_item_entrada.php',
                data:{id_entrada:id_entrada, id:id}
            }).done(function(data){
                $('#tabela_item_entrada').empty();
                if(data=="0"){
                    document.getElementById("btn_salvar").disabled = true;
                }else{
                    document.getElementById("btn_salvar").disabled = false;
                } 
                for(var i=0; data.length>i; i++){
                    var id = data[i].id;
                    var id_entrada = data[i].id_entrada;
                    var descricao_produto = data[i].descricao_produto;
                    var quantidade_produto = data[i].quantidade;
                    var saldo = data[i].quantidade_produto;
                    $('#tabela_item_entrada').append('<tr><td>'+descricao_produto+'</td><td>'+quantidade_produto+'</td><td>'+saldo+'</td><td><div style="display: inline-flex; float: right;"><button type="submit" class="btn btn-icon remove" onclick="delete_produto('+id+')"><span class="glyphicon glyphicon-trash"></span></button></div></td></tr>');  
                }
            });
    }

    function delete_entrada(id){

        $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/delete_entrada.php',
                data:{id_entrada:id}
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
                            <li class="active"><a>Entrada<span class="sr-only">(current)</span></a></li>
                            <li><a>Retirada<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Produtos para entrada no estoque<div style="float: right; font-size: 17pt;"><a target="_blank" href="/estoque/produto/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td colspan="2">
                                        <label class="col-md-3 control-label" for="motivo" style="min-width: 100px;">Motivo</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="motivo" value="{{$entrada->motivo}}" readonly style="min-width: 300px;">
                                        </div>
                                    </td>
                                    <tr></tr>
                                    <td colspan="2">
                                        <label class="col-md-3 control-label" style="min-width: 100px; padding-bottom: 1em; padding-top: 1em;" for="num_nota_fiscal">Procurar</label>
                                        <div class="col-md-6">
                                                <div class="form-group" style="padding-top: 1em;">
                                                    <input style="min-width: 300px;" type="text" id="input_search" name="input_search" class="form-control" placeholder="Código, descrição, marca ou departamento" autofocus="autofocus" onkeypress="getPageDataEnter(event)">
                                                </div>
                                                <td>
                                                    <button type="submit" class="btn btn-icon" onclick="getPageData()"><span class="glyphicon glyphicon-search"></span></button>
                                                    <button type="submit" class="btn btn-icon" onclick="clearPageData()"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                                </td>
                                                {{ csrf_field() }}
                                        </div>
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
                                <tbody id="tabela_produtos"></tbody>     
                            </TABLE>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Lista de produtos inseridos</div>
                        <div class="panel-body">
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                        <th>Saldo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tabela_item_entrada">
                                    <!-- conteudo js -->
                                </tbody>
                            </TABLE>
                        </div>
                    </div>

                    <form method="GET" action="entrada">
                        <div class="form-group">
                            <div align="center">
                                <button id="btn_salvar" type="submit" class="btn btn-primary" disabled="true">
                                    Salvar entrada
                                </button>
                                <button type="submit" class="btn btn-danger" onclick="delete_entrada({{$entrada->id}})">
                                    Cancelar entrada
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
            <div class="panel-heading">Inserir item</div>
            <div class="panel-body">

            <div id="modal_entrada" class="modal-body" style="color: #1E3973">
            <!-- conteudo js -->
        
    
            </div>

            </div>
        </div>
        
        </div>
    </div>
</div>

@endsection
