<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;
	
	$sql = "UPDATE solicitacao_produto 
			SET status = 'f'
			WHERE id ='".$post['id_solicitacao']."'
		";

	$result = $mysqli->query($sql);

	echo json_encode("ok");

?>