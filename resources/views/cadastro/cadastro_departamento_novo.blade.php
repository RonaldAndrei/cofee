@extends('layouts.app2')

@section('content')

<script type="text/javascript">

    window.onload = function() {
        document.getElementById('nome').focus();
    };
    
</script>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar departamento</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/cadastro/departamento/cadastrar">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label required">Nome</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" style="text-transform:uppercase" required>

                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div align="center">
                                <button type="submit" class="btn btn-primary">
                                    Salvar
                                </button>
                                
                                <button type="button" name="cancel" class="btn btn-default" data-toggle="modal" data-target="#cancelar">Cancelar</button>
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
