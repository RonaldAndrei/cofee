@extends('layouts.app2')
@section('content')

<script>

    window.onload = function() {
        document.getElementById('nome_fantasia').focus();
    };

    function formatar(mascara, documento, tipo){

        if(documento.value.length == 10  &&  tipo == 'telefone'){
            mascara = '##-####-####';
        }else if(documento.value.length == 11  &&  tipo == 'telefone'){
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
                    <form class="form-horizontal" method="POST" action="/cadastro/pessoa/juridica/create">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div align="left">
                                <div style="padding:15px">
                                    <legend align="left">Informações Pessoais:</legend>
                                </div>

                                <div class="form-group{{ $errors->has('cnpj') ? ' has-error' : '' }}">
                                    <label for="cnpj" class="col-md-4 control-label required">CNPJ</label>

                                    <div class="col-md-6">
                                        <input id="cnpj" type="text" class="form-control" name="cnpj" OnKeyPress="formatar('###.###.##-##', this, 'cnpj')" readonly="true" value="{{$cnpj}}" required>

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
                                        <input id="nome_fantasia" type="text" class="form-control" name="nome_fantasia" placeholder="Ex: Mega atacados" style="text-transform:uppercase" required>

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
                                        <input id="razao_social" type="text" class="form-control" name="razao_social" placeholder="Ex: Mega atacados ltda." style="text-transform:uppercase" required>

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
                                        <input id="inscricao_estadual" type="text" maxlength="16" class="form-control" name="inscricao_estadual" placeholder="Ex: 000.000.000.000" required>

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
                                        <input id="telefone" type="text" maxlength="11" class="form-control" pattern="^\d{10,11}$" name="telefone" placeholder="Ex: 0000000000" required>

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
                                        <input id="telefone_sec" type="text" maxlength="11" class="form-control" pattern="^\d{10,11}$" placeholder="Ex: 0000000000" name="telefone_sec">

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
                                        <input id="email" type="email" class="form-control" name="email"  placeholder="Ex: atacados@mega.com" required>

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
                                        <input id="cep" maxlength="9" type="text" class="form-control" name="cep" oninput="formatar('#####-###', this, 'cep')" autocomplete="false"  placeholder="Digite o CEP" pattern="[0-9]{5}-[0-9]{3}$" required>

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
                                        <input id="cidade" type="text" class="form-control" name="cidade" placeholder="Ex: Curitiba" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="bairro" class="col-md-4 control-label" id="bairroL">Bairro</label>
                                    <div class="col-md-6">
                                        <input id="bairro" type="text" class="form-control" name="bairro" placeholder="Ex: Batel">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="logradouro" class="col-md-4 control-label required" id="logradouroL">Logradouro</label>
                                    <div class="col-md-6">
                                        <input id="logradouro" type="text" class="form-control" name="logradouro" placeholder="Ex: Avenida do Batel" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="numero" class="col-md-4 control-label required" id="numeroL">Número</label>
                                    <div class="col-md-6">
                                        <input id="numero" type="number" class="form-control" name="numero" placeholder="Ex: 1203" required autocomplete = "false">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="complemento" class="col-md-4 control-label" id="complementoL">Complemento</label>
                                    <div class="col-md-6">
                                        <input id="complemento" type="text" class="form-control" name="complemento" placeholder="Ex: Aos fundos">
                                    </div>
                                </div>

                                <div id="resultadoCep">

                                </div>

                                <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                    <label for="tipo_pessoa" class="col-md-4 control-label">Relação</label>

                                    <div class="col-md-6">
                                        <input type="checkbox" name="fornecedor" value="f"> Fornecedor<br>
                                        <input type="checkbox" name="cliente" value="c"> Cliente 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div align="center">
                                        <button type="submit" class="btn btn-primary">
                                            Registrar
                                        </button>
                                        <button type="button" name="cancel" class="btn btn-default" data-toggle="modal" data-target="#cancelar">Cancelar</button>
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

<div class="modal fade" id="cancelar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Atenção!</div>
                <div class="panel-body">
                    <div id="modal_delete" class="modal-body" style="color: #1E3973;">
                        <div align="center">
                            <p class="p_center">Tem certeza que deseja cancelar o cadastro?<br> Nada será salvo!</p>
                        </div>
                        <br><br>
                        <div align="center">
                            <table>
                                <tr>
                                    <td>
                                        <button type="submit" class="btn crud-submit btn-primary" onclick="history.go(-1)">Sim</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Não</span>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection