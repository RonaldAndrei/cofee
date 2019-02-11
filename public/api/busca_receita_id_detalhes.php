<?php

$mysqli = new mysqli("localhost", "root", "root", "teste");

if (isset($_GET["busca"])) {
	$busca  = $_GET["busca"];
}

$sql = mysqli_query($mysqli, "
			SELECT
                contas_receber.id,
                contas_receber.id_categoria,
                contas_receber.id_cliente as cliente,
                contas_receber.descricao,
                contas_receber.valor,
                contas_receber.valor_pago,
                contas_receber.qtd_parcelas,
                contas_receber.qtd_parcelas_pagas,
                contas_receber.created_at,
                parcelas_receita.id,
                parcelas_receita.id_conta_receber,
                parcelas_receita.id_forma_pagamento,
                parcelas_receita.valor_pago,
                parcelas_receita.valor_parcela,
                parcelas_receita.num_parcela,
                parcelas_receita.data_vencimento,
                parcelas_receita.data_pagamento,
                parcelas_receita.status,
                categoria.nome as categoria
            FROM contas_receber, parcelas_receita, categoria
            WHERE contas_receber.id_categoria = categoria.id
            AND parcelas_receita.id_conta_receber = contas_receber.id
			AND parcelas_receita.id = ".$busca
		); 

   
    while($resultado = mysqli_fetch_assoc($sql)){
        $data[] = array_map('utf8_encode', $resultado); 
    }    
    
    echo json_encode($data);

?>