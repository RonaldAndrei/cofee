<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "
			SELECT
			produto_solicitado.id,
			solicitacao_produto.id as id_solicitacao,
			produtos.codigo_barras,
			produtos.descricao,
			produtos.saldo,
			produtos.unidade_medida,
			solicitacao_produto.id_usuario_solicitante,
			solicitacao_produto.id_usuario_aprova,
			solicitacao_produto.data_solicitacao,
			solicitacao_produto.data_aprovacao,
			produto_solicitado.qtd_solicitada,
			produto_solicitado.qtd_atendida,
			produto_solicitado.aprovado,
			solicitacao_produto.status
			FROM produto_solicitado, solicitacao_produto, produtos
			WHERE solicitacao_produto.id = produto_solicitado.id_solicitacao_produto
			AND produto_solicitado.id = '".$busca."'
			AND produtos.id = produto_solicitado.id_produto
		"); 

   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    
    
    echo json_encode($data);

?>