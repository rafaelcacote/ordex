<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Cidade;
use App\Models\Estado;
use Illuminate\Http\Request;
use App\Http\Requests\Fornecedores\StoreFornecedorRequest;
use App\Http\Requests\Fornecedores\UpdateFornecedorRequest;

class FornecedorController extends Controller
{
    // Listar fornecedores
    public function index(Request $request)
    {
        $query = Fornecedor::where('status', 1);

        if ($request->has('nome')) {
            $query->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        if ($request->has('cpf_cnpj')) {
            $query->where('cpf_cnpj', 'like', '%' . $request->input('cpf_cnpj') . '%');
        }

        $fornecedores = $query->paginate(10);

        return view('fornecedores.index', compact('fornecedores'));
    }

    // Mostrar o formulário de criação
    public function create()
    {
        $estados = Estado::all();


        return view('fornecedores.create', compact('estados'));
    }

    // Armazenar fornecedor
    public function store(StoreFornecedorRequest $request)
    {
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
        $cidades = Cidade::all();
        return view('fornecedores.edit', compact('fornecedor', 'estados', 'cidades'));
    }

    // Atualizar fornecedor
    public function update(UpdateFornecedorRequest $request, $id)
    {

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

    // EstadoController.php
    public function getIdByUf($uf)
    {
        // Busca o estado pela sigla (UF)
        $estado = Estado::where('sgl', $uf)->first();

        if ($estado) {
            return response()->json(['id' => $estado->id]);
        }

        return response()->json(['id' => null], 404);
    }

    public function getCidades($estado_id)
    {
        // Verifica se o estado existe
        $cidades = Cidade::where('estado_id', $estado_id)->get();

        // Verifica se foram encontradas cidades
        if ($cidades->isEmpty()) {
            return response()->json(['message' => 'Nenhuma cidade encontrada para este estado'], 404);
        }

        // Retorna as cidades no formato JSON
        return response()->json($cidades);
    }
}
