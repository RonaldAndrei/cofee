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
<!-- <script src="//code.jquery.com/jquery-3.2.1.js"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css"> -->


<script type="text/javascript">

    function formatar_Data(data, tipo){
        var d = new Date(data),
        ano = ''  +  d.getFullYear(),
        mes = ''  + (d.getMonth() + 1),
        dia = ''  +  d.getDate(),
        hora = '' +  d.getHours(),
        min = ''  +  d.getMinutes();

        if(mes.length  < 2) mes  = '0' + mes;
        if(dia.length  < 2) dia  = '0' + dia;
        if(hora.length < 2) hora = '0' + hora;
        if(min.length  < 2) min  = '0' + min;

        if(tipo == 'nasc') return [dia, mes, ano].join('/');

        return [dia, mes, ano].join('/') + " Horas: " + [hora, min].join(':');
    }

    function detalhes_produto(id){

        $.ajax({
            dataType: 'json',
            url: url+'api/busca_produto_id_detalhes.php',
            data: {busca:id}
        }).done(function(data){
            var id = data[0].id;
            var codigo_barras = data[0].codigo_barras;
            var descricao = data[0].descricao;
            var saldo = data[0].saldo;
            var unidade_medida = data[0].unidade_medida;
            var posicao = data[0].posicao;
            var corredor = data[0].corredor;
            var prateleira = data[0].prateleira;
            var minimo = data[0].minimo;
            var observacao = data[0].observacao;
            var created_at = formatar_Data(data[0].created_at, 'nc');
            var updated_at = formatar_Data(data[0].updated_at, 'nc');
            var nome_marca = data[0].nome_marca;
            var nome_departamento = data[0].nome_departamento;

            $('span.id').text(id);
            $('span.codigo_barras').text(codigo_barras);
            $('span.descricao').text(descricao);
            $('span.saldo').text(saldo);
            $('span.unidade_medida').text(unidade_medida);
            $('span.posicao').text(posicao);
            $('span.corredor').text(corredor);
            $('span.prateleira').text(prateleira);        
            $('span.minimo').text(minimo);
            $('span.observacao').text(observacao);
            $('span.nome_marca').text(nome_marca);
            $('span.nome_departamento').text(nome_departamento);
            $('span.created_at').text(created_at);
            $('span.updated_at').text(updated_at);
        });
        $('#modal_detalhes').modal('show');
    }

    function delete_produto(id,nome){

        $('#modal_delete').html('<div align="center"><p class="p_center">Tem certeza que deseja excluir o produto "'+nome+'"?</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/cadastro/produto/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');
    }

</script>

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
                    title: "Relatório de Produtos Cadastrados",
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
                    title: "Relatório de Produtos Cadastrados"
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
    } );
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">

            <div class="col-md-2 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastros</div>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/home"><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                        <li class="active"><a href="#">Produtos<span class="sr-only">(current)</span></a>
                            <ul class="nav nav-pills nav-stacked"> 
                                <li style = "padding-left: 10px "><a href="/cadastro/departamento"> <span class="glyphicon glyphicon-menu-right"></span>  Departamento</a></li> 
                                <li style = "padding-left: 10px "><a href="/cadastro/marca"> <span class="glyphicon glyphicon-menu-right"></span> Marca</a></li> 
                            </ul>
                        </li>
                        <li><a href="/cadastro/fisica">Pessoas<span class="sr-only">(current)</span></a></li>
                        <li><a href="/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de produtos<div style="float: right; font-size: 17pt;"><a target="_blank" href="/cadastro/produto/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">
                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <tr>
                                        <td>
                                            <form class="btn-new" method="get" action="produto/cadastrar">
                                                <button type="submit" class="btn btn-primary"><span style="color: white" class="glyphicon glyphicon-plus"></span> Novo</button>
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <TABLE  id="example" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                        <th>Marca</th>
                                        <th>Departamento</th>
                                        <th style="text-align: right; padding-right: 3em">Opções</th>
                                    </tr>

                                    <tfoot>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                        <th>Marca</th>
                                        <th>Departamento</th>
                                        <th></th>
                                    </tfoot>
                                </thead>
                                
                                <tbody>
                                    @if($produtos)
                                    @foreach($produtos as $produto)
                                    <tr>
                                        <td>{{$produto->codigo_barras}}</td>
                                        <td>{{$produto->descricao}}</td>
                                        <td>{{$produto->nome_marca}}</td>
                                        <td>{{$produto->nome_departamento}}</td>
                                        <td>
                                            <div style="display: inline-flex; float: right;">
                                                <button type="submit" class="btn btn-icon" data-toggle="modal" data-target="#detail_item" onclick="detalhes_produto('{{$produto->id}}')"><span class="glyphicon glyphicon-eye-open"></span></button>

                                                <form method="GET" action="produto/{{$produto->id}}/update"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-pencil"></span></button></form>

                                                <button type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_produto('{{$produto->id}}','{{$produto->descricao}}')"><span class="glyphicon glyphicon-trash"></span></button>
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

<div class="modal fade" id="detail_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Detalhes do produto</div>
                <div class="panel-body">
                    <div id="modal_detalhes" class="modal-body" style="color: #1E3973;">
                        <div class="container">
                            <div class="center-block" style="margin-left: 5%;">
                                <table class="table-detalhes">
                                    <td>
                                        <th style="float: right">Código:</th>
                                    </td>
                                    <td style="color: black; font-family: arial; padding-left: 10%; min-width: 250px;">
                                        <span class="codigo_barras"></span>
                                    </td>
                                    <tr>
                                        <td>
                                            <th style="float: right">Descrição:</th>
                                        </td>
                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="descricao"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Marca:</th>
                                        </td>
                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="nome_marca"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Departamento:</th>
                                        </td>
                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="nome_departamento"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Saldo:</th>
                                        </td>

                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="saldo"></span> <span class="unidade_medida"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Mínimo:</th>
                                        </td>

                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="minimo"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Posição:</th>
                                        </td>

                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="posicao"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Corredor:</th>
                                        </td>

                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="corredor"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Prateleira:</th>
                                        </td>

                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="prateleira"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Observação:</th>
                                        </td>

                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="observacao"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Criado em:</th>
                                        </td>

                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="created_at"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <th style="float: right">Alterado em:</th>
                                        </td>

                                        <td style="color: black; font-family: arial; padding-left: 10%;">
                                            <span class="updated_at"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
<!--                     <div align="center">
                        <button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Fechar</span></button>
                    </div> -->
                    <form method="GET" action="/cadastro/produto">
                        <div align="center">
                            <button type="submit" class="btn crud-submit btn-primary"><span aria-hidden="true">Fechar</span></button>
                        </div>
                    </form>
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
