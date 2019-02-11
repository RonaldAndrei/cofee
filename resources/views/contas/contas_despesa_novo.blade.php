@extends('layouts.app2')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('fornecedor').focus();
    };

    function atualiza_campos_repete(value){
        
        $('#repete').empty();

        if (value == '1') {

            $('#repete').html('<div class="form-group{{ $errors->has('qtd_parcelas') ? ' has-error' : '' }}"><label for="qtd_parcelas" class="col-md-4 control-label required">Qtd. Parcelas</label><div class="col-md-5"><input id="qtd_parcelas" type="number" min="2" max="360" class="form-control" name="qtd_parcelas" style="text-align: right;" placeholder="Ex: 12" value="{{ old('qtd_parcelas') }}" required>@if ($errors->has('qtd_parcelas'))<span class="help-block"><strong>{{ $errors->first('qtd_parcelas') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('intervalo') ? ' has-error' : '' }}"><label for="intervalo" class="col-md-4 control-label required">Intervalo (dias)</label><div class="col-md-5"><input id="intervalo" type="number" min="1" max="1461   " class="form-control" name="intervalo" style="text-align: right;" placeholder="Ex: 30" value="{{ old('intervalo') }}" required>@if ($errors->has('intervalo'))<span class="help-block"><strong>{{ $errors->first('intervalo') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('data_vencimento') ? ' has-error' : '' }}"><label for="data_vencimento" class="col-md-4 control-label required">Data 1º vencimento</label><div class="col-md-5"><input id="data_vencimento" type="date" class="form-control" name="data_vencimento" value="{{ old('data_vencimento') }}" required>@if ($errors->has('data_vencimento'))<span class="help-block"><strong>{{ $errors->first('data_vencimento') }}</strong></span>@endif</div></div>');
            document.getElementById("btn_salvar").disabled = false;

        }else if (value == '0') {
            $('#repete').html('<div class="form-group{{ $errors->has('data_vencimento') ? ' has-error' : '' }}"><label for="data_vencimento" class="col-md-4 control-label required">Data vencimento</label><div class="col-md-5"><input id="data_vencimento" type="date" class="form-control" name="data_vencimento" value="{{ old('data_vencimento') }}" required>@if ($errors->has('data_vencimento'))<span class="help-block"><strong>{{ $errors->first('data_vencimento') }}</strong></span>@endif</div></div>');
            document.getElementById("btn_salvar").disabled = false;
        }  
    }

</script>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar despesa</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/contas/despesas/novo">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('fornecedor') ? ' has-error' : '' }}">
                            <label for="fornecedor" class="col-md-4 control-label required">Fornecedor</label>

                            <div class="col-md-5">
                                <select id="fornecedor" name="fornecedor" class="form-control" required>
                                    <option value="">Escolha um fornecedor</option>

                                    @foreach($fornecedors as $fornecedor)
                                        <option value="{{$fornecedor->id}}">{{$fornecedor->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('fornecedor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fornecedor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label required">Descrição</label>

                            <div class="col-md-5">
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{ old('descricao') }}" placeholder="Ex: Compras de estoque" required>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('categoria') ? ' has-error' : '' }}">
                            <label for="categoria" class="col-md-4 control-label required">Categoria</label>

                            <div class="col-md-5">
                                <select name="categoria" class="form-control" required>
                                    <option value="">Escolha uma categoria</option>

                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('categoria'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categoria') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('valor') ? ' has-error' : '' }}">
                            <label for="valor" class="col-md-4 control-label required">Valor R$</label>

                            <div class="col-md-5">
                                <input type="text" id="valor" class="form-control dinheiro" name="valor" value="{{ old('valor') }}" style="text-align: right;" placeholder="Ex: 0,00" autocomplete="off" required>

                                @if ($errors->has('valor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('repete') ? ' has-error' : '' }}">
                            <label for="repete" class="col-md-4 control-label required">Parcelas</label>

                            <div class="col-md-5">
                                <input type="radio" name="repete" value="1" onchange="atualiza_campos_repete(this.value)"> Sim<br>
                                <input type="radio" name="repete" value="0" onchange="atualiza_campos_repete(this.value)"> Não<br>
                            </div>
                        </div>

                        <div id="repete">
                            <!-- conteudo js -->
                        </div>

                        <div class="form-group">
                            <div align="center">
                                <button id="btn_salvar" type="submit" class="btn btn-primary" disabled="true">
                                    Salvar
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
