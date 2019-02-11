<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "SELECT
				produtos.id,
				produtos.codigo_barras, 
				produtos.descricao, 
				marcas.nome as nome_marca, 
				departamentos.nome as nome_departamento, 
				produtos.saldo, 
				produtos.unidade_medida, 
				produtos.posicao, 
				produtos.minimo, 
				produtos.observacao 
			FROM produtos, marcas, departamentos
			WHERE produtos.id_marca = marcas.id 
			AND produtos.id_departamento = departamentos.id
			AND produtos.ativo = '1'
			AND (
				produtos.descricao LIKE '%".$busca."%' OR
				produtos.codigo_barras LIKE '%".$busca."%' OR
				marcas.nome LIKE '%".$busca."%' OR
				departamentos.nome LIKE '%".$busca."%'
			)
			ORDER BY descricao ASC
			"); 

   $count = 0;

    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado);
        $count++;
    }    
    
    if($count == 0){
		echo json_encode($count);
	}else{
		echo json_encode($data);
	}

?>