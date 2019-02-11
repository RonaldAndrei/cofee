<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

	$id  = $_POST["id"];
	$id_retirada = $_POST["id_retirada"];

	$sql = "DELETE FROM produto_solicitado WHERE id = '".$id."'";

	$result = $mysqli->query($sql);

	$sql = mysqli_query($mysqli, "SELECT
		produto_solicitado.id,
	    produto_solicitado.id_solicitacao_produto,
		produtos.descricao as descricao_produto,
		produtos.saldo as qtd_produto,
		produtos.saldo as minimo_produto,
		produto_solicitado.qtd_solicitada	
		FROM produtos, produto_solicitado, solicitacao_produto
		WHERE produtos.id = produto_solicitado.id_produto 
		AND solicitacao_produto.id = produto_solicitado.id_solicitacao_produto 
		AND produto_solicitado.id_solicitacao_produto = '".$id_retirada."'
		ORDER BY descricao_produto ASC
	");

	$count = 0;

	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado); 
	$count++;
	}  

	if($count == 0){
		echo json_encode($count);
	}else{
		echo json_encode($data);
	}
	
 
?>