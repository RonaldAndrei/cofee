<?php
$mysqli = new mysqli("localhost", "root", "root", "teste");

	$post = $_POST;

	$sql = "UPDATE produto_solicitado 
			SET qtd_atendida ='".$post['qtd_atendida']."', aprovado ='1'
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

	$sql = mysqli_query($mysqli, "SELECT *
			FROM produtos
			WHERE produtos.codigo_barras = ".$post['codigo_produto']);

   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    
    
    echo json_encode($data);

?>