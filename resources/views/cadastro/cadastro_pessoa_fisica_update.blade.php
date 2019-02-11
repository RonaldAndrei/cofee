@extends('layouts.app2')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('nome').focus();
    };

    function valida_data(){
        var data_nascim = document.getElementById('data_nascim').value;
        var partesData = data_nascim.split("/");
        var data = "<?php print $date = date('Y-m-d') ?>"

        if(data < data_nascim){
            document.getElementById("div_data_nascim").className="form-group{{ $errors->has('data_nascim') ? ' has-error' : '' }} form-group has-error has-feedback";
            document.getElementById("btn_salvar").disabled = true;
        }else{
            document.getElementById("div_data_nascim").className="form-group{{ $errors->has('data_nascim') ? ' has-error' : '' }}";
            document.getElementById("btn_salvar").disabled = false;
        }
    }

    function formatar(mascara, documento, tipo){

        if(documento.value.length > 12  &&  tipo == 'telefone'){
            mascara = '##-#####-####';
        }

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
            if(data.uf != 'undefined'){
                document.querySelector("[name='uf']").value = data.uf;
            }
            if(data.localidade != 'undefined'){
                document.querySelector("[name='cidade']").value = data.localidade;
            }
            if(data.bairro != 'undefined'){
                document.querySelector("[name='bairro']").value = data.bairro;
            }
            if(data.logradouro != 'undefined'){
                document.querySelector("[name='logradouro']").value = data.logradouro;
            }
        });
    }

</script>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Pessoa</div>
                <div class="panel-body">

                    <form class="form-horizontal" method="POST" action="/cadastro/pessoa/fisica/{{$pessoa_fisica->id}}/save">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div align="left">
                                <div style="padding:15px">
                                    <legend align="left">Informações Pessoais:</legend>
                                </div>

                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label for="nome" class="col-md-4 control-label required">Nome</label>

                                    <div class="col-md-6">
                                        <input id="nome" type="text" class="form-control" name="nome" pattern="[A-Za-z\s]+$" value="{{$pessoa_fisica->nome}}" placeholder="Ex: Joao Carlos Santos" required>

                                        @if ($errors->has('nome'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                    <label for="cpf" class="col-md-4 control-label required">CPF</label>

                                    <div class="col-md-6">
                                        <input id="cpf" type="text" class="form-control" name="cpf" OnKeyPress="formatar('###.###.###-##', this, 'cpf')" value="{{$pessoa_fisica->cpf}}" readonly="true" required>

                                        @if ($errors->has('cpf'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cpf') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }}">
                                    <label for="rg" class="col-md-4 control-label required">RG</label>

                                    <div class="col-md-6">
                                        <input id="rg" type="text" maxlength="13" class="form-control" name="rg" OnKeyPress="formatar('##.###.###-##', this, 'rg')" style="text-transform:uppercase" value="{{$pessoa_fisica->rg}}" placeholder="Ex: 00.000.000-0" required>

                                        @if ($errors->has('rg'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rg') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('orgao_expedidor') ? ' has-error' : '' }}">
                                    <label for="orgao_expedidor" class="col-md-4 control-label required">Orgão Expedidor</label>

                                    <div class="col-md-6">
                                        <input id="orgao_expedidor" type="text" maxlength="6" class="form-control" name="orgao_expedidor" onkeyup="formatar('######', this, 'orgao_expedidor')" style="text-transform:uppercase" value="{{$pessoa_fisica->orgao_expedidor}}" placeholder="Ex: SESP" required>

                                        @if ($errors->has('orgao_expedidor'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('orgao_expedidor') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
                                    <label for="sexo" class="col-md-4 control-label required">Sexo</label>

                                    <div class="col-md-6">
                                        @if ($pessoa_fisica->sexo == "f")
                                        <input type="radio" name="sexo" value="f" checked> Feminino<br>
                                        <input type="radio" name="sexo" value="m"> Masculino<br>
                                        @else
                                        <input type="radio" name="sexo" value="f"> Feminino<br>
                                        <input type="radio" name="sexo" value="m" checked> Masculino<br>
                                        @endif
                                    </div>
                                </div>

                                <div id="div_data_nascim" class="form-group{{ $errors->has('data_nascim') ? ' has-error' : '' }}">
                                    <label for="data_nascim" class="col-md-4 control-label required">Data de Nascimento</label>

                                    <div class="col-md-6">
                                        <input id="data_nascim" type="date" class="form-control" maxlength="8" name="data_nascim" oninput="valida_data()" onkeyup="valida_data()" value="{{$pessoa_fisica->data_nascim}}" required>

                                        @if ($errors->has('data_nascim'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('data_nascim') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                    <label for="telefone" class="col-md-4 control-label required">Telefone</label>

                                    <div class="col-md-6">
                                        <input id="telefone" type="text" maxlength="11" class="form-control" name="telefone" pattern="^\d{10,11}$" value="{{$pessoa_fisica->telefone}}" required>

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
                                        <input id="telefone_sec" type="text" maxlength="11" class="form-control" name="telefone_sec" pattern="^\d{10,11}$" value="{{$pessoa_fisica->telefone_sec}}">

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
                                        <input id="email" type="email" class="form-control" name="email" value="{{$pessoa_fisica->email}}" required>

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
                                        <input id="cep" maxlength="9" type="text" class="form-control" name="cep" oninput="formatar('#####-###', this, 'cep')" autocomplete="false" pattern="[0-9]{5}-[0-9]{3}$" value="{{$pessoa_fisica->cep}}">

                                        @if ($errors->has('cep'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cep') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label for="uf" class="col-md-4 control-label required" id="ufL">UF</label>
                                    <div class="col-md-6">

                                        <select class="form-control" name="uf" id="ufL" required>
                                            <option value="{{$pessoa_fisica->uf}}">{{$pessoa_fisica->uf}}</option>
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
                                        <input id="cidade" type="text" class="form-control" name="cidade" value="{{$pessoa_fisica->cidade}}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="bairro" class="col-md-4 control-label required" id="bairroL">Bairro</label>
                                    <div class="col-md-6">
                                        <input id="bairro" type="text" class="form-control" name="bairro" value="{{$pessoa_fisica->bairro}}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="logradouro" class="col-md-4 control-label required" id="logradouroL">Logradouro</label>
                                    <div class="col-md-6">
                                        <input id="logradouro" type="text" class="form-control" name="logradouro" value="{{$pessoa_fisica->logradouro}}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="numero" class="col-md-4 control-label required" id="numeroL">Número</label>
                                    <div class="col-md-6">
                                        <input id="numero" type="number" class="form-control" name="numero" value="{{$pessoa_fisica->numero}}" autocomplete="false" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="complemento" class="col-md-4 control-label" id="complementoL">Complemento</label>
                                    <div class="col-md-6">
                                        <input id="complemento" type="text" class="form-control" name="complemento" value="{{$pessoa_fisica->complemento}}">
                                    </div>
                                </div>

                                <div id="resultadoCep">

                                </div> 

                                <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                    <label for="tipo_pessoa" class="col-md-4 control-label">Relação</label>
                                    @if ($pessoa_fisica->tipo == 'c')
                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f"> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c" checked> Cliente 
                                    </div>
                                    @elseif ($pessoa_fisica->tipo == 'f')
                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f" checked> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c"> Cliente 
                                    </div>
                                    @elseif ($pessoa_fisica->tipo == "cf")
                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f" checked> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c" checked> Cliente 
                                    </div>
                                    @else
                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f"> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c"> Cliente 
                                    </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div align="center">
                                        <button id="btn_salvar" type="submit" class="btn btn-primary">
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