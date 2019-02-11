@extends('layouts.app2')
@section('content')

<script>

	window.onload = function() {
        document.getElementById('nome_fantasia').focus();
    };

    function formatar(mascara, documento, tipo){
        var i = documento.value.length;
        var saida = mascara.substring(0,1);
        var texto = mascara.substring(i)

        if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
        }
        
        if(documento.value.length >= 9 && tipo == 'cep'){
            getCep();
        } else if(documento.value.length < 9 && tipo == 'cep'){
            form.remove();
        }
        
    }

    function getPageDataEnter(event) {
        if(event.keyCode == 13){
            getCep();
        } 
    }

    function getCep() {

        busca = ({ "cep": $("#cep").val().replace(/[^\d]+/g,'') }); 
        
        $.ajax({
            dataType: 'json',
            url: 'http://viacep.com.br/ws/'+busca.cep+'/json/'
        }).done(function(data){

            $('#resultadoCep').empty();
            $('#preCep').empty();

            $('#resultadoCep').append('<div id="form"><div class="form-group"><label for="uf" class="col-md-4 control-label" id="ufL">UF</label><div class="col-md-6"><input id="uf" type="text" class="form-control" name="uf" value="'+data.uf+'" ></div></div><div class="form-group"><label for="cidade" class="col-md-4 control-label" id="cidadeL">Cidade</label><div class="col-md-6"><input id="cidade" type="text" class="form-control" name="cidade" value="'+data.localidade+'" ></div></div><div class="form-group"><label for="bairro" class="col-md-4 control-label" id="bairroL">Bairro</label><div class="col-md-6"><input id="bairro" type="text" class="form-control" name="bairro" value="'+data.bairro+'" ></div></div><div class="form-group"><label for="logradouro" class="col-md-4 control-label" id="logradouroL">Logradouro</label><div class="col-md-6"><input id="logradouro" type="text" class="form-control" name="logradouro" value="'+data.logradouro+'" ></div></div><div class="form-group"><label for="numero" class="col-md-4 control-label" id="numeroL">Número</label><div class="col-md-6"><input id="numero" type="number" class="form-control" name="numero" required autocomplete = "false"></div></div></div>'
                );
        });
    }

</script>



