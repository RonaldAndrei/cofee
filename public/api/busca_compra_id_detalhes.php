<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "
			SELECT
			users.name as solicitante,
			produtos.descricao,
			produtos.saldo,
			produtos.minimo,
			solicitacao_compra.id,
			solicitacao_compra.id_usuario_solicitante,
			solicitacao_compra.id_produto,
			solicitacao_compra.data_solicitacao,
			solicitacao_compra.data_confirmacao,
			solicitacao_compra.confirmado
			FROM solicitacao_compra, users, produtos
			WHERE solicitacao_compra.id = '".$busca."'
			AND solicitacao_compra.id_usuario_solicitante = users.id
			AND solicitacao_compra.id_produto = produtos.id
			ORDER BY data_solicitacao DESC
			"); 

   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    
    
    echo json_encode($data);

?>