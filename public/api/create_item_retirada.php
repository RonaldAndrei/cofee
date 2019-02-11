<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;

	$sql = "INSERT INTO produto_solicitado (id_solicitacao_produto,id_produto,qtd_solicitada,qtd_atendida) 

	VALUES ('".$post['id_retirada']."','".$post['id_produto']."','".$post['qtd_solicitada']."','0')";


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
		AND produto_solicitado.id_solicitacao_produto = '".$post['id_retirada']."'
		ORDER BY descricao_produto ASC
	"); 


	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado); 
	}  


	echo json_encode($data);

?>