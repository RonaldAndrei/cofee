<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

	$id_retirada = $_POST["id_retirada"];

	$sql = "DELETE FROM solicitacao_produto WHERE id = '".$id_retirada."'";
	$result = $mysqli->query($sql);

	$sql = "DELETE FROM produto_solicitado WHERE id_solicitacao_produto = '".$id_retirada."'";
	$result = $mysqli->query($sql);

?>