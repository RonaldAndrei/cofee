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
                        columns: [0, 1] // seleciona as colunas que deseja exportar
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Usuários Cadastrados",
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
                        columns: [0, 1]
                    },
                    message: <?php $data = date("d/m/Y H:i");?> "Relatório gerado no dia {!! $data !!}",
                    title: "Relatório de Usuários Cadastrados"
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
                this.api().columns([0, 1]).every( function () {
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
            // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "sPaginationType": "full_numbers",
            "oLanguage": {
                buttons: {
                    pageLength: {
                         _: "Mostrando %d Registros",
                         '-1': "Mostrando Todos"
                    }
                },
                // "sLengthMenu": "Registros por páginas: _MENU_",
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

<script type="text/javascript">

    function delete_usuario(id,nome){

        $('#modal_delete').html('<div align="center"><p class="p_center">Tem certeza que deseja excluir o usuário "'+nome+'"?</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/cadastro/usuario/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');    
    }
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                        <li><a href="/cadastro/produto">Produtos<span class="sr-only">(current)</span></a></li>
                        <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a></li>
                        <li class="active"><a href="#">Usuários<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de usuários<div style="float: right; font-size: 17pt;"><a target="_blank" href="/cadastro/usuario/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">

                            <table>
                                <tr>
<!--                                     <td>
                                        <form class="btn-convidar" method="get" action="usuario/convidar">
                                            <button type="submit" class="btn btn-primary">Convidar</button>
                                        </form>
                                    </td> -->

                                    <td>
                                        <form class="btn-new" method="get" action="/cadastro/usuario/cadastrar">
                                            <button type="submit" class="btn btn-primary"><span style="color: white" class="glyphicon glyphicon-plus"></span> Novo</button>
                                        </form>
                                    </td>

                                </tr>
                            </table>
                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th style="text-align: right; ; padding-right: 3em">Opções</th>
                                        
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    @if($usuarios)
                                    @foreach($usuarios as $usuario)
                                    <tr>
                                        <td>{{$usuario->name}}</td>
                                        <td>{{$usuario->email}}</td>
                                        <td>
                                            <div style="display: inline-flex; float: right;">
                                                <form method="GET" action="mailto:{{$usuario->email}}"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-envelope"></span></button></form>

                                                <form method="GET" action="/cadastro/usuario/{{$usuario->id}}/update"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-pencil"></span></button></form>

                                                <button type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_usuario('{{$usuario->id}}','{{$usuario->name}}')"><span class="glyphicon glyphicon-trash"></span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                
                            </TABLE>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="delete_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Atenção!</div>
                <div class="panel-body">
                    <div id="modal_delete" class="modal-body" style="color: #1E3973;">
                        <!-- conteudo js -->
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
