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
                    title: "Relatório de Pessoas Jurídicas Cadastradas",
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
                    title: "Relatório de Pessoas Jurídicas Cadastradas"
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
                "sLengthMenu": "Registros por páginas: _MENU_",
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

        return [dia, mes, ano].join('/') + " Horas: " + [hora, min].join(':');
    }

    function detalhes_pessoa(id){

        $.ajax({
            dataType: 'json',
            url: url+'api/busca_pessoa_juridica_id_detalhes.php',
            data: {busca:id}

        }).done(function(data){
            var id = data[0].id;
            var nome_fantasia = data[0].nome_fantasia;
            var cnpj = data[0].cnpj;
            var razao_social = data[0].razao_social;
            var inscricao_estadual = data[0].inscricao_estadual;
            var telefone = data[0].telefone;
            var telefone_sec = data[0].telefone_sec;
            var email = data[0].email;
            var uf = data[0].uf;
            var cidade = data[0].cidade;
            var bairro = data[0].bairro;
            var logradouro = data[0].logradouro;
            var numero = data[0].numero;
            var complemento = data[0].complemento;
            var tipo = data[0].tipo;
            var created_at = formatar_Data(data[0].created_at);
            var updated_at = formatar_Data(data[0].updated_at);

            if(tipo == 'c'){
                tipo = 'Cliente';
            } else if(tipo == 'f'){
                tipo = 'Fornecedor';
            } else if(tipo == "cf"){
                tipo = 'Cliente/Fornecedor';
            }else{
                tipo = '';
            }

            $('span.id').text(id);
            $('span.nome_fantasia').text(nome_fantasia);
            $('span.cnpj').text(cnpj);
            $('span.inscricao_estadual').text(inscricao_estadual);
            $('span.razao_social').text(razao_social);
            $('span.telefone').text(telefone);        
            $('span.telefone_sec').text(telefone_sec);
            $('span.email').text(email);
            $('span.uf').text(uf);
            $('span.cidade').text(cidade);
            $('span.bairro').text(bairro);
            $('span.logradouro').text(logradouro);
            $('span.numero').text(numero);
            $('span.complemento').text(complemento);
            $('span.tipo').text(tipo);
            $('span.created_at').text(created_at);
            $('span.updated_at').text(updated_at);

            $('#modal_detalhes_juridica').modal('show');      
        });
    }

    function delete_pessoa(id,nome){

        $('#modal_delete').html('<div align="center"><p class="p_center">Tem certeza que deseja excluir o cadastro de "'+nome+'"?</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/cadastro/pessoa/juridica/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');    
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
                        <li class="active"><a href="#">Pessoas<span class="sr-only">(current)</span></a>
                            <ul class="nav nav-pills nav-stacked"> 
                                <li style = "padding-left: 10px "><a href="/cadastro/cliente-fisica"> <span class="glyphicon glyphicon-menu-right"></span>  Clientes</a></li> 
                                <li style = "padding-left: 10px "><a href="/cadastro/fornecedor-fisica"> <span class="glyphicon glyphicon-menu-right"></span> Fornecedores</a></li>
                            </ul>
                        </li>
                        <li><a href="/cadastro/usuario">Usuários<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10 col-md-offset-0">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cadastro de Pessoas<div style="float: right; font-size: 17pt;"><a target="_blank" href="/cadastro/juridica/help"><span style="color: white" class="glyphicon glyphicon-question-sign"></span></a></div></div>
                        <div class="panel-body">
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="pessoa/tipo">
                                            <button type="submit" class="btn btn-primary"><span style="color: white" class="glyphicon glyphicon-plus"></span> Novo</button>
                                        </form>
                                    </td>
                                    <td>
                                        <select name="tipo" class="form-control" onchange="location = this.value;" style="margin-bottom: 1em;">
                                            <option value="fisica">Pessoa Física</option>
                                            <option value="juridica" selected>Pessoa Jurídica</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CNPJ</th>
                                        <th>IE</th>
                                        <th>Relação</th>
                                        <th style="text-align: right; padding-right: 3em">Opções</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CNPJ</th>
                                        <th>IE</th>
                                        <th>Relação</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                
                                <tbody>
                                    @if($pessoas)
                                    @foreach($pessoas as $pessoa)
                                    <?php  
                                    if($pessoa->tipo == "cf"){
                                        $pessoa->tipo = "Cliente/Fornecedor";
                                    }else if($pessoa->tipo == "c"){
                                        $pessoa->tipo = "Cliente";
                                    }else if($pessoa->tipo == "f"){
                                        $pessoa->tipo = "Fornecedor";
                                    }
                                    ?>
                                    <tr>
                                        <td>{{$pessoa->nome_fantasia}}</td>

                                        <td>{{substr($pessoa->cnpj,0,2) . "." . substr($pessoa->cnpj,2,3) . "." . substr($pessoa->cnpj,5,3) . "/" . substr($pessoa->cnpj,8,4)  . "-" . substr($pessoa->cnpj,12,2)}}</td>
                                        
                                        <td>{{$pessoa->inscricao_estadual}}</td>
                                        <td>{{$pessoa->tipo}}</td>
                                        <td>
                                            <div style="display: inline-flex; float: right;">
                                                <button type="submit" class="btn btn-icon" data-toggle="modal" data-target="#detail_item" onclick="detalhes_pessoa('{{$pessoa->id}}')"><span class="glyphicon glyphicon-eye-open"></span></button>

                                                <form method="GET" action="/cadastro/pessoa/juridica/{{$pessoa->id}}/update"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-pencil"></span></button></form>

                                                <button type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_pessoa('{{$pessoa->id}}','{{$pessoa->nome_fantasia}}')"><span class="glyphicon glyphicon-trash"></span></button>
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
                <div class="panel-heading" align="center">Detalhes da Pessoa</div>
                <div class="panel-body">
                    <div id="modal_detalhes_juridica" class="modal-body" style="color: #1E3973;">
                        <div class="container"><div class="center-block" style="margin-left: 5%;"><table class="table-detalhes"><td><th style="float: right">Nome Fantasia:</th></td><td style="color: black; font-family: arial; padding-left: 10%; min-width: 250px;"><span class="nome_fantasia"></span></td><tr><td><th style="float: right">CNPJ:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="cnpj"></span></td><tr><td><th style="float: right">Inscrição Estadual:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="inscricao_estadual"></span></td><tr><td><th style="float: right">Razão Social:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="razao_social"></span></td><tr><td><th style="float: right">Telefone:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="telefone"></span></td><tr><td><th style="float: right">Telefone Secundário:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="telefone_sec"></span></td><tr><td><th style="float: right">Email:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="email"></span></td><tr><td><th style="float: right">UF:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="uf"></span></td><tr><td><th style="float: right">Cidade:</th></td><td style="color: black; fontuf-family: arial; padding-left: 10%;"><span class="cidade"></span></td><tr><td><th style="float: right">Bairro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="bairro"></span></td><tr><td><th style="float: right">Logradouro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="logradouro"></span></td><tr><td><th style="float: right">Complemento:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="complemento"></span></td><tr><td><th style="float: right">Número:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="numero"></span></td><tr><td><th style="float: right">Tipo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="tipo"></span></td><tr><td><th style="float: right">Criado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="created_at"></span></td><tr><td><th style="float: right">Alterado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="updated_at"></span></td></table></div>'
                        </div>

                    </div>

                    <form method="GET" action="/cadastro/juridica">
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

                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
