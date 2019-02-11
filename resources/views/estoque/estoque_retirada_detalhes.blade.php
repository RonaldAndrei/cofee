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
                this.api().columns([1, 2, 3, 4, 5]).every( function () {
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

<script type="text/javascript">

    function modal_retirada(id){
        $.ajax({
            dataType: 'json',
            url: url+'api/busca_retirada_id.php',
            data: {busca:id}
        }).done(function(data){
            var id = data[0].id;
            var codigo_barras = data[0].codigo_barras;
            var descricao = data[0].descricao;
            var qtd_solicitada = data[0].qtd_solicitada;
            var qtd_atendida = data[0].qtd_atendida;
            $('#modal_retirada').html('<form class="form-horizontal"><div class="form-group"><label for="codigo_barras" class="col-md-4 control-label">Código</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="codigo_barras" type="text" class="form-control" name="codigo_barras" value="'+codigo_barras+'" readonly></div><label for="descricao" class="col-md-4 control-label">Descrição</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="descricao" type="text" class="form-control" name="descricao" value="'+descricao+'" readonly></div><label for="qtd_solicitada" class="col-md-4 control-label">Solicitado</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="qtd_solicitada" type="text" class="form-control" name="qtd_solicitada" value="'+qtd_solicitada+'" readonly></div><label for="qtd_atendida" class="col-md-4 control-label">Atender</label><div class="col-md-6" style="padding-bottom: 1em;"><input id="qtd_atendida" type="number" class="form-control" name="qtd_atendida" autocomplete="off" oninput="calcula_saldo()" value="'+qtd_solicitada+'" required></div><div align="center"><button data-toggle="modal" data-target="#create_modal_compra" id="btn_retirar" type="button" class="btn crud-submit btn-primary" onclick="aprova_retirada('+id+')" data-dismiss="modal" aria-label="Close">Retirar</button><button type="button" class="btn crud-submit btn-primary" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></div></div></form>');    
        });
    }

    function calcula_saldo(){
        var qtd_solicitada =  parseInt(document.getElementById('qtd_solicitada').value);
        var qtd_atendida =  parseInt(document.getElementById('qtd_atendida').value);
        if(qtd_atendida>qtd_solicitada || qtd_atendida<=0){
            document.getElementById("btn_retirar").disabled = true; 
        }else{
            document.getElementById("btn_retirar").disabled = false;
        }
    }

    function aprova_retirada(id){
        var id_solicitacao = "<?php print $id_solicitacao ?>";
        var id_retirada = id;
        var qtd_atendida = document.getElementById('qtd_atendida').value;
        var id_usuario_aprova = "<?php print Auth::user()->id ?>";
        var codigo_produto = document.getElementById('codigo_barras').value;
        if(id_solicitacao != '' && id_retirada != '' && qtd_atendida != '' && id_usuario_aprova != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/aprova_retirada_item.php',
                data:{  id_solicitacao:id_solicitacao,
                        id_retirada:id_retirada,
                        id_usuario_aprova:id_usuario_aprova,
                        codigo_produto:codigo_produto,
                        qtd_atendida:qtd_atendida
                    }
            }).done(function(data){
                var id = data[0].id;
                var descricao = data[0].descricao;
                var saldo = data[0].saldo;
                var minimo = data[0].minimo;

                var saldo = parseInt(saldo);
                var minimo = parseInt(minimo);
                if(saldo<=minimo){
                    $('#modal_compra').html('<div align="center"><p class="p_center">Com esta retirada o saldo de '+descricao+'<br>é '+saldo+' enquanto o mínimo deve ser '+minimo+'.<br><br>Gostaria de adicionar este produto à lista para compra?</p></div><br><br><div align="center"><button id="btn_retirar" type="button" class="btn crud-submit btn-primary" onclick="inserir_compra('+id+')" data-dismiss="modal" aria-label="Close">Adicionar</button><button type="button" class="btn crud-submit btn-default" onclick="ignorar_compra()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Ignorar</span></button></div>');
                }else{
                    $('#create_modal_compra').empty();
                    $('#create_modal_compra').hide();
                    location.reload();
                }
            });
        }
    }

    function inserir_compra(id){
        var id_produto = id;
        var id_usuario_solicitante = "<?php print Auth::user()->id ?>";
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'api/create_item_compra.php',
            data:{id_produto:id_produto, id_usuario_solicitante:id_usuario_solicitante}
        }).done(function(data){
            location.reload();
        });
    }

    function ignorar_compra(){
        location.reload();
    }

    function recusa_retirada(id){
        var id_solicitacao = "<?php print $id_solicitacao ?>";
        var id_retirada = id;
        var id_usuario_aprova = "<?php print Auth::user()->id ?>";
        if(id_solicitacao != '' && id_retirada != '' && id_usuario_aprova != ''){
           $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/recusa_retirada_item.php',
                data:{  id_solicitacao:id_solicitacao,
                        id_retirada:id_retirada,
                        id_usuario_aprova:id_usuario_aprova
                    }
            }).done(function(){
                location.reload();
            });
        }
    }

    function salvar_retirada(){
        var id_solicitacao = "<?php print $id_solicitacao ?>";
        if(id_solicitacao != ''){
            $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/salvar_retirada.php',
                data:{id_solicitacao:id_solicitacao}
            }).done(function(){
                window.location.replace('/estoque/retirada');
            });
        }
    }

    function cancelar_retirada(){
        var id_solicitacao = "<?php print $id_solicitacao ?>";
        if(id_solicitacao != ''){
           $.ajax({
                dataType: 'json',
                type:'POST',
                url: url+'api/cancelar_retirada.php',
                data:{ id_solicitacao:id_solicitacao}
            }).done(function(){
                window.location.replace('/estoque/retirada');
            });
        }
    }

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
                        @if($status == 'p')
                        <ul class="nav nav-pills nav-stacked">
                            <li><a><span style="margin-right: 5%" class="glyphicon glyphicon-circle-arrow-left"></span>  Menu</a></li>
                            <li><a>Estoque<span class="sr-only">(current)</span></a></li>
                            <li><a>Entrada<span class="sr-only">(current)</span></a></li>
                            <li class="active"><a>Retirada<span class="sr-only">(current)</span></a>
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="subactive"><a> <span style="font-size: 16px;" class="glyphicon glyphicon-triangle-right"></span>  Solicitações retirada</a></li> 
                                    <li style = "padding-left: 5px;"><a> <span class="glyphicon glyphicon-menu-right"></span> Solicitações compra</a></li>
                                    <!-- <li style = "padding-left: 5px;"><a> <span class="glyphicon glyphicon-menu-right"></span> Solicitar retirada</a></li> -->
                                </ul>
                            </li>
                        </ul>
                        @else
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
                        </ul>
                        @endif
                </div>
            </div>
                  
            <div class="col-md-10    col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detalhes da retirada<div style="float: right; font-size: 17pt;"><a target="_blank" href="/estoque/retirada_detalhes/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">

                            <div style="float: left; padding-bottom: 1em;">
                                <table>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Nº solicitação</label>
                                        <div class="col-md-6">
                                            <input class="form-control number" type="text" value="{{$id_solicitacao}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Solicitante</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$solicitante}}" readonly style="min-width: 200px; text-transform:uppercase;">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Data solicitação</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$data_solicitacao}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                    <tr>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Aprovador</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$aprovador}}" readonly style="min-width: 200px; text-transform:uppercase">
                                        </div>
                                    </td>
                                    <td style="float: left; padding-bottom: 1em;">
                                        <label class="col-md-3 control-label" style="min-width: 150px;">Data aprovação</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" value="{{$data_aprovacao}}" readonly style="min-width: 200px;">
                                        </div>
                                    </td>
                                </table>
                            </div>
                            <TABLE id="example" class="table table-hover compact order-column cell-border">
                                <thead>
                                    <tr>
                                        <th>Código barras</th>
                                        <th>Descrição</th>
                                        <th>Saldo</th>
                                        <th>Un. Medida</th>
                                        <th>Qtd. Solicitada</th>
                                        <th>Qtd. Aprovada</th>
                                        <th>Aprovado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if($retiradas)
                                    <tbody>
                                        @foreach($retiradas as $retirada)
                                        <tr>
                                            <td>{{$retirada->codigo_barras}}</td>
                                            <td>{{$retirada->descricao}}</td>
                                            <td style="text-align: right; padding-right: 1em;">{{$retirada->saldo}}</td>
                                            <td>{{$retirada->unidade_medida}}</td>
                                            <td style="text-align: right; padding-right: 1em;">{{$retirada->qtd_solicitada}}</td>
                                            <td style="text-align: right; padding-right: 1em;">{{$retirada->qtd_atendida}}</td>
                                            <td>@if($retirada->aprovado)Sim
                                                @else Não
                                                @endif</td>
                                            @if($retirada->status == 'p')
                                            <td style="text-align: right; padding-right: 1.1em;">
                                                <div style="display: inline-flex; float: right;">
                                                <button type="submit" class="btn btn-icon add" data-toggle="modal" data-target="#create-item" onclick="modal_retirada('{{$retirada->id}}')"><span class="glyphicon glyphicon-thumbs-up"></span></button>
                                                <button type="submit" class="btn btn-icon remove" onclick="recusa_retirada('{{$retirada->id}}')"><span class="glyphicon glyphicon-thumbs-down"></span></button>
                                                </div>
                                            </td>
                                            @else
                                            <td>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>

                                @endif
                            </TABLE>

                            <div align="center">
                                @if($status == 'p')
                                <button class="btn btn-primary" type="button" onclick="salvar_retirada()">
                                    Salvar
                                </button>
                                <button class="btn btn-primary" type="button" onclick="cancelar_retirada()">
                                    Cancelar
                                </button>
                                @else
                                <button class="btn btn-primary" type="button" onclick="history.go(-1)">
                                    Voltar
                                </button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Create Item Modal -->
<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div class="panel panel-default">
            <div class="panel-heading">Aprovar retirada do item</div>
            <div class="panel-body">

            <div id="modal_retirada" class="modal-body" style="color: #1E3973">
            <!-- conteudo js -->
            </div>

            </div>
        </div>
        
        </div>
    </div>
</div>

<div class="modal fade" id="create_modal_compra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div class="panel panel-default">
            <div class="panel-heading">Produto acabando</div>
            <div class="panel-body">

            <div id="modal_compra" class="modal-body" style="color: #1E3973">
            <!-- conteudo js -->
            </div>

            </div>
        </div>
        
        </div>
    </div>
</div>

@endsection
