<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "SELECT
				pessoa_juridicas.id,
				pessoa_juridicas.cnpj, 
				pessoa_juridicas.nome_fantasia,
				pessoa_juridicas.razao_social,
				pessoa_juridicas.inscricao_estadual,
				pessoa_juridicas.telefone,
				pessoa_juridicas.telefone_sec,
				pessoa_juridicas.email,
				pessoa_juridicas.cep,
				pessoa_juridicas.uf,
				pessoa_juridicas.cidade,
				pessoa_juridicas.bairro,
				pessoa_juridicas.logradouro,
				pessoa_juridicas.numero,
				pessoa_juridicas.complemento,
				pessoa_juridicas.tipo,
				pessoa_juridicas.created_at,
				pessoa_juridicas.updated_at
			FROM pessoa_juridicas
			WHERE pessoa_juridicas.id = ".$busca); 

   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    
    
    echo json_encode($data);

?>