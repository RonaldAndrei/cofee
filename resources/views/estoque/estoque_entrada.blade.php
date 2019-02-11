@extends('layouts.app')
@section('content')

<script src="//code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">

<script type="text/javascript">

    function atualiza_campos(value){
        
        $('#tipo_entrada').empty();

        if (value == "compra") {

            $('#tipo_entrada').html('<div id="div_data_entrada" class="form-group{{ $errors->has('data_entrada') ? ' has-error' : '' }}"><br><br><label for="data_entrada" class="col-md-4 control-label">Data entrada</label><div class="col-md-6" style="padding-right: 15%;"><input id="data_entrada" type="date" class="form-control" name="data_entrada" value="{{ old('data_entrada') }}" autocomplete="off" oninput="valida_data()" onkeyup="valida_data()" required="true">@if ($errors->has('data_entrada'))<span class="help-block"><strong>{{ $errors->first('data_entrada') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('fornecedor') ? ' has-error' : '' }}"><label for="fornecedor" class="col-md-4 control-label">Fornecedor</label><div class="col-md-6" style="padding-right: 15%;"><select name="fornecedor" class="form-control" required><option value="">Escolha um fornecedor</option>@foreach($fornecedors as $fornecedor)<option value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>@endforeach</select>@if ($errors->has('fornecedor'))<span class="help-block"><strong>{{ $errors->first('fornecedor') }}</strong></span>@endif</div></div><div id="div_num_nf" class="form-group{{ $errors->has('num_nota_fiscal') ? ' has-error' : '' }}"><label for="num_nota_fiscal" class="col-md-4 control-label">Nº nota fiscal</label><div class="col-md-6" style="padding-right: 15%;"><input id="num_nota_fiscal" type="text" class="form-control" name="num_nota_fiscal" placeholder="Nº nota fiscal" maxlength="9" pattern="[0-9]{1,9}" value="{{ old('num_nota_fiscal') }}" onkeyup="consulta_nf()" autocomplete="off" required="true">@if ($errors->has('num_nota_fiscal'))<span class="help-block"><strong>{{ $errors->first('num_nota_fiscal') }}</strong></span>@endif</div></div><div id="div_serie_nf" class="form-group{{ $errors->has('serie_nf') ? ' has-error' : '' }}"><label for="serie_nf" class="col-md-4 control-label">Série nota fiscal</label><div class="col-md-6" style="padding-right: 15%;"><input id="serie_nf" type="text" class="form-control" name="serie_nf"  placeholder="Série nota fiscal" maxlength="3" value="{{ old('serie_nf') }}" onkeyup="consulta_nf()" autocomplete="off" required="true">@if ($errors->has('serie_nf'))<span class="help-block"><strong>{{ $errors->first('serie_nf') }}</strong></span>@endif</div></div>');

            document.getElementById('data_entrada').focus();
            document.getElementById("btn_proximo").disabled = true;

        }else if (value == "retorno") {
            $('#tipo_entrada').html('<div id="div_data_entrada" class="form-group{{ $errors->has('data_entrada') ? ' has-error' : '' }}"><br><br><label for="data_entrada" class="col-md-4 control-label">Data entrada</label><div class="col-md-6" style="padding-right: 15%;"><input id="data_entrada" type="date" class="form-control" name="data_entrada" value="{{ old('data_entrada') }}" autocomplete="off" oninput="valida_data()" onkeyup="valida_data()" required="true">@if ($errors->has('data_entrada'))<span class="help-block"><strong>{{ $errors->first('data_entrada') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }}"><label for="motivo" class="col-md-4 control-label">Motivo</label><div class="col-md-6" style="padding-right: 15%;"><input id="motivo" type="text" class="form-control" name="motivo" placeholder="Motivo do retorno" value="{{ old('motivo') }}" autocomplete="off" required="true">@if ($errors->has('motivo'))<span class="help-block"><strong>{{ $errors->first('motivo') }}</strong></span>@endif</div>');

            document.getElementById('data_entrada').focus();
            document.getElementById("btn_proximo").disabled = false;
        }  
    }

    function consulta_nf(){
        $('#alerta').empty();
        var serie_nf = document.getElementById('serie_nf').value;
        var num_nota_fiscal = document.getElementById('num_nota_fiscal').value;

        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/consulta_nf.php',
            data:{serie_nf:serie_nf, num_nota_fiscal:num_nota_fiscal}
        }).done(function(data){
            if(data>0){
                document.getElementById("btn_proximo").disabled = true;
                $('#alerta').html('<div align="center" class="alert alert-warning" role="alert">Uma entrada com o mesmo número de nota fiscal e série já está cadastrada!</div>').focus;
                document.getElementById("div_serie_nf").className="form-group{{ $errors->has('serie_nf') ? ' has-error' : '' }} form-group has-error has-feedback";
                document.getElementById("div_num_nf").className="form-group{{ $errors->has('num_nota_fiscal') ? ' has-error' : '' }} form-group has-error has-feedback";
            }else if(data==0){
                document.getElementById("div_serie_nf").className="form-group{{ $errors->has('serie_nf') ? ' has-error' : '' }}";
                document.getElementById("div_num_nf").className="form-group{{ $errors->has('num_nota_fiscal') ? ' has-error' : '' }}";           
                document.getElementById("btn_proximo").disabled = false;
            }
        });
    }

    function valida_data(){
        var data_entrada = document.getElementById('data_entrada').value;
        var partesData = data_entrada.split("/");
        var data = "<?php print $date = date('Y-m-d') ?>"

        if(data < data_entrada){
            document.getElementById("div_data_entrada").className="form-group{{ $errors->has('data_entrada') ? ' has-error' : '' }} form-group has-error has-feedback";
            document.getElementById("btn_proximo").disabled = true;
        }else{
            document.getElementById("div_data_entrada").className="form-group{{ $errors->has('data_entrada') ? ' has-error' : '' }}";
            document.getElementById("btn_proximo").disabled = false;
        }
    }

</script>

<div id="alerta"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Estoque</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                        <li><a href="/estoque/show">Estoque<span class="sr-only">(current)</span></a></li>
                        <li class="active"><a>Entrada<span class="sr-only">(current)</span></a></li>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="/estoque/historico_entrada"> <span style="font-size: 16px;" class="glyphicon glyphicon-menu-right"></span>  Histórico entradas</a></li>
                                <li class="subactive"><a> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Realizar entrada</a></li> 
                            </ul>
                        <li><a href="/estoque/retirada">Retirada<span class="sr-only">(current)</span></a></li>
                        <li><a href="/estoque/relatorio/?filter=faltando">Relatórios<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Entrada de produtos<div style="float: right; font-size: 17pt;"><a target="_blank" href="/estoque/entrada/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/estoque/produto">
                                {{ csrf_field() }}
                               
                                <div class="form-group{{ $errors->has('tipo_entrada') ? ' has-error' : '' }}">
                                    <label for="tipo_entrada" class="col-md-4 control-label">Tipo de entrada</label>

                                    <div class="col-md-6">
                                        <input type="radio" name="tipo_entrada" value="compra" onchange="atualiza_campos(this.value)"> Compra de produtos<br>
                                        <input type="radio" name="tipo_entrada" value="retorno" onchange="atualiza_campos(this.value)"> Retorno de produtos<br>
                                    </div>
                                </div>
                                
                                <div id="tipo_entrada">
                                    <!-- conteudo js -->
                                </div>
                                <br>
                                <br>

                                <div class="form-group">
                                    <div align="center">
                                        <button id="btn_proximo" type="submit" class="btn btn-primary" disabled="true">
                                            Próximo
                                        </button>
                                    </div>
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
