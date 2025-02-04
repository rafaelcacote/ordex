<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('dashboard');
})->name('home');




Route::get('/dashboard', function () {
    return view('index');
})->middleware('auth');

// Auth::routes();

// Fornecedores
Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores');
Route::get('/fornecedores/adicionar', [FornecedorController::class, 'create'])->name('fornecedores.create');
Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store');
Route::get('/fornecedores/{fornecedor}/editar', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
Route::put('/fornecedores/{fornecedor}', [FornecedorController::class, 'update'])->name('fornecedores.update');
//Route::get('/fornecedores/pesquisar', [FornecedorController::class, 'pesquisar'])->name('fornecedores.pesquisar');
Route::get('/fornecedores/{fornecedor}/detalhes', [FornecedorController::class, 'detalhes'])->name('fornecedores.detalhes');

// Categorias
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/adicionar', [CategoriaController::class, 'create'])->name('categorias.create');
Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
Route::get('/categorias/{categoria}/editar', [CategoriaController::class, 'edit'])->name('categorias.edit');
Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
//Route::get('/categorias/pesquisar', [CategoriaController::class, 'pesquisar'])->name('categorias.pesquisar');
Route::get('/categorias/{categoria}/detalhes', [CategoriaController::class, 'detalhes'])->name('categorias.detalhes');
Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
