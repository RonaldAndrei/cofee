<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "SELECT
				produtos.id,
				produtos.codigo_barras, 
				produtos.descricao, 
				produtos.saldo,
				produtos.minimo,
				marcas.nome as nome_marca, 
				departamentos.nome as nome_departamento
			FROM produtos, marcas, departamentos
			WHERE produtos.id_marca = marcas.id 
			AND produtos.id_departamento = departamentos.id
			AND produtos.id = ".$busca); 

   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    
    
    echo json_encode($data);

?>