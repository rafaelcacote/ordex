<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\Categorias\StoreCategoriaRequest;
use App\Http\Requests\Categorias\UpdateCategoriaRequest;

class CategoriaController extends Controller
{
    // Exibe a lista de categorias ativas (status = 1)
    public function index(Request $request)
    {
        $query = Categoria::where('status', 1);

        // Filtro de pesquisa
        if ($request->has('for_nome')) {
            $query->where('nome', 'like', '%' . $request->for_nome . '%');
        }

        // Paginação - modificando para 'paginate' com 10 itens por página
        $categorias = $query->paginate(10);


        return view('categorias.index', compact('categorias', 'request'));
    }


    // Exibe o formulário de criação
    public function create()
    {
        return view('categorias.create');
    }

    // Salva uma nova categoria
    public function store(StoreCategoriaRequest $request)
    {
        Categoria::create([
            'nome' => $request->nome,
            'status' => 1, // Status ativo por padrão
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit(Categoria $categoria)
    {

        return view('categorias.edit', compact('categoria'));
    }

    // Atualiza uma categoria existente
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update([
            'nome' => $request->nome,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    // Desativa uma categoria (status = 0)
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update(['status' => 0]);

        return redirect()->route('categorias.index')->with('success', 'Categoria excluido com sucesso!');
    }
}
