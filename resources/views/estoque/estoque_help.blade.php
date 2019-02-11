@extends('layouts.app2')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">
            <div class="col-md-8 col-md-offset-2">
                <div class="well well-lg">
                    <div class="panel panel-default">
                        @if($atributo == "show")
                        <div class="panel-heading">Ajuda: Produtos em estoque</div>
                        @elseif($atributo == "historico_entrada")
                        <div class="panel-heading">Ajuda: Histórico de entradas</div>
                        @elseif($atributo == "entrada")
                        <div class="panel-heading">Ajuda: Realizar entrada de produtos</div>
                        @elseif($atributo == "entrada_detalhes")
                        <div class="panel-heading">Ajuda: Detalhes da entrada</div>
                        @elseif($atributo == "retirada")
                        <div class="panel-heading">Ajuda: Solicitações de retirada</div>
                        @elseif($atributo == "retirada_produto")
                        <div class="panel-heading">Ajuda: Solicitar retirada de produtos</div>
                        @elseif($atributo == "retirada_detalhes")
                        <div class="panel-heading">Ajuda: Detalhes da retirada</div>
                        @elseif($atributo == "compra")
                        <div class="panel-heading">Ajuda: Solicitações de compra</div>
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
                                    <td><p>À esquerda no menu de navegação é possível escolher a página de estoque desejada.<ul><li><strong>Menu:</strong> Volta ao menu principal.</li><li><strong>Estoque:</strong> São listados todos os produtos em estoque.</li><li><strong>Entrada:</strong> É possível realizar entrada de produtos no estoque e visualizar as entradas já realizadas.</li><ul><li><strong>Histórico entradas:</strong> São listadas todas as entradas de produtos no estoque.</li></ul><ul><li><strong>Realizar entrada:</strong> É possível realizar entrada de produtos no estoque</li></ul><li><strong>Retirada:</strong> São as solicitações de retirada de produtos do estoque e solicitações de compra de produtos em falta ou acabando.</li><ul><li><strong>Solicitações retirada:</strong> É possível solicitar a retirada de produtos do estoque e visualizar as solicitações finalizadas e pendentes de aprovação.</li></ul><ul><li><strong>Solicitações compra:</strong> É possível visualizar as solicitações de compra de produtos que estão em falta ou estão abaixo do mínimo desejado.</li></ul></p></td>
                                    <tr>

                                    @if($atributo == "historico_entrada")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Nova entrada</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-plus"></span> novo" será direcionado para a tela de entrada de novos produtos no estoque.</p></td>
                                    <tr>
                                    @endif

                                    @if($atributo == "entrada")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Tipos de entrada</h3></td>
                                    <tr>
                                    <td><p>Escolhendo umas das opções de entrada é possível realizar entrada de produtos no estoque, as opções são:<ul><li>Compra de novos produtos</li><li>Retorno de produtos</li></ul></p></td>
                                    <tr>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Compra de novos produtos</h3></td>
                                    <tr>
                                    <td><p>Esta opção deve ser escolhida quando a entrada de produtos é realizada por aquisição de novos produtos.<br>Será necessário informar:<ul><li>Data da entrada</li><li>Fornecedor</li><li>Série da nota fiscal</li><li>Número da nota fiscal</li></ul></p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Retorno de produtos</h3></td>
                                    <tr>
                                    <td><p>Esta opção deve ser escolhida quando a entrada de produtos é realizada por retorno de produtos que anteriormente estiveram no estoque.<br>Será necessário informar:<ul><li>Data de entrada</li><li>Motivo pelo qual o produto está retornando</li></ul></p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Próxima página</h3></td>
                                    <tr>
                                    <td><p>Clicando no botão "Próximo" será direcionado para a página onde são escolhidos os produtos que entrarão no estoque.</p></td>
                                    <tr>
                                    @endif
                                    
                                    @if($atributo == "produto")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Procurar</h3></td>
                                    <tr>
                                    <td><p>Neste campo é possível pesquisar os produtos que serão inseridos no estoque.<br>Clicando em "<span class="glyphicon glyphicon-search"></span>" é realizada a busca dos produtos cadastrados, a busca também pode ser feita pressionando a tecla "Enter".<br>Clicando em "<span class="glyphicon glyphicon-arrow-left"></span>" são limpadas a busca e os resultados da tela.</p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Inserir produto</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-plus"></span>" é possível inserir o produto escolhido na lista de entradas.<ul><li>Será necessário informar a quantidade e inserir na lista.</li></ul></p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Remover produto</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-trash"></span>" é possível remover o produto escolhido da lista de entradas.</p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Salvar entrada</h3></td>
                                    <tr>
                                    <td><p>Clicando em "Salvar entrada" a lista de produtos será inserida no estoque conforme as quantidades informadas.</p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Cancelar entrada</h3></td>
                                    <tr>
                                    <td><p>Clicando em "Cancelar entrada" a entrada será cancelada e nenhum produto será inserido no estoque.</p></td>
                                    <tr>
                                    @endif

                                    @if($atributo == "retirada")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Nova solicitação de retirada</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-plus"></span> novo" será direcionado para a tela de solicitação de retirada de produtos do estoque.</p></td>
                                    <tr>
                                    @endif

                                    @if($atributo == "retirada_produto")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Procurar</h3></td>
                                    <tr>
                                    <td><p>Neste campo é possível pesquisar os produtos que serão retirados do estoque.<br>Clicando em "<span class="glyphicon glyphicon-search"></span>" é realizada a busca dos produtos cadastrados, a busca também pode ser feita pressionando a tecla "Enter".<br>Clicando em "<span class="glyphicon glyphicon-arrow-left"></span>" são limpadas a busca e os resultados da tela.</p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Inserir produto</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-plus"></span>" é possível inserir o produto escolhido na lista de retiradas.<ul><li>Será necessário informar a quantidade e inserir na lista.</li></ul></p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Remover produto</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-trash"></span>" é possível remover o produto escolhido da lista de retiradas.</p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Salvar solicitação</h3></td>
                                    <tr>
                                    <td><p>Clicando em "Salvar solicitação" a lista de produtos será enviada para aprovação e posteriormente retirada do estoque.</p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Cancelar solicitação</h3></td>
                                    <tr>
                                    <td><p>Clicando em "Cancelar solicitação" a solicitação será cancelada e nenhum produto será retirado do estoque.</p></td>
                                    <tr>
                                    @endif
                                    
                                    @if($atributo == "show" || $atributo == "historico_entrada" || $atributo == "retirada" || $atributo == "compra" || $atributo == "entrada_detalhes" || $atributo == "retirada_detalhes")
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
                                    @endif

                                    @if($atributo == "retirada_detalhes")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Aprovar solicitação</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-thumbs-up"></span>" é possível aprovar a solicitação de retirada do estoque.<ul><li>Será necessário informar a quantidade aprovada.</li></ul></p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Reprovar solicitação</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-thumbs-down"></span>" é possível reprovar a solicitação de retirada do estoque.</p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Salvar retirada</h3></td>
                                    <tr>
                                    <td><p>Clicando em "Salvar" os produtos aprovados serão retirados do estoque e a solicitação será finalizada, não podendo mais ser alterada.</p></td>
                                    <tr>
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Cancelar retirada</h3></td>
                                    <tr>
                                    <td><p>Clicando em "Cancelar" os produtos não são aprovados mas a solicitação continua pendente para que seja aprovada ou reprovada posteriormente.</p></td>
                                    <tr>
                                    @endif

                                    @if($atributo == "show" || $atributo == "historico_entrada" || $atributo == "retirada")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Exibir detalhes</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-eye-open"></span>" é possível visulizar os detalhes do registro escolhido.</p></td>
                                    <tr>
                                    @endif

                                    @if($atributo == "compra")
                                    <td><h3><span class="glyphicon glyphicon-unchecked"></span> Confirmar compra</h3></td>
                                    <tr>
                                    <td><p>Clicando em "<span class="glyphicon glyphicon-ok"></span> " é possível atender a solicitação de compra do produto escolhido.</p></td>
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
