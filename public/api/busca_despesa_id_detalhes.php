<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "
			SELECT
                contas_pagar.id,
                contas_pagar.id_categoria,
                contas_pagar.id_fornecedor as fornecedor,
                contas_pagar.descricao,
                contas_pagar.valor,
                contas_pagar.valor_pago,
                contas_pagar.qtd_parcelas,
                contas_pagar.qtd_parcelas_pagas,
                contas_pagar.created_at,
                parcelas_despesa.id,
                parcelas_despesa.id_conta_pagar,
                parcelas_despesa.id_forma_pagamento,
                parcelas_despesa.valor_pago,
                parcelas_despesa.valor_parcela,
                parcelas_despesa.num_parcela,
                parcelas_despesa.data_vencimento,
                parcelas_despesa.data_pagamento,
                parcelas_despesa.status,
                categoria.nome as categoria
            FROM contas_pagar, parcelas_despesa, categoria
            WHERE contas_pagar.id_categoria = categoria.id
            AND parcelas_despesa.id_conta_pagar = contas_pagar.id
			AND parcelas_despesa.id = ".$busca
		); 

   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    
    
    echo json_encode($data);

?>