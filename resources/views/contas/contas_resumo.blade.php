@extends('layouts.app2')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Contas</div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                            <li class="active"><a href="#">Resumo<span class="sr-only">(current)</span></a></li>
                            <li><a href="/contas/despesas">Despesas<span class="sr-only">(current)</span></a></li>
                            <li><a href="/contas/receitas">Receitas<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-9 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="panel panel-default col-md-6">
                                <div class="panel-heading">Receitas</div>
                                <div class="panel-body">
                                    <TABLE  class="table table-hover">
                                        <tr>
                                            <th colspan="2" class="table-receita">Hoje
                                                <div style="float: right;">
                                                    <button type="submit" class="btn btn-icon" onclick="location = '/contas/receitas_parcelas?filter=all&inicio={{$hoje}}&fim={{$hoje}}'"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </div>
                                                <br>
                                                {{$hoje}}
                                            </th>
                                            <tr>
                                            <td>Valor total (R$)</td>
                                            <td class="number">{{$receita_valor_hoje}}</td>
                                        </tr>
                                        <tr>
                                            <td>Valor pago (R$)</td>
                                            <td class="number">{{$receita_valor_hoje_pago}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delta (R$)</td>
                                            <td class="number">{{$receita_delta_hoje}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="table-receita">Semana
                                                <div style="float: right;">
                                                    <button type="submit" class="btn btn-icon" onclick="location = '/contas/receitas_parcelas?filter=all&inicio={{$hoje}}&fim={{$semana}}'"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </div>
                                                <br>
                                                {{$hoje}} - {{$semana}}</th>
                                            <tr>
                                            <td>Valor total (R$)</td>
                                            <td class="number">{{$receita_valor_semana}}</td>
                                        </tr>
                                        <tr>
                                            <td>Valor pago (R$)</td>
                                            <td class="number">{{$receita_valor_semana_pago}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delta (R$)</td>
                                            <td class="number">{{$receita_delta_semana}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="table-receita">Mês
                                                <div style="float: right;">
                                                    <button type="submit" class="btn btn-icon" onclick="location = '/contas/receitas_parcelas?filter=all&inicio={{$hoje}}&fim={{$mes}}'"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </div>
                                                <br>
                                                {{$hoje}} - {{$mes}}</th>
                                            <tr>
                                            <td>Valor total (R$)</td>
                                            <td class="number">{{$receita_valor_mes}}</td>
                                        </tr>
                                        <tr>
                                            <td>Valor pago (R$)</td>
                                            <td class="number">{{$receita_valor_mes_pago}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delta (R$)</td>
                                            <td class="number">{{$receita_delta_mes}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="table-receita">Total</th>
                                            <tr>
                                            <td>Valor total (R$)</td>
                                            <td class="number">{{$receita_valor_total}}</td>
                                        </tr>
                                        <tr>
                                            <td>Valor pago (R$)</td>
                                            <td class="number">{{$receita_valor_total_pago}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delta (R$)</td>
                                            <td class="number">{{$receita_delta_total}}</td>
                                        </tr>
                                        <tr>
                                            <td>Em atraso (R$)</td>
                                            <td class="number">{{$receita_valor_atraso}}</td>
                                        </tr>
                                    </TABLE>
                                </div>
                            </div>
                            <div class="panel panel-default col-md-6">
                                <div class="panel-heading">Despesas</div>
                                <div class="panel-body">
                                    <TABLE  class="table table-hover">
                                        <tr>
                                            <th colspan="2" class="table-despesa">Hoje<div style="float: right;">
                                                    <button type="submit" class="btn btn-icon" onclick="location = '/contas/despesas_parcelas?filter=all&inicio={{$hoje}}&fim={{$hoje}}'"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </div>
                                                <br>
                                                {{$hoje}}
                                            </th>
                                            <tr>
                                            <td>Valor total (R$)</td>
                                            <td class="number">{{$despesa_valor_hoje}}</td>
                                        </tr>
                                        <tr>
                                            <td>Valor pago (R$)</td>
                                            <td class="number">{{$despesa_valor_hoje_pago}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delta (R$)</td>
                                            <td class="number">{{$despesa_delta_hoje}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="table-despesa">Semana<div style="float: right;">
                                                    <button type="submit" class="btn btn-icon" onclick="location = '/contas/despesas_parcelas?filter=all&inicio={{$hoje}}&fim={{$semana}}'"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </div>
                                                <br>
                                                {{$hoje}} - {{$semana}}
                                            </th>
                                            <tr>
                                            <td>Valor total (R$)</td>
                                            <td class="number">{{$despesa_valor_semana}}</td>
                                        </tr>
                                        <tr>
                                            <td>Valor pago (R$)</td>
                                            <td class="number">{{$despesa_valor_semana_pago}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delta (R$)</td>
                                            <td class="number">{{$despesa_delta_semana}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="table-despesa">Mês<div style="float: right;">
                                                    <button type="submit" class="btn btn-icon" onclick="location = '/contas/despesas_parcelas?filter=all&inicio={{$hoje}}&fim={{$mes}}'"><span class="glyphicon glyphicon-eye-open"></span></button>
                                                </div>
                                                <br>
                                                {{$hoje}} - {{$mes}}
                                            </th>
                                            <tr>
                                            <td>Valor total (R$)</td>
                                            <td class="number">{{$despesa_valor_mes}}</td>
                                        </tr>
                                        <tr>
                                            <td>Valor pago (R$)</td>
                                            <td class="number">{{$despesa_valor_mes_pago}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delta (R$)</td>
                                            <td class="number">{{$despesa_delta_mes}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="table-despesa">Total</th>
                                            <tr>
                                            <td>Valor total (R$)</td>
                                            <td class="number">{{$despesa_valor_total}}</td>
                                        </tr>
                                        <tr>
                                            <td>Valor pago (R$)</td>
                                            <td class="number">{{$despesa_valor_total_pago}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delta (R$)</td>
                                            <td class="number">{{$despesa_delta_total}}</td>
                                        </tr>
                                        <tr>
                                            <td>Em atraso (R$)</td>
                                            <td class="number">{{$despesa_valor_atraso}}</td>
                                        </tr>
                                    </TABLE>
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
