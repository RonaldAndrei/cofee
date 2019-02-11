<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

	$id_entrada = $_POST["id_entrada"];

	$sql = "DELETE FROM entrada_produto WHERE id_entrada = '".$id_entrada."'";
	$result = $mysqli->query($sql);

	$sql = "DELETE FROM entrada WHERE id = '".$id_entrada."'";
	$result = $mysqli->query($sql);
 
?>