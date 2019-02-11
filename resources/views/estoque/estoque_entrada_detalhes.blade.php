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

        var id_entrada = <?php print "$id_entrada" ?>;

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
                        columns: [0, 1, 2, 3, 4] // seleciona as colunas que deseja exportar
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Detalhes da Entrada Nº"+id_entrada,
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
                        columns: [0, 1, 2, 3, 4]
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Detalhes da Entrada"
                },

                'pageLength',
            ],

            lengthMenu: [
                 [ 10, 25, 50, -1 ],
                 [ '10 registros', '25 registros', '50 registros', 'Mostrar Todos' ]
            ],

            stateSave: false,
            fixedHeader: true,

            initComplete: function () {
                this.api().columns([0, 1, 2, 3]).every( function () {
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

<style type="text/css">
    label {
        text-align: right;
    }
    td{
        margin-bottom: 1em; 
    }
</style>

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
                    </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detalhes da entrada<div style="float: right; font-size: 17pt;"><a target="_blank" href="/estoque/entrada_detalhes/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">

                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Nº entrada</label>
                                        <div class="col-md-6">
                                            <input class="form-control number" type="text" value="{{$id_entrada}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Data entrada</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$data_entrada}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Responsável</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$responsavel}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    @if($serie_nf)
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Fornecedor</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$fornecedor}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Série nota fiscal</label>
                                        <div class="col-md-6">
                                            <input class="form-control number" type="text" value="{{$serie_nf}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Nº nota fiscal</label>
                                        <div class="col-md-6">
                                            <input class="form-control number" type="text" value="{{$num_nota_fiscal}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    @elseif($motivo)
                                    <td colspan="2" style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Motivo</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$motivo}}" readonly style="min-width: 350px;">
                                        </div>
                                    </td>
                                    @endif
                                </table>
                            </div>
                            <TABLE  id="example" class="table table-hover compact order-column cell-border">
                                <thead>
                                    <tr>
                                        <th>Código barras</th>
                                        <th>Descrição</th>
                                        <th>Saldo</th>
                                        <th>Un. Medida</th>
                                        <th>Quantidade</th>
                                    </tr>
                                </thead>

                             @if($entradas)
                                    <tbody>
                                        @foreach($entradas as $entrada)
                                        <tr>
                                            <td>{{$entrada->codigo_barras}}</td>
                                            <td>{{$entrada->descricao}}</td>
                                            <td style="text-align: right; padding-right: 2em;">{{$entrada->saldo}}</td>
                                            <td>{{$entrada->unidade_medida}}</td>
                                            <td style="text-align: right; padding-right: 2em; ">{{$entrada->quantidade}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </TABLE>

                            <div align="center">
                                <button class="btn btn-primary" type="button" onclick="history.go(-1)">
                                    Voltar
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