<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Pessoa</div>
                <div class="panel-body">

                    <form class="form-horizontal" method="POST" action="/cadastro/pessoa/juridica/{{$pessoa_juridica->id}}/save">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div align="left">
                                <div style="padding:15px">
                                    <legend align="left">Informações Pessoais:</legend>
                                </div>

                                <div class="form-group{{ $errors->has('cnpj') ? ' has-error' : '' }}">
                                    <label for="cnpj" class="col-md-4 control-label required">CNPJ</label>

                                    <div class="col-md-6">
                                        <input id="cnpj" type="text" class="form-control" name="cnpj" OnKeyPress="formatar('###.###.##-##', this, 'cnpj')" readonly="true" value="{{$pessoa_juridica->cnpj}}" required readonly="true">

                                        @if ($errors->has('cnpj'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cnpj') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('nome_fantasia') ? ' has-error' : '' }}">
                                    <label for="nome_fantasia" class="col-md-4 control-label required">Nome Fantasia</label>

                                    <div class="col-md-6">
                                        <input id="nome_fantasia" type="text" class="form-control" name="nome_fantasia" value="{{$pessoa_juridica->nome_fantasia}}" style="text-transform:uppercase" required>

                                        @if ($errors->has('nome_fantasia'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nome_fantasia') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('razao_social') ? ' has-error' : '' }}">
                                    <label for="razao_social" class="col-md-4 control-label required">Razão Social</label>

                                    <div class="col-md-6">
                                        <input id="razao_social" type="text" class="form-control" name="razao_social" value="{{$pessoa_juridica->razao_social}}" style="text-transform:uppercase" required>

                                        @if ($errors->has('razao_social'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('razao_social') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('inscricao_estadual') ? ' has-error' : '' }}">
                                    <label for="inscricao_estadual" class="col-md-4 control-label required">Inscrição Estadual</label>

                                    <div class="col-md-6">
                                        <input id="inscricao_estadual" type="text" class="form-control" name="inscricao_estadual" value="{{$pessoa_juridica->inscricao_estadual}}" required>

                                        @if ($errors->has('inscricao_estadual'))
                                        <span class="help-block">inscricao_estadual
                                            <strong>{{ $errors->first('inscricao_estadual') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                    <label for="telefone" class="col-md-4 control-label required">Telefone</label>

                                    <div class="col-md-6">
                                        <input id="telefone" type="text" class="form-control" maxlength="11" pattern="^\d{10,11}$" name="telefone" value="{{$pessoa_juridica->telefone}}" required autofocus>

                                        @if ($errors->has('telefone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('telefone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('telefone_sec') ? ' has-error' : '' }}">
                                    <label for="telefone_sec" class="col-md-4 control-label">Telefone Secundário</label>

                                    <div class="col-md-6">
                                        <input id="telefone_sec" type="text" maxlength="11" class="form-control" pattern="^\d{10,11}$" name="telefone_sec" value="{{$pessoa_juridica->telefone_sec}}" autofocus>

                                        @if ($errors->has('telefone_sec'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('telefone_sec') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label required">Email</label>

                                    <div class="col-md-6">
                                        <input id="email" type="text" class="form-control" name="email" value="{{$pessoa_juridica->email}}" required autofocus>

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>



                                <div style="padding:15px">
                                    <legend align="left">Dados de Endereço:</legend>
                                </div>

                                <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                                    <label for="cep" class="col-md-4 control-label">CEP</label>

                                    <div class="col-md-6">
                                        <input id="cep" maxlength="9" type="text" class="form-control" name="cep" oninput="formatar('#####-###', this, 'cep')" autocomplete="false" value="{{$pessoa_juridica->cep}}">

                                        @if ($errors->has('cep'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cep') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div id="resultadoCep">

                                </div>

                                <div id="preCep">

                                    <div class="form-group">
                                        <label for="uf" class="col-md-4 control-label required" id="ufL">UF</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="uf" id="ufL" required>
                                            <option value="{{$pessoa_juridica->uf}}">{{$pessoa_juridica->uf}}</option>
                                            <option value="">Selecione</option>
                                            <option value="AC">AC</option>
                                            <option value="AL">AL</option>
                                            <option value="AM">AM</option>
                                            <option value="AP">AP</option>
                                            <option value="BA">BA</option>
                                            <option value="CE">CE</option>
                                            <option value="DF">DF</option>
                                            <option value="ES">ES</option>
                                            <option value="GO">GO</option>
                                            <option value="MA">MA</option>
                                            <option value="MG">MG</option>
                                            <option value="MS">MS</option>
                                            <option value="MT">MT</option>
                                            <option value="PA">PA</option>
                                            <option value="PB">PB</option>
                                            <option value="PE">PE</option>
                                            <option value="PI">PI</option>
                                            <option value="PR">PR</option>
                                            <option value="RJ">RJ</option>
                                            <option value="RN">RN</option>
                                            <option value="RS">RS</option>
                                            <option value="RO">RO</option>
                                            <option value="RR">RR</option>
                                            <option value="SC">SC</option>
                                            <option value="SE">SE</option>
                                            <option value="SP">SP</option>
                                            <option value="TO">TO</option>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="cidade" class="col-md-4 control-label required" id="cidadeL">Cidade</label>
                                        <div class="col-md-6">
                                            <input id="cidade" type="text" class="form-control" name="cidade" value="{{$pessoa_juridica->cidade}}" required >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="bairro" class="col-md-4 control-label required" id="bairroL">Bairro</label>
                                        <div class="col-md-6">
                                            <input id="bairro" type="text" class="form-control" name="bairro" value="{{$pessoa_juridica->bairro}}" required >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="logradouro" class="col-md-4 control-label required" id="logradouroL">Logradouro</label>
                                        <div class="col-md-6">
                                            <input id="logradouro" type="text" class="form-control" name="logradouro" value="{{$pessoa_juridica->logradouro}}" required >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="numero" class="col-md-4 control-label required" id="numeroL">Número</label>
                                        <div class="col-md-6">
                                            <input id="numero" type="number" class="form-control" name="numero" value="{{$pessoa_juridica->numero}}" required autocomplete = "false">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="complemento" class="col-md-4 control-label" id="complementoL">Complemento</label>
                                    <div class="col-md-6">
                                        <input id="complemento" type="text" class="form-control" name="complemento" value="{{$pessoa_juridica->complemento}}">
                                    </div>
                                </div>

                                <div id="resultadoCep">

                                </div> 

                                @if($pessoa_juridica->tipo == "c")
                                <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                    <label for="tipo_pessoa" class="col-md-4 control-label">Relação</label>

                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f"> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c" checked> Cliente 
                                    </div>
                                </div>
                                @elseif($pessoa_juridica->tipo == "f")
                                <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                    <label for="tipo_pessoa" class="col-md-4 control-label">Relação</label>

                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f" checked> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c"> Cliente 
                                    </div>
                                </div>
                                @else
                                <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                    <label for="tipo_pessoa" class="col-md-4 control-label">Relação</label>

                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f" checked> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c" checked> Cliente 
                                    </div>
                                </div>
                                @endif

                                <div class="form-group">
                                    <div align="center">
                                        <button type="submit" class="btn btn-primary">
                                            Salvar
                                        </button>
                                        <button type="reset" name="cancel" class="btn btn-default" onclick="history.go(-1)">    
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection