<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;


// Rota inicial (home)
Route::get('/', function () {
    return view('dashboard');
})->name('home');

// Rotas de autenticação (fora do middleware 'auth')
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('home');
    });

    // Logout (apenas para usuários autenticados)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/adicionar', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
    //Route::get('/usuarios/pesquisar', [UserController::class, 'pesquisar'])->name('usuarios.pesquisar');
    Route::get('/usuarios/{usuario}/detalhes', [UserController::class, 'detalhes'])->name('usuarios.detalhes');
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    // Fornecedores
    Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores.index');
    Route::get('/fornecedores/adicionar', [FornecedorController::class, 'create'])->name('fornecedores.create');
    Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store');
    Route::get('/fornecedores/{fornecedor}/editar', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
    Route::put('/fornecedores/{fornecedor}', [FornecedorController::class, 'update'])->name('fornecedores.update');
    //Route::get('/fornecedores/pesquisar', [FornecedorController::class, 'pesquisar'])->name('fornecedores.pesquisar');
    Route::get('/fornecedores/{fornecedor}/detalhes', [FornecedorController::class, 'detalhes'])->name('fornecedores.detalhes');
    Route::delete('/fornecedores/{fornecedor}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy');
    Route::get('/cidades/{estado_id}', [FornecedorController::class, 'getCidades']);
    Route::get('/estado/por-uf/{uf}', [FornecedorController::class, 'getIdByUf']);

    // Categorias
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categorias/adicionar', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{categoria}/editar', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
    //Route::get('/categorias/pesquisar', [CategoriaController::class, 'pesquisar'])->name('categorias.pesquisar');
    Route::get('/categorias/{categoria}/detalhes', [CategoriaController::class, 'detalhes'])->name('categorias.detalhes');
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    // Produtos
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/adicionar', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/produtos/{produto}/editar', [ProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
    //Route::get('/produtos/pesquisar', [ProdutoController::class, 'pesquisar'])->name('produtos.pesquisar');
    Route::get('/produtos/{produto}/detalhes', [ProdutoController::class, 'detalhes'])->name('produtos.detalhes');
    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
    Route::get('/buscar-produto-codigo/{codigo}', [ProdutoController::class, 'buscarProdutoCodigo'])->name('buscar.produto.codigo');
    Route::get('/buscar-produto-nome', [ProdutoController::class, 'buscarProdutoNome'])->name('buscar.produto.nome');


    // Orcamentos
    Route::get('/orcamentos', [OrcamentoController::class, 'index'])->name('orcamentos.index');
    Route::get('/orcamentos/adicionar', [OrcamentoController::class, 'create'])->name('orcamentos.create');
    Route::post('/orcamentos', [OrcamentoController::class, 'store'])->name('orcamentos.store');
    Route::get('/orcamentos/{orcamento}/editar', [OrcamentoController::class, 'edit'])->name('orcamentos.edit');
    Route::put('/orcamentos/{orcamento}', [OrcamentoController::class, 'update'])->name('orcamentos.update');
    //Route::get('/orcamentos/pesquisar', [OrcamentoController::class, 'pesquisar'])->name('orcamentos.pesquisar');
    Route::get('/orcamentos/{orcamento}/detalhes', [OrcamentoController::class, 'detalhes'])->name('orcamentos.detalhes');
    Route::delete('/orcamentos/{orcamento}', [OrcamentoController::class, 'destroy'])->name('orcamentos.destroy');
    Route::post('/salvar-orcamento', [OrcamentoController::class, 'salvarOrcamento'])->name('orcamento.salvar');
    Route::put('/atualizar-orcamento/{id}', [OrcamentoController::class, 'atualizarOrcamento']);
    Route::get('/orcamento/{id}/pdf', [OrcamentoController::class, 'generatePdf'])->name('orcamento.pdf');
    Route::get('/buscar-fornecedor/{codigo}', [OrcamentoController::class, 'buscarFornecedor'])->name('buscar.fornecedor');
    Route::get('/fornecedores/buscar', [OrcamentoController::class, 'buscarPorNome'])->name('buscar.fornecedor.nome');


    // Pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/adicionar', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{pedido}/editar', [PedidoController::class, 'edit'])->name('pedidos.edit');
    Route::put('/pedidos/{pedido}', [PedidoController::class, 'update'])->name('pedidos.update');
    //Route::get('/pedidos/pesquisar', [PedidoController::class, 'pesquisar'])->name('pedidos.pesquisar');
    Route::get('/pedidos/{pedido}/detalhes', [PedidoController::class, 'detalhes'])->name('pedidos.detalhes');
    Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');
    Route::post('/salvar-pedido', [PedidoController::class, 'salvarPedido'])->name('pedido.salvar');
    Route::put('/atualizar-pedido/{id}', [PedidoController::class, 'atualizarPedido'])->name('pedido.atualizar');
    Route::get('/pedido/{id}/pdf', [PedidoController::class, 'generatePdf'])->name('pedido.pdf');
    Route::post('calcular-parcelas', [PedidoController::class, 'calcularParcelas'])->name('calcular.parcelas');
});
