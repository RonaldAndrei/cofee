@extends('layouts.app')
@section('content')

<script src="//code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script type="text/javascript">

    $(document).ready(function() {

        $('#example').dataTable({
            dom: 'Bfrtip',

            buttons: [
                {
                    // exporta em PDF
                    // extend: 'pdf',
                    extend:    'pdfHtml5',
                    text:      '<i class="fa fa-file-pdf-o" style="font-size: 18px; color: #CD0000"></i>',
                    titleAttr: 'Exportar para PDF',
                    orientation: 'portrait', //landscape = paisagem | portrait = retrato
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3] // seleciona as colunas que deseja exportar
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Histórico de Entradas",
                    customize: function(doc) {
                        doc.defaultStyle.alignment = 'center';
                        doc.styles.tableHeader.alignment = 'center';
                    }

                },

                {
                    // exporta em excel
                    extend: 'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o" style="font-size: 18px; color: green"></i>',
                    titleAttr: 'Exportar para Excel',
                    orientation: 'portrait', //landscape = paisagem | portrait = retrato
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Histórico de Entradas"
                },

                'pageLength',
            ],

            lengthMenu: [
                 [ 10, 25, 50, -1 ],
                 [ '10 registros', '25 registros', '50 registros', 'Mostrar Todos' ]
            ],

            stateSave: false,
            fixedHeader: true, // para congelar os titulos quando rolar o relatório para baixo

            initComplete: function () {
                this.api().columns([1, 2]).every( function () {
                    var column = this;
                    var title = $(this).text();
                    var select = $('<select><option value="">Mostrar Todos</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                            );

                        column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                    } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            },

            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "oLanguage": {
                buttons: {
                    pageLength: {
                         _: "Mostrando %d Registros",
                         '-1': "Mostrando Todos"
                    }
                },
                "sZeroRecords": "Nenhum registro encontrado",
                "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
                "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros)",
                "sSearch": "Pesquisar: ",
                "oPaginate": {
                    "sFirst": "Início",
                    "sPrevious": "Anterior",
                    "sNext": "Próximo",
                    "sLast": "Último"
                }
            },
        });  
    });
</script>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Estoque</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                        <li><a href="/estoque/show">Estoque<span class="sr-only">(current)</span></a></li>
                        <li class="active"><a href="#">Entrada<span class="sr-only">(current)</span></a></li>
                            <ul class="nav nav-pills nav-stacked">
                                <li class="subactive"><a href="#"> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Histórico entradas</a></li>
                            </ul>
                        <li><a href="/estoque/retirada">Retirada<span class="sr-only">(current)</span></a></li>
                        <li><a href="/estoque/relatorio/?filter=faltando">Relatórios<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Entradas de produto<div style="float: right; font-size: 17pt;"><a target="_blank" href="/estoque/historico_entrada/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">

                            <div style="float: left;">
                                <table>
                                    <td style="padding-top: 1.6em;">
                                        <a href="/estoque/entrada">
                                            <button type="submit" class="btn btn-primary"><span style="color: white;" class="glyphicon glyphicon-plus"></span> Novo</button>
                                        </a>
                                    </td>
                                    <form method="post" action= "/estoque/historico_entrada">
                                    <td style="padding-right: 1em;">
                                        <div class="form-group">
                                            <label for="descricao" class="col-md-4 control-label">Tipo:</label>
                                            <select name="tipo" class="form-control" onchange="location = '/estoque/historico_entrada?tipo='+this.value;" style="margin-bottom: 1em;">
                                                <option value="{{$tipo}}">{{strtoupper($tipo)}}</option>
                                                <option value="compra">Compra de produtos</option>
                                                <option value="retorno">Retorno de produtos</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="padding-right: 1em;">
                                        <div class="form-group">
                                            <label for="descricao" class="col-md-4 control-label">De:</label>
                                            <div>
                                                @if($tipo == "compra")
                                                <input class="form-control" type="date" name="inicio" value="{{$inicio}}">
                                                @elseif($tipo == "retorno")
                                                <input class="form-control" type="date" name="inicio" value="{{$inicio}}">
                                                @endif
                                            </div>
                                            
                                        </div>
                                    </td>
                                    <td style="padding-right: 1em;">
                                        <div class="form-group">
                                            <label for="descricao" class="col-md-4 control-label">Até:</label>
                                            <div>
                                                @if($tipo == "compra")
                                                <input class="form-control" type="date" name="fim" value="{{$fim}}">
                                                @elseif($tipo == "retorno")
                                                <input class="form-control" type="date" name="fim" value="{{$fim}}">
                                                @endif
                                            </div>
                                            
                                        </div>
                                    </td>
                                    <td style="padding-right: 1em;">
                                        <div style="display: inline-flex; float: right; margin-top: 0.8em;">
                                            
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-filter"></span></button>
                                        </div>
                                    </td>
                                    </form>
                                    <td style="padding-top: 0.8em;">
                                    <form method="get" action= "/estoque/historico_entrada">
                                        <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-refresh"></span></button>
                                    </form>
                                    </td>
                                </table>
                            </div>

                            @if($tipo == "compra")

                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th style="text-align: center" width="75">Nº entrada</th>
                                        <th>Responsável</th>
                                        <th>Fornecedor</th>
                                        <th>Data</th>
                                        <th>Tipo</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Responsável</th>
                                        <th>Fornecedor</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                
                                @if($entradas)
                                    <tbody>
                                        @foreach($entradas as $entrada)
                                        <tr>
                                            <td style="text-align: center;">{{$entrada->id}}</td>
                                            <td>{{strtoupper($entrada->responsavel)}}</td>
                                            <td>{{strtoupper($entrada->fornecedor)}}</td>
                                            <td>{{$entrada->data_entrada = date('d/m/Y', strtotime($entrada->data_entrada))}}</td>
                                            <td>{{strtoupper($tipo)}}</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                    <form method="get" action="/estoque/entrada/detalhes/{{$entrada->id}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </TABLE>

                            @elseif($tipo == "retorno")
                            
                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th style="text-align: center" width="75">Nº entrada</th>
                                        <th>Responsável</th>
                                        <th>Motivo</th>
                                        <th>Data</th>
                                        <th>Tipo</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Responsável</th>
                                        <th>Data</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                
                                @if($entradas)
                                    <tbody>
                                        @foreach($entradas as $entrada)
                                        <tr>
                                            <td style="text-align: center;">{{$entrada->id}}</td>
                                            <td>{{strtoupper($entrada->responsavel)}}</td>
                                            <td>{{$entrada->motivo}}</td>
                                            <td>{{$entrada->data_entrada = date('d/m/Y', strtotime($entrada->data_entrada))}}</td>
                                            <td>{{strtoupper($tipo)}}</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                    <form method="get" action="/estoque/entrada/detalhes/{{$entrada->id}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </TABLE>
                            
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
