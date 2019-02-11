@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                            <li><a href="./produto">Produtos<span class="sr-only">(current)</span></a></li>
                            <li><a href="./cliente">Clientes<span class="sr-only">(current)</span></a></li>
                            <li><a href="./fornecedor">Fornecedores<span class="sr-only">(current)</span></a></li>
                            <li class="active"><a href="#">Usuários<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Convidar novo usuário</div>
                        <div class="panel-body">
                            <form method="post" action="convidar">
                                <div class="form-group">
                                    <label for="name">Nome *</label>
                                    <input type="text" name="name" id="nome" class="form-control" placeholder="Seu nome" required="true">
                                </div>
                                <div class="form-group">
                                    <label for="name">Convidado(a) *</label>
                                    <input type="text" name="convidado" id="convidado" class="form-control" placeholder="Nome do convidado(a)" required="true">
                                </div>
                                <div class="form-group">
                                    <label for="mail">E-mail *</label>
                                    <input type="email" name="email" id="email_usuario" class="form-control" placeholder="E-mail do convidado(a)" required="true">
                                </div>
                                <div class="form-group">
                                    <label for="text">Observações</label>
                                    <textarea name="obs" id="obs_convite" class="form-control" placeholder="Escreva sua mensagem..." rows="5" cols="40"></textarea>
                                </div>
                                    {{ csrf_field() }}
                                <p style="font-size: 10pt">Campos com * são obrigatórios</p>
                                
                                <div align="center">

                                    <button type="submit" name="send" class="btn btn-success">Enviar</button>
                                    <button type="reset" name="cancel" class="btn btn-default" onclick="history.go(-1)">Cancelar</button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
