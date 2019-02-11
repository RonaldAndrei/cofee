<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;

	$sql = "UPDATE parcelas_despesa 
			SET id_forma_pagamento = '".$post['forma_pagamento']."', valor_pago = '".$post['valor_pago']."', data_pagamento = '".$post['data_pagamento']."', status = '1'
			WHERE id = '".$post['id_parcela']."'
		";

	$result = $mysqli->query($sql);

	$sql = "UPDATE contas_pagar 
			SET valor_pago = valor_pago + '".$post['valor_pago']."', qtd_parcelas_pagas = qtd_parcelas_pagas + 1
			WHERE id = '".$post['id_conta_pagar']."'
		";

	$result = $mysqli->query($sql);

	if($post['status'] == '1'){
		$sql = "UPDATE contas_pagar 
			SET status = 1
			WHERE id = '".$post['id_conta_pagar']."'
		";

		$result = $mysqli->query($sql);
	}

	echo json_encode("ok");

?>