<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/cadastro/{atributo}', 'Cadastro_Controller@index')->name('cadastro');
Route::get('/estoque/{atributo}', 'Estoque_Controller@index')->name('estoque');
Route::get('/contas/{atributo}', 'Contas_Controller@index')->name('contas');

Route::post('/estoque/{atributo}', 'Estoque_Controller@filtro')->name('estoque');

Route::get('/cadastro/{atributo}/help', 'Help_Controller@help_cadastro')->name('help_cadastro');
Route::get('/estoque/{atributo}/help', 'Help_Controller@help_estoque')->name('help_estoque');


//cadastro usuario
//get
Route::get('/cadastro/usuario/{convidar}', 'Cadastro_Controller@novo_usuario')->name('novo_usuario');
Route::get('/cadastro/usuario/{cadastrar}', 'Cadastro_Controller@novo_usuario')->name('novo_usuario');
Route::get('/cadastro/usuario/{id}/update', 'Cadastro_Controller@update_usuario')->name('update_usuario');
Route::get('/cadastro/usuario/{id}/delete', 'Cadastro_Controller@delete_usuario')->name('delete_usuario');
//post
Route::post('/cadastro/usuario/convidar', 'Cadastro_Controller@enviar_convite')->name('convite');
Route::post('/cadastro/usuario/cadastrar', 'Cadastro_Controller@create_usuario')->name('cadastro_usuario');
Route::post('/cadastro/usuario/{id}/salvar', 'Cadastro_Controller@save_usuario')->name('update_usuario');

Route::post('/cadastro/usuario/busca', 'Cadastro_Controller@busca_usuario')->name('busca_usuario');


//cadastro produto
//get
Route::get('/cadastro/produto/{cadastrar}', 'Cadastro_Controller@novo_produto')->name('novo_produto');

Route::get('/cadastro/produto/{id}/update', 'Cadastro_Controller@update_produto')->name('update_produto');

Route::get('/cadastro/produto/{id}/delete', 'Cadastro_Controller@delete_produto')->name('delete_produto');
//post
Route::post('/cadastro/produto/busca', 'Cadastro_Controller@busca_produto')->name('busca_produto');

Route::post('/cadastro/produto/cadastrar', 'Cadastro_Controller@create_produto')->name('cadastro_produto');

Route::post('/cadastro/produto/{id}/update', 'Cadastro_Controller@save_produto')->name('update_produto');


//Departamento
Route::get('/cadastro/departamento/{cadastrar}', 'Cadastro_Controller@novo_departamento')->name('novo_departamento');

Route::post('/cadastro/departamento/cadastrar', 'Cadastro_Controller@create_departamento')->name('cadastro_departamento');

Route::get('/cadastro/departamento/{id}/update', 'Cadastro_Controller@update_departamento')->name('update_departamento');

Route::post('/cadastro/departamento/{id}/save', 'Cadastro_Controller@departamento_save')->name('departamento_save');

Route::get('/cadastro/departamento/{id}/delete', 'Cadastro_Controller@delete_departamento')->name('delete_departamento');

Route::post('/cadastro/departamento/busca', 'Cadastro_Controller@busca_departamento')->name('busca_departamento');


//Marca
Route::get('/cadastro/marca/{cadastrar}', 'Cadastro_Controller@novo_marca')->name('novo_marca');

Route::post('/cadastro/marca/cadastrar', 'Cadastro_Controller@create_marca')->name('cadastro_marca');

Route::get('/cadastro/marca/{id}/update', 'Cadastro_Controller@update_marca')->name('update_marca');

Route::post('/cadastro/marca/{id}/save', 'Cadastro_Controller@marca_save')->name('marca_save');

Route::get('/cadastro/marca/{id}/delete', 'Cadastro_Controller@delete_marca')->name('delete_marca');

Route::post('/cadastro/marca/busca', 'Cadastro_Controller@busca_marca')->name('busca_marca');


//cadastro pessoa
Route::get('/cadastro/pessoa/tipo', 'Cadastro_Controller@pessoa_tipo')->name('pessoa_tipo');

Route::post('/cadastro/pessoa/tipo/novo', 'Cadastro_Controller@pessoa_tipo_novo')->name('pessoa_tipo_novo');

Route::post('/cadastro/pessoa/{tipo}/create', 'Cadastro_Controller@create_pessoa')->name('pessoa_tipo_create');


