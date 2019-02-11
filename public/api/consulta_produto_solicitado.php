<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;
	$tam = 0;

	$sql = mysqli_query($mysqli, "SELECT * FROM produto_solicitado
		WHERE produto_solicitado.id_solicitacao_produto = '".$post['id_solicitacao_produto']."' AND produto_solicitado.id_produto = '".$post['id_produto']."'");

	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado);
	$tam++;
	}

	echo json_encode($tam);
	
?>