<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;

	$sql = "UPDATE produto_solicitado 
			SET qtd_atendida ='0', aprovado ='0'
			WHERE id ='".$post['id_retirada']."' 
			AND id_solicitacao_produto ='".$post['id_solicitacao']."'
		";

	$result = $mysqli->query($sql);
	
	$sql = "UPDATE solicitacao_produto 
			SET id_usuario_aprova ='".$post['id_usuario_aprova']."', 
				data_aprovacao = now()
			WHERE id ='".$post['id_solicitacao']."'
		";

	$result = $mysqli->query($sql);

	echo json_encode("ok");

?>