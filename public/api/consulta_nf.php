<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;
	$tam = 0;

	$sql = mysqli_query($mysqli, "SELECT * FROM entrada
			WHERE entrada.serie_nf = '".$post['serie_nf']."' 
			AND entrada.num_nota_fiscal = '".$post['num_nota_fiscal']."'
		");

	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado);
	$tam++;
	}

	echo json_encode($tam);
	
?>