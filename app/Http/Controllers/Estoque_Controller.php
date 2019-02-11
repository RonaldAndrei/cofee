<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Marca;
use App\Produto;
use App\Entrada;
use App\Retirada;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Estoque_Controller extends Controller
{
	public function index($atributo){

		if($atributo == "show"){

			$produtos = DB::select("
				SELECT
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
				ORDER BY descricao ASC
				");

			return view('estoque.estoque_show',compact('produtos'));

		}else if($atributo == "historico_entrada"){

			if(isset($_GET['tipo'])){
				$tipo = $_GET["tipo"];
			}else{
				$tipo = 'compra';
			}

			$inicio = '0000-00-00';
			$fim = '9999-99-99';
				
			if($tipo == "compra"){
				$entradas = DB::select("
					SELECT
						entrada.id,
						entrada.id_usuario,
					    entrada.id_fornecedor,
						entrada.data_entrada,
					    entrada.serie_nf,
					    entrada.num_nota_fiscal,
						users.name as responsavel,
						fornecedors.id as id_fornecedor,
					    pessoa_fisicas.nome as fornecedor
						FROM entrada, users, fornecedors, pessoa_fisicas
					    WHERE (entrada.id_fornecedor = fornecedors.id 
							AND fornecedors.id_pessoa_fisica = pessoa_fisicas.id 
							AND entrada.id_usuario = users.id)
						AND entrada.data_entrada >= '".$inicio."'
						AND entrada.data_entrada <= '".$fim."'
					union
					SELECT
						entrada.id,
						entrada.id_usuario,
					    entrada.id_fornecedor,
						entrada.data_entrada,
					    entrada.serie_nf,
					    entrada.num_nota_fiscal,
						users.name as responsavel,
						fornecedors.id as id_fornecedor,
					    pessoa_juridicas.nome_fantasia as fornecedor
						FROM entrada, users, fornecedors, pessoa_juridicas
					    WHERE (entrada.id_fornecedor = fornecedors.id 
							AND fornecedors.id_pessoa_juridica = pessoa_juridicas.id 
							AND entrada.id_usuario = users.id)
						AND entrada.data_entrada >= '".$inicio."'
						AND entrada.data_entrada <= '".$fim."'
					group by entrada.id
					order by data_entrada desc
				");
			}else if($tipo == "retorno"){
				$entradas = DB::select("
					SELECT 
					entrada.id,
					entrada.id_usuario,
					entrada.data_entrada,
				    entrada.motivo,
					users.name as responsavel
					FROM entrada, users
					WHERE entrada.id_fornecedor = '0'
					AND entrada.id_usuario = users.id
					AND entrada.data_entrada >= '".$inicio."'
					AND entrada.data_entrada <= '".$fim."'
				");
			}

			return view('estoque.estoque_historico_entrada',compact('entradas','tipo','inicio','fim'));

		}else if($atributo == "entrada"){

			$fornecedors = DB::select("
				SELECT fornecedors.id, pessoa_fisicas.nome FROM fornecedors
				INNER JOIN pessoa_fisicas ON pessoa_fisicas.id = fornecedors.id_pessoa_fisica
				AND pessoa_fisicas.ativo = '1'
				union
				SELECT fornecedors.id, pessoa_juridicas.nome_fantasia as nome FROM fornecedors
				INNER JOIN pessoa_juridicas ON pessoa_juridicas.id = fornecedors.id_pessoa_juridica
				AND pessoa_juridicas.ativo = '1'
				ORDER BY nome ASC
				");

			return view('estoque.estoque_entrada',compact('fornecedors'));

		}else if($atributo == "retirada"){

			$inicio_sol = '0000-00-00';
			$fim_sol = '9999-99-99';
			$inicio_apr = '0000-00-00';
			$fim_apr = '9999-99-99';

			$solicitacoes = DB::select("
				SELECT
				solicitacao_produto.id,
				solicitacao_produto.id_usuario_solicitante as solicitante,
				solicitacao_produto.id_usuario_aprova as aprovador,
				solicitacao_produto.data_solicitacao,
				solicitacao_produto.data_aprovacao,
				solicitacao_produto.status
				FROM solicitacao_produto
				ORDER BY data_solicitacao DESC
				");

			foreach ($solicitacoes as $solicitacao) {

				$solicitacao->data_solicitacao = date('d/m/Y H:i:s', strtotime($solicitacao->data_solicitacao));
				$solicitacao->data_aprovacao = date('d/m/Y H:i:s', strtotime($solicitacao->data_aprovacao));

				if($solicitacao->status == 'f'){

					$users = DB::select("
						SELECT 
						users_sol.name as solicitante,
						users_apr.name as aprovador
						FROM users as users_sol, users as users_apr
						WHERE users_sol.id = '".$solicitacao->solicitante."' AND users_apr.id = '".$solicitacao->aprovador."'
						");

					if($users){
						foreach ($users as $user) {
							$solicitacao->solicitante = $user->solicitante;
							$solicitacao->aprovador = $user->aprovador;
						}
					}
				}elseif($solicitacao->status == 'p'){

					$users = DB::select("
						SELECT 
						users_sol.name as solicitante
						FROM users as users_sol
						WHERE users_sol.id = '".$solicitacao->solicitante."'
						");

					if($users){
						foreach ($users as $user) {
							$solicitacao->solicitante = $user->solicitante;
						}
					}
				}
			}

			return view('estoque.estoque_retirada',compact('solicitacoes','inicio_sol','fim_sol','inicio_apr','fim_apr'));

		}else if($atributo == "compra"){

			$inicio_sol = '0000-00-00';
			$fim_sol = '9999-99-99';
			$inicio_apr = '0000-00-00';
			$fim_apr = '9999-99-99';

			$solicitacoes = DB::select("
				SELECT
				users.name as solicitante,
				produtos.descricao,
				produtos.saldo,
				produtos.minimo,
				solicitacao_compra.id,
				solicitacao_compra.id_usuario_solicitante,
				solicitacao_compra.id_produto,
				solicitacao_compra.data_solicitacao,
				solicitacao_compra.data_confirmacao,
				solicitacao_compra.confirmado
				FROM solicitacao_compra, users, produtos
				WHERE solicitacao_compra.id_usuario_solicitante = users.id
				AND solicitacao_compra.id_produto = produtos.id
				ORDER BY data_solicitacao DESC
				");
			foreach ($solicitacoes as $solicitacao) {

				$solicitacao->data_solicitacao = date('d/m/Y', strtotime($solicitacao->data_solicitacao));
				
				if($solicitacao->data_confirmacao){
					$solicitacao->data_confirmacao = date('d/m/Y', strtotime($solicitacao->data_confirmacao));
				}
			}

			return view('estoque.estoque_compra',compact('solicitacoes','inicio_sol','fim_sol','inicio_apr','fim_apr'));

		}else if($atributo == "solicita_retirada"){

			$timestamp = Carbon::now()->toDateTimeString();

			$retirada = Retirada::create([
				'id_usuario_solicitante' => Auth::user()->id,
				'data_solicitacao' => $timestamp,
				'status' => 'p'
			]);

			return view('estoque.estoque_solicita_retirada',compact('retirada'));
		}else if($atributo == "relatorio"){

			$filter = $_GET["filter"];

			if($filter == "faltando"){
				$produtos = DB::select("
				SELECT
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
				AND produtos.saldo = '0'
				ORDER BY descricao ASC
				");

				return view('estoque.estoque_relatorio',compact('filter','produtos'));

			}else if($filter == "minimo"){
				$produtos = DB::select("
				SELECT
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
				AND produtos.saldo < produtos.minimo
				ORDER BY descricao ASC
				");

				return view('estoque.estoque_relatorio',compact('filter','produtos'));

			}else if($filter == "entrada"){
				$produtos = DB::select("
				SELECT 
				produtos.id,
				produtos.codigo_barras, 
				produtos.descricao, 
				marcas.nome as nome_marca, 
				departamentos.nome as nome_departamento, 
				produtos.saldo, 
				produtos.unidade_medida, 
				produtos.posicao, 
				produtos.minimo, 
				produtos.observacao, 
				count(id_produto) as qtd 
				FROM entrada_produto, produtos, marcas, departamentos
				WHERE produtos.id = entrada_produto.id_produto
				AND produtos.id_marca = marcas.id 
				AND produtos.id_departamento = departamentos.id
				AND produtos.ativo = '1'
				group by entrada_produto.id_produto
				order by qtd desc
				");

				return view('estoque.estoque_relatorio',compact('filter','produtos'));

			}else if($filter == "saida"){
				$produtos = DB::select("
				SELECT 
				produtos.id,
				produtos.codigo_barras, 
				produtos.descricao, 
				marcas.nome as nome_marca, 
				departamentos.nome as nome_departamento, 
				produtos.saldo, 
				produtos.unidade_medida, 
				produtos.posicao, 
				produtos.minimo, 
				produtos.observacao, 
				count(id_produto) as qtd 
				FROM produto_solicitado, produtos, marcas, departamentos
				WHERE produtos.id = produto_solicitado.id_produto
				AND produtos.id_marca = marcas.id 
				AND produtos.id_departamento = departamentos.id
				AND produtos.ativo = '1'
				group by produto_solicitado.id_produto
				order by qtd desc
				");

				return view('estoque.estoque_relatorio',compact('filter','produtos'));
			}

		}else{
			return;
		}    
	}

	public function filtro(Request $request, $atributo){

		if($atributo == "historico_entrada"){

			$tipo = $request['tipo'];
			$inicio = $request['inicio'];
			$fim = $request['fim'];
				
			if($tipo == "compra"){
				$entradas = DB::select("
					SELECT
						entrada.id,
						entrada.id_usuario,
					    entrada.id_fornecedor,
						entrada.data_entrada,
					    entrada.serie_nf,
					    entrada.num_nota_fiscal,
						users.name as responsavel,
						fornecedors.id as id_fornecedor,
					    pessoa_fisicas.nome as fornecedor
						FROM entrada, users, fornecedors, pessoa_fisicas
					    WHERE (entrada.id_fornecedor = fornecedors.id 
							AND fornecedors.id_pessoa_fisica = pessoa_fisicas.id 
							AND entrada.id_usuario = users.id)
						AND entrada.data_entrada >= '".$inicio."'
						AND entrada.data_entrada <= '".$fim."'
					union
					SELECT
						entrada.id,
						entrada.id_usuario,
					    entrada.id_fornecedor,
						entrada.data_entrada,
					    entrada.serie_nf,
					    entrada.num_nota_fiscal,
						users.name as responsavel,
						fornecedors.id as id_fornecedor,
					    pessoa_juridicas.nome_fantasia as fornecedor
						FROM entrada, users, fornecedors, pessoa_juridicas
					    WHERE (entrada.id_fornecedor = fornecedors.id 
							AND fornecedors.id_pessoa_juridica = pessoa_juridicas.id 
							AND entrada.id_usuario = users.id)
						AND entrada.data_entrada >= '".$inicio."'
						AND entrada.data_entrada <= '".$fim."'
					group by entrada.id
					order by data_entrada desc
				");
			}else if($tipo == "retorno"){
				$entradas = DB::select("
					SELECT 
					entrada.id,
					entrada.id_usuario,
					entrada.data_entrada,
				    entrada.motivo,
					users.name as responsavel
					FROM entrada, users
					WHERE entrada.id_fornecedor = '0'
					AND entrada.id_usuario = users.id
					AND entrada.data_entrada >= '".$inicio."'
					AND entrada.data_entrada <= '".$fim."'
				");
			}

			return view('estoque.estoque_historico_entrada',compact('entradas','tipo','inicio','fim'));
		}else if($atributo == "retirada"){

			if($request['inicio_sol'] == "" || $request['fim_sol'] == ""){
				$inicio_sol = "0000-00-00";
				$fim_sol = "9999-99-99";
				$inicio_apr = $request['inicio_apr'];
				$fim_apr = $request['fim_apr'];

				$solicitacoes = DB::select("
					SELECT
					solicitacao_produto.id,
					solicitacao_produto.id_usuario_solicitante as solicitante,
					solicitacao_produto.id_usuario_aprova as aprovador,
					solicitacao_produto.data_solicitacao,
					solicitacao_produto.data_aprovacao,
					solicitacao_produto.status
					FROM solicitacao_produto
					WHERE solicitacao_produto.data_aprovacao >= '".$inicio_apr."'
					AND solicitacao_produto.data_aprovacao <= '".$fim_apr."'
					group by solicitacao_produto.id
					ORDER BY data_solicitacao DESC
				");

			}else if($request['inicio_apr'] == "" || $request['fim_apr'] == ""){
				$inicio_apr = "0000-00-00";
				$fim_apr = "9999-99-99";
				$inicio_sol = $request['inicio_sol'];
				$fim_sol = $request['fim_sol'];

				$solicitacoes = DB::select("
					SELECT
					solicitacao_produto.id,
					solicitacao_produto.id_usuario_solicitante as solicitante,
					solicitacao_produto.id_usuario_aprova as aprovador,
					solicitacao_produto.data_solicitacao,
					solicitacao_produto.data_aprovacao,
					solicitacao_produto.status
					FROM solicitacao_produto
					WHERE solicitacao_produto.data_solicitacao >= '".$inicio_sol."'
					AND solicitacao_produto.data_solicitacao <= '".$fim_sol."'
					group by solicitacao_produto.id
					ORDER BY data_solicitacao DESC
				");

			}else{
				$inicio_apr = $request['inicio_apr'];;
				$fim_apr = $request['fim_apr'];;
				$inicio_sol = $request['inicio_sol'];
				$fim_sol = $request['fim_sol'];

				$solicitacoes = DB::select("
					SELECT
					solicitacao_produto.id,
					solicitacao_produto.id_usuario_solicitante as solicitante,
					solicitacao_produto.id_usuario_aprova as aprovador,
					solicitacao_produto.data_solicitacao,
					solicitacao_produto.data_aprovacao,
					solicitacao_produto.status
					FROM solicitacao_produto
					WHERE solicitacao_produto.data_solicitacao >= '".$inicio_sol."'
					AND solicitacao_produto.data_solicitacao <= '".$fim_sol."'
					AND solicitacao_produto.data_aprovacao >= '".$inicio_apr."'
					AND solicitacao_produto.data_aprovacao <= '".$fim_apr."'
					group by solicitacao_produto.id
					ORDER BY data_solicitacao DESC
				");
			}


			foreach ($solicitacoes as $solicitacao) {

				$solicitacao->data_solicitacao = date('d/m/Y H:i:s', strtotime($solicitacao->data_solicitacao));
				$solicitacao->data_aprovacao = date('d/m/Y H:i:s', strtotime($solicitacao->data_aprovacao));

				if($solicitacao->status == 'f'){

					$users = DB::select("
						SELECT 
						users_sol.name as solicitante,
						users_apr.name as aprovador
						FROM users as users_sol, users as users_apr
						WHERE users_sol.id = '".$solicitacao->solicitante."' AND users_apr.id = '".$solicitacao->aprovador."'
						");

					if($users){
						foreach ($users as $user) {
							$solicitacao->solicitante = $user->solicitante;
							$solicitacao->aprovador = $user->aprovador;
						}
					}
				}elseif($solicitacao->status == 'p'){

					$users = DB::select("
						SELECT 
						users_sol.name as solicitante
						FROM users as users_sol
						WHERE users_sol.id = '".$solicitacao->solicitante."'
						");

					if($users){
						foreach ($users as $user) {
							$solicitacao->solicitante = $user->solicitante;
						}
					}
				}
			}

			return view('estoque.estoque_retirada',compact('solicitacoes','inicio_sol','fim_sol','inicio_apr','fim_apr'));
		}else if($atributo == "compra"){

			if($request['inicio_sol'] == "" || $request['fim_sol'] == ""){
				$inicio_sol = "0000-00-00";
				$fim_sol = "9999-99-99";
				$inicio_apr = $request['inicio_apr'];
				$fim_apr = $request['fim_apr'];

				$solicitacoes = DB::select("
					SELECT
					users.name as solicitante,
					produtos.descricao,
					produtos.saldo,
					produtos.minimo,
					solicitacao_compra.id,
					solicitacao_compra.id_usuario_solicitante,
					solicitacao_compra.id_produto,
					solicitacao_compra.data_solicitacao,
					solicitacao_compra.data_confirmacao,
					solicitacao_compra.confirmado
					FROM solicitacao_compra, users, produtos
					WHERE solicitacao_compra.id_usuario_solicitante = users.id
					AND solicitacao_compra.id_produto = produtos.id
					AND solicitacao_compra.data_confirmacao >= '".$inicio_apr."'
					AND solicitacao_compra.data_confirmacao <= '".$fim_apr."'
					group by solicitacao_compra.id
					ORDER BY data_solicitacao DESC
				");

			}else if($request['inicio_apr'] == "" || $request['fim_apr'] == ""){
				$inicio_apr = "0000-00-00";
				$fim_apr = "9999-99-99";
				$inicio_sol = $request['inicio_sol'];
				$fim_sol = $request['fim_sol'];

				$solicitacoes = DB::select("
					SELECT
					users.name as solicitante,
					produtos.descricao,
					produtos.saldo,
					produtos.minimo,
					solicitacao_compra.id,
					solicitacao_compra.id_usuario_solicitante,
					solicitacao_compra.id_produto,
					solicitacao_compra.data_solicitacao,
					solicitacao_compra.data_confirmacao,
					solicitacao_compra.confirmado
					FROM solicitacao_compra, users, produtos
					WHERE solicitacao_compra.id_usuario_solicitante = users.id
					AND solicitacao_compra.id_produto = produtos.id
					AND solicitacao_compra.data_solicitacao >= '".$inicio_sol."'
					AND solicitacao_compra.data_solicitacao <= '".$fim_sol."'
					group by solicitacao_compra.id
					ORDER BY data_solicitacao DESC
				");
			}else{
				$inicio_apr = $request['inicio_apr'];;
				$fim_apr = $request['fim_apr'];;
				$inicio_sol = $request['inicio_sol'];
				$fim_sol = $request['fim_sol'];

				$solicitacoes = DB::select("
					SELECT
					users.name as solicitante,
					produtos.descricao,
					produtos.saldo,
					produtos.minimo,
					solicitacao_compra.id,
					solicitacao_compra.id_usuario_solicitante,
					solicitacao_compra.id_produto,
					solicitacao_compra.data_solicitacao,
					solicitacao_compra.data_confirmacao,
					solicitacao_compra.confirmado
					FROM solicitacao_compra, users, produtos
					WHERE solicitacao_compra.id_usuario_solicitante = users.id
					AND solicitacao_compra.id_produto = produtos.id
					AND solicitacao_compra.data_solicitacao >= '".$inicio_sol."'
					AND solicitacao_compra.data_solicitacao <= '".$fim_sol."'
					AND solicitacao_compra.data_confirmacao >= '".$inicio_apr."'
					AND solicitacao_compra.data_confirmacao <= '".$fim_apr."'
					group by solicitacao_compra.id
					ORDER BY data_solicitacao DESC
				");
			}
			
			foreach ($solicitacoes as $solicitacao) {

				$solicitacao->data_solicitacao = date('d/m/Y', strtotime($solicitacao->data_solicitacao));
				
				if($solicitacao->data_confirmacao){
					$solicitacao->data_confirmacao = date('d/m/Y', strtotime($solicitacao->data_confirmacao));
				}
			}

			return view('estoque.estoque_compra',compact('solicitacoes','inicio_sol','fim_sol','inicio_apr','fim_apr'));

		}
	}

    //entrada
	public function create_entrada(Request $data){

		$entrada = Entrada::create([
			'id_usuario' => Auth::user()->id,
			'id_fornecedor' => $data['fornecedor'],
			'data_entrada' => $data['data_entrada'],
			'serie_nf' => $data['serie_nf'],
			'num_nota_fiscal' => $data['num_nota_fiscal'],
			'motivo' => $data['motivo']
		]);

		if($entrada->id_fornecedor){
			$array = DB::select("
				SELECT
				pessoa_juridicas.nome_fantasia as nome
				FROM pessoa_juridicas, fornecedors
				WHERE pessoa_juridicas.id = fornecedors.id_pessoa_juridica 
				AND fornecedors.id = '".$entrada->id_fornecedor."'
				");

			if($array){
				foreach ($array as $fornecedor) {
					$nome = $fornecedor->nome;
				}
				return view('estoque.estoque_entrada_produto',compact('entrada','nome'));
			}else{

				$array = DB::select("
					SELECT
					pessoa_fisicas.nome
					FROM pessoa_fisicas, fornecedors
					WHERE pessoa_fisicas.id = fornecedors.id_pessoa_fisica 
					AND fornecedors.id = '".$entrada->id_fornecedor."'
					");

				if($array){
					foreach ($array as $fornecedor) {
						$nome = $fornecedor->nome;
					}
					return view('estoque.estoque_entrada_produto',compact('entrada','nome'));
				}
			}
		}else{
			return view('estoque.estoque_entrada_produto_retorno',compact('entrada'));
		} 

	}

	public function detalhes_entrada($id){

		$entrada_id = DB::select("
			SELECT * FROM entrada WHERE entrada.id = '".$id."'
		");

		foreach ($entrada_id as $entrada) {
			$id_entrada = $entrada->id;
			$data_entrada = date('d/m/Y', strtotime($entrada->data_entrada));
			$responsavel = $entrada->id_usuario;
			
			$id_fornecedor = $entrada->id_fornecedor;
			$serie_nf = $entrada->serie_nf;
			$num_nota_fiscal = $entrada->num_nota_fiscal;

			$motivo = $entrada->motivo;
		}

		$users = DB::select("
			SELECT 
			users.name as responsavel
			FROM users
			WHERE users.id = '".$responsavel."'
		");

		if($users){
			foreach ($users as $user) {
				$responsavel = strtoupper($user->responsavel);
			}
		}else{
			$responsavel = "Excluído";
		}


		$entradas = DB::select("
			SELECT
			entrada_produto.id,
			entrada_produto.id_entrada,
			entrada_produto.id_produto,
			entrada_produto.quantidade,
			produtos.codigo_barras,
			produtos.descricao,
			produtos.saldo,
			produtos.unidade_medida
			FROM entrada, entrada_produto, produtos
			WHERE entrada.id = entrada_produto.id_entrada
			AND entrada_produto.id_entrada = '".$id_entrada."'
			AND produtos.id = entrada_produto.id_produto
			");        

		if($id_fornecedor){
			$array = DB::select("
				SELECT
				pessoa_juridicas.nome_fantasia as nome
				FROM pessoa_juridicas, fornecedors
				WHERE pessoa_juridicas.id = fornecedors.id_pessoa_juridica 
				AND fornecedors.id = '".$id_fornecedor."'
				");

			if($array){
				foreach ($array as $fornecedor) {
					$fornecedor = $fornecedor->nome;
				}
			}else{
				$array = DB::select("
					SELECT
					pessoa_fisicas.nome
					FROM pessoa_fisicas, fornecedors
					WHERE pessoa_fisicas.id = fornecedors.id_pessoa_fisica 
					AND fornecedors.id = '".$id_fornecedor."'
					");
				if($array){
					foreach ($array as $fornecedor) {
						$fornecedor = $fornecedor->nome;
					}
				}else{
					$fornecedor = "Excluído";
				}
			}
		}

		return view('estoque.estoque_entrada_detalhes', compact('id_entrada','data_entrada','responsavel','serie_nf','num_nota_fiscal','fornecedor','motivo','entradas'));
	}

	//retirada
	public function detalhes_retirada($id){

		$solicitacao_id = DB::select("
			SELECT * FROM solicitacao_produto WHERE solicitacao_produto.id = '".$id."'
			");

		foreach ($solicitacao_id as $solicitacao) {

			$id_solicitacao = $id;
			$id_solicitante = $solicitacao->id_usuario_solicitante;
			$data_solicitacao = date('d/m/Y H:i:s', strtotime($solicitacao->data_solicitacao));
			$status = $solicitacao->status;

			if($status == 'f'){
				$id_aprovador = $solicitacao->id_usuario_aprova;
				$data_aprovacao = date('d/m/Y H:i:s', strtotime($solicitacao->data_aprovacao));
			}else{
				$aprovador = '';
				$data_aprovacao = '';
			}
		}

		if($status == 'f'){

			$users = DB::select("
				SELECT 
				users_sol.name as solicitante,
				users_apr.name as aprovador
				FROM users as users_sol, users as users_apr
				WHERE users_sol.id = '".$id_solicitante."' AND users_apr.id = '".$id_aprovador."'
				");

			if($users){
				foreach ($users as $user) {
					if($user->solicitante && $user->aprovador){
						$solicitante = $user->solicitante;
						$aprovador = $user->aprovador;
					}else if($user->solicitante){
						$solicitante = $user->solicitante;
						$aprovador = "Excluído";
					}else if($user->aprovador){
						$solicitante = "Excluído";
						$aprovador = $user->aprovador;
					}
				}
			}else{
				$solicitante = "Excluído";
				$aprovador = "Excluído";
			}

		}elseif($status == 'p'){

			$users = DB::select("
				SELECT 
				users_sol.name as solicitante
				FROM users as users_sol
				WHERE users_sol.id = '".$id_solicitante."'
				");

			if($users){
				foreach ($users as $user) {
					$solicitante = $user->solicitante;
				}
			}
		}

		$retiradas = DB::select("
			SELECT
			produto_solicitado.id,
			solicitacao_produto.id as id_solicitacao,
			produtos.codigo_barras,
			produtos.descricao,
			produtos.saldo,
			produtos.unidade_medida,
			solicitacao_produto.id_usuario_solicitante,
			solicitacao_produto.id_usuario_aprova,
			solicitacao_produto.data_solicitacao,
			solicitacao_produto.data_aprovacao,
			produto_solicitado.qtd_solicitada,
			produto_solicitado.qtd_atendida,
			produto_solicitado.aprovado,
			solicitacao_produto.status
			FROM produto_solicitado, solicitacao_produto, produtos
			WHERE solicitacao_produto.id = produto_solicitado.id_solicitacao_produto
			AND solicitacao_produto.id = '".$id."'
			AND produtos.id = produto_solicitado.id_produto
			");        

		return view('estoque.estoque_retirada_detalhes',compact('retiradas','status','id_solicitacao','solicitante','aprovador','data_solicitacao','data_aprovacao'));
	}

}
