<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\ItemOrcamento;
use App\Models\Fornecedor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrcamentoController extends Controller
{
    // Exibe a lista de orçamentos ativos (status = 1)
    public function index(Request $request)
    {
        // Inicia a query para buscar orçamentos
        $query = Orcamento::query();

        // Aplica o filtro de código (id), se fornecido
        if ($request->has('id') && $request->input('id') != '') {
            $query->where('orcamentos.id', $request->input('id'));
        }

        // Aplica o filtro de fornecedor (nome), se fornecido
        if ($request->has('nome') && $request->input('nome') != '') {
            // Faz o join com a tabela fornecedores e filtra pelo nome
            $query->join('fornecedores', 'orcamentos.fornecedor_id', '=', 'fornecedores.id')
                ->where('fornecedores.nome', 'like', '%' . $request->input('nome') . '%');
        }

        // Executa a query e obtém os resultados
        $orcamentos = $query->paginate(10);

        // Retorna a view com os orçamentos
        return view('orcamentos.index', compact('orcamentos'));
    }



    // Exibe o formulário de criação
    public function create()
    {
        $fornecedores = Fornecedor::all();
        return view('orcamentos.create', compact('fornecedores'));
    }

    // Salva um novo orçamento
    public function store(Request $request)
    {
        $request->validate([
            'prazo' => 'required|date',
            'data' => 'required|date',
            'status' => 'required|in:0,1', // 0 = inativo, 1 = ativo
            'fornecedor_id' => 'required|exists:fornecedores,id',
        ]);

        Orcamento::create([
            'prazo' => $request->prazo,
            'data' => $request->data,
            'status' => $request->status,
            'fornecedor_id' => $request->fornecedor_id,
        ]);

        return redirect()->route('orcamentos.index')->with('success', 'Orçamento criado com sucesso!');
    }

    //Exibe o formulário de edição
    public function edit($id)
    {
        // Carregar o orçamento e os itens relacionados
        $orcamento = Orcamento::with('itensOrcamento')->findOrFail($id);

        // Salvar os itens na sessão
        session(['itens_orcamento' => $orcamento->itensOrcamento]);

        return view('orcamentos.edit', compact('orcamento'));
    }



    // Atualiza um orçamento existente
    public function update(Request $request, $id)
    {
        $orcamento = Orcamento::findOrFail($id);

        // Atualiza os campos do orçamento
        $orcamento->update([
            'prazo' => $request->input('prazo'),
            'data' => $request->input('data'),
        ]);

        // Processa os itens do orçamento
        $itens = $request->input('itens'); // Supondo que os itens sejam enviados como um array
        foreach ($itens as $item) {
            // Atualiza ou cria os itens do orçamento
            $orcamento->itensOrcamento()->updateOrCreate([
                'produto_id' => $item['produto_id'],
            ], [
                'quantidade' => $item['quantidade'],
                'valor_unitario' => $item['valor_unitario'],
                'valor_total' => $item['valor_total'],
            ]);
        }

        return redirect()->route('orcamentos.index')->with('success', 'Orçamento atualizado com sucesso!');
    }


    public function destroy($id)
    {
        // Encontra o orçamento pelo ID
        $orcamento = Orcamento::findOrFail($id);

        // Deleta todos os itens associados ao orçamento
        $orcamento->itensOrcamento()->delete();

        // Deleta o orçamento
        $orcamento->delete();

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->route('orcamentos.index')->with('success', 'Orçamento e itens deletados com sucesso!');
    }

    public function buscarFornecedor($codigo)
    {
        $fornecedor = Fornecedor::where('id', $codigo)->first();

        if ($fornecedor) {
            return response()->json([
                'success' => true,
                'nome' => $fornecedor->nome
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function buscarPorNome(Request $request)
    {
        $termo = $request->input('nome');

        // Buscar fornecedores que contêm o termo de pesquisa no nome
        $fornecedores = Fornecedor::where('nome', 'like', "%$termo%")
            ->orWhere('cpf_cnpj', 'like', "%$termo%")
            ->limit(5) // Limitar a quantidade de resultados (ajuste conforme necessário)
            ->get(['id', 'nome', 'cpf_cnpj']); // Selecionando apenas os campos necessários

        return response()->json($fornecedores);
    }

    public function salvarOrcamento(Request $request)
    {
        // Limpar espaços extras no backend antes de salvar
        $totalItens = trim($request->total_itens);

        // Iniciar uma transação para garantir que todas as operações sejam feitas corretamente
        DB::beginTransaction();

        try {
            // 1. Salvar dados na tabela orcamentos (aba Geral e Finalizar)
            $orcamento = Orcamento::create([
                'fornecedor_id' => $request->fornecedor_id,
                'total_itens' => $totalItens,
                'total_orcamento' => $request->total_orcamento,
                'prazo' => $request->prazo,
                'data' => $request->data,
            ]);



            // 2. Salvar itens na tabela itens_orcamentos
            foreach ($request->itens as $item) {
                ItemOrcamento::create([
                    'orcamento_id' => $orcamento->id, // ID do orçamento que foi salvo
                    'produto_id' => $item['produto_id'],
                    'valor_unitario' => $item['estoque'],
                    'quantidade' => $item['quantidade'],
                    'valor_total' => $item['valor_total'],

                ]);
            }

            // Se tudo deu certo, comita a transação
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Orçamento salvo com sucesso.']);
        } catch (\Exception $e) {
            // Se algum erro ocorrer, faz o rollback da transação
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Erro ao salvar orçamento: ' . $e->getMessage()]);
        }
    }

    public function atualizarOrcamento(Request $request, $id)
    {
        // Validação dos dados
        $totalItens = trim($request->total_itens);

        //dd($request->all());



        // Iniciar uma transação para garantir que todas as operações sejam feitas corretamente
        DB::beginTransaction();

        try {
            // 1. Buscar o orçamento a ser atualizado
            $orcamento = Orcamento::findOrFail($id); // Busca o orçamento pelo ID

            // Atualiza os dados na tabela orcamentos (aba Geral e Finalizar)
            $orcamento->update([
                'fornecedor_id' => $request->fornecedor_id,
                'total_itens' => $totalItens,
                'total_orcamento' => $request->total_orcamento,
                'prazo' => $request->prazo,
                'data' => $request->data,
                'status' => $request->status,
            ]);

            // 2. Atualizar os itens na tabela itens_orcamentos
            // Primeiramente, excluir os itens antigos
            ItemOrcamento::where('orcamento_id', $orcamento->id)->delete();

            // Agora, adicionar os novos itens
            foreach ($request->itens as $item) {
                ItemOrcamento::create([
                    'orcamento_id' => $orcamento->id,
                    'produto_id' => $item['produto_id'],
                    'valor_unitario' => $item['estoque'],
                    'quantidade' => $item['quantidade'],
                    'valor_total' => $item['valor_total'],
                    'observacao' => $item['observacao'],
                ]);
            }

            // Se tudo deu certo, comita a transação
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Orçamento atualizado com sucesso.']);
        } catch (\Exception $e) {
            // Se algum erro ocorrer, faz o rollback da transação
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Erro ao atualizar orçamento: ' . $e->getMessage()]);
        }
    }


    public function generatePdf($orcamentoId)
    {
        // Buscar os dados do orçamento, fornecedor e itens
        $orcamento = Orcamento::findOrFail($orcamentoId);
        $fornecedor = Fornecedor::findOrFail($orcamento->fornecedor_id);
        $itens = ItemOrcamento::where('orcamento_id', $orcamentoId)->get();

        // Caminho da logo
        $logo = public_path('assets/img/logo_.png'); // Ajuste o caminho conforme necessário \public\assets\img

        // Passar os dados para o template
        $data = [
            'orcamento' => $orcamento,
            'fornecedor' => $fornecedor,
            'itens' => $itens,
            'logo' => $logo, // Passar o caminho da logo
        ];

        // Gerar o PDF
        $pdf = Pdf::loadView('orcamentos.pdf', $data);

        // Abrir o PDF em uma nova aba
        return $pdf->stream('orcamento.pdf');
    }
}
