@extends('layouts.app2')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">
            <div class="col-md-8 col-md-offset-2">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        @if($atributo == "produto")
                        <div class="panel-heading">Ajuda: Cadastro produtos</div>
                        @elseif($atributo == "marca")
                        <div class="panel-heading">Ajuda: Cadastro marcas</div>
                        @elseif($atributo == "departamento")
                        <div class="panel-heading">Ajuda: Cadastro departamentos</div>
                        @elseif($atributo == "fisica")
                        <div class="panel-heading">Ajuda: Cadastro pessoa física</div>
                        @elseif($atributo == "juridica")
                        <div class="panel-heading">Ajuda: Cadastro pessoa jurídica</div>
                        @elseif($atributo == "cliente-fisica")
                        <div class="panel-heading">Ajuda: Cadastro cliente pessoa física</div>
                        @elseif($atributo == "cliente-juridica")
                        <div class="panel-heading">Ajuda: Cadastro cliente pessoa jurídica</div>
                        @elseif($atributo == "fornecedor-fisica")
                        <div class="panel-heading">Ajuda: Cadastro fornecedor pessoa física</div>
                        @elseif($atributo == "fornecedor-juridica")
                        <div class="panel-heading">Ajuda: Cadastro fornecedor pessoa jurídica</div>
                        @elseif($atributo == "usuario")
                        <div class="panel-heading">Ajuda: Cadastro usuário</div>
                        @endif
                        <div class="panel-body">
                            <table>
                                <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Encerrar sessão</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-user"></span> usuário" será exibida a opção de "<span class="glyphicon glyphicon-off"></span> Sair", permitindo encerrar a sessão atual.</p></td>
                                    <tr>

                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Menu de navegação</h3></td>
                                    <tr>
                                    <td><p>À esquerda no menu de navegação é possível escolher a página de cadastro desejada.<ul><li><strong>Menu:</strong> Volta ao menu principal.</li><li><strong>Produtos:</strong> São listados todos os produtos cadastrados.</li><ul><li><strong>Departamentos:</strong> São listados todos os departamentos cadastrados.</li></ul><ul><li><strong>Marcas:</strong> São listadas todas as marcas cadastrados.</li></ul><li><strong>Pessoas:</strong> São listados todos os cadastrados de pessoas, sendo possível escolher por Pessoa física ou Pessoa jurídica.</li><ul><li><strong>Clientes:</strong> São listadas todas as pessoas cadastradas como clientes, sendo possível escolher por Pessoa física ou Pessoa jurídica.</li></ul><ul><li><strong>Fornecedores:</strong> São listadas todas as pessoas cadastradas como fornecedores, sendo possível escolher por Pessoa física ou Pessoa jurídica.</li></ul><li><strong>Usuários:</strong> São listados todos os usuários com acesso ao sistema.</li></ul></p></td>
                                    <tr>

                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Novo cadastro</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-plus"></span> novo" será direcionado para a tela de cadastro de registros.</p></td>
                                    <tr>

                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Paginação</h3></td>
                                    <tr>
                                    <td><p>Clicando em "registros por página" será alterada a quantidade de registros por página e abaixo é possível navegar nas demais páginas, clicando em "Início"/"Anterior"/"Próximo"/"Último".</p></td>
                                    <tr>

                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Filtros</h3></td>
                                    <tr>
                                    <td><p>Clicando em "Mostrar todos" é possível filtrar os resultados conforme a opção desejada.</p></td>
                                    <tr>

                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Pesquisa</h3></td>
                                    <tr>
                                    <td><p>No campo pesquisa é possível pesquisar por qualquer registro exibido na lista.</p></td>
                                    <tr>

                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Ordenação</h3></td>
                                    <tr>
                                    <td><p>Clicando no cabeçalho da tabela é possível ordenar os registros conforme a coluna desejada em ordem crescente e clicando novamente é ordenado em ordem decrescente.</p></td>
                                    <tr>

                                    @if($atributo == "produto" || $atributo == "fisica" || $atributo == "juridica" || $atributo == "cliente-fisica" || $atributo == "cliente-juridica" || $atributo == "fornecedor-fisica" || $atributo == "fornecedor-juridica")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Exibir detalhes</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-eye-open"></span>" é possível visulizar os detalhes do registro escolhido.</p></td>
                                    <tr>
                                    @endif
                                    
                                    @if($atributo == "produto" || $atributo == "fisica" || $atributo == "juridica" || $atributo == "departamento" || $atributo == "marca" || $atributo == "usuario")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Editar registro</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-pencil"></span>" será direcionado para a tela de edição de registros.</p></td>
                                    <tr>

                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Excluir registro</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-trash"></span>" o registro escolhido será excluído.</p></td>
                                    <tr>
                                    @endif

                                    @if($atributo == "cliente-fisica" || $atributo == "cliente-juridica" || $atributo == "fornecedor-fisica" || $atributo == "fornecedor-juridica" || $atributo == "usuario")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> E-mail para contato</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-envelope"></span>" é possível enviar um e-mail para o contato escolhido.</p></td>
                                    <tr>
                                    @endif

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
