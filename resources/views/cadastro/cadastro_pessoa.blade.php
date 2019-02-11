@extends('layouts.app')

@section('content')

<script src="//code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">

<script type="text/javascript">

    $(document).ready(function() {

        $('#example').dataTable({
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
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "oLanguage": {
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

        if(tipo == 'nasc') return [dia, mes, ano].join('/');

        return [dia, mes, ano].join('/') + " Horas: " + [hora, min].join(':');
    }

    function detalhes_pessoa_juridica(id, tipo){
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

    function detalhes_pessoa(id, tipo){
        if(tipo == 'fisica') {

            $.ajax({
                dataType: 'json',
                url: url+'api/busca_pessoa_fisica_id_detalhes.php',
                data: {busca:id}

            }).done(function(data){
                var id = data[0].id;
                var nome = data[0].nome;

                var cpf = data[0].cpf;
                cpf = cpf.substring(0, 3) + '.' + cpf.substring(3, 6) + '.' + cpf.substring(6, 9) + '-' + cpf.substring(9, 11);

                var rg = data[0].rg;
                rg = rg.substring(0, 2) + '.' + rg.substring(2, 5) + '.' + rg.substring(5, 8) + '-' + rg.substring(8, 9);

                var orgao_expedidor = data[0].orgao_expedidor;

                var sexo = data[0].sexo;
                var data_nascim = formatar_Data(data[0].data_nascim, 'nasc');
                var telefone = data[0].telefone;
                var telefone_sec = data[0].telefone_sec;
                var email = data[0].email;
                var uf = data[0].uf;
                var cidade = data[0].cidade;
                var bairro = data[0].bairro;
                var logradouro = data[0].logradouro;
                var complemento = data[0].complemento;
                var numero = data[0].numero;
                var tipo = data[0].tipo;
                var created_at = formatar_Data(data[0].created_at, 'nc');
                var updated_at = formatar_Data(data[0].updated_at, 'nc');

                if(sexo == 'm'){
                    sexo = 'MASCULINO';
                } else {
                    sexo = 'FEMININO';
                }

                if(tipo == 'c'){
                    tipo = 'Cliente';
                } else if(tipo == 'f'){
                    tipo = 'Fornecedor';
                } else if(tipo == 'cf'){
                    tipo = 'Cliente/Fornecedor';
                }else{
                    tipo = '';
                }

                $('span.id').text(id);
                $('span.nome').text(nome);
                $('span.cpf').text(cpf);
                $('span.rg').text(rg);
                $('span.orgao_expedidor').text(orgao_expedidor);
                $('span.sexo').text(sexo);
                $('span.data_nascim').text(data_nascim);
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

                $('#modal_detalhes_fisica').modal('show');    
            });

        } 
    }

    function delete_pessoa_fisica(id,nome,tipo){
        $('span.nome').text(nome);
        document.getElementById('delete').action = "/cadastro/pessoa/fisica/" + id + "/delete";

        // console.log(id);
        // console.log(nome);
        // console.log(tipo);

        // if(tipo == 'fisica'){
        //     $('span.nome').text(nome);
        //     $('#modal_delete').html('<div align="center"><p>Tem certeza que deseja excluir o cadastro de "'+nome+'"?</p></div><br><br><div align="center"><table><tr><td><form method="GET" action="/cadastro/pessoa/fisica/'+id+'/delete"><button type="submit" class="btn crud-submit btn-primary remove">Excluir</button></form></td><td><button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button></td></tr></table></div>');    
        //     // $('#delete-fisica').modal('show');  
        //     // document.getElementById('delete-fisica').action = "/cadastro/pessoa/fisica/" + id + "/delete";
        // }  
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
                        <div class="panel-heading">Cadastro de Pessoas</div>
                        <div class="panel-body">
                            @if($tipo == "fisica")
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="pessoa/tipo">
                                            <button type="submit" class="btn btn-primary">Novo</button>
                                        </form>
                                    </td>
                                    <td>
                                        <select name="tipo" class="form-control" onchange="location = this.value;" style="margin-bottom: 1em;">
                                            <option value="fisica" selected>Pessoa Física</option>
                                            <option value="juridica">Pessoa Jurídica</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <TABLE  id="example" class="table table-hover compact order-column">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>RG</th>
                                        <th>Relação</th>
                                        <th style="text-align: right; padding-right: 3em">Opções</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>RG</th>
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
                                        <td>{{$pessoa->nome}}</td>

                                        <td>{{substr($pessoa->cpf,0,3) . "." . substr($pessoa->cpf,3,3) . "." . substr($pessoa->cpf,6,3) . "-" . substr($pessoa->cpf,9,3)}}</td>

                                        <td>{{substr($pessoa->rg,0,2) . "." . substr($pessoa->rg,2,3) . "." . substr($pessoa->rg,5,3) . "-" . substr($pessoa->rg,8,2)}}</td>

                                        <td>{{$pessoa->tipo}}</td>
                                        <td>
                                            <div style="display: inline-flex; float: right;">
                                                <button type="submit" class="btn btn-icon" data-toggle="modal" data-target="#detail_item" onclick="detalhes_pessoa('{{$pessoa->id}}','fisica')"><span class="glyphicon glyphicon-eye-open"></span></button>

                                                <form method="GET" action="/cadastro/pessoa/fisica/{{$pessoa->id}}/update"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-pencil"></span></button></form>

                                                <button type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item"><span class="glyphicon glyphicon-trash"></span></button>
                                            </div>
                                        </td>                                      
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </TABLE>

                            @endif

                            @if($tipo == "juridica")
                            <table>
                                <tr>
                                    <td>
                                        <form class="btn-new" method="get" action="pessoa/tipo">
                                            <button type="submit" class="btn btn-primary">Novo</button>
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

                                                <button type="submit" class="btn btn-icon" data-toggle="modal" data-target="#detail_item_juridica" onclick="detalhes_pessoa_juridica('{{$pessoa->id}}', 'juridica')"><span class="glyphicon glyphicon-eye-open"></span></button>

                                                <form method="GET" action="pessoa/juridica/{{$pessoa->id}}/update"><button type="submit" class="btn btn-icon"><span class="glyphicon glyphicon-pencil"></span></button></form>

                                                <button type="submit" class="btn btn-icon remove" data-toggle="modal" data-target="#delete_item" onclick="delete_pessoa_fisica('{{$pessoa->id}}','{{$pessoa->nome_fantasia}}','juridica')"><span class="glyphicon glyphicon-trash"></span></button>
                                            </div>
                                        </td>                                      
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </TABLE>

                            @endif
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
                    <div id="modal_detalhes_fisica" class="modal-body" style="color: #1E3973;">
                        <div class="container"><div class="center-block" style="margin-left: 5%;"><table><td><th style="float: right">Nome:</th></td><td style="color: black; font-family: arial; padding-left: 10%; min-width: 250px;"><span class="nome"></span></td><tr><td><th style="float: right">CPF:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="cpf"></span></td><tr><td><th style="float: right">RG:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="rg"></span></td><tr><td><th style="float: right">Orgão Expedidor:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="orgao_expedidor"></span></td><tr><td><th style="float: right">Sexo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="sexo"></span></td><tr><td><th style="float: right">Data de nascimento:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="data_nascim"></span></td><tr><td><th style="float: right">Telefone:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="telefone"></span></td><tr><td><th style="float: right">Telefone Secundário:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="telefone_sec"></span></td><tr><td><th style="float: right">Email:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="email"></span></td><tr><td><th style="float: right">UF:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="uf"></span></td><tr><td><th style="float: right">Cidade:</th></td><td style="color: black; fontuf-family: arial; padding-left: 10%;"><span class="cidade"></span></td><tr><td><th style="float: right">Bairro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="bairro"></span></td><tr><td><th style="float: right">Logradouro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="logradouro"></span>'</td><tr><td><th style="float: right">Complemento:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="complemento"></span></td><tr><td><th style="float: right">Número:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="numero"></span>'</td><tr><td><th style="float: right">Tipo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="tipo"></span></td><tr><td><th style="float: right">Criado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="created_at"></span></td><tr><td><th style="float: right">Alterado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="updated_at"></span></td></table></div>'
                        </div>

                    </div>

                    <form method="GET" action="/cadastro/fisica">
                        <div align="center">
                            <button type="submit" class="btn crud-submit btn-primary"><span aria-hidden="true">Fechar</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detail_item_juridica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Detalhes da Pessoa</div>
                <div class="panel-body">
                    <div id="modal_detalhes_juridica" class="modal-body" style="color: #1E3973;">

                        <div class="container"><div class="center-block" style="margin-left: 5%;"><table><td><th style="float: right">Nome Fantasia:</th></td><td style="color: black; font-family: arial; padding-left: 10%; min-width: 250px;"><span class="nome_fantasia"></span></td><tr><td><th style="float: right">CNPJ:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="cnpj"></span></td><tr><td><th style="float: right">Razão Social:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="razao_social"></span></td><tr><td><th style="float: right">Inscrição Estadual:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="inscricao_estadual"></span></td><tr><td><th style="float: right">Telefone:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="telefone"></span></td><tr><td><th style="float: right">Telefone Secundário:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="telefone_sec"></span></td><tr><td><th style="float: right">uf:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="uf"></span></td><tr><td><th style="float: right">Cidade:</th></td><td style="color: black; fontuf-family: arial; padding-left: 10%;"><span class="cidade"></span></td><tr><td><th style="float: right">bairro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="bairro"></span></td><tr><td><th style="float: right">logradouro:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="logradouro"></span></td><tr><td><th style="float: right">Número:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="numero"></span></td><tr><td><th style="float: right">Complemento:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="complemento"></span></td><tr><td><th style="float: right">Tipo:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="tipo"></span></td><tr><td><th style="float: right">Criado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="created_at"></span></td><tr><td><th style="float: right">Alterado em:</th></td><td style="color: black; font-family: arial; padding-left: 10%;"><span class="updated_at"></span></td></table></div>'   
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

<form method="GET" id="delete">
<div class="modal fade" id="delete_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Atenção!</div>
                <div class="panel-body">
                    <div id="modal_delete" class="modal-body" style="color: #1E3973;">
                        <div align="center">
                            <p class="p_center">Tem certeza que deseja excluir <span class="nome"></span>?</p>
                        </div>
                        <br><br>
                        <div align="center">
                            <table>
                                <tr>
                                    <td>
                                        <button type="submit" class="btn crud-submit btn-primary remove delete-yes">Excluir</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn crud-submit btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span>
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
</form>
@endsection
