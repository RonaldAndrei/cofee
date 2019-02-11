<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "SELECT
				pessoa_fisicas.id,
				pessoa_fisicas.nome, 
				pessoa_fisicas.cpf,
				pessoa_fisicas.rg,
				pessoa_fisicas.data_nascim,
				pessoa_fisicas.sexo,
				pessoa_fisicas.telefone,
				pessoa_fisicas.telefone_sec,
				pessoa_fisicas.email,
				pessoa_fisicas.cep,
				pessoa_fisicas.uf,
				pessoa_fisicas.cidade,
				pessoa_fisicas.bairro,
				pessoa_fisicas.logradouro,
				pessoa_fisicas.numero,
				pessoa_fisicas.tipo,
				pessoa_fisicas.orgao_expedidor,
				pessoa_fisicas.complemento,
				pessoa_fisicas.created_at,
				pessoa_fisicas.updated_at
			FROM pessoa_fisicas
			WHERE pessoa_fisicas.id = ".$busca
		); 

   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    
    
    echo json_encode($data);

?>