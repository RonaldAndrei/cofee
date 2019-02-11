<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Marca;
use App\Produto;
use App\Entrada;
use App\Retirada;
use App\Despesa;
use App\Receita;
use App\Parcela_despesa;
use App\Parcela_receita;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Contas_Controller extends Controller
{
    public function index($atributo){
        
        if($atributo == "resumo"){

            $hoje = date("Y-m-d");
            $semana = date('Y-m-d', strtotime($hoje. ' + 7 days'));
            $mes = date('Y-m-d', strtotime($hoje. ' + 30 days'));

// despesas
            // despesas hoje
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total, SUM(valor_pago) as valor_pago
                FROM parcelas_despesa
                WHERE parcelas_despesa.data_vencimento = '".$hoje."';
            ");
            foreach ($query as $q) {
                $despesa_valor_hoje = $q->valor_total;
                $despesa_valor_hoje_pago = $q->valor_pago;
                $despesa_delta_hoje = $q->valor_total-$q->valor_pago;

                $despesa_valor_hoje = number_format($despesa_valor_hoje, 2, ',', '.');
                $despesa_valor_hoje_pago = number_format($despesa_valor_hoje_pago, 2, ',', '.');
                $despesa_delta_hoje = number_format($despesa_delta_hoje, 2, ',', '.');
            } 
            // despesas semana
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total, SUM(valor_pago) as valor_pago
                FROM parcelas_despesa
                WHERE parcelas_despesa.data_vencimento >= '".$hoje."'
                AND parcelas_despesa.data_vencimento <= '".$semana."';
            ");
            foreach ($query as $q) {
                $despesa_valor_semana = $q->valor_total;
                $despesa_valor_semana_pago = $q->valor_pago;
                $despesa_delta_semana = $q->valor_total-$q->valor_pago;

                $despesa_valor_semana = number_format($despesa_valor_semana, 2, ',', '.');
                $despesa_valor_semana_pago = number_format($despesa_valor_semana_pago, 2, ',', '.');
                $despesa_delta_semana = number_format($despesa_delta_semana, 2, ',', '.');
            } 
            // despesas mes
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total, SUM(valor_pago) as valor_pago
                FROM parcelas_despesa
                WHERE parcelas_despesa.data_vencimento >= '".$hoje."'
                AND parcelas_despesa.data_vencimento <= '".$mes."';
            ");
            foreach ($query as $q) {
                $despesa_valor_mes = $q->valor_total;
                $despesa_valor_mes_pago = $q->valor_pago;
                $despesa_delta_mes = $q->valor_total-$q->valor_pago;

                $despesa_valor_mes = number_format($despesa_valor_mes, 2, ',', '.');
                $despesa_valor_mes_pago = number_format($despesa_valor_mes_pago, 2, ',', '.');
                $despesa_delta_mes = number_format($despesa_delta_mes, 2, ',', '.');
            }
            // despesas total
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total, SUM(valor_pago) as valor_pago
                FROM parcelas_despesa;
            ");
            foreach ($query as $q) {
                $despesa_valor_total = $q->valor_total;
                $despesa_valor_total_pago = $q->valor_pago;
                $despesa_delta_total = $q->valor_total-$q->valor_pago;

                $despesa_valor_total = number_format($despesa_valor_total, 2, ',', '.');
                $despesa_valor_total_pago = number_format($despesa_valor_total_pago, 2, ',', '.');
                $despesa_delta_total = number_format($despesa_delta_total, 2, ',', '.');
            }
            // despesas em atraso
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total
                FROM parcelas_despesa
                WHERE parcelas_despesa.data_vencimento < '".$hoje."'
                AND parcelas_despesa.status = '0'
            ");
            foreach ($query as $q) {
                $despesa_valor_atraso = $q->valor_total;
                $despesa_valor_atraso = number_format($despesa_valor_atraso, 2, ',', '.');
            }
// receitas
            // receitas hoje
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total, SUM(valor_pago) as valor_pago
                FROM parcelas_receita
                WHERE parcelas_receita.data_vencimento = '".$hoje."';
            ");
            foreach ($query as $q) {
                $receita_valor_hoje = $q->valor_total;
                $receita_valor_hoje_pago = $q->valor_pago;
                $receita_delta_hoje = $q->valor_total-$q->valor_pago;

                $receita_valor_hoje = number_format($receita_valor_hoje, 2, ',', '.');
                $receita_valor_hoje_pago = number_format($receita_valor_hoje_pago, 2, ',', '.');
                $receita_delta_hoje = number_format($receita_delta_hoje, 2, ',', '.');
            } 
            // receitas semana
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total, SUM(valor_pago) as valor_pago
                FROM parcelas_receita
                WHERE parcelas_receita.data_vencimento >= '".$hoje."'
                AND parcelas_receita.data_vencimento <= '".$semana."';
            ");
            foreach ($query as $q) {
                $receita_valor_semana = $q->valor_total;
                $receita_valor_semana_pago = $q->valor_pago;
                $receita_delta_semana = $q->valor_total-$q->valor_pago;

                $receita_valor_semana = number_format($receita_valor_semana, 2, ',', '.');
                $receita_valor_semana_pago = number_format($receita_valor_semana_pago, 2, ',', '.');
                $receita_delta_semana = number_format($receita_delta_semana, 2, ',', '.');
            } 
            // receitas mes
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total, SUM(valor_pago) as valor_pago
                FROM parcelas_receita
                WHERE parcelas_receita.data_vencimento >= '".$hoje."'
                AND parcelas_receita.data_vencimento <= '".$mes."';
            ");
            foreach ($query as $q) {
                $receita_valor_mes = $q->valor_total;
                $receita_valor_mes_pago = $q->valor_pago;
                $receita_delta_mes = $q->valor_total-$q->valor_pago;

                $receita_valor_mes = number_format($receita_valor_mes, 2, ',', '.');
                $receita_valor_mes_pago = number_format($receita_valor_mes_pago, 2, ',', '.');
                $receita_delta_mes = number_format($receita_delta_mes, 2, ',', '.');
            }
            // receitas total
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total, SUM(valor_pago) as valor_pago
                FROM parcelas_receita;
            ");
            foreach ($query as $q) {
                $receita_valor_total = $q->valor_total;
                $receita_valor_total_pago = $q->valor_pago;
                $receita_delta_total = $q->valor_total-$q->valor_pago;

                $receita_valor_total = number_format($receita_valor_total, 2, ',', '.');
                $receita_valor_total_pago = number_format($receita_valor_total_pago, 2, ',', '.');
                $receita_delta_total = number_format($receita_delta_total, 2, ',', '.');
            }
            // receitas em atraso
            $query = DB::select("
                SELECT SUM(valor_parcela) as valor_total
                FROM parcelas_receita
                WHERE parcelas_receita.data_vencimento < '".$hoje."'
                AND parcelas_receita.status = '0'
            ");
            foreach ($query as $q) {
                $receita_valor_atraso = $q->valor_total;
                $receita_valor_atraso = number_format($receita_valor_atraso, 2, ',', '.');
            }

            $hoje = date('d/m/Y', strtotime($hoje));
            $semana = date('d/m/Y', strtotime($semana));
            $mes = date('d/m/Y', strtotime($mes));

            return view('contas.contas_resumo', compact('despesa_valor_hoje','despesa_valor_hoje_pago','despesa_delta_hoje','despesa_valor_semana','despesa_valor_semana_pago','despesa_delta_semana','despesa_valor_mes','despesa_valor_mes_pago','despesa_delta_mes','despesa_valor_total', 'despesa_valor_total_pago','despesa_delta_total','despesa_valor_atraso','receita_valor_hoje','receita_valor_hoje_pago','receita_delta_hoje','receita_valor_semana','receita_valor_semana_pago','receita_delta_semana','receita_valor_mes','receita_valor_mes_pago','receita_delta_mes','receita_valor_total', 'receita_valor_total_pago','receita_delta_total','receita_valor_atraso','hoje','semana','mes'));

        }elseif($atributo == "despesas"){

            $despesas = DB::select("
                SELECT
                contas_pagar.*,
                categoria.nome as categoria
                FROM contas_pagar, categoria
                WHERE contas_pagar.id_categoria = categoria.id
                ORDER BY contas_pagar.id DESC
            ");

            foreach ($despesas as $despesa) {

                $fornecedores = DB::select("
                    SELECT
                    pessoa_fisicas.nome
                    FROM pessoa_fisicas, fornecedors
                    WHERE fornecedors.id = '".$despesa->id_fornecedor."' 
                    AND pessoa_fisicas.id = fornecedors.id_pessoa_fisica
                ");

                if($fornecedores){
                    foreach ($fornecedores as $fornecedor) {
                        $despesa->fornecedor = $fornecedor->nome;
                    }
                }else{
                    $fornecedores = DB::select("
                        SELECT
                        pessoa_juridicas.nome_fantasia
                        FROM pessoa_juridicas, fornecedors
                        WHERE fornecedors.id = '".$despesa->id_fornecedor."' 
                        AND pessoa_juridicas.id = fornecedors.id_pessoa_juridica
                    ");

                    foreach ($fornecedores as $fornecedor) {
                        $despesa->fornecedor = $fornecedor->nome_fantasia;
                    }
                }
            }    

            return view('contas.contas_depesas',compact('despesas'));

        }elseif($atributo == "despesas_parcelas"){

            $hoje = date("Y-m-d");
            $filter = $_GET["filter"];

            if(isset($_GET['inicio']) && isset($_GET['fim'])){
                $inicio = str_replace("/", "-", $_GET['inicio']);
                $fim = str_replace("/", "-", $_GET['fim']);

                $inicio = date('Y-m-d', strtotime($inicio));
                $fim = date('Y-m-d', strtotime($fim));
                
            }else{
                $inicio = "0000-00-00";
                $fim = "9999-99-99";
            }

            if($filter == "all"){
                $despesas = DB::select("
                    SELECT
                        contas_pagar.id,
                        contas_pagar.id_categoria,
                        contas_pagar.id_fornecedor as fornecedor,
                        contas_pagar.descricao,
                        contas_pagar.valor,
                        contas_pagar.valor_pago,
                        contas_pagar.qtd_parcelas,
                        contas_pagar.qtd_parcelas_pagas,
                        parcelas_despesa.id as id_parcela,
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
                    AND parcelas_despesa.data_vencimento >= '".$inicio."'
                    AND parcelas_despesa.data_vencimento <= '".$fim."'
                    group by id_parcela
                    ORDER BY data_vencimento ASC
                ");
            }else if($filter == "intime"){
                $despesas = DB::select("
                    SELECT
                        contas_pagar.id,
                        contas_pagar.id_categoria,
                        contas_pagar.id_fornecedor as fornecedor,
                        contas_pagar.descricao,
                        contas_pagar.valor,
                        contas_pagar.valor_pago,
                        contas_pagar.qtd_parcelas,
                        contas_pagar.qtd_parcelas_pagas,
                        parcelas_despesa.id as id_parcela,
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
                    AND parcelas_despesa.status = '0'
                    AND parcelas_despesa.data_vencimento >= '".$hoje."'
                    ORDER BY data_vencimento ASC
                ");
            }else if($filter == "timeout"){
                $despesas = DB::select("
                    SELECT
                        contas_pagar.id,
                        contas_pagar.id_categoria,
                        contas_pagar.id_fornecedor as fornecedor,
                        contas_pagar.descricao,
                        contas_pagar.valor,
                        contas_pagar.valor_pago,
                        contas_pagar.qtd_parcelas,
                        contas_pagar.qtd_parcelas_pagas,
                        parcelas_despesa.id as id_parcela,
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
                    AND parcelas_despesa.status = '0'
                    AND parcelas_despesa.data_vencimento < '".$hoje."'
                    ORDER BY data_vencimento ASC
                ");
            }

            foreach ($despesas as $despesa) {

                $despesa->data_vencimento = date('d/m/Y', strtotime($despesa->data_vencimento));
                $despesa->data_pagamento = date('d/m/Y', strtotime($despesa->data_pagamento));

                $fornecedores = DB::select("
                    SELECT
                    pessoa_fisicas.nome
                    FROM pessoa_fisicas, fornecedors
                    WHERE fornecedors.id = '".$despesa->fornecedor."' 
                    AND pessoa_fisicas.id = fornecedors.id_pessoa_fisica
                ");

                if($fornecedores){
                    foreach ($fornecedores as $fornecedor) {
                        $despesa->fornecedor = $fornecedor->nome;
                    }
                }else{
                    $fornecedores = DB::select("
                        SELECT
                        pessoa_juridicas.nome_fantasia
                        FROM pessoa_juridicas, fornecedors
                        WHERE fornecedors.id = '".$despesa->fornecedor."' 
                        AND pessoa_juridicas.id = fornecedors.id_pessoa_juridica
                    ");

                    foreach ($fornecedores as $fornecedor) {
                        $despesa->fornecedor = $fornecedor->nome_fantasia;
                    }
                }
            }

            $formas_pagamento = DB::select("
                SELECT * FROM forma_pagamento"); 

            return view('contas.contas_despesas_parcelas',compact('despesas','formas_pagamento','hoje','filter'));

        }elseif($atributo == "receitas"){
            
            $receitas = DB::select("
                SELECT
                contas_receber.*,
                categoria.nome as categoria
                FROM contas_receber, categoria
                WHERE contas_receber.id_categoria = categoria.id
                ORDER BY contas_receber.id DESC
            ");

            foreach ($receitas as $receita) {

                $clientes = DB::select("
                    SELECT
                    pessoa_fisicas.nome
                    FROM pessoa_fisicas, clientes
                    WHERE clientes.id = '".$receita->id_cliente."' 
                    AND pessoa_fisicas.id = clientes.id_pessoa_fisica
                ");

                if($clientes){
                    foreach ($clientes as $cliente) {
                        $receita->cliente = $cliente->nome;
                    }
                }else{
                    $clientes = DB::select("
                        SELECT
                        pessoa_juridicas.nome_fantasia
                        FROM pessoa_juridicas, clientes
                        WHERE clientes.id = '".$receita->id_cliente."' 
                        AND pessoa_juridicas.id = clientes.id_pessoa_juridica
                    ");

                    foreach ($clientes as $cliente) {
                        $receita->cliente = $cliente->nome_fantasia;
                    }
                }
            }    

            return view('contas.contas_receitas',compact('receitas'));
        }elseif($atributo == "receitas_parcelas"){

            $hoje = date("Y-m-d");
            $filter = $_GET["filter"];

            if(isset($_GET['inicio']) && isset($_GET['fim'])){
                $inicio = str_replace("/", "-", $_GET['inicio']);
                $fim = str_replace("/", "-", $_GET['fim']);

                $inicio = date('Y-m-d', strtotime($inicio));
                $fim = date('Y-m-d', strtotime($fim));

            }else{
                $inicio = "0000-00-00";
                $fim = "9999-99-99";
            }

            if($filter == "all"){
                $receitas = DB::select("
                    SELECT
                        contas_receber.id,
                        contas_receber.id_categoria,
                        contas_receber.id_cliente as cliente,
                        contas_receber.descricao,
                        contas_receber.valor,
                        contas_receber.valor_pago,
                        contas_receber.qtd_parcelas,
                        contas_receber.qtd_parcelas_pagas,
                        parcelas_receita.id as id_parcela,
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
                    AND parcelas_receita.data_vencimento >= '".$inicio."'
                    AND parcelas_receita.data_vencimento <= '".$fim."'
                    group by id_parcela
                    ORDER BY data_vencimento ASC
                ");
            }else if($filter == "intime"){
                $receitas = DB::select("
                    SELECT
                        contas_receber.id,
                        contas_receber.id_categoria,
                        contas_receber.id_cliente as cliente,
                        contas_receber.descricao,
                        contas_receber.valor,
                        contas_receber.valor_pago,
                        contas_receber.qtd_parcelas,
                        contas_receber.qtd_parcelas_pagas,
                        parcelas_receita.id as id_parcela,
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
                    AND parcelas_receita.status = '0'
                    AND parcelas_receita.data_vencimento >= '".$hoje."'
                    ORDER BY data_vencimento ASC
                ");
            }else if($filter == "timeout"){
                $receitas = DB::select("
                    SELECT
                        contas_receber.id,
                        contas_receber.id_categoria,
                        contas_receber.id_cliente as cliente,
                        contas_receber.descricao,
                        contas_receber.valor,
                        contas_receber.valor_pago,
                        contas_receber.qtd_parcelas,
                        contas_receber.qtd_parcelas_pagas,
                        parcelas_receita.id as id_parcela,
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
                    AND parcelas_receita.status = '0'
                    AND parcelas_receita.data_vencimento < '".$hoje."'
                    ORDER BY data_vencimento ASC
                ");
            }

            foreach ($receitas as $receita) {

                $receita->data_vencimento = date('d/m/Y', strtotime($receita->data_vencimento));
                $receita->data_pagamento = date('d/m/Y', strtotime($receita->data_pagamento));

                $clientes = DB::select("
                    SELECT
                    pessoa_fisicas.nome
                    FROM pessoa_fisicas, clientes
                    WHERE clientes.id = '".$receita->cliente."' 
                    AND pessoa_fisicas.id = clientes.id_pessoa_fisica
                ");

                if($clientes){
                    foreach ($clientes as $cliente) {
                        $receita->cliente = $cliente->nome;
                    }
                }else{
                    $clientes = DB::select("
                        SELECT
                        pessoa_juridicas.nome_fantasia
                        FROM pessoa_juridicas, clientes
                        WHERE clientes.id = '".$receita->cliente."' 
                        AND pessoa_juridicas.id = clientes.id_pessoa_juridica
                    ");

                    foreach ($clientes as $cliente) {
                        $receita->cliente = $cliente->nome_fantasia;
                    }
                }
            }

            $formas_pagamento = DB::select("
                SELECT * FROM forma_pagamento");     

            return view('contas.contas_receitas_parcelas',compact('receitas','formas_pagamento','hoje','filter'));
        }
    }

// despesas
    public function nova_despesa () {

        $fornecedors = DB::select("
            SELECT fornecedors.id, pessoa_fisicas.nome FROM fornecedors
            INNER JOIN pessoa_fisicas ON pessoa_fisicas.id = fornecedors.id_pessoa_fisica
            AND pessoa_fisicas.ativo = '1'
            union
            SELECT fornecedors.id, pessoa_juridicas.nome_fantasia as nome FROM fornecedors
            INNER JOIN pessoa_juridicas ON pessoa_juridicas.id = fornecedors.id_pessoa_juridica
            AND pessoa_juridicas.ativo = '1'
            ORDER BY nome
        ");

        $categorias = DB::select("
            SELECT *
            FROM categoria
            WHERE categoria.tipo = 'despesa'
            ORDER BY nome
        ");

        return view('contas.contas_despesa_novo', compact('fornecedors','categorias'));
    }

    public function create_despesa (Request $despesa) {
        
        if($despesa->repete == '1'){

            $descricao = strtoupper($despesa->descricao);
            $qtd_parcelas = $despesa->qtd_parcelas;
            $data_vencimento = $despesa->data_vencimento;
            $intervalo = $despesa->intervalo;
            // $meses = $despesa->intervalo/30;
            $dias = $despesa->intervalo;

            $valor_despesa = str_replace('.', '', $despesa['valor']);
            $valor_despesa = str_replace(',', '.', $valor_despesa);
            $valor_parcela = $valor_despesa/$qtd_parcelas;

            $conta_pagar = Despesa::create([
                'id_categoria'=> $despesa['categoria'],
                'id_fornecedor'=> $despesa['fornecedor'],
                'descricao'=> strtoupper($despesa['descricao']),
                'valor'=> $valor_despesa,
                'valor_pago'=> 0,
                'qtd_parcelas'=> $qtd_parcelas,
                'qtd_parcelas_pagas'=> 0,
                'status'=> 0
            ]);

            Parcela_despesa::create([
                'id_conta_pagar'=> $conta_pagar->id,
                'valor_parcela'=> $valor_parcela,
                'num_parcela' => 1,
                'data_vencimento'=> $data_vencimento,
                'status'=> 0
            ]);

            for($i=2; $i<=$qtd_parcelas; $i++){

                $data_vencimento = date('Y-m-d', strtotime($data_vencimento. ' +'.$dias.' days'));
                Parcela_despesa::create([
                    'id_conta_pagar'=> $conta_pagar->id,
                    'valor_parcela'=> $valor_parcela,
                    'num_parcela' => $i,
                    'data_vencimento'=> $data_vencimento,
                    'status'=> 0
                ]);
            }

            return redirect('contas/despesas/parcelas/'.$conta_pagar->id);   

        }else{

            $valor_despesa = str_replace('.', '', $despesa['valor']);
            $valor_despesa = str_replace(',', '.', $valor_despesa);

            $conta_pagar = Despesa::create([
                'id_categoria'=> $despesa['categoria'],
                'id_fornecedor'=> $despesa['fornecedor'],
                'descricao'=> strtoupper($despesa['descricao']),
                'valor'=> $valor_despesa,
                'valor_pago'=> 0,
                'qtd_parcelas'=> 1,
                'qtd_parcelas_pagas'=> 0,
                'status'=> 0
            ]);

            Parcela_despesa::create([
                'id_conta_pagar'=> $conta_pagar->id,
                'valor_parcela'=> $valor_despesa,
                'num_parcela' => 1,
                'data_vencimento'=> $despesa['data_vencimento'],
                'status'=> 0
            ]);

            return redirect('contas/despesas/parcelas/'.$conta_pagar->id);
        }

    }

    public function detalhes_despesa ($id){

        $parcelas = DB::select("
                SELECT
                    contas_pagar.id,
                    contas_pagar.id_categoria,
                    contas_pagar.id_fornecedor as fornecedor,
                    contas_pagar.descricao,
                    contas_pagar.valor,
                    contas_pagar.valor_pago as total_pago,
                    contas_pagar.qtd_parcelas,
                    contas_pagar.qtd_parcelas_pagas,
                    parcelas_despesa.id as id_parcela,
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
                AND contas_pagar.id = '".$id."'
                ORDER BY data_vencimento ASC
            ");

            foreach ($parcelas as $parcela) {

                $id_despesa = $parcela->id;
                $categoria = $parcela->categoria;
                $descricao = $parcela->descricao;
                $qtd_parcelas = $parcela->qtd_parcelas;
                $qtd_parcelas_pagas = $parcela->qtd_parcelas_pagas;
                $valor_total = number_format($parcela->valor, 2, ',', '.');
                $total_pago = number_format($parcela->total_pago, 2, ',', '.');

                $parcela->data_vencimento = date('d/m/Y', strtotime($parcela->data_vencimento));
                $parcela->data_pagamento = date('d/m/Y', strtotime($parcela->data_pagamento));

                $fornecedores = DB::select("
                    SELECT
                    pessoa_fisicas.nome
                    FROM pessoa_fisicas, fornecedors
                    WHERE fornecedors.id = '".$parcela->fornecedor."' 
                    AND pessoa_fisicas.id = fornecedors.id_pessoa_fisica
                ");

                if($fornecedores){
                    foreach ($fornecedores as $fornecedor) {
                        $fornecedor = $fornecedor->nome;
                    }
                }else{
                    $fornecedores = DB::select("
                        SELECT
                        pessoa_juridicas.nome_fantasia
                        FROM pessoa_juridicas, fornecedors
                        WHERE fornecedors.id = '".$parcela->fornecedor."' 
                        AND pessoa_juridicas.id = fornecedors.id_pessoa_juridica
                    ");

                    foreach ($fornecedores as $fornecedor) {
                        $fornecedor = $fornecedor->nome_fantasia;
                    }
                }

            }

            $formas_pagamento = DB::select("
                SELECT * FROM forma_pagamento");

            $hoje = date("Y-m-d"); 
            $count = 1;

           return view('contas.contas_despesas_detalhes',compact('id_despesa','categoria','descricao','qtd_parcelas','valor_total','fornecedor','qtd_parcelas_pagas','total_pago','parcelas','formas_pagamento','hoje','count'));
    }

    public function delete_despesa(Request $request, $id){

        $despesa = DB::table('contas_pagar')->where('id', '=', $id)->delete();
        
        return redirect('/contas/despesas');

    }

    public function delete_parcela_despesa(Request $request, $id){

        $despesa = DB::table('parcelas_despesa')->where('id', '=', $id)->get();
        $parcela = DB::table('parcelas_despesa')->where('id', '=', $id)->delete();

        foreach ($despesa as $i) {
            $id_despesa = $i->id_conta_pagar;
        }
        
        return redirect('/contas/despesas/parcelas/'.$id_despesa);
    }

// receitas
    public function nova_receita () {

        $clientes = DB::select("
            SELECT clientes.id, pessoa_fisicas.nome FROM clientes
            INNER JOIN pessoa_fisicas ON pessoa_fisicas.id = clientes.id_pessoa_fisica
            AND pessoa_fisicas.ativo = '1'
            union
            SELECT clientes.id, pessoa_juridicas.nome_fantasia as nome FROM clientes
            INNER JOIN pessoa_juridicas ON pessoa_juridicas.id = clientes.id_pessoa_juridica
            AND pessoa_juridicas.ativo = '1'
            ORDER BY nome
        ");

        $categorias = DB::select("
            SELECT *
            FROM categoria
            WHERE categoria.tipo = 'receita'
            ORDER BY nome
        ");

        return view('contas.contas_receita_novo', compact('clientes','categorias'));
    }

    public function create_receita (Request $receita) {
        
        if($receita->repete == '1'){

            $descricao = strtoupper($receita->descricao);
            $qtd_parcelas = $receita->qtd_parcelas;
            $data_vencimento = $receita->data_vencimento;
            $intervalo = $receita->intervalo;
            $dias = $receita->intervalo;

            $valor_receita = str_replace('.', '', $receita['valor']);
            $valor_receita = str_replace(',', '.', $valor_receita);
            $valor_parcela = $valor_receita/$qtd_parcelas;

            $conta_receber = Receita::create([
                'id_categoria'=> $receita['categoria'],
                'id_cliente'=> $receita['cliente'],
                'descricao'=> strtoupper($receita['descricao']),
                'valor'=> $valor_receita,
                'valor_pago'=> 0,
                'qtd_parcelas'=> $qtd_parcelas,
                'qtd_parcelas_pagas'=> 0,
                'status'=> 0
            ]);

            Parcela_receita::create([
                'id_conta_receber'=> $conta_receber->id,
                'valor_parcela'=> $valor_parcela,
                'num_parcela' => 1,
                'data_vencimento'=> $data_vencimento,
                'status'=> 0
            ]);

            $valor_receita = str_replace('.', '', $receita['valor']);
            $valor_receita = str_replace(',', '.', $valor_receita);

            for($i=2; $i<=$qtd_parcelas; $i++){

                $data_vencimento = date('Y-m-d', strtotime($data_vencimento. ' +'.$dias.' days'));
                Parcela_receita::create([
                    'id_conta_receber'=> $conta_receber->id,
                    'valor_parcela'=> $valor_parcela,
                    'num_parcela' => $i,
                    'data_vencimento'=> $data_vencimento,
                    'status'=> 0
                ]);
            }

            return redirect('contas/receitas/parcelas/'.$conta_receber->id);   

        }else{

            $valor_receita = str_replace('.', '', $receita['valor']);
            $valor_receita = str_replace(',', '.', $valor_receita);

            $conta_receber = Receita::create([
                'id_categoria'=> $receita['categoria'],
                'id_cliente'=> $receita['cliente'],
                'descricao'=> strtoupper($receita['descricao']),
                'valor'=> $valor_receita,
                'valor_pago'=> 0,
                'qtd_parcelas'=> 1,
                'qtd_parcelas_pagas'=> 0,
                'status'=> 0
            ]);

            Parcela_receita::create([
                'id_conta_receber'=> $conta_receber->id,
                'valor_parcela'=> $valor_receita,
                'num_parcela' => 1,
                'data_vencimento'=> $receita['data_vencimento'],
                'status'=> 0
            ]);

            return redirect('contas/receitas/parcelas/'.$conta_receber->id);
        }

    }

    public function detalhes_receita ($id){

        $parcelas = DB::select("
                SELECT
                    contas_receber.id,
                    contas_receber.id_categoria,
                    contas_receber.id_cliente as cliente,
                    contas_receber.descricao,
                    contas_receber.valor,
                    contas_receber.valor_pago as total_pago,
                    contas_receber.qtd_parcelas,
                    contas_receber.qtd_parcelas_pagas,
                    parcelas_receita.id as id_parcela,
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
                AND contas_receber.id = '".$id."'
                ORDER BY data_vencimento ASC
            ");

            foreach ($parcelas as $parcela) {

                $id_receita = $parcela->id;
                $categoria = $parcela->categoria;
                $descricao = $parcela->descricao;
                $qtd_parcelas = $parcela->qtd_parcelas;
                $qtd_parcelas_pagas = $parcela->qtd_parcelas_pagas;
                $valor_total = number_format($parcela->valor, 2, ',', '.');
                $total_pago = number_format($parcela->total_pago, 2, ',', '.');

                $parcela->data_vencimento = date('d/m/Y', strtotime($parcela->data_vencimento));
                $parcela->data_pagamento = date('d/m/Y', strtotime($parcela->data_pagamento));

                $clientes = DB::select("
                    SELECT
                    pessoa_fisicas.nome
                    FROM pessoa_fisicas, clientes
                    WHERE clientes.id = '".$parcela->cliente."' 
                    AND pessoa_fisicas.id = clientes.id_pessoa_fisica
                ");

                if($clientes){
                    foreach ($clientes as $cliente) {
                        $cliente = $cliente->nome;
                    }
                }else{
                    $clientes = DB::select("
                        SELECT
                        pessoa_juridicas.nome_fantasia
                        FROM pessoa_juridicas, clientes
                        WHERE clientes.id = '".$parcela->cliente."' 
                        AND pessoa_juridicas.id = clientes.id_pessoa_juridica
                    ");

                    foreach ($clientes as $cliente) {
                        $cliente = $cliente->nome_fantasia;
                    }
                }

            }

            $formas_pagamento = DB::select("
                SELECT * FROM forma_pagamento");

            $hoje = date("Y-m-d"); 
            $count = 1;

            return view('contas.contas_receitas_detalhes',compact('id_receita','categoria','descricao','qtd_parcelas','valor_total','cliente','qtd_parcelas_pagas','total_pago','parcelas','formas_pagamento','hoje','count'));
    }

    public function delete_receita(Request $request, $id){

        $receita = DB::table('contas_receber')->where('id', '=', $id)->delete();
        
        return redirect('/contas/receitas');

    }

    public function delete_parcela_receita(Request $request, $id){

        $receita = DB::table('parcelas_receita')->where('id', '=', $id)->get();
        $parcela = DB::table('parcelas_receita')->where('id', '=', $id)->delete();

        foreach ($receita as $i) {
            $id_receita = $i->id_conta_receber;
        }

        return redirect('/contas/receitas/parcelas/'.$id_receita);

    }

}
