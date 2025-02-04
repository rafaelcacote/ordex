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
        $contasPagar = ContasPagar::query();

        if ($request->has('descricao')) {
            $contasPagar->where('descricao', 'like', '%' . $request->descricao . '%');
        }

        $contasPagar = $contasPagar->get();

        return view('contas_pagar.index', compact('contasPagar'));
    }

    public function create()
    {
        $pedidos = Pedido::all();
        return view('contas_pagar.create', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => 'required|string',
            'valor_quitacao' => 'required|numeric',
            'data' => 'required|date',
            'vencimento' => 'required|date',
        ]);

        ContasPagar::create($validated);

        return redirect()->route('contas_pagar.index');
    }

    public function edit($id)
    {
        $contaPagar = ContasPagar::findOrFail($id);
        $pedidos = Pedido::all();
        return view('contas_pagar.edit', compact('contaPagar', 'pedidos'));
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

        return redirect()->route('contas_pagar.index');
    }

    public function destroy($id)
    {
        $contaPagar = ContasPagar::findOrFail($id);
        $contaPagar->delete();

        return redirect()->route('contas_pagar.index');
    }
}
