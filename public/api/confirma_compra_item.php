<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;

	$sql = "UPDATE solicitacao_compra 
			SET data_confirmacao = now(), confirmado ='1', id_usuario_confirma = '".$post['id_usuario_confirma']."'
			WHERE id ='".$post['id_solicitacao']."'
		";

	$result = $mysqli->query($sql);
	
    echo json_encode($result);

?>