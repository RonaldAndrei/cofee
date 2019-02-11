@extends('layouts.app')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('search').focus();
    };

    function formatar_Data(data, tipo){
        var d = new Date(data),
        ano = ''  +  d.getFullYear(),
        mes = ''  + (d.getMonth() + 1),
        dia = ''  +  d.getDate(),
        hora = '' +  d.getHours(),
        min = ''  +  d.getMinutes();

        if(mes.length  < 2) mes  = '0' + mes;
        if(dia.length  < 2) dia  = '0' + dia;
        if(hora.length < 2) hora = '0' + hora;
        if(min.length  < 2) min  = '0' + min;

        if(tipo == 'nasc') return [dia, mes, ano].join('/');

        return [dia, mes, ano].join('/') + " Horas: " + [hora, min].join(':');
    }

    function detalhes_pessoa(id, tipo){
        if(tipo == 'fisica') {

            $.ajax({
                dataType: 'json',
                url: url+'api/busca_pessoa_fisica_id_detalhes.php',
                data: {busca:id}

            }).done(function(data){
                var id = data[0].id;
                var nome = data[0].nome;
                var cpf = data[0].cpf;
                cpf = cpf.substring(0, 3) + '.' + cpf.substring(3, 6) + '.' + cpf.substring(6, 9) + '-' + cpf.substring(9, 11);
                var rg = data[0].rg;
                rg = rg.substring(0, 2) + '.' + rg.substring(2, 5) + '.' + rg.substring(5, 8) + '-' + rg.substring(8, 9);
                var orgao_expedidor = data[0].orgao_expedidor;
                var sexo = data[0].sexo;
                var data_nascim = formatar_Data(data[0].data_nascim, 'nasc');
                var telefone = data[0].telefone;
                var telefone_sec = data[0].telefone_sec;
                var email = data[0].email;
                var uf = data[0].uf;
                var cidade = data[0].cidade;
                var bairro = data[0].bairro;
                var logradouro = data[0].logradouro;
                var complemento = data[0].complemento;
                var numero = data[0].numero;
                var tipo = data[0].tipo;
                var created_at = formatar_Data(data[0].created_at, 'nc');
                var updated_at = formatar_Data(data[0].updated_at, 'nc');

                if(sexo == 'm'){
                    sexo = 'MASCULINO';
                } else {
                    sexo = 'FEMININO';
                }

                if(tipo == 'c'){
                    tipo = 'Cliente';
                } else if(tipo == 'f'){
                    tipo = 'Fornecedor';
                } else if(tipo == 'cf'){
                    tipo = 'Cliente/Fornecedor';
                }else{
                    tipo = '';
                }

                $('#modal_detalhes').html('<div class="container"><div class="center-block" style="margin-left: 5%;"><table><td><th style="float: right">Nome:</th></td><td style="color: black; font-family: arial; padding-left: 10%; min-width: 250px;">'+nome+'</td><tr><td><th style="float: right">CPF:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+cpf+'</td><tr><td><th style="float: right">RG:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+rg+'</td><tr><td><th style="float: right">Orgão Expedidor:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+orgao_expedidor+'</td><tr><td><th style="float: right">Sexo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+sexo+'</td><tr><td><th style="float: right">Data de nascimento:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+data_nascim+'</td><tr><td><th style="float: right">Telefone:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+telefone+'</td><tr><td><th style="float: right">Telefone Secundário:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+telefone_sec+'</td><tr><td><th style="float: right">Email:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+email+'</td><tr><td><th style="float: right">UF:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+uf+'</td><tr><td><th style="float: right">Cidade:</th></td><td style="color: black; fontuf-family: arial; padding-left: 10%;">'+cidade+'</td><tr><td><th style="float: right">Bairro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+bairro+'</td><tr><td><th style="float: right">Logradouro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+logradouro+'</td><tr><td><th style="float: right">Complemento:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+complemento+'</td><tr><td><th style="float: right">Número:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+numero+'</td><tr><td><th style="float: right">Tipo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+tipo+'</td><tr><td><th style="float: right">Criado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+created_at+'</td><tr><td><th style="float: right">Alterado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+updated_at+'</td></table></div>');    
            });
        }else{
            $.ajax({
                dataType: 'json',
                url: url+'api/busca_pessoa_juridica_id_detalhes.php',
                data: {busca:id}

            }).done(function(data){

                var id = data[0].id;
                var nome_fantasia = data[0].nome_fantasia;
                var cnpj = data[0].cnpj;
                var razao_social = data[0].razao_social;
                var inscricao_estadual = data[0].inscricao_estadual;
                var telefone = data[0].telefone;
                var telefone_sec = data[0].telefone_sec;
                var email = data[0].email;
                var uf = data[0].uf;
                var cidade = data[0].cidade;
                var bairro = data[0].bairro;
                var logradouro = data[0].logradouro;
                var numero = data[0].numero;
                var complemento = data[0].complemento;
                var tipo = data[0].tipo;
                var created_at = formatar_Data(data[0].created_at);
                var updated_at = formatar_Data(data[0].updated_at);

                if(tipo == 'c'){
                    tipo = 'Cliente';
                } else if(tipo == 'f'){
                    tipo = 'Fornecedor';
                } else if(tipo == "cf"){
                    tipo = 'Cliente/Fornecedor';
                }else{
                    tipo = '';
                }

                $('#modal_detalhes').html('<div class="container"><div class="center-block" style="margin-left: 5%;"><table><td><th style="float: right">Nome Fantasia:</th></td><td style="color: black; font-family: arial; padding-left: 10%; min-width: 250px;">'+nome_fantasia+'</td><tr><td><th style="float: right">CNPJ:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+cnpj+'</td><tr><td><th style="float: right">Razão Social:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+razao_social+'</td><tr><td><th style="float: right">Inscrição Estadual:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+inscricao_estadual+'</td><tr><td><th style="float: right">Telefone:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+telefone+'</td><tr><td><th style="float: right">Telefone Secundário:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+telefone_sec+'</td><tr><td><th style="float: right">uf:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+uf+'</td><tr><td><th style="float: right">Cidade:</th></td><td style="color: black; fontuf-family: arial; padding-left: 10%;">'+cidade+'</td><tr><td><th style="float: right">bairro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+bairro+'</td><tr><td><th style="float: right">logradouro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+logradouro+'</td><tr><td><th style="float: right">Número:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+numero+'</td><tr><td><th style="float: right">Complemento:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+complemento+'</td><tr><td><th style="float: right">Tipo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+tipo+'</td><tr><td><th style="float: right">Criado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+created_at+'</td><tr><td><th style="float: right">Alterado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;">'+updated_at+'</td></table></div>');    
            });
        }
    }
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                            <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a>
                            </li>
                            <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked"> 
                                    <li style = "padding-left: 10px " class="active"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span>  Clientes</a></li> 
                                    <li style = "padding-left: 10px "><a href="/cadastro/fornecedor-fisica"> <span class="glyphicon glyphicon-menu-right"></span> Fornecedores</a></li>
                                </ul>
                            </li>
                            <li><a href="/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de Clientes</div>
                        <div class="panel-body">
                        @if($tipo == "cliente-fisica")
                            
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="/cadastro/pessoa/tipo">
                                            <button type="submit" class="btn btn-primary">Novo</button>
                                        </form>
                                    </td>
                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/cliente_fisica/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/cliente-fisica" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            @if($clientesF)
                                <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Telefone</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            
                                @foreach($clientesF as $cliente)

                                    <tbody>
                                        <tr>
                                            <td>{{$cliente->nome}}</td>
                                            <td>{{substr($cliente->cpf,0,3) . "." . substr($cliente->cpf,3,3) . "." . substr($cliente->cpf,6,3) . "-" . substr($cliente->cpf,9,3)}}</td>
                                            <td>{{$cliente->telefone}}</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                <button type="submit" class="btn btn-icon" data-toggle="modal" data-target="#detail_item" onclick="detalhes_pessoa('{{$cliente->id_pessoa_fisica}}','fisica')"><span class="glyphicon glyphicon-eye-open"></span></button>

                                                <form method="GET" action="mailto:{{$cliente->email}}"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-envelope"></span></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                                </TABLE>
                            @endif
                        @endif

                        @if($tipo == "cliente-juridica")
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="/cadastro/pessoa/tipo">
                                            <button type="submit" class="btn btn-primary">Novo</button>
                                        </form>
                                    </td>
                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/cliente_juridica/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/cliente-juridica" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <TABLE  class="table table-hover">
                            @if($clientesJ)
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Razão Social</th>
                                        <th>CNPJ</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                @foreach($clientesJ as $cliente)
                                    <tbody>
                                        <tr>
                                            <td>{{$cliente->nome_fantasia}}</td>
                                            <td>{{$cliente->razao_social}}</td>
                                            <td>{{substr($cliente->cnpj,0,2) . "." . substr($cliente->cnpj,2,3) . "." . substr($cliente->cnpj,5,3) . "/" . substr($cliente->cnpj,8,4)  . "-" . substr($cliente->cnpj,12,2)}}</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                <button type="submit" class="btn btn-icon" data-toggle="modal" data-target="#detail_item" onclick="detalhes_pessoa('{{$cliente->id_pessoa_juridica}}','juridica')"><span class="glyphicon glyphicon-eye-open"></span></button>

                                                <form method="GET" action="mailto:{{$cliente->email}}"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-envelope"></span></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @endif
                            </TABLE>
                        @endif
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
                <div class="panel-heading" align="center">Detalhes do cliente</div>
                <div class="panel-body">
                    <div id="modal_detalhes" class="modal-body" style="color: #1E3973;">
                        <!-- conteudo js -->
                    </div>
                </div>
                <div align="center">
                    <button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
