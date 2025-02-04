<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // Exibe a lista de produtos ativos (status = 1)
    public function index(Request $request)
    {
        $produtos = Produto::where('status', 1);

        // Filtros condicionais
        if ($request->input('codigo')) {
            $produtos->where('codigo', $request->input('codigo'));
        }

        if ($request->input('nome')) {
            $produtos->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        if ($request->input('tipo')) {
            $produtos->where('tipo', $request->input('tipo'));
        }

        $produtos = $produtos->get();

        return view('produtos.index', compact('produtos'));
    }


    // Exibe o formulário de criação
    public function create()
    {
        $categorias = Categoria::all();
        return view('produtos.create', compact('categorias'));
    }

    // Salva um novo produto
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Produto::create([
            'codigo' => $request->codigo,
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'medida' => $request->medida,
            'status' => 1, // Status ativo por padrão
            'estoque' => $request->estoque,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        $categorias = Categoria::all();
        return view('produtos.edit', compact('produto', 'categorias'));
    }

    // Atualiza um produto existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $produto = Produto::findOrFail($id);
        $produto->update([
            'codigo' => $request->codigo,
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'medida' => $request->medida,
            'estoque' => $request->estoque,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    // Desativa um produto (status = 0)
    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->update(['status' => 0]);

        return redirect()->route('produtos.index')->with('success', 'Produto desativado com sucesso!');
    }

    // Buscar produto por código
    public function buscarProdutoCodigo($codigo)
    {
        $produto = Produto::where('codigo', $codigo)->first();

        if ($produto) {
            return response()->json([
                'success' => true,
                'nome' => $produto->nome,
                'estoque' => $produto->estoque,
                'id' => $produto->id
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    // Buscar produtos por nome
    public function buscarProdutoNome(Request $request)
    {
        $nome = $request->input('nome');
        $produtos = Produto::where('nome', 'like', '%' . $nome . '%')->get();
        return response()->json($produtos);
    }
}
