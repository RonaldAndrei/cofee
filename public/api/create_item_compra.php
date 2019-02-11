<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;
	$tam = 0;

	$sql = mysqli_query($mysqli, "SELECT * FROM solicitacao_compra
			WHERE solicitacao_compra.id_produto = '".$post['id_produto']."' 
			AND solicitacao_compra.confirmado = '0'
		");

	while($resultado = mysqli_fetch_assoc($sql)){
	$data[] = array_map('utf8_encode', $resultado);
	$tam++;
	}  

	if($tam == 0){
		$sql = "INSERT INTO solicitacao_compra 
			(id_usuario_solicitante,id_produto,data_solicitacao,confirmado) 
			VALUES ('".$post['id_usuario_solicitante']."','".$post['id_produto']."',now(),'0')
		";
		$result = $mysqli->query($sql);
		echo json_encode($tam);	
	}else{
		echo json_encode($tam);
	}
?>