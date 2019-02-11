@extends('layouts.app')

@section('content')

<script type="text/javascript">
    
    window.onload = function() {
        document.getElementById('search').focus();
    };

    function delete_departamento(id,nome){

        $('#modal_delete').html('<div align="center"><p>Tem certeza que deseja excluir o departamento "'+nome+'"?</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/cadastro/departamento/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');    
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
                                <ul class="nav nav-pills nav-stacked"> 
                                    <li style = "padding-left: 10px" class="active"><a href="#"> <span class="glyphicon glyphicon-menu-right"></span>  Departamento</a></li> 
                                    <li style = "padding-left: 10px "><a href="/cadastro/marca"> <span class="glyphicon glyphicon-menu-right"></span> Marca</a></li> 
                                </ul>
                            </li>
                            <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a></li>
                            <li><a href="/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de Departamentos</div>
                        <div class="panel-body">
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="/cadastro/departamento/cadastrar">
                                            <button type="submit" class="btn btn-primary">Novo Departamento</button>
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/departamento/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input id="search" type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/departamento" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Nome</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($departamentos)
                                    @foreach($departamentos as $departamento)
                                    <tbody>
                                        <tr>
                                            <td>{{$departamento->id}}</td>
                                            <td>{{$departamento->nome}}</td>
                                            <td>
                                            <div style="display: inline-flex; float: right;">
                                            <form method="GET" action="/cadastro/departamento/{{$departamento->id}}/update"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-pencil"></span></button></form>
                                            
                                            <button type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_departamento('{{$departamento->id}}','{{$departamento->nome}}')"><span class="glyphicon glyphicon-trash"></span></button>
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
<div class="modal fade" id="delete_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Atenção!</div>
                <div class="panel-body">
                    <div id="modal_delete" class="modal-body" style="color: #1E3973;">
                    <!-- conteudo js -->
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
