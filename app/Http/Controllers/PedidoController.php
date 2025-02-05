<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\FormaPagamento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    // Exibe a lista de pedidos
    public function index(Request $request)
    {

        $query = Pedido::query();

        // Filtros condicionais
        if ($request->input('codigo')) {
            $query->where('id', $request->input('codigo'));
        }

        // Aplica o filtro de fornecedor (nome), se fornecido
        if ($request->has('nome') && $request->input('nome') != '') {
            // Faz o join com a tabela fornecedores e filtra pelo nome
            $query->join('fornecedores', 'pedidos.fornecedor_id', '=', 'fornecedores.id')
                ->where('fornecedores.nome', 'like', '%' . $request->input('nome') . '%');
        }

        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }

        $pedidos = $query->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        $formaPagamentos = FormaPagamento::all();
        $fornecedores = Fornecedor::all();
        return view('pedidos.create', compact('fornecedores', 'formaPagamentos'));
    }

    public function salvarPedido(Request $request)
    {
        // Limpar espaços extras no backend antes de salvar
        $totalItens = trim($request->total_itens);

        // Iniciar uma transação para garantir que todas as operações sejam feitas corretamente
        DB::beginTransaction();

        try {
            // 1. Salvar dados na tabela orcamentos (aba Geral e Finalizar)
            $pedido = Pedido::create([
                'user_id' => auth()->user()->id,
                'fornecedor_id' => $request->fornecedor_id,
                'total_itens' => $totalItens,
                'total_pedido' => $request->total_pedido,
                'prazo' => $request->prazo,
                'data' => $request->data,
                'hora' => now()->format('H:i:s'),
                'status' => 'Aberto',
                'observacao' => $request->observacao,
            ]);



            // 2. Salvar itens na tabela itens_orcamentos
            foreach ($request->itens as $item) {
                ItemPedido::create([
                    'pedido_id' => $pedido->id, // ID do orçamento que foi salvo
                    'produto_id' => $item['produto_id'],
                    'valor_unitario' => $item['estoque'],
                    'quantidade' => $item['quantidade'],
                    'valor_total' => $item['valor_total'],

                ]);
            }

            // Se tudo deu certo, comita a transação
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pedido salvo com sucesso.']);
        } catch (\Exception $e) {
            // Se algum erro ocorrer, faz o rollback da transação
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Erro ao salvar Pedido: ' . $e->getMessage()]);
        }
    }



    // Exibe o formulário de edição
    public function edit($id)
    {
        // Carregar o orçamento e os itens relacionados
        $pedido = Pedido::with('itensPedido')  // Carrega os itens do pedido
            ->join('users', 'pedidos.user_id', '=', 'users.id')  // Faz o join com a tabela users
            ->select('pedidos.*', 'users.name as usuario_nome', 'users.email as usuario_email')  // Seleciona as colunas necessárias
            ->findOrFail($id);

        // Salvar os itens na sessão
        session(['itens_pedido' => $pedido->itensPedido]);

        return view('pedidos.edit', compact('pedido'));
    }

    public function atualizarPedido(Request $request, $id)
    {
        // Validação dos dados
        $totalItens = trim($request->total_itens);

        //dd($request->all());
        // Iniciar uma transação para garantir que todas as operações sejam feitas corretamente
        DB::beginTransaction();

        try {
            // 1. Buscar o orçamento a ser atualizado
            $pedido = Pedido::findOrFail($id); // Busca o orçamento pelo ID

            // Atualiza os dados na tabela pedidos (aba Geral e Finalizar)
            $pedido->update([
                'fornecedor_id' => $request->fornecedor_id,
                'total_itens' => $totalItens,
                'total_pedido' => $request->total_pedido,
                'prazo' => $request->prazo,
                'data' => $request->data,
                'status' => $request->status,
            ]);

            // 2. Atualizar os itens na tabela itens_pedidos
            // Primeiramente, excluir os itens antigos
            ItemPedido::where('pedido_id', $pedido->id)->delete();

            // Agora, adicionar os novos itens
            foreach ($request->itens as $item) {
                ItemPedido::create([
                    'pedido_id' => $pedido->id,
                    'produto_id' => $item['produto_id'],
                    'valor_unitario' => $item['estoque'],
                    'quantidade' => $item['quantidade'],
                    'valor_total' => $item['valor_total'],
                    'observacao' => $item['observacao'],
                ]);
            }

            // Se tudo deu certo, comita a transação
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pedido atualizado com sucesso.']);
        } catch (\Exception $e) {
            // Se algum erro ocorrer, faz o rollback da transação
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Erro ao atualizar orçamento: ' . $e->getMessage()]);
        }
    }



    // Atualiza um pedido existente
    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $pedido->update([
            'data' => $request->data,
            'status' => $request->status,
            'observacao' => $request->observacao,
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    // Exclui um pedido
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->itensPedido()->delete();
        $pedido->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido e itens deletados com sucesso!');
    }

    // Gera o PDF do pedido
    public function generatePdf($pedidoId)
    {
        $pedido = Pedido::findOrFail($pedidoId);
        $fornecedor = Fornecedor::findOrFail($pedido->fornecedor_id);
        $itens = ItemPedido::where('pedido_id', $pedidoId)->get();
        $logo = public_path('assets/img/logo_.png');

        $data = [
            'pedido' => $pedido,
            'fornecedor' => $fornecedor,
            'itens' => $itens,
            'logo' => $logo,
        ];

        $pdf = Pdf::loadView('pedidos.pdf', $data);
        return $pdf->stream('pedido.pdf');
    }


    public function calcularParcelas(Request $request)
    {
        $numeroParcelas = (int) $request->input('numero_parcelas');
        $diasEntreParcelas = (int) $request->input('numero_dias');
        $valorTotal = (float) $request->input('valor_total');
        $valorRecebido = (float) $request->input('valor_recebido');

        $dataAtual = date('Y-m-d');
        $parcelas = [];
        $aReceber = 0;

        if ($valorRecebido < $valorTotal) {
            $aReceber = $valorTotal - $valorRecebido;
        }

        $valorPorParcela = round($valorRecebido / $numeroParcelas, 2);
        $restantePorParcela = round($aReceber / $numeroParcelas, 2);

        for ($i = 1; $i <= $numeroParcelas; $i++) {
            $dataParcela = date('d/m/Y', strtotime("+" . ($diasEntreParcelas * ($i - 1)) . " days", strtotime($dataAtual)));
            $valorParcela = $i === $numeroParcelas ? ($valorPorParcela + $restantePorParcela) : $valorPorParcela;

            $parcelas[] = [
                'parcela' => $i,
                'valor' => $valorParcela,
                'data_vencimento' => $dataParcela,
            ];
        }

        return response()->json([
            'parcelas' => $parcelas,
            'aReceber' => $aReceber,
        ]);
    }
}
