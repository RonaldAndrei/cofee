<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;
	$tam = 0;

	$sql = mysqli_query($mysqli, "SELECT * FROM pessoa_juridicas
		WHERE pessoa_juridicas.cnpj = '".$post['cnpj']."'");

	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado);
	$tam++;
	}

	echo json_encode($tam);
?>