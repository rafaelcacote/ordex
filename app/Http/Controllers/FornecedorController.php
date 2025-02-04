<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Cidade;
use App\Models\Estado;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    // Listar fornecedores
    public function index(Request $request)
    {
        $fornecedores = Fornecedor::where('status', 1);

        if ($request->has('nome')) {
            $fornecedores->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        if ($request->has('cpf_cnpj')) {
            $fornecedores->where('cpf_cnpj', 'like', '%' . $request->input('cpf_cnpj') . '%');
        }

        if ($request->has('telefone')) {
            $fornecedores->where('telefone1', 'like', '%' . $request->input('telefone') . '%');
        }

        $fornecedores = $fornecedores->get();

        return view('fornecedores.index', compact('fornecedores'));
    }

    // Mostrar o formulário de criação
    public function create()
    {
        $estados = Estado::all();
        return view('fornecedores.create', compact('estados'));
    }

    // Armazenar fornecedor
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:F,J',
            'cpf_cnpj' => 'required|string',
            'nome' => 'required|string|max:255',
            'ins_estadual' => 'nullable|string|max:20',
            'ins_municipal' => 'nullable|string|max:20',
            'telefone1' => 'required|string|max:15',
            'telefone2' => 'nullable|string|max:15',
            'logradouro' => 'required|string|max:255',
            'numero' => 'nullable|string|max:10',
            'bairro' => 'required|string|max:100',
            'cep' => 'required|string|max:10',
            'cidade_id' => 'required|exists:cidades,id',

        ]);

        // Remove caracteres não numéricos do campo cpf_cnpj
        $request->merge([
            'cpf_cnpj' => preg_replace('/\D/', '', $request->cpf_cnpj),
        ]);

        Fornecedor::create([
            'tipo' => $request->tipo,
            'cpf_cnpj' => $request->cpf_cnpj,
            'nome' => $request->nome,
            'ins_estadual' => $request->ins_estadual,
            'ins_municipal' => $request->ins_municipal,
            'telefone1' => $request->telefone1,
            'telefone2' => $request->telefone2,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cep' => $request->cep,
            'cidade_id' => $request->cidade_id,
            'status' => 1, // Status ativo por padrão
        ]);

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor criado com sucesso!');
    }

    // Mostrar o formulário de edição
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $estados = Estado::all();
        return view('fornecedores.edit', compact('fornecedor', 'estados'));
    }

    // Atualizar fornecedor
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:F,J',
            'cpf_cnpj' => 'required|string|',
            'nome' => 'required|string|max:255',
            'ins_estadual' => 'nullable|string|max:20',
            'ins_municipal' => 'nullable|string|max:20',
            'telefone1' => 'required|string|max:15',
            'telefone2' => 'nullable|string|max:15',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:100',
            'cep' => 'required|string|max:10',
            'cidade_id' => 'required|exists:cidades,id',
            'status' => 'required|in:0,1'
        ]);

        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->update($request->all());

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    // Desativar fornecedor (status = 0)
    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->update(['status' => 0]);

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor desativado com sucesso!');
    }
}
