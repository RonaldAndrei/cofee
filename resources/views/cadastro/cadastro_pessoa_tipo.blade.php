@extends('layouts.app2')
@section('content')

<script type="text/javascript">

    function formatar_cpf(){

        var documento = document.getElementById('cpf');
        var cpf = documento.value;
        var mascara = '###.###.###-##';

        var i = documento.value.length;
        var saida = mascara.substring(0,1);
        var texto = mascara.substring(i)

        if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
        }

        if(i<14){
            $('#alerta').empty();
            document.getElementById("btn_proximo").disabled = true;
        }

        if(i==14){

            cpf = cpf.replace('.', '');
            cpf = cpf.replace('.', '');
            cpf = cpf.replace('-', '');

            valida_cpf(cpf);
        }
    }

    function valida_cpf(cpf) {
        var Soma;
        var Resto;
        Soma = 0;
        if (cpf == "00000000000" || 
            cpf == "00000000000000" ||
            cpf == "11111111111" || 
            cpf == "11111111111111" || 
            cpf == "22222222222" || 
            cpf == "22222222222222" || 
            cpf == "33333333333" || 
            cpf == "33333333333333" ||
            cpf == "44444444444" || 
            cpf == "44444444444444" || 
            cpf == "55555555555" || 
            cpf == "55555555555555" || 
            cpf == "66666666666" || 
            cpf == "66666666666666" || 
            cpf == "77777777777" || 
            cpf == "77777777777777" || 
            cpf == "88888888888" || 
            cpf == "88888888888888" || 
            cpf == "99999999999" ||
            cpf == "99999999999999") {

            $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">O CPF informado é invalido!</div>');
            return;
        }
        
        for (i=1; i<=9; i++) Soma = Soma + parseInt(cpf.substring(i-1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;
        
        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(cpf.substring(9, 10)) ){
            $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">O CPF informado é invalido!</div>');
        }
        
        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(cpf.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;
        
        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(cpf.substring(10, 11) ) ){
            $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">O CPF informado é invalido!</div>');
        }else{
            consulta_cpf(cpf);
        }
    }

    function consulta_cpf(cpf){    
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/consulta_cpf.php',
            data:{cpf:cpf}
        }).done(function(data){
            if(data==1){
                document.getElementById("btn_proximo").disabled = true;
                $('#alerta').html('<div align="center" class="alert alert-warning" role="alert">O CPF informado já está cadastrado!</div>');
            }else if(data==0){                
                document.getElementById("btn_proximo").disabled = false;
            }
        });
    }

    function formatar_cnpj(){

        var documento = document.getElementById('cnpj');
        var cnpj = documento.value;
        var mascara = '##.###.###/####-##';

        var i = documento.value.length;
        var saida = mascara.substring(0,1);
        var texto = mascara.substring(i)

        if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
        }

        if(i<18){
            $('#alerta').empty();
            document.getElementById("btn_proximo").disabled = true;
        }

        if(i==18){

            cnpj = cnpj.replace('.', '');
            cnpj = cnpj.replace('.', '');
            cnpj = cnpj.replace('/', '');
            cnpj = cnpj.replace('-', '');
            valida_cnpj(cnpj);
        }
    }

    function valida_cnpj(cnpj){
     
        if (cnpj == "000000000000000000" || 
            cnpj == "111111111111111111" || 
            cnpj == "222222222222222222" || 
            cnpj == "333333333333333333" || 
            cnpj == "444444444444444444" || 
            cnpj == "555555555555555555" || 
            cnpj == "666666666666666666" || 
            cnpj == "777777777777777777" || 
            cnpj == "888888888888888888" || 
            cnpj == "999999999999999999" ||
            cnpj == "00000000000000" || 
            cnpj == "11111111111111" || 
            cnpj == "22222222222222" || 
            cnpj == "33333333333333" || 
            cnpj == "44444444444444" || 
            cnpj == "55555555555555" || 
            cnpj == "66666666666666" || 
            cnpj == "77777777777777" || 
            cnpj == "88888888888888" || 
            cnpj == "99999999999999"){

            $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">O CNPJ informado é invalido!</div>');
            return;
        }
             
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
          soma += numeros.charAt(tamanho - i) * pos--;
          if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)){
            $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">O CNPJ informado é invalido!</div>');
        }
             
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
          soma += numeros.charAt(tamanho - i) * pos--;
          if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)){
            $('#alerta').html('<div align="center" class="alert alert-danger" role="alert">O CNPJ informado é invalido!</div>');
        }else{
            console.log('true');
            consulta_cnpj(cnpj);
        }    
    }

    function consulta_cnpj(cnpj){     
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/consulta_cnpj.php',
            data:{cnpj:cnpj}
        }).done(function(data){
            if(data==1){
                document.getElementById("btn_proximo").disabled = true;
                $('#alerta').html('<div align="center" class="alert alert-warning" role="alert">O CNPJ informado já está cadastrado!</div>');
                console.log(data);
            }else if(data==0){                
                document.getElementById("btn_proximo").disabled = false;
                console.log(data);
            }
        });
    }


    function documento(tipo){

        if(tipo == 'fisica'){

            $('#campoCpfCnpj').empty();
            $('#campoCpfCnpj').append('<div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}"><label for="cpf" class="col-md-4 control-label">CPF</label><div class="col-md-6"><input id="cpf" type="text" class="form-control" name="cpf" autocomplete="off" onkeyup="formatar_cpf()" maxlength="14" required>@if ($errors->has('cpf'))<span class="help-block"><strong>{{ $errors->first('cpf') }}</strong></span>@endif</div></div>');
        } else if(tipo == 'juridica'){

            $('#campoCpfCnpj').empty();
            $('#campoCpfCnpj').append('<div class="form-group{{ $errors->has('cnpj') ? ' has-error' : '' }}"><label for="cnpj" class="col-md-4 control-label">CNPJ</label><div class="col-md-6"><input id="cnpj" type="text" class="form-control" name="cnpj" autocomplete="off" onkeyup="formatar_cnpj()" maxlength="18" required>@if ($errors->has('cnpj'))<span class="help-block"><strong>{{ $errors->first('cnpj') }}</strong></span>@endif</div></div>');
        }
    }



</script>

<div id="alerta"></div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Pessoa</div>
                <div class="panel-body">

                    <form class="form-horizontal" method="POST" action="/cadastro/pessoa/tipo/novo">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Tipo de Pessoa</label>

                            <div class="col-md-6">
                                <input type="radio" name="pessoa" value="fisica" onclick="documento('fisica')" required>Pessoa Física<br>
                                <input type="radio" name="pessoa" value="juridica" onclick="documento('juridica')" required>Pessoa Jurídica<br>
                            </div>
                        </div>

                        <div id="campoCpfCnpj">

                        </div>

                        <div class="form-group">
                            <div align="center">
                                <button id="btn_proximo" type="submit" class="btn btn-primary" disabled="true">
                                    Proximo
                                </button>
                                <button type="reset" name="cancel" class="btn btn-default" onclick="history.go(-1)">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
