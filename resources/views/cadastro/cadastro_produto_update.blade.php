@extends('layouts.app2')

@section('content')

<script type="text/javascript">
    function consulta_codigo_barras(codigo_barras){

        var codigo_barras_old = <?php print "$produto->codigo_barras" ?>

        if(codigo_barras != codigo_barras_old){
            $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/consulta_codigo_barras.php',
            data:{codigo_barras:codigo_barras}
            }).done(function(data){
                console.log(data);
                if(data==1){
                    document.getElementById("btn_salvar").disabled = true;
                    $('#alerta').html('<div align="center" class="alert alert-warning" role="alert">O código informado já está cadastrado!</div>');
                }else if(data==0){                
                    $('#alerta').empty();
                    document.getElementById("btn_salvar").disabled = false;
                }
            });
        }
        
    }
</script>

<div id="alerta"></div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editar produto</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/cadastro/produto/{{$produto->id}}/update">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('departamento') ? ' has-error' : '' }}">
                            <label for="departamento" class="col-md-4 control-label required">Departamento</label>

                            <div class="col-md-6">
                                <select name="departamento" class="form-control" required>
                                    <option value="{{$produto->id_departamento}}">{{$departamento_up->nome}}</option>
                                    <option value="">Escolha um departamento</option>

                                    @foreach($departamentos as $departamento)
                                        <option value="{{$departamento->id}}">{{$departamento->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('departamento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('departamento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('marca') ? ' has-error' : '' }}">
                            <label for="marca" class="col-md-4 control-label required">Marca</label>

                            <div class="col-md-6">
                                <select name="marca" class="form-control" required>
                                    <option value="{{$produto->id_marca}}">{{$marca_up->nome}}</option>
                                    <option value="">Escolha uma marca</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{$marca->id}}">{{$marca->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('marca'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('marca') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label required">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{$produto->descricao}}" maxlength="34" placeholder="Ex: lapis de escrever" style="text-transform:uppercase" required>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('codigo_barras') ? ' has-error' : '' }}">
                            <label for="codigo_barras" class="col-md-4 control-label required">Código de barras</label>

                            <div class="col-md-6">
                                <input id="codigo_barras" type="text" class="form-control" name="codigo_barras" value="{{$produto->codigo_barras}}" maxlength="13" onkeyup="consulta_codigo_barras(this.value)" placeholder="Digite um código válido" required>

                                @if ($errors->has('codigo_barras'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('codigo_barras') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('unidade_medida') ? ' has-error' : '' }}">
                            <label for="unidade_medida" class="col-md-4 control-label required">Unidade de medida</label>

                            <div class="col-md-6">
                                <select name="unidade_medida" class="form-control" required>
                                    <option value="{{$produto->unidade_medida}}">{{$produto->unidade_medida}}</option>
                                    <option value="">Escolha uma unidade de medida</option>
                                    @foreach($unidade_medidas as $unidade_medida)
                                        <option value="{{$unidade_medida->nome}}">{{$unidade_medida->nome}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('unidade_medida'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('unidade_medida') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('posicao') ? ' has-error' : '' }}">
                            <label for="posicao" class="col-md-4 control-label required">Posição</label>

                            <div class="col-md-6">
                                <input id="posicao" type="text" class="form-control" name="posicao" value="{{$produto->posicao}}" placeholder="Ex: A" maxlength="3" pattern="[A-Za-z]{1-3}" style="text-transform:uppercase" required>

                                @if ($errors->has('posicao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('posicao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('corredor') ? ' has-error' : '' }}">
                            <label for="corredor" class="col-md-4 control-label required">Corredor</label>

                            <div class="col-md-6">
                                <input id="corredor" type="number" class="form-control" name="corredor" value="{{$produto->corredor}}" min="0" max="9999999" placeholder="Ex: 7" required>

                                @if ($errors->has('corredor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('corredor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('prateleira') ? ' has-error' : '' }}">
                            <label for="prateleira" class="col-md-4 control-label required">Prateleira</label>

                            <div class="col-md-6">
                                <input id="prateleira" type="number" class="form-control" name="prateleira" value="{{$produto->prateleira}}" min="0" max="9999999" placeholder="Ex: 23" required>

                                @if ($errors->has('prateleira'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prateleira') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>   
                        <div class="form-group{{ $errors->has('minimo') ? ' has-error' : '' }}">
                            <label for="minimo" class="col-md-4 control-label required">Quantidade mínima</label>

                            <div class="col-md-6">
                                <input id="minimo" type="number" class="form-control" name="minimo" value="{{$produto->minimo}}" required>

                                @if ($errors->has('minimo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('minimo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('observacao') ? ' has-error' : '' }}">
                            <label for="observacao" class="col-md-4 control-label">Observações</label>

                            <div class="col-md-6">
                                <textarea id="observacao" style="resize: none" rows="3" class="form-control" name="observacao" value="{{ old('observacao') }}" placeholder="Ex: Caixa com 200 unidades">{{$produto->observacao}}</textarea>

                                @if ($errors->has('observacao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('observacao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group">
                            <div align="center">
                                <button id="btn_salvar" type="submit" class="btn btn-primary">
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
