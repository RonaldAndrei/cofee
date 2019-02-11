@extends('layouts.app2')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">
            <div class="col-md-8 col-md-offset-2">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Erro</div>
                        <div class="panel-body">
                            <table>
                                <tr>
                                    @if($mensagem)
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> {{$titulo}}</h3></td>
                                    <tr>
                                    <td><p>{{$mensagem}}</p></td>
                                    <tr>
                                    @else
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Erro</h3></td>
                                    <tr>
                                    <td><p>Ocorreu um erro ao executar esta ação.</p></td>
                                    <tr>
                                    @endif
                                 </tr>
                            </table>
                            <div class="form-group">
                                <div align="center">
                                    <button type="reset" name="cancel" class="btn btn-default" onclick="history.go(-1)">Voltar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
