<?php

use Src\Route as Route;

//Rotas Site
Route::get('/', function (){
    view('index.php',["teste"=>"123"]);
});







//Rotas API

//Rotas CRUD Cliente
Route::get(['set'=>'/api/clientes', 'as'=>'api.clientes.list'], 'ClienteController@list');
Route::get(['set'=>'/api/cliente/{id}','as'=>'api.cliente.details'],'ClienteController@details');
Route::post(['set'=>'/api/cliente/save','as'=>'api.cliente.save'],'ClienteController@save');
Route::put(['set'=>'/api/cliente/update','as'=>'api.cliente.update'],'ClienteController@update');
Route::delete(['set'=>'/api/cliente/{id}','as'=>'api.cliente.delete'],'ClienteController@delete');

//Rotas CRUD Proprietario
Route::get(['set'=>'/api/proprietarios', 'as'=>'api.proprietarios.list'], 'ProprietarioController@list');
Route::get(['set'=>'/api/proprietario/{id}','as'=>'api.proprietario.details'],'ProprietarioController@details');
Route::post(['set'=>'/api/proprietario/save','as'=>'api.proprietario.save'],'ProprietarioController@save');
Route::put(['set'=>'/api/proprietario/update','as'=>'api.proprietario.update'],'ProprietarioController@update');
Route::delete(['set'=>'/api/proprietario/{id}','as'=>'api.proprietario.delete'],'ProprietarioController@delete');

//Rotas CRUD Imoveis
Route::get(['set'=>'/api/imoveis', 'as'=>'api.imoveis.list'], 'ImovelController@list');
Route::get(['set'=>'/api/imovel/{id}','as'=>'api.imovel.details'],'ImovelController@details');
Route::post(['set'=>'/api/imovel/save','as'=>'api.imovel.save'],'ImovelController@save');
Route::put(['set'=>'/api/imovel/update','as'=>'api.imovel.update'],'ImovelController@update');
Route::delete(['set'=>'/api/imovel/{id}','as'=>'api.imovel.delete'],'ImovelController@delete');

//Rotas CRUD Contratos

Route::get(['set'=>'/api/contratos', 'as'=>'api.contratos.list'], 'ContratoController@list');
Route::get(['set'=>'/api/contrato/{id}','as'=>'api.contrato.details'],'ContratoController@details');
Route::post(['set'=>'/api/contrato/save','as'=>'api.contrato.save'],'ContratoController@save');
Route::put(['set'=>'/api/contrato/update','as'=>'api.contrato.update'],'ContratoController@update');
Route::delete(['set'=>'/api/contrato/{id}','as'=>'api.contrato.delete'],'ContratoController@delete');



