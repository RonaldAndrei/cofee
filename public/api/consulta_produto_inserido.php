<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;
	$tam = 0;

	$sql = mysqli_query($mysqli, "SELECT * FROM entrada_produto
		WHERE entrada_produto.id_entrada = '".$post['id_entrada']."' AND entrada_produto.id_produto = '".$post['id_produto']."'");

	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado);
	$tam++;
	}

	echo json_encode($tam);
	
?>