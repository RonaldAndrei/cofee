<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "SELECT
						users.name as responsavel,
						entrada.id_fornecedor as fornecedor,
						entrada.id,
						entrada.data_entrada,
						entrada.serie_nf,
						entrada.num_nota_fiscal,
						entrada.motivo,
						entrada.created_at,
						entrada.updated_at
						from entrada, users
						where entrada.id_usuario = users.id
						and entrada.id = ".$busca
					);
   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    

    echo json_encode($data);

?>