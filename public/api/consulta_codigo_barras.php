<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;
	$tam = 0;

	$sql = mysqli_query($mysqli, "SELECT * FROM produtos
		WHERE produtos.codigo_barras = '".$post['codigo_barras']."'");

	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado);
	$tam++;
	}

	echo json_encode($tam);
	
?>