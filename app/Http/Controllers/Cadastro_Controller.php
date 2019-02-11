<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Departamento;
use App\Marca;
use App\Produto;
use App\Pessoa_fisica;
use App\Pessoa_juridica;
use App\Fornecedor;
use App\Cliente;
use App\Unidade_medida;
use DB;
use Illuminate\Database\QueryException;

class Cadastro_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //cadastro index
    public function index($atributo){

        if($atributo == "produto"){

            $produtos = DB::select("
                select
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
            ");


            return view('cadastro.cadastro_produto',compact('produtos'));

        }else if($atributo == "marca"){

            $marcas = DB::table('marcas')->orderByRaw('nome ASC')->get();

            return view('cadastro.cadastro_marca', compact('marcas'));

        }else if($atributo == "departamento"){

            $departamentos = DB::table('departamentos')->orderByRaw('nome ASC')->get();

            return view('cadastro.cadastro_departamento', compact('departamentos'));

        }else if($atributo == "fisica"){
            $tipo = "fisica";

            $pessoas = DB::table('pessoa_fisicas')->where('ativo', '1')->orderByRaw('nome ASC')->get();

            return view('cadastro.cadastro_pessoa_fisica', compact('pessoas'));

        }else if($atributo == "juridica"){
            $tipo = "juridica";

            $pessoas = DB::table('pessoa_juridicas')->where('ativo', '1')->get();

            return view('cadastro.cadastro_pessoa_juridica', compact('pessoas'));

        }else if($atributo == "cliente-fisica"){

            $tipo = "fisica";

            $clientesF = DB::table('pessoa_fisicas')->join(
                'clientes', 'pessoa_fisicas.id', '=', 'clientes.id_pessoa_fisica')->select(
                    'pessoa_fisicas.id',
                    'clientes.id',
                    'clientes.id_pessoa_fisica',
                    'pessoa_fisicas.nome as nome', 
                    'pessoa_fisicas.cpf as cpf',
                    'pessoa_fisicas.telefone as telefone',
                    'pessoa_fisicas.email as email')->where('ativo', '1')->orderByRaw('nome ASC')->get();

                return view('cadastro.cadastro_cliente', compact('clientesF', 'tipo'));

            } else if($atributo == "cliente-juridica"){

                $tipo = "juridica";

                $clientesJ = DB::table('pessoa_juridicas')->join(
                    'clientes', 'pessoa_juridicas.id', '=', 'clientes.id_pessoa_juridica')->select(
                        'pessoa_juridicas.id',
                        'clientes.id',
                        'clientes.id_pessoa_juridica',
                        'pessoa_juridicas.nome_fantasia as nome_fantasia',
                        'pessoa_juridicas.razao_social as razao_social',
                        'pessoa_juridicas.cnpj as cnpj',
                        'pessoa_juridicas.telefone as telefone',
                        'pessoa_juridicas.email as email')->where('ativo', '1')->orderByRaw('nome_fantasia ASC')->get();

                    return view('cadastro.cadastro_cliente', compact('clientesJ', 'tipo'));

                }else if($atributo == "fornecedor-fisica"){

                    $tipo = "fisica";

                    $fornecedorsF = DB::table('pessoa_fisicas')->join(
                        'fornecedors', 'pessoa_fisicas.id', '=', 'fornecedors.id_pessoa_fisica')->select(
                            'pessoa_fisicas.id',
                            'fornecedors.id',
                            'fornecedors.id_pessoa_fisica',
                            'pessoa_fisicas.nome as nome', 
                            'pessoa_fisicas.cpf as cpf',
                            'pessoa_fisicas.telefone as telefone',
                            'pessoa_fisicas.email as email')->where('ativo', '1')->orderByRaw('nome ASC')->paginate(7);

                        return view('cadastro.cadastro_fornecedor', compact('fornecedorsF', 'tipo'));

                    }else if($atributo == "fornecedor-juridica"){

                        $tipo = "juridica";

                        $fornecedorsJ = DB::table('pessoa_juridicas')->join(
                            'fornecedors', 'pessoa_juridicas.id', '=', 'fornecedors.id_pessoa_juridica')->select(
                                'pessoa_juridicas.id',
                                'fornecedors.id',
                                'fornecedors.id_pessoa_juridica',
                                'pessoa_juridicas.nome_fantasia as nome_fantasia',
                                'pessoa_juridicas.razao_social as razao_social',
                                'pessoa_juridicas.cnpj as cnpj',
                                'pessoa_juridicas.telefone as telefone',
                                'pessoa_juridicas.email as email')->where('ativo', '1')->orderByRaw('nome_fantasia ASC')->paginate(7);

                            return view('cadastro.cadastro_fornecedor', compact('fornecedorsJ', 'tipo'));

                        }else if($atributo == "usuario"){

                            $usuarios = DB::table('users')->where([['id', '!=', '0'],['ativo', '=', '1']])->orderByRaw('name ASC')->get();

                            return view('cadastro.cadastro_usuario',compact('usuarios'));
                        }else{
                            return;
                        }    
                    }

    //cadastro usuario
                    public function novo_usuario($atributo){
                        if($atributo == "convidar"){
                            return view('cadastro.cadastro_usuario_convite');
                        }elseif ($atributo == "cadastrar") {
                            return view('cadastro.cadastro_usuario_novo');
                        }else{
                            return;
                        }
                    }

    public function enviar_convite(Request $request){//testar no servidor em localhost não funciona

        $nome = $request->nome;
        $convidado = $request->convidado;
        $email = $request->email_usuario;
        $subject = "Cadastre-se no Cofee";
        $obs = $request->obs_convite;
        $link = "127.0.0.1:8000/register";

        $message = "Olá ".$convidado.",\nVocê recebeu um convite de ".$nome." para cadastrar-se no sistema Cofee.\nClique no link para que seja redirecionado até a página de cadastro.\n".$link."\n".$obs."\nAtenciosamente Equipe Cofee";

        mail( $email, $subject, $message);

        return view('cadastro.cadastro_usuario');
    }
    
    public function create_usuario(Request $data){

        User::create([
            'name' => $data['name'],
            'email' => mb_strtolower($data['email']),
            'password' => bcrypt($data['password']),
            'nivel' => 1,
            'ativo' => 1
        ]);

        return redirect('cadastro/usuario');
    }

    public function update_usuario(Request $request, $id){

        $usuario = \App\User::find($id);

        return view('cadastro/cadastro_usuario_update',compact('usuario')); 
    }  

    public function save_usuario(Request $request, $id){

        $usuario = \App\User::find($id);

        $usuario->name = $request->input('name');
        $usuario->email = mb_strtolower($request->input('email'));

        $usuario->save();

        return redirect('cadastro/usuario');
    }


    public function delete_usuario(Request $request, $id){

        $usuario = \App\User::find($id);

        $usuario->ativo = '0';

        $usuario->save();

        return redirect('cadastro/usuario');      

    }

    //cadastro produto
    public function novo_produto($atributo){
        if ($atributo == "cadastrar") {

            $departamentos = \App\Departamento::All();
            $departamentos = $departamentos->sortBy('nome');
            $marcas = \App\Marca::All();
            $marcas = $marcas->sortBy('nome');
            $unidade_medidas = \App\Unidade_medida::All();
            $unidade_medidas = $unidade_medidas->sortBy('nome');

            return view('cadastro.cadastro_produto_novo', compact('departamentos','marcas','unidade_medidas'));
        }else{
            return;
        }
    }   

    public function create_produto(Request $data){

        Produto::create([
            'id_marca'=> $data['marca'],
            'id_departamento'=> $data['departamento'],
            'descricao'=> mb_strtoupper($data['descricao']),
            'codigo_barras'=> $data['codigo_barras'],
            'saldo'=> $data['saldo'],
            'unidade_medida'=> $data['unidade_medida'],
            'posicao'=> $data['posicao'],
            'corredor'=> $data['corredor'],
            'prateleira'=> $data['prateleira'],
            'minimo'=> $data['minimo'],
            'observacao'=> $data['observacao'],
            'saldo'=> 0,
            'ativo'=> 1
        ]);

        return redirect('cadastro/produto');

    }

    public function update_produto(Request $request, $id){

        $produto = \App\Produto::find($id);
        $departamento_up = \App\Departamento::find($produto->id_departamento);
        $marca_up = \App\Marca::find($produto->id_marca);

        $departamentos = \App\Departamento::All();
        $departamentos = $departamentos->sortBy('nome');
        $marcas = \App\Marca::All();
        $marcas = $marcas->sortBy('nome');
        $unidade_medidas = \App\Unidade_medida::All();
        $unidade_medidas = $unidade_medidas->sortBy('nome');

        return view('cadastro/cadastro_produto_update',compact('produto','marcas','departamentos','unidade_medidas', 'departamento_up','marca_up')); 
    }  

    public function save_produto(Request $request, $id){

        $produto = \App\Produto::find($id);

        $produto->id_marca = $request->input('marca');
        $produto->id_departamento = $request->input('departamento');
        $produto->descricao = mb_strtoupper($request->input('descricao'));
        $produto->codigo_barras = $request->input('codigo_barras');
        $produto->unidade_medida = $request->input('unidade_medida');
        $produto->posicao = $request->input('posicao');
        $produto->minimo = $request->input('minimo');
        $produto->observacao = $request->input('observacao');

        $produto->save();

        return redirect('cadastro/produto');
    }


    public function delete_produto(Request $request, $id){

        $produto = \App\Produto::find($id);

        if($produto->saldo > 0){
            $titulo = "Excluir produto";
            $mensagem = "Um produto com saldo em estoque não pode ser excluído!";
            return view('cadastro/cadastro_erro',compact('titulo','mensagem'));
        }else{
            $produto->ativo = '0';
            $produto->save();   

            return redirect('cadastro/produto');
        }

    }

    public function novo_departamento($atributo){
        if ($atributo == "cadastrar") {
            return view('cadastro.cadastro_departamento_novo');
        }else{
            return;
        }
    }

    public function create_departamento(Request $data){

        Departamento::create([
            'nome' => mb_strtoupper($data['nome']),
        ]);

        return redirect('cadastro/departamento');
    }

    public function update_departamento(Request $request, $id){
        $departamento = \App\Departamento::find($id);

        return view('cadastro/cadastro_departamento_update',compact('departamento')); 
    }

    public function departamento_save(Request $request, $id){
        $departamento = \App\Departamento::find($id);

        $departamento->nome = mb_strtoupper($request->input('nome'));
        $departamento->save();

        return redirect('cadastro/departamento');
    }

    public function delete_departamento(Request $request, $id){

        try {
            $departamento = \App\Departamento::find($id);
            $departamento = $departamento->delete();

            return redirect('cadastro/departamento');

        } catch (QueryException $e) {
            $titulo = "Excluir departamento";
            $mensagem = "Este departamento não pode ser excluído!";
            return view('cadastro/cadastro_erro',compact('titulo','mensagem')); 
        }   
    }

    //busca produto
    // public function busca_produto(Request $request){

    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'produto';

    //     if($busca != ''){
    //         $produtos = DB::select("
    //             SELECT
    //             produtos.id,
    //             produtos.codigo_barras, 
    //             produtos.descricao, 
    //             marcas.nome as nome_marca, 
    //             departamentos.nome as nome_departamento, 
    //             produtos.saldo, 
    //             produtos.unidade_medida, 
    //             produtos.posicao, 
    //             produtos.minimo, 
    //             produtos.observacao 
    //             FROM produtos, marcas, departamentos
    //             WHERE produtos.id_marca = marcas.id 
    //             AND produtos.id_departamento = departamentos.id
    //             AND produtos.ativo = '1'
    //             AND (
    //             produtos.descricao LIKE '%".$busca."%' OR
    //             produtos.codigo_barras LIKE '%".$busca."%' OR
    //             marcas.nome LIKE '%".$busca."%' OR
    //             departamentos.nome LIKE '%".$busca."%'
    //         )
    //         ORDER BY descricao ASC
    //         ");

    //         if (count($produtos) != 0) {

    //             return view('cadastro.cadastro_produto_busca',compact('produtos','busca'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca','tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/produto');
    //     }
    // }


    //MARCA
    public function novo_marca($atributo){
        if ($atributo == "cadastrar") {
            return view('cadastro.cadastro_marca_novo');
        }else{
            return;
        }
    } 

    public function create_marca(Request $data){

        Marca::create([
            'nome' => mb_strtoupper($data['nome']),
        ]);

        return redirect('cadastro/marca');
    }

    public function update_marca(Request $request, $id){
        $marca = \App\Marca::find($id);

        return view('cadastro/cadastro_marca_update',compact('marca')); 
    }

    public function marca_save(Request $request, $id){
        $marca = \App\Marca::find($id);

        $marca->nome = mb_strtoupper($request->input('nome'));
        $marca->save();

        return redirect('cadastro/marca');
    }

    public function delete_marca(Request $request, $id){

        try{
            $marca = \App\Marca::find($id);
            $marca = $marca->delete();

            return redirect('cadastro/marca');

        } catch (QueryException $e) {
            $titulo = "Excluir marca";
            $mensagem = "Esta marca não pode ser excluída!";
            return view('cadastro/cadastro_erro',compact('titulo','mensagem')); 
        }     

    }

    //PESSOA
    public function pessoa_tipo(){

        return view('cadastro.cadastro_pessoa_tipo');
    }

    public function pessoa_tipo_novo(Request $request){
        $pessoa = $request->pessoa;

        if($pessoa == "fisica"){
            $cpf = $request->cpf;
            return view('cadastro.cadastro_pessoa_fisica_novo', compact('cpf'));
        }else if($pessoa == "juridica"){
            $cnpj = $request->cnpj;
            return view('cadastro.cadastro_pessoa_juridica_novo', compact('cnpj'));
        }else{
            return;
        }
        
    }

    public function create_pessoa(Request $data, $tipo){

        if($tipo == "fisica"){

            if ($data['cliente'] && $data['fornecedor']) {
                $relacao = "cf";
            }else if ($data['cliente']) {
                $relacao = "c";
            }else if ($data['fornecedor']) {
                $relacao = "f";
            }else{
                $relacao = '';
            }

            $date = str_replace('/', '-', $data['data_nascim']);
            $data_nascim = date('Y-m-d', strtotime($date));

            $data['nome'] = mb_strtoupper($data['nome']);
            $data['email'] = mb_strtolower($data['email']);
            $data['orgao_expedidor'] = mb_strtoupper($data['orgao_expedidor']);
            $data['cpf'] = preg_replace("/\D+/", "", $data['cpf']);
            $data['rg'] = preg_replace("/\D+/", "", $data['rg']);
            $data['telefone'] = preg_replace("/\D+/", "", $data['telefone']);
            $data['telefone_sec'] = preg_replace("/\D+/", "", $data['telefone_sec']);
            $data['cep'] = preg_replace("/\D+/", "", $data['cep']);

            $registro = Pessoa_fisica::Create([

                'nome' => $data['nome'],
                'cpf' => $data['cpf'],
                'rg' => $data['rg'],
                'orgao_expedidor' => $data['orgao_expedidor'],
                'sexo' => $data['sexo'],
                'data_nascim' => $data_nascim,
                'telefone' => $data['telefone'],
                'telefone_sec' => $data['telefone_sec'],
                'email' => $data['email'],
                'cep' => $data['cep'],
                'logradouro' => $data['logradouro'],
                'complemento' => $data['complemento'],
                'numero' => $data['numero'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'uf' => $data['uf'],
                'tipo' => $relacao,
                'ativo' => 1
            ]);

            if ($registro->tipo == "cf") {
                Fornecedor::Create(['id_pessoa_fisica'=>$registro->id]);
                Cliente::Create(['id_pessoa_fisica'=>$registro->id]);
            }else if ($registro->tipo == "c") {
                Cliente::Create(['id_pessoa_fisica'=>$registro->id]);
            }else if ($registro->tipo == "f") {
                Fornecedor::Create(['id_pessoa_fisica'=>$registro->id]);
            }else{
                return;
            }

            return redirect('cadastro/fisica');

        }else if($tipo == "juridica"){

            if ($data['cliente'] && $data['fornecedor']) {
                $relacao = "cf";
            }else if ($data['cliente']) {
                $relacao = "c";
            }else if ($data['fornecedor']) {
                $relacao = "f";
            }else{
                $relacao = '';
            }

            $data['nome_fantasia'] = mb_strtoupper($data['nome_fantasia']);
            $data['email'] = mb_strtolower($data['email']);

            $data['cnpj'] = preg_replace("/\D+/", "", $data['cnpj']);
            $data['inscricao_estadual'] = preg_replace("/\D+/", "", $data['inscricao_estadual']);
            $data['telefone'] = preg_replace("/\D+/", "", $data['telefone']);
            $data['telefone_sec'] = preg_replace("/\D+/", "", $data['telefone_sec']);
            $data['cep'] = preg_replace("/\D+/", "", $data['cep']);

            $registro = Pessoa_juridica::create([
                'cnpj' => $data['cnpj'],
                'nome_fantasia' => $data['nome_fantasia'],
                'razao_social' => $data['razao_social'],
                'inscricao_estadual' => $data['inscricao_estadual'],
                'telefone' => $data['telefone'],
                'telefone_sec' => $data['telefone_sec'],
                'email' => $data['email'],
                'cep' => $data['cep'],
                'logradouro' => $data['logradouro'],
                'numero' => $data['numero'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'uf' => $data['uf'],
                'tipo' => $relacao,
                'ativo' => 1
            ]);

            if ($registro->tipo == "cf") {
                Fornecedor::Create(['id_pessoa_juridica'=>$registro->id]);
                Cliente::Create(['id_pessoa_juridica'=>$registro->id]);
            }else if ($registro->tipo == "c") {
                Cliente::Create(['id_pessoa_juridica'=>$registro->id]);
            }else if ($registro->tipo == "f") {
                Fornecedor::Create(['id_pessoa_juridica'=>$registro->id]);
            }else{
                return;
            }

            return redirect('cadastro/juridica');
        }else{
            return;
        }
    }

    public function Mask($mask,$str){

        $str = str_replace(" ","",$str);

        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }

        return $mask;

    }

    public function update_pessoa_fisica(Request $request, $id){
        $pessoa_fisica = \App\Pessoa_fisica::find($id);

        if(strlen($pessoa_fisica->cpf) == 11){
            $pessoa_fisica->cpf = $this->Mask("###.###.###-##",$pessoa_fisica->cpf);
        }

        if(strlen($pessoa_fisica->rg) == 9){
            $pessoa_fisica->rg = $this->Mask("##.###.###-#",$pessoa_fisica->rg);
        }

        if(strlen($pessoa_fisica->orgao_expedidor) == 5){
            $pessoa_fisica->orgao_expedidor = $this->Mask("###/##",$pessoa_fisica->orgao_expedidor);
        }

        // if(strlen($pessoa_fisica->telefone) == 10){
        //     $pessoa_fisica->telefone = $this->Mask("##-####-####",$pessoa_fisica->telefone);
        // } else if(strlen($pessoa_fisica->telefone) == 11){
        //     $pessoa_fisica->telefone = $this->Mask("##-#####-####",$pessoa_fisica->telefone);
        // }

        // if(strlen($pessoa_fisica->telefone_sec) == 10){
        //     $pessoa_fisica->telefone_sec = $this->Mask("##-####-####",$pessoa_fisica->telefone_sec);
        // } else if(strlen($pessoa_fisica->telefone_sec) == 11){
        //     $pessoa_fisica->telefone_sec = $this->Mask("##-#####-####",$pessoa_fisica->telefone_sec);
        // }

        if(strlen($pessoa_fisica->cep) == 8){
            $pessoa_fisica->cep = $this->Mask("#####-###",$pessoa_fisica->cep);
        }
        
        // $date = str_replace('-', '/', $pessoa_fisica->data_nascim);
        // $pessoa_fisica->data_nascim = date('d/m/Y', strtotime($date));

        return view('cadastro/cadastro_pessoa_fisica_update',compact('pessoa_fisica')); 
    }

    public function update_pessoa_juridica(Request $request, $id){
        $pessoa_juridica = \App\Pessoa_juridica::find($id);

        if(strlen($pessoa_juridica->telefone) == 10){
            $pessoa_juridica->telefone = $this->Mask("##-####-####",$pessoa_juridica->telefone);
        } else if(strlen($pessoa_juridica->telefone) == 11){
            $pessoa_juridica->telefone = $this->Mask("##-#####-####",$pessoa_juridica->telefone);
        }

        if(strlen($pessoa_juridica->telefone_sec) == 10){
            $pessoa_juridica->telefone_sec = $this->Mask("##-####-####",$pessoa_juridica->telefone_sec);
        } else if(strlen($pessoa_juridica->telefone_sec) == 11){
            $pessoa_juridica->telefone_sec = $this->Mask("##-#####-####",$pessoa_juridica->telefone_sec);
        }

        if(strlen($pessoa_juridica->cnpj) == 14){
            $pessoa_juridica->cnpj = $this->Mask("##.###.###/####-##",$pessoa_juridica->cnpj);
        }

        if(strlen($pessoa_juridica->cep) == 8){
            $pessoa_juridica->cep = $this->Mask("#####-###",$pessoa_juridica->cep);
        }

        return view('cadastro/cadastro_pessoa_juridica_update',compact('pessoa_juridica')); 
    }

    public function pessoa_fisica_save(Request $request, $id){

        $pessoa_fisica = \App\Pessoa_fisica::find($id);

        if ($request['cliente'] && $request['fornecedor']) {
            $relacao = "cf";
        }else if ($request['cliente']) {
            $relacao = "c";
        }else if ($request['fornecedor']) {
            $relacao = "f";
        }else{
            $relacao = '';
        }

        $date = str_replace('/', '-', $request['data_nascim']);
        $data_nascim = date('Y-m-d', strtotime($date));

        $request['cep'] = preg_replace("/\D+/", "", $request['cep']);
        $request['cpf'] = preg_replace("/\D+/", "", $request['cpf']);
        $request['rg'] = preg_replace("/\D+/", "", $request['rg']);
        $request['orgao_expedidor'] = mb_strtoupper($request['orgao_expedidor']);
        $request['telefone'] = preg_replace("/\D+/", "", $request['telefone']);
        $request['telefone_sec'] = preg_replace("/\D+/", "", $request['telefone_sec']);

        $request['nome'] = mb_strtoupper($request['nome']);
        $request['email'] = mb_strtolower($request['email']);

        //echo $pessoa_fisica->nome;

        $pessoa_fisica->nome = $request->input('nome');
        $pessoa_fisica->rg = $request->input('rg');
        $pessoa_fisica->orgao_expedidor = $request->input('orgao_expedidor');
        $pessoa_fisica->sexo = $request->input('sexo');
        $pessoa_fisica->data_nascim = $data_nascim;
        $pessoa_fisica->telefone = $request->input('telefone');
        $pessoa_fisica->telefone_sec = $request->input('telefone_sec');
        $pessoa_fisica->email = $request->input('email');
        $pessoa_fisica->cep = $request->input('cep');
        $pessoa_fisica->uf = $request->input('uf');
        $pessoa_fisica->cidade = $request->input('cidade');
        $pessoa_fisica->bairro = $request->input('bairro');
        $pessoa_fisica->logradouro = $request->input('logradouro');
        $pessoa_fisica->complemento = $request->input('complemento');
        $pessoa_fisica->numero = $request->input('numero');
        $pessoa_fisica->tipo = $relacao;
        $pessoa_fisica->save();

        return redirect('cadastro/fisica');
    }

    public function pessoa_juridica_save(Request $request, $id){

        $pessoa_juridica = \App\Pessoa_juridica::find($id);

        if ($request['cliente'] && $request['fornecedor']) {
            $relacao = "cf";
        }else if ($request['cliente']) {
            $relacao = "c";
        }else if ($request['fornecedor']) {
            $relacao = "f";
        }else{
            $relacao = '';
        }

        $request['cep'] = preg_replace("/\D+/", "", $request['cep']);
        $request['cnpj'] = preg_replace("/\D+/", "", $request['cnpj']);
        $request['telefone'] = preg_replace("/\D+/", "", $request['telefone']);
        $request['telefone_sec'] = preg_replace("/\D+/", "", $request['telefone_sec']);

        $request['nome_fantasia'] = mb_strtoupper($request['nome_fantasia']);
        $request['email'] = mb_strtolower($request['email']);

        $pessoa_juridica->nome_fantasia = $request->input('nome_fantasia');
        $pessoa_juridica->razao_social = $request->input('razao_social');
        $pessoa_juridica->inscricao_estadual = $request->input('inscricao_estadual');
        $pessoa_juridica->telefone = $request->input('telefone');
        $pessoa_juridica->telefone_sec = $request->input('telefone_sec');
        $pessoa_juridica->email = $request->input('email');
        $pessoa_juridica->cep = $request->input('cep');
        $pessoa_juridica->uf = $request->input('uf');
        $pessoa_juridica->cidade = $request->input('cidade');
        $pessoa_juridica->bairro = $request->input('bairro');
        $pessoa_juridica->logradouro = $request->input('logradouro');
        $pessoa_juridica->numero = $request->input('numero');
        $pessoa_juridica->tipo = $relacao;
        $pessoa_juridica->save();

        return redirect('cadastro/juridica');
    }

    public function delete_pessoa_fisica(Request $request, $id){

        $pessoa_fisica = \App\Pessoa_fisica::find($id);

        $pessoa_fisica->ativo = '0';

        $pessoa_fisica->save();

        return redirect('cadastro/fisica');      

    }

    public function delete_pessoa_juridica(Request $request, $id){

        $pessoa_juridica = \App\Pessoa_juridica::find($id);

        $pessoa_juridica->ativo = '0';

        $pessoa_juridica->save();

        return redirect('cadastro/juridica');      
    }

    // public function busca_pessoa_fisica(Request $request){
    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'fisica';

    //     if($busca != ''){
    //         $pessoas = DB::select("
    //             SELECT
    //             pessoa_fisicas.id,
    //             pessoa_fisicas.nome, 
    //             pessoa_fisicas.cpf, 
    //             pessoa_fisicas.rg, 
    //             pessoa_fisicas.orgao_expedidor,
    //             pessoa_fisicas.sexo,
    //             pessoa_fisicas.data_nascim, 
    //             pessoa_fisicas.email, 
    //             pessoa_fisicas.telefone, 
    //             pessoa_fisicas.telefone_sec, 
    //             pessoa_fisicas.cep, 
    //             pessoa_fisicas.uf, 
    //             pessoa_fisicas.cidade, 
    //             pessoa_fisicas.logradouro,
    //             pessoa_fisicas.complemento, 
    //             pessoa_fisicas.numero,
    //             pessoa_fisicas.tipo 
    //             FROM pessoa_fisicas
    //             WHERE pessoa_fisicas.cpf LIKE '%".$busca."%' 
    //             OR pessoa_fisicas.nome LIKE '%".$busca."%' 
    //             OR pessoa_fisicas.rg LIKE '%".$busca."%'
    //             ORDER BY nome ASC
    //             ");

    //         if (count($pessoas) != 0) {

    //             return view('cadastro.cadastro_pessoa_busca',compact('pessoas','busca', 'tipo'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca', 'tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/fisica');
    //     }
    // }

    // public function busca_pessoa_juridica(Request $request){
    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'juridica';

    //     if($busca != ''){
    //         $pessoas = DB::select("
    //             SELECT
    //             pessoa_juridicas.id,
    //             pessoa_juridicas.nome_fantasia, 
    //             pessoa_juridicas.cnpj, 
    //             pessoa_juridicas.inscricao_estadual, 
    //             pessoa_juridicas.razao_social, 
    //             pessoa_juridicas.email, 
    //             pessoa_juridicas.telefone, 
    //             pessoa_juridicas.telefone_sec, 
    //             pessoa_juridicas.cep, 
    //             pessoa_juridicas.uf, 
    //             pessoa_juridicas.cidade, 
    //             pessoa_juridicas.logradouro, 
    //             pessoa_juridicas.numero,
    //             pessoa_juridicas.tipo 
    //             FROM pessoa_juridicas
    //             WHERE pessoa_juridicas.cnpj LIKE '%".$busca."%' 
    //             OR pessoa_juridicas.nome_fantasia LIKE '%".$busca."%' 
    //             OR pessoa_juridicas.razao_social LIKE '%".$busca."%' 
    //             OR pessoa_juridicas.inscricao_estadual LIKE '%".$busca."%'
    //             ORDER BY nome_fantasia ASC
    //             ");

    //         if (count($pessoas) != 0) {

    //             return view('cadastro.cadastro_pessoa_busca',compact('pessoas','busca', 'tipo'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca', 'tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/juridica');
    //     }
    // }

    // public function busca_cliente_fisica(Request $request){
    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'cliente-fisica';

    //     if($busca != ''){
    //         $clientesF = DB::select("
    //             SELECT
    //             pessoa_fisicas.id,
    //             pessoa_fisicas.nome, 
    //             pessoa_fisicas.cpf, 
    //             pessoa_fisicas.rg, 
    //             pessoa_fisicas.orgao_expedidor,
    //             pessoa_fisicas.sexo,
    //             pessoa_fisicas.data_nascim, 
    //             pessoa_fisicas.email, 
    //             pessoa_fisicas.telefone, 
    //             pessoa_fisicas.telefone_sec, 
    //             pessoa_fisicas.cep, 
    //             pessoa_fisicas.uf, 
    //             pessoa_fisicas.cidade, 
    //             pessoa_fisicas.logradouro, 
    //             pessoa_fisicas.complemento,
    //             pessoa_fisicas.numero,
    //             pessoa_fisicas.tipo 
    //             FROM pessoa_fisicas, clientes
    //             WHERE pessoa_fisicas.id = clientes.id_pessoa_fisica
    //             AND(
    //             pessoa_fisicas.cpf LIKE '%".$busca."%' 
    //             OR pessoa_fisicas.nome LIKE '%".$busca."%' 
    //             OR pessoa_fisicas.rg LIKE '%".$busca."%'
    //         )
    //         ORDER BY nome ASC
    //         ");

    //         if (count($clientesF) != 0) {

    //             return view('cadastro.cadastro_cliente_busca',compact('clientesF','busca', 'tipo'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca', 'tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/cliente-fisica');
    //     }
    // }

    // public function busca_cliente_juridica(Request $request){
    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'cliente-juridica';

    //     if($busca != ''){
    //         $clientesJ = DB::select("
    //             SELECT
    //             pessoa_juridicas.id,
    //             pessoa_juridicas.nome_fantasia, 
    //             pessoa_juridicas.cnpj, 
    //             pessoa_juridicas.inscricao_estadual, 
    //             pessoa_juridicas.razao_social, 
    //             pessoa_juridicas.email, 
    //             pessoa_juridicas.telefone, 
    //             pessoa_juridicas.telefone_sec, 
    //             pessoa_juridicas.cep, 
    //             pessoa_juridicas.uf, 
    //             pessoa_juridicas.cidade, 
    //             pessoa_juridicas.logradouro, 
    //             pessoa_juridicas.numero,
    //             pessoa_juridicas.tipo
    //             FROM pessoa_juridicas, clientes
    //             WHERE pessoa_juridicas.id = clientes.id_pessoa_juridica
    //             AND(
    //             pessoa_juridicas.cnpj LIKE '%".$busca."%' 
    //             OR pessoa_juridicas.nome_fantasia LIKE '%".$busca."%' 
    //             OR pessoa_juridicas.razao_social LIKE '%".$busca."%' 
    //             OR pessoa_juridicas.inscricao_estadual LIKE '%".$busca."%'
    //         )
    //         ORDER BY nome_fantasia ASC
    //         ");

    //         if (count($clientesJ) != 0) {

    //             return view('cadastro.cadastro_cliente_busca',compact('clientesJ','busca', 'tipo'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca', 'tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/cliente-juridica');
    //     }
    // }

    // public function delete_cliente_fisica($id){

    //     $cliente = \App\Cliente::find($id);

    //     // $pessoa_fisica = DB::select("
    //     //         SELECT 
    //     //         pessoa_fisicas.id,
    //     //         pessoa_fisicas.tipo
    //     //         FROM pessoa_fisicas
    //     //         WHERE pessoa_fisicas.id = '%".$cliente->id_pessoa_fisica."%'
    //     //     ");

    //     echo $pessoa_fisica->nome;

    //     if($pessoa_fisica->tipo == 'cf'){
    //         $pessoa_fisica->tipo = 'f'; 
    //         $pessoa_fisica->save();
    //     } else if($pessoa_fisica->tipo == 'c'){
    //         $pessoa_fisica->tipo = ''; 
    //         $pessoa_fisica->save();
    //     } else{
    //         return redirect('cadastro/cliente-fisica');
    //     }

    //     $cliente = $cliente->delete();

    //     return redirect('cadastro/cliente-fisica');      
    // }

    // public function delete_cliente_juridica($id){

    //     $cliente = \App\Cliente::find($id);
    //     $cliente = $cliente->delete();

    //     $pessoa_juridica = DB::select("
    //         SELECT 
    //         pessoa_juridicas.id,
    //         pessoa_juridica.tipo
    //         FROM pessoa_juridicas, clientes
    //         WHERE pessoa_juridicas.id = clientes.id_pessoa_juridica
    //         ");

    //     $pessoa_juridica = $pessoa_juridica->delete();

    //     return redirect('cadastro/cliente-juridica');      
    // }

    // public function busca_fornecedor_fisica(Request $request){
    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'fornecedor-fisica';

    //     if($busca != ''){
    //         $fornecedorsF = DB::select("
    //             SELECT
    //             pessoa_fisicas.id,
    //             pessoa_fisicas.nome, 
    //             pessoa_fisicas.cpf, 
    //             pessoa_fisicas.rg, 
    //             pessoa_fisicas.sexo,
    //             pessoa_fisicas.orgao_expedidor,
    //             pessoa_fisicas.data_nascim, 
    //             pessoa_fisicas.email, 
    //             pessoa_fisicas.telefone, 
    //             pessoa_fisicas.telefone_sec, 
    //             pessoa_fisicas.cep, 
    //             pessoa_fisicas.uf, 
    //             pessoa_fisicas.cidade, 
    //             pessoa_fisicas.logradouro, 
    //             pessoa_fisicas.complemento,
    //             pessoa_fisicas.numero,
    //             pessoa_fisicas.tipo 
    //             FROM pessoa_fisicas, fornecedors
    //             WHERE pessoa_fisicas.id = fornecedors.id_pessoa_fisica
    //             AND(
    //             pessoa_fisicas.cpf LIKE '%".$busca."%' 
    //             OR pessoa_fisicas.nome LIKE '%".$busca."%' 
    //             OR pessoa_fisicas.rg LIKE '%".$busca."%'
    //         )
    //         ORDER BY nome ASC
    //         ");

    //         if (count($fornecedorsF) != 0) {

    //             return view('cadastro.cadastro_fornecedor_busca',compact('fornecedorsF','busca', 'tipo'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca', 'tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/fornecedor-fisica');
    //     }
    // }

    // public function busca_fornecedor_juridica(Request $request){
    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'fornecedor-juridica';

    //     if($busca != ''){
    //         $fornecedorsJ = DB::select("
    //             SELECT
    //             pessoa_juridicas.id,
    //             pessoa_juridicas.nome_fantasia, 
    //             pessoa_juridicas.cnpj, 
    //             pessoa_juridicas.inscricao_estadual, 
    //             pessoa_juridicas.razao_social, 
    //             pessoa_juridicas.email, 
    //             pessoa_juridicas.telefone, 
    //             pessoa_juridicas.telefone_sec, 
    //             pessoa_juridicas.cep, 
    //             pessoa_juridicas.uf, 
    //             pessoa_juridicas.cidade, 
    //             pessoa_juridicas.logradouro, 
    //             pessoa_juridicas.numero,
    //             pessoa_juridicas.tipo
    //             FROM pessoa_juridicas, fornecedors
    //             WHERE pessoa_juridicas.id = fornecedors.id_pessoa_juridica
    //             AND(
    //             pessoa_juridicas.cnpj LIKE '%".$busca."%' 
    //             OR pessoa_juridicas.nome_fantasia LIKE '%".$busca."%' 
    //             OR pessoa_juridicas.razao_social LIKE '%".$busca."%' 
    //             OR pessoa_juridicas.inscricao_estadual LIKE '%".$busca."%'
    //         )
    //         ORDER BY nome_fantasia ASC
    //         ");

    //         if (count($fornecedorsJ) != 0) {

    //             return view('cadastro.cadastro_fornecedor_busca',compact('fornecedorsJ','busca', 'tipo'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca', 'tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/fornecedor-juridica');
    //     }
    // }

    // public function busca_usuario(Request $request){
    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'usuario';

    //     if($busca != ''){
    //         $usuarios = DB::select("
    //             SELECT
    //             users.id,
    //             users.name, 
    //             users.email
    //             FROM users
    //             WHERE users.id != '0'
    //             AND users.name LIKE '%".$busca."%' OR users.id LIKE '%".$busca."%' 
    //             OR users.email LIKE '%".$busca."%'
    //             ORDER BY name
    //             ");

    //         if (count($usuarios) != 0) {

    //             return view('cadastro.cadastro_usuario_busca',compact('usuarios','busca', 'tipo'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca', 'tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/usuario');
    //     }
    // }

    // public function busca_marca(Request $request){
    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'marca';

    //     if($busca != ''){
    //         $marcas = DB::select("
    //             SELECT
    //             marcas.id,
    //             marcas.nome
    //             FROM marcas
    //             WHERE marcas.nome LIKE '%".$busca."%' 
    //             OR marcas.id LIKE '%".$busca."%'
    //             ORDER BY nome ASC
    //             ");

    //         if (count($marcas) != 0) {

    //             return view('cadastro.cadastro_marca_busca',compact('marcas','busca', 'tipo'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca', 'tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/marca');
    //     }
    // }

    // public function busca_departamento(Request $request){
    //     $busca = $request->search;
    //     trim($busca);
    //     $tipo = 'departamento';

    //     if($busca != ''){
    //         $departamentos = DB::select("
    //             SELECT
    //             departamentos.id,
    //             departamentos.nome
    //             FROM departamentos
    //             WHERE departamentos.nome LIKE '%".$busca."%' 
    //             OR departamentos.id LIKE '%".$busca."%'
    //             ORDER BY nome ASC
    //             ");

    //         // $departamentos = DB::table('departamentos')->select(
    //         //     'departamentos.id', 
    //         //     'departamentos.nome')->where('nome', '=', $busca)->where('id', '=', $busca);


    //            // echo $departamentos->nome;
            

    //         //echo $departamentos->nome;

    //         if (count($departamentos) != 0) {

    //             return view('cadastro.cadastro_departamento_busca',compact('departamentos','busca', 'tipo'));
    //         }else{

    //             return view('cadastro.cadastro_busca_vazia',compact('busca', 'tipo'));
    //         }
    //     }else{

    //         return redirect('cadastro/departamento');
    //     }
    // }
}