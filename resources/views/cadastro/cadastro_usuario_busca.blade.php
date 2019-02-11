@extends('layouts.app')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('search').focus();
    };

    function delete_usuario(id,nome){

        $('#modal_delete').html('<div align="center"><p class"p_center">Tem certeza que deseja excluir o usuário "'+nome+'"?</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/cadastro/usuario/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');    
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
                        <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a></li>
                        <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a></li>
                        <li class="active"><a href="#">Usuários<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de usuários</div>
                        <div class="panel-body">
                            
                            <TABLE>
                                <tr>
<!--                                     <td>
                                        <form class="btn-convidar" method="get" action="usuario/convidar">
                                            <button type="submit" class="btn btn-primary">Convidar</button>
                                        </form>
                                    </td> -->
                                    <td>
                                        <form class="btn-new" method="get" action="/cadastro/usuario/cadastrar">
                                            <button type="submit" class="btn btn-primary">Novo</button>
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em; padding-left: 1em;">
                                        <form method="post" action="/cadastro/usuario/busca" class="form-inline" role="search">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" style="min-width:300px; margin-right: 1em;" placeholder="Procurar" value="{{$busca}}" autofocus="true">
                                            </div>
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-search"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>

                                    <td style="padding-bottom: 1em;">
                                        <form method="get" action="/cadastro/usuario" class="form-inline">
                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-arrow-left"></span></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <TABLE  class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th></th>
                                        
                                    </tr>
                                </thead>
                                @if($usuarios)
                                @foreach($usuarios as $usuario)
                                <tbody>
                                    <tr>
                                        <td>{{$usuario->name}}</td>
                                        <td>{{$usuario->email}}</td>
                                        <td>
                                            <div style="display: inline-flex; float: right;">
                                                <form method="GET" action="mailto:{{$usuario->email}}"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-envelope"></span></button></form>
                                                
                                                <form method="GET" action="/cadastro/usuario/{{$usuario->id}}/update"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-pencil"></span></button></form>
                                                
                                                <button type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_usuario('{{$usuario->id}}','{{$usuario->name}}')"><span class="glyphicon glyphicon-trash"></span></button>
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
