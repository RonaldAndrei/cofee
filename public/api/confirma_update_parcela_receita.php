<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;
		
	$sql = "UPDATE parcelas_receita 
		SET valor_parcela = '".$post['valor_parcela']."',
			valor_pago = 0,
			data_vencimento = '".$post['data_vencimento']."'
		WHERE id = '".$post['id_parcela']."'
	";

	$result = $mysqli->query($sql);

	echo json_encode("ok");    

?>