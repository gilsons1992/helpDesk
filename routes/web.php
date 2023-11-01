<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ConfigBancoController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\TributoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\ClienteOsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('principal');
});

// Item
Route::get('/item.index', [ItemController::class, 'index']);
Route::get('/item.create', [ItemController::class, 'create']);
Route::get('/item.retrieveAll', [ItemController::class, 'retrieveAll']);
Route::post('/item.store', [ItemController::class, 'store']);
Route::post('/item.saveAjax', [ItemController::class, 'saveAjax']);
Route::post('/item.delete', [ItemController::class, 'delete']);
Route::get('/item.edit.{i}', [ItemController::class, 'edit']);
Route::get('/item.importarXML', [ItemController::class, 'importarXML']);
Route::post('/item.processarXML', [ItemController::class, 'processarXML']);
Route::post('/item.executarImportacaoXML', [ItemController::class, 'executarImportacaoXML']);
Route::get('/item.pesquisaPorCodigoBarras.{i}', [ItemController::class, 'pesquisaPorCodigoBarras']);
Route::get('/item.historicoPrecos.{i}', [ItemController::class, 'historicoPrecos']);

// Categoria
Route::get('/categoria.index', [CategoriaController::class, 'index']);
Route::get('/categoria.create', [CategoriaController::class, 'create']);
Route::get('/categoria.retrieveAll', [CategoriaController::class, 'retrieveAll']);
Route::post('/categoria.store', [CategoriaController::class, 'store']);
Route::post('/categoria.delete', [CategoriaController::class, 'delete']);
Route::get('/categoria.edit.{i}', [CategoriaController::class, 'edit']);
Route::get('/categoria.load', [CategoriaController::class, 'load']);

// ConfigBanco
Route::get('/configBanco.index', [ConfigBancoController::class, 'index']);
Route::get('/configBanco.create', [ConfigBancoController::class, 'create']);
Route::get('/configBanco.retrieveAll', [ConfigBancoController::class, 'retrieveAll']);
Route::post('/configBanco.store', [ConfigBancoController::class, 'store']);
Route::post('/configBanco.delete', [ConfigBancoController::class, 'delete']);
Route::get('/configBanco.edit.{i}', [ConfigBancoController::class, 'edit']);
Route::get('/configBanco.load', [ConfigBancoController::class, 'load']);

// Venda
Route::get('/venda.index', [VendaController::class, 'index']);
Route::get('/venda.carrega', [VendaController::class, 'carrega']);
Route::get('/venda.retornaItens.{i}', [VendaController::class, 'retornaItens']);
Route::post('/venda.adicionaItemAoCupom', [VendaController::class, 'adicionaItemAoCupom']);
Route::get('/venda.pesquisaItem', [VendaController::class, 'pesquisaItem']);
Route::get('/venda.cancelaItem', [VendaController::class, 'cancelaItem']);
Route::post('/venda.executaCancelaItem', [VendaController::class, 'executaCancelaItem']);
Route::get('/venda.selecionaItem.{i}', [VendaController::class, 'selecionaItem']);
Route::get('/venda.cancela', [VendaController::class, 'cancela']);
Route::post('/venda.executaPesquisaItem', [VendaController::class, 'executaPesquisaItem']);

// Unidade
Route::get('/unidade.index', [UnidadeController::class, 'index']);
Route::get('/unidade.create', [UnidadeController::class, 'create']);
Route::get('/unidade.retrieveAll', [UnidadeController::class, 'retrieveAll']);
Route::post('/unidade.store', [UnidadeController::class, 'store']);
Route::post('/unidade.delete', [UnidadeController::class, 'delete']);
Route::get('/unidade.edit.{i}', [UnidadeController::class, 'edit']);
Route::get('/unidade.load', [UnidadeController::class, 'load']);

// Tributo
Route::get('/tributo.index', [TributoController::class, 'index']);
Route::get('/tributo.create', [TributoController::class, 'create']);
Route::get('/tributo.retrieveAll', [TributoController::class, 'retrieveAll']);
Route::post('/tributo.store', [TributoController::class, 'store']);
Route::post('/tributo.delete', [TributoController::class, 'delete']);
Route::get('/tributo.edit.{i}', [TributoController::class, 'edit']);
Route::get('/tributo.load', [TributoController::class, 'load']);

// Usuario
Route::get('/usuario.index', [UsuarioController::class, 'index']);
Route::get('/usuario.create', [UsuarioController::class, 'create']);
Route::get('/usuario.retrieveAll', [UsuarioController::class, 'retrieveAll']);
Route::post('/usuario.store', [UsuarioController::class, 'store']);
Route::post('/usuario.delete', [UsuarioController::class, 'delete']);
Route::get('/usuario.edit.{i}', [UsuarioController::class, 'edit']);
Route::get('/usuario.load', [UsuarioController::class, 'load']);

// Ordem de Serviço
Route::get('/ordemServico.index', [OrdemServicoController::class, 'index']);
Route::get('/ordemServico.create', [OrdemServicoController::class, 'create']);
Route::get('/ordemServico.retrieveAll', [OrdemServicoController::class, 'retrieveAll']);
Route::post('/ordemServico.store', [OrdemServicoController::class, 'store']);
Route::post('/ordemServico.delete', [OrdemServicoController::class, 'delete']);
Route::get('/ordemServico.edit.{i}', [OrdemServicoController::class, 'edit']);
Route::get('/ordemServico.load', [OrdemServicoController::class, 'load']);
Route::get('/ordemServico.pdf.{i}', [OrdemServicoController::class, 'gerarPdf']);
Route::get('/ordemServico.pesquisaCliente.{i}', [OrdemServicoController::class, 'pesquisaCliente']);

// Usuario OS
Route::get('/clientesOs.index', [ClienteOsController::class, 'index']);
Route::get('/clientesOs.create', [ClienteOsController::class, 'create']);
Route::get('/clientesOs.retrieveAll', [ClienteOsController::class, 'retrieveAll']);
Route::post('/clientesOs.store', [ClienteOsController::class, 'store']);
Route::post('/clientesOs.delete', [ClienteOsController::class, 'delete']);
Route::get('/clientesOs.edit.{i}', [ClienteOsController::class, 'edit']);
Route::get('/clientesOs.load', [ClienteOsController::class, 'load']);

