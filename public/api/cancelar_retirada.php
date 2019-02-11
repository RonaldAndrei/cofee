<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;

	$sql = "UPDATE produto_solicitado 
			SET qtd_atendida ='0', aprovado ='0'
			WHERE id_solicitacao_produto = '".$post['id_solicitacao']."'
		";

	$result = $mysqli->query($sql);
	
	$sql = "UPDATE solicitacao_produto 
			SET id_usuario_aprova = NULL, 
				data_aprovacao = NULL
			WHERE id = '".$post['id_solicitacao']."'
		";

	$result = $mysqli->query($sql);

	echo json_encode("ok");

?>