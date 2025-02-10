<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Http\Requests\Produtos\StoreProdutoRequest;
use App\Http\Requests\Produtos\UpdateProdutoRequest;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // Exibe a lista de produtos ativos (status = 1)
    public function index(Request $request)
    {
        $categorias = Categoria::where('status', 1)->get();
        $query = Produto::where('status', 1);

        // Filtros condicionais
        if ($request->input('codigo')) {
            $query->where('codigo', $request->input('codigo'));
        }

        if ($request->input('nome')) {
            $query->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        if ($request->input('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        if ($request->input('categoria_id')) {
            $query->where('categoria_id', $request->input('categoria_id'));
        }

        $produtos = $query->paginate(10);

        return view('produtos.index', compact('produtos', 'categorias'));
    }


    // Exibe o formulário de criação
    public function create()
    {
        $categorias = Categoria::where('status', 1)->get();
        return view('produtos.create', compact('categorias'));
    }

    // Salva um novo produto
    public function store(StoreProdutoRequest $request)
    {
        // Verifica se o codigo já existe
        $codigoExistente = Produto::where('codigo', $request->codigo)->exists();

        if ($codigoExistente) {
            return redirect()->back()
                ->withErrors(['codigo' => 'Este código já está cadastrado no sistema.'])
                ->withInput();
        }

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
    public function update(UpdateProdutoRequest $request, $id)
    {

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

        return redirect()->route('produtos.index')->with('success', 'Produto excluido com sucesso!');
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
