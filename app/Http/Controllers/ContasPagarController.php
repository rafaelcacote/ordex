<?php

namespace App\Http\Controllers;

use App\Models\ContasPagar;
use App\Models\Pedido;
use App\Models\FormaPagamento;
use Illuminate\Http\Request;

class ContasPagarController extends Controller
{
    public function index(Request $request)
    {
        $query = ContasPagar::query();

        // Filtro de pesquisa
        if ($request->has('descricao')) {
            $query->where('descricao', 'like', '%' . $request->descricao . '%');
        }

        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }


        // Paginação - modificando para 'paginate' com 10 itens por página
        $contaspagar = $query->paginate(10);

        return view('contaspagar.index', compact('contaspagar'));
    }

    public function create()
    {
        $pedidos = Pedido::all();
        return view('contaspagar.create', compact('pedidos'));
    }

    public function store(Request $request)
    {
        ContasPagar::create([
            'descricao' => $request->descricao,
            'documento' => $request->documento,
            'data' => $request->data,
            'valor_quitacao' => $request->valor_quitacao,
            'multa' => $request->multa,
            'juros' => $request->juros,
            'vencimento' => $request->vencimento,
            'parcela' => $request->parcela,
            'status' => $request->status,
        ]);

        return redirect()->route('contaspagar.index')->with('success', 'Contas a pagar criada com sucesso!');
    }

    public function edit($id)
    {
        $contaPagar = ContasPagar::findOrFail($id);
        $pedidos = Pedido::all();
        return view('contaspagar.edit', compact('contaPagar', 'pedidos'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'descricao' => 'required|string',
            'valor_quitacao' => 'required|numeric',
            'data' => 'required|date',
            'vencimento' => 'required|date',
        ]);

        $contaPagar = ContasPagar::findOrFail($id);
        $contaPagar->update($validated);

        return redirect()->route('contaspagar.index');
    }

    public function destroy($id)
    {
        $contaPagar = ContasPagar::findOrFail($id);
        $contaPagar->delete();

        return redirect()->route('contaspagar.index');
    }
}
