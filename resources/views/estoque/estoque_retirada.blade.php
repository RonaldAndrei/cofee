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
                        columns: [0, 1, 2, 3, 4, 5] // seleciona as colunas que deseja exportar
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Solicitação de Retirada",
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
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Solicitação de Retirada"
                },

                'pageLength',
            ],

            lengthMenu: [
                 [ 10, 25, 50, -1 ],
                 [ '10 registros', '25 registros', '50 registros', 'Mostrar Todos' ]
            ],

            initComplete: function () {
                this.api().columns([1, 3, 5]).every( function () {
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
                            <li><a href="/estoque/historico_entrada">Entrada<span class="sr-only">(current)</span></a></li>
                            <li class="active"><a>Retirada<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="subactive"><a href="/estoque/retirada"> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Solicitações retirada</a></li> 
                                    <li style = "padding-left: 5px;"><a href="/estoque/compra"> <span class="glyphicon glyphicon-menu-right"></span> Solicitações compra</a></li>
                                    <!-- <li style = "padding-left: 5px;"><a href="/estoque/solicita_retirada"> <span class="glyphicon glyphicon-menu-right"></span> Solicitar retirada</a></li> -->
                                </ul>
                            </li>
                            <li><a href="/estoque/relatorio/?filter=faltando">Relatórios<span class="sr-only">(current)</span></a></li>
                        </ul>
                </div>
            </div>
                  
            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Solicitações de retirada<div style="float: right; font-size: 17pt;"><a target="_blank" href="/estoque/retirada/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">

                            <div style="float: left;">
                                <table>
                                    <td style="padding-top: 3em;"><a href="/estoque/solicita_retirada"><button type="submit" class="btn btn-primary"><span style="color: white" class="glyphicon glyphicon-plus"></span> Novo</button></td>
                                    
                                <form method="post" action= "/estoque/retirada">    

                                    <td style="padding-right: 1em;">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Solicitado de:</label>
                                            <div>
                                                <input class="form-control" type="date" name="inicio_sol" value="{{$inicio_sol}}">
                                            </div>
                                            
                                        </div>
                                    </td>
                                    <td style="padding-right: 1em;">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Solicitado até:</label>
                                            <div>
                                                <input class="form-control" type="date" name="fim_sol"  value="{{$fim_sol}}">
                                            </div>
                                            
                                        </div>
                                    </td>
                                    <td style="padding-right: 1em;">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Aprovado de:</label>
                                            <div>
                                                <input class="form-control" type="date" name="inicio_apr" value="{{$inicio_apr}}">
                                            </div>
                                            
                                        </div>
                                    </td>
                                    <td style="padding-right: 1em;">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Aprovado até:</label>
                                            <div>
                                                <input class="form-control" type="date" name="fim_apr"  value="{{$fim_apr}}">
                                            </div>
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: inline-flex; float: right; margin-top: 2em;">
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-filter"></span></button>
                                        </div>
                                    </td>
                                </form>
                                    <td style="padding-top: 2em;">
                                    <form method="get" action= "/estoque/retirada">
                                        <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-refresh"></span></button>
                                    </form>
                                    </td>
                                </table>
                            </div>
                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th>Nº solicitação</th>
                                        <th>Solicitante</th>
                                        <th>Data solicitação</th>
                                        <th>Usuário aprovador</th>
                                        <th>Data aprovação</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Solicitante</th>
                                        <th></th>
                                        <th>Usuário aprovador</th>
                                        <th></th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                                @if($solicitacoes)
                                    <tbody>
                                        @foreach($solicitacoes as $solicitacao)
                                        <tr>
                                            <td style="text-align: center;">{{$solicitacao->id}}</td>
                                            <td>{{strtoupper($solicitacao->solicitante)}}</td>
                                            <td>{{$solicitacao->data_solicitacao}}</td>
                                            <td>{{strtoupper($solicitacao->aprovador)}}</td>
                                            <td>@if($solicitacao->status=='p')
                                                @else{{$solicitacao->data_aprovacao}}
                                                @endif</td>
                                            <td>@if($solicitacao->status=='p')Pendente
                                                @else Finalizada
                                                @endif</td>
                                            <td>
                                                <div style="display: inline-flex; float: right;">
                                                    <form method="get" action="/estoque/retirada/detalhes/{{$solicitacao->id}}">
                                                    <button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-eye-open"></span></button></form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </TABLE>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