Route::get('/cadastro/pessoa/fisica/{id}/update', 'Cadastro_Controller@update_pessoa_fisica')->name('update_pessoa_fisica');

Route::get('/cadastro/pessoa/juridica/{id}/update', 'Cadastro_Controller@update_pessoa_juridica')->name('update_pessoa_juridica');

Route::post('/cadastro/pessoa/fisica/{id}/save', 'Cadastro_Controller@pessoa_fisica_save')->name('pessoa_fisica_save');

Route::post('/cadastro/pessoa/juridica/{id}/save', 'Cadastro_Controller@pessoa_juridica_save')->name('pessoa_juridica_save');

Route::get('/cadastro/pessoa/fisica/{id}/delete', 'Cadastro_Controller@delete_pessoa_fisica')->name('delete_pessoa_fisica');

Route::get('/cadastro/pessoa/juridica/{id}/delete', 'Cadastro_Controller@delete_pessoa_juridica')->name('delete_pessoa_juridica');

Route::post('/cadastro/pessoa_fisica/busca', 'Cadastro_Controller@busca_pessoa_fisica')->name('busca_pessoa_fisica');

Route::post('/cadastro/pessoa_juridica/busca', 'Cadastro_Controller@busca_pessoa_juridica')->name('busca_pessoa_juridica');

//Clientes
Route::post('/cadastro/cliente_fisica/busca', 'Cadastro_Controller@busca_cliente_fisica')->name('busca_cliente_fisica');

Route::post('/cadastro/cliente_juridica/busca', 'Cadastro_Controller@busca_cliente_juridica')->name('busca_cliente_juridica');

Route::get('/cadastro/departamento/{id}/delete', 'Cadastro_Controller@delete_departamento')->name('delete_departamento');

Route::get('/cadastro/cliente-fisica/{id}/delete', 'Cadastro_Controller@delete_cliente_fisica')->name('delete_cliente');

Route::get('/cadastro/cliente-juridica/{id}/delete', 'Cadastro_Controller@delete_cliente_juridica')->name('delete_cliente');



//Fornecedores
Route::post('/cadastro/fornecedor_fisica/busca', 'Cadastro_Controller@busca_fornecedor_fisica')->name('busca_fornecedor_fisica');

Route::post('/cadastro/fornecedor_juridica/busca', 'Cadastro_Controller@busca_fornecedor_juridica')->name('busca_fornecedor_juridica');


//Estoque
//get
Route::get('/estoque/retirada/detalhes/{id}', 'Estoque_Controller@detalhes_retirada')->name('detalhes_retirada');
Route::get('/estoque/entrada/detalhes/{id}', 'Estoque_Controller@detalhes_entrada')->name('detalhes_entrada');

//post
Route::post('/estoque/busca', 'Estoque_Controller@busca_produto')->name('busca_produto');

Route::post('/estoque/produto', 'Estoque_Controller@create_entrada')->name('entrada');

Route::post('/estoque/entrada/busca', 'Estoque_Controller@busca_entrada')->name('busca_entrada');

Route::post('/estoque/retirada/busca', 'Estoque_Controller@busca_retirada')->name('busca_retirada');

Route::post('/estoque/compra/busca', 'Estoque_Controller@busca_compra')->name('busca_compra');

//Contas
//get
Route::get('/contas/despesas/novo', 'Contas_Controller@nova_despesa')->name('despesa');

Route::get('/contas/despesas/parcelas/{id}', 'Contas_Controller@detalhes_despesa')->name('detalhes_despesa');

Route::get('/contas/despesas_parcelas/{id}/delete', 'Contas_Controller@delete_parcela_despesa')->name('delete_parcela_despesa');

Route::get('/contas/despesas/{id}/delete', 'Contas_Controller@delete_despesa')->name('delete_despesa');


Route::get('/contas/receitas/novo', 'Contas_Controller@nova_receita')->name('receita');

Route::get('/contas/receitas/parcelas/{id}', 'Contas_Controller@detalhes_receita')->name('detalhes_receita');

Route::get('/contas/receitas_parcelas/{id}/delete', 'Contas_Controller@delete_parcela_receita')->name('delete_parcela_receita');

Route::get('/contas/receitas/{id}/delete', 'Contas_Controller@delete_receita')->name('delete_receita');
//post
Route::post('/contas/despesas/novo', 'Contas_Controller@create_despesa')->name('create_despesa');

Route::post('/contas/receitas/novo', 'Contas_Controller@create_receita')->name('create_receita');