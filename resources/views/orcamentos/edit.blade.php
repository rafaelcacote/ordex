@extends('layouts.default')


@section('content')
    <div class="card">
        <form class="row g-3 cadastro" method="POST" action="{{ route('orcamentos.update', $orcamento->id) }}" novalidate>
            @csrf
            @method('PUT')
            <div class="pagetitle">

                <button type="submit" class="btn btn-success salvar"><i class="bi bi-save2 me-1"></i> SALVAR</button>
                <a href="{{ route('orcamentos.index') }}" class="btn btn-danger cancelar"><i class="bi bi-backspace me-1"></i>
                    CANCELAR</a>
                <h1>Cotação - Editar</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Financeiro</li>
                        <li class="breadcrumb-item active">Cotação</li>
                    </ol>
                </nav>
            </div>
            @error('mensagem')
                <div class="alert alert-danger" role="alert" id="mensagemErro">
                    {{ $message }}
                </div>
            @enderror
            <!-- -- Final do Titulo da Pagina -- -->

            <!-- Campos -->
            <div class="card-body">
                <!-- Bordered Tabs Justified -->
                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home"
                            aria-selected="false" tabindex="-1">Geral</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#bordered-justified-profile" type="button" role="tab"
                            aria-controls="profile" aria-selected="false" tabindex="-1">Itens</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                            data-bs-target="#bordered-justified-contact" type="button" role="tab"
                            aria-controls="contact" aria-selected="true">Finalizar</button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                    <div class="tab-pane fade active show" id="bordered-justified-home" role="tabpanel"
                        aria-labelledby="home-tab">
                        <!-- Primeira Linha: Código e Nome -->
                        <div class="row mb-3 mt-4">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="codigo"><strong>Código</strong></label>
                                    <input type="text" name="codigo" id="codigo" class="form-control"
                                        value="{{ $orcamento->fornecedor_id }}" readonly style="background-color: #e9ecef;">
                                    <input type="hidden" name="orcamento_id" id="orcamento_id"
                                        value="{{ $orcamento->id }}">

                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="nome"><strong>Fornecedor</strong></label>
                                    <input type="text" name="nome" id="nome" class="form-control"
                                        value="{{ $orcamento->fornecedor->nome }}" readonly style="background-color: #e9ecef;">
                                </div>
                            </div>
                            <div class="row mb-3 mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status"><strong>Status</strong></label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="Aberto" {{ $orcamento->status == 'Aberto' ? 'selected' : '' }}>
                                                Aberto</option>
                                            <option value="Enviado" {{ $orcamento->status == 'Enviado' ? 'selected' : '' }}>
                                                Enviado</option>
                                            <option value="Respondido"
                                                {{ $orcamento->status == 'Respondido' ? 'selected' : '' }}>Respondido
                                            </option>
                                            <option value="Finalizado"
                                                {{ $orcamento->status == 'Finalizado' ? 'selected' : '' }}>Finalizado
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prazo"><strong>Prazo</strong></label>
                                        <input type="date" name="prazo" id="prazo" class="form-control"
                                            value="{{ $orcamento->prazo }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data"><strong>Data</strong></label>
                                        <input type="date" name="data" id="data" class="form-control"
                                            value="{{ $orcamento->data }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <div class="row mb-3 mt-4">
                            <!-- Campo Código Produto -->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="codigo_produto"><strong>Código</strong></label>
                                    <input type="text" name="codigo_produto" id="codigo_produto"
                                        class="form-control">
                                    <input type="hidden" name="produto_id" id="produto_id">
                                </div>
                            </div>

                            <!-- Campo Nome Produto -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome_produto"><strong>Produto</strong></label>
                                    <input type="text" name="nome_produto" id="nome_produto" class="form-control"
                                        autocomplete="off">
                                    <div class="alert alert-warning alert-dismissible fade show invalid-feedback mt-3"
                                        id="produto-error" role="alert" style="display: none;">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        Produto não encontrado!
                                    </div>
                                </div>
                            </div>
                            <!-- Aqui vai aparecer a tabela com produtos -->
                            <div id="produto-table-container"
                                style="display: none; position: absolute; top: 100%; left: 0; max-height: 200px; overflow-y: auto; background: #fff; border: 1px solid #ccc; width: calc(55% - 20px); z-index: 100;">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="produto-list"></tbody>
                                </table>
                            </div>

                            <!-- Campo Valor Produto -->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="estoque"><strong>Valor</strong></label>
                                    <input type="text" name="estoque_produto" id="estoque_produto"
                                        class="form-control" readonly>
                                </div>
                            </div>

                            <!-- Campo Quantidade -->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="quantidade"><strong>Quantidade</strong></label>
                                    <input type="text" name="quantidade" id="quantidade" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- Tabela de Itens Inseridos -->
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered" id="itens-inseridos">
                                <thead>
                                    <tr>
                                        <th>Cód</th>
                                        <th>Produto</th>
                                        <th>Valor</th>
                                        <th>Quantidade</th>
                                        <th>Valor Total</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="itens-list">
                                    @foreach (session('itens_orcamento', []) as $item)
                                        <tr data-produto-id="{{ $item->produto_id }}">
                                            <td>{{ $item->produto->codigo }}</td>
                                            <td>{{ $item->produto->nome }} <br>
                                             <!-- Adiciona a observação abaixo do nome do produto -->
                                             @if ($item->observacao)
                                                <span class="small-text text-muted" title="{{ $item->observacao }}"
                                                    style="font-size: 9px;">
                                                    <strong>{{ $item->observacao }}</strong>
                                                </span>
                                            @endif
                                        </td>
                                            <td>{{ $item->produto->estoque }}</td>
                                            <td>{{ $item->quantidade }}</td>
                                            <td>{{ $item->valor_total }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm edit-item">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm delete-item">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Total de itens -->
                            <div class="foote-class">
                                <span class="font-bold">Quant. Itens:<span id="total-quantidade"
                                        class="font-bold">{{ $orcamento->itensOrcamento->count() }}</span> </span>
                                <br>
                                <span class="font-bold">Total dos Itens: R$<span id="total-valores"
                                        class="font-bold">{{ $orcamento->total_orcamento }}</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bordered-justified-contact" role="tabpanel"
                        aria-labelledby="contact-tab">
                        <div class="row mb-3 mt-4">
                            <div class="col-md-12">
                                <label for="observacao" class="form-label"><strong>Observação</strong></label>
                                <textarea class="form-control" id="observacao" name="observacao" autocomplete="off">{{ old('observacao', $orcamento->observacao) }}</textarea>
                            </div>
                        </div>
                    </div><!-- End Bordered Tabs Justified -->

                </div>
            </div>
        </form>
    </div>



<!-- Modal de Sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Sucesso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Erro -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Erro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="errorMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal para editar observação -->
<div class="modal fade" id="observacaoModal" tabindex="-1" aria-labelledby="observacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="observacaoModalLabel">Editar Observação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea id="observacaoText" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="salvarObservacao">Salvar</button>
            </div>
        </div>
    </div>
</div>

    {{-- pesquisa pelo codigo do produto --}}
    <script>
        const codigoprodutoInput = document.getElementById('codigo_produto');
        const produtoError = document.getElementById('produto-error');
        const estoqueprodutoInput = document.getElementById('estoque_produto');
        const nomeprodutoInput = document.getElementById('nome_produto');
        const quantidadeprodutoInput = document.getElementById('quantidade');
        const idprodutoInput = document.getElementById('produto_id');

        // Função para pesquisar produto pelo código
        codigoprodutoInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                let codigo = codigoprodutoInput.value;

                if (codigo) {
                    fetch(`{{ route('buscar.produto.codigo', '') }}/${codigo}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                nomeprodutoInput.value = data.nome;
                                estoqueprodutoInput.value = data.estoque;
                                idprodutoInput.value = data.id;
                                quantidadeprodutoInput.focus();
                                produtoError.style.display = 'none';
                            } else {
                                nomeprodutoInput.focus();
                                codigoprodutoInput.value = "";
                                nomeprodutoInput.value = "";
                                produtoError.style.display = 'block';

                                setTimeout(function() {
                                    produtoError.style.display = 'none';
                                }, 3000);
                            }
                        })
                        .catch(error => {
                            console.error("Erro ao buscar produto:", error);
                            produtoError.style.display = 'block';

                            setTimeout(function() {
                                produtoError.style.display = 'none';
                            }, 1000);
                        });
                } else {
                    nomeprodutoInput.focus();
                    produtoError.style.display = 'none';
                }
            }
        });
    </script>


    {{-- pesquisa pelo nome do produto --}}
    <script>
        // Variáveis dos elementos

        const produtoTableContainer = document.getElementById('produto-table-container');
        const produtoList = document.getElementById('produto-list');
        let currentIndex = -1;

        // Função para buscar produtos enquanto o usuário digita no nome_produto
        nomeprodutoInput.addEventListener('input', function() {
            const termo = nomeprodutoInput.value;
            const rect = nomeprodutoInput.getBoundingClientRect(); // Pega a posição do campo nome_produto

            if (termo.length >= 3) {
                fetch("{{ route('buscar.produto.nome') }}?nome=" + encodeURIComponent(termo))
                    .then(response => response.json())
                    .then(data => {
                        produtoList.innerHTML = '';
                        if (data.length > 0) {
                            produtoTableContainer.style.display = 'block';
                            // Posiciona a tabela abaixo do campo
                            produtoTableContainer.style.left = `${rect.left}px`;
                            produtoTableContainer.style.top = `${rect.bottom + window.scrollY}px`;

                            data.forEach((produto, index) => {
                                const tr = document.createElement('tr');
                                tr.classList.add('produto-item');
                                tr.setAttribute('data-id', produto.id);
                                tr.setAttribute('data-codigo', produto.codigo);
                                tr.setAttribute('data-nome', produto.nome);
                                tr.setAttribute('data-estoque', produto.estoque);

                                tr.innerHTML = `
                                <td>${produto.codigo}</td>
                                <td>${produto.nome}</td>
                                <td>${produto.estoque}</td>
                            `;

                                tr.addEventListener('click', function() {
                                    nomeprodutoInput.value = produto.nome;
                                    codigoprodutoInput.value = produto.codigo;
                                    estoqueprodutoInput.value = produto.estoque;
                                    idprodutoInput.value = produto.id;
                                    produtoTableContainer.style.display = 'none';
                                });

                                produtoList.appendChild(tr);
                            });
                        } else {
                            produtoTableContainer.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar produtos:', error);
                    });
            } else {
                produtoTableContainer.style.display = 'none';
            }
        });

        // Navegação com as setas do teclado
        nomeprodutoInput.addEventListener('keydown', function(event) {
            const rows = document.querySelectorAll('.produto-item');
            const totalRows = rows.length;

            if (event.key === 'ArrowDown') {
                if (currentIndex < totalRows - 1) {
                    currentIndex++;
                    highlightRow(rows);
                }
            } else if (event.key === 'ArrowUp') {
                if (currentIndex > 0) {
                    currentIndex--;
                    highlightRow(rows);
                }
            } else if (event.key === 'Enter' && currentIndex >= 0) {
                const selectedRow = rows[currentIndex];
                const codigo = selectedRow.getAttribute('data-codigo');
                const nome = selectedRow.getAttribute('data-nome');
                const estoque = selectedRow.getAttribute('data-estoque');
                const produtoId = selectedRow.getAttribute('data-id');

                nomeprodutoInput.value = nome;
                codigoprodutoInput.value = codigo;
                estoqueprodutoInput.value = estoque;
                idprodutoInput.value = produtoId;
                quantidadeprodutoInput.value = 1;
                quantidadeprodutoInput.focus();

                produtoTableContainer.style.display = 'none';
            }
        });

        // Função para destacar a linha selecionada
        function highlightRow(rows) {
            rows.forEach((row, index) => {
                if (index === currentIndex) {
                    row.classList.add('table-active');
                } else {
                    row.classList.remove('table-active');
                }
            });
        }
    </script>


    <!-- Script de Adição de Itens -->
    <script>
        // const quantidadeprodutoInput = document.getElementById('quantidade');
        // const codigoprodutoInput = document.getElementById('codigo_produto');
        // const nomeprodutoInput = document.getElementById('nome_produto');
        //const estoqueprodutoInput = document.getElementById('estoque_produto');
        const produtoIdInput = document.getElementById('produto_id');
        const erroItem = document.getElementById('produto-error');
        const itensList = document.getElementById('itens-list');




        quantidadeprodutoInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Evita o comportamento padrão de "Enter"

                // Verifica se os campos necessários estão preenchidos
                const codigo = codigoprodutoInput.value;
                const nome = nomeprodutoInput.value;
                const estoque = estoqueprodutoInput.value;
                const quantidade = quantidadeprodutoInput.value;
                const produtoId = produtoIdInput.value;

                // Reseta as mensagens de erro
                erroItem.style.display = 'none';

                if (!codigo || !nome || !estoque) {
                    erroItem.style.display = 'block';
                    setTimeout(function() {
                        erroItem.style.display = 'none';
                    }, 1000);
                } else if (!quantidade) {
                    erroQuantidade.style.display = 'block';
                    setTimeout(function() {
                        erroQuantidade.style.display = 'none';
                    }, 1000);
                } else {
                    // Verificar se o item já existe na tabela
                    const existingItems = document.querySelectorAll('#itens-list tr');
                    let itemExists = false;

                    existingItems.forEach(function(row) {
                        const itemId = row.getAttribute('data-produto-id');
                        if (itemId === produtoId) {
                            itemExists = true;
                        }
                    });

                    // Verifica se o item já foi adicionado
                    // if (itemExists) {
                    //     alert('Este item já foi adicionado.');
                    //     return; // Impede a adição do item novamente
                    // }

                    // Se o item não existir, prossegue com a adição à tabela
                    const total = parseFloat(estoque) * parseInt(quantidade);

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td>${codigo}</td>
                    <td>${nome}</td>
                    <td>${estoque}</td>
                    <td>${quantidade}</td>
                    <td>${total.toFixed(2)}</td>
                    <td>
                         <button type="button" class="btn btn-warning btn-sm edit-item" data-id="${produtoId}">
            <i class="bi bi-pencil"></i>
        </button>
                        <button class="btn btn-danger btn-sm delete-item"><i class="bi bi-trash"></i></button></td>
                `;
                    tr.setAttribute('data-produto-id', produtoId);

                    // Adiciona a nova linha à tabela de itens
                    itensList.appendChild(tr);

                    atualizarTotais();

                    // Limpa os campos após adicionar o item
                    codigoprodutoInput.value = '';
                    nomeprodutoInput.value = '';
                    estoqueprodutoInput.value = '';
                    quantidadeprodutoInput.value = '';
                    produtoIdInput.value = '';
                }
            }
        });
    </script>

    <!-- Script de Remoção de Itens -->
    <script>
        itensList.addEventListener('click', function(event) {
            if (event.target.closest('.delete-item')) {
                const row = event.target.closest('tr');
                row.remove();
                atualizarTotais();
            }
        });
    </script>

    <!-- Script de Atualização dos Totais -->
    <script>
        function atualizarTotais() {
            let totalQuantidade = 0;
            let totalValores = 0;

            document.querySelectorAll('#itens-list tr').forEach(row => {
                const quantidade = parseInt(row.children[3].textContent);
                const valorTotal = parseFloat(row.children[4].textContent);
                totalQuantidade += quantidade;
                totalValores += valorTotal;
            });

            document.getElementById('total-quantidade').textContent = totalQuantidade;
            document.getElementById('total-valores').textContent = totalValores.toLocaleString('pt-BR', {
                style: 'decimal',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    </script>

    {{-- lógica para abrir o modal e salvar a observação --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const itensList = document.getElementById('itens-list'); // Tabela de itens
        let currentRow = null; // Linha atual sendo editada

        // Função para abrir o modal de edição de observação
        function openObservacaoModal(row) {
            const observacao = row.getAttribute('data-observacao') || ''; // Recupera a observação atual
            document.getElementById('observacaoText').value = observacao; // Preenche o textarea
            currentRow = row; // Armazena a linha atual
            const modal = new bootstrap.Modal(document.getElementById('observacaoModal'));
            modal.show(); // Abre o modal
        }

        // Adicionar evento de clique ao botão de editar (usando delegação de eventos)
        itensList.addEventListener('click', function(event) {
            const editButton = event.target.closest('.edit-item');
            if (editButton) {
                const row = editButton.closest('tr'); // Captura a linha correspondente
                openObservacaoModal(row); // Abre o modal para editar a observação
            }
        });

        // Salvar a observação quando o botão de salvar no modal for clicado
        document.getElementById('salvarObservacao').addEventListener('click', function() {
            const observacao = document.getElementById('observacaoText').value; // Captura a observação
            if (currentRow) {
                const nomeCell = currentRow.querySelector('td:nth-child(2)'); // Célula do nome do produto

                // Verifica se já existe uma observação na célula
                const existingObservacao = nomeCell.querySelector('.small-text');

                if (observacao) {
                    // Se já existe uma observação, atualiza o texto
                    if (existingObservacao) {
                        existingObservacao.innerHTML = `<strong>${observacao}</strong>`;
                    } else {
                        // Se não existe uma observação, adiciona o <br> e a observação
                        nomeCell.innerHTML += `
                            <br>
                            <span class="small-text text-muted" title="${observacao}" style="font-size: 9px;">
                                <strong>${observacao}</strong>
                            </span>
                        `;
                    }
                } else {
                    // Se a observação estiver vazia, remove o <br> e a observação
                    if (existingObservacao) {
                        existingObservacao.remove(); // Remove a observação
                        const brElement = nomeCell.querySelector('br');
                        if (brElement) {
                            brElement.remove(); // Remove o <br>
                        }
                    }
                }

                // Atualiza o atributo data-observacao da linha
                currentRow.setAttribute('data-observacao', observacao);
                const modal = bootstrap.Modal.getInstance(document.getElementById('observacaoModal'));
                modal.hide(); // Fecha o modal
            }
        });
    });
</script>

    <!-- Script de Submissão dos Dados para o Backend -->
    <script>
        document.querySelector('.btn-success').addEventListener('click', function(event) {
            event.preventDefault();

            const itensList = document.querySelectorAll('#itens-list tr');

            const totalValores = document.getElementById('total-valores').textContent
                .replace('R$', '')
                .replace(/\./g, '')
                .replace(',', '.');

            // Verifica se há itens na lista
            if (itensList.length === 0) {
                showErrorModal('Nenhum produto foi adicionado. Por favor, adicione pelo menos um produto.');
                return;
            }

            const itens = [];
            itensList.forEach(row => {
                const produtoId = row.getAttribute('data-produto-id');
                const estoque = row.children[2].textContent;
                const quantidade = row.children[3].textContent;
                const valorTotal = row.children[4].textContent;
                //const observacao = row.getAttribute('data-observacao') || ''; // Observação
                const observacao = row.querySelector('span.small-text') ? row.querySelector('span.small-text').textContent : '';  // Ajuste para pegar corretamente a observação.
                    ''; // Pega o texto do span da observação
                // const valorTotal = row.children[4].textContent
                // .replace('R$', '')
                // .replace(/\./g, '')
                // .replace(',', '.');

                itens.push({
                    produto_id: produtoId,
                    estoque: estoque,
                    quantidade: quantidade,
                    valor_total: valorTotal,
                    observacao: observacao
                });
            });

            const dataToSend = {
                fornecedor_id: document.getElementById('codigo')
                    .value, // Pegue o fornecedor_id de algum lugar do seu form
                total_itens: itens.length,
                total_orcamento: calcularTotalOrcamento(itens),
                prazo: document.getElementById('prazo').value,
                data: document.getElementById('data').value,
                itens: itens,
                status: document.getElementById('status').value,
                observacao: document.getElementById('observacao').value
            };

            // Aqui você precisa pegar o ID do orçamento que você deseja atualizar (exemplo, orcamentoId)
            const orcamentoId = document.getElementById('orcamento_id')
                .value; // Supondo que você tenha esse campo no seu form

            // Envia os dados para o backend
            const updateUrl = "{{ route('orcamento.atualizar', ':orcamentoId') }}".replace(':orcamentoId', orcamentoId);


            // Envia os dados para o backend
            fetch(updateUrl, { // Ajuste a URL para a de atualização
                    method: 'PUT', // Mudamos o método para PUT (para atualizar)
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                    },
                    body: JSON.stringify(dataToSend),
                })
                .then(response => response.json())
                .then(data => {
                    const orcamentosIndexRoute = "{{ route('orcamentos.index') }}";
                    if (data.success) {
                        // Exibe a mensagem de sucesso
                        showSuccessModal('Orçamento salvo com sucesso!');
                        // Redireciona para a página de orçamentos após um pequeno delay
                        setTimeout(() => {
                            window.location.href = routeOrcamentos;
                        }, 2000); // 2 segundos de delay
                    } else {
                        showErrorModal('Erro ao salvar orçamento: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showErrorModal('Erro inesperado ao atualizar orçamento');
                });
        });

        // Função para calcular o total do orçamento
        function calcularTotalOrcamento(itens) {
            return itens.reduce((total, item) => total + parseFloat(item.valor_total), 0);
        }

                  // Função para exibir o modal de sucesso
                  function showSuccessModal(message) {
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                document.getElementById('successMessage').textContent = message;
                successModal.show();
            }

            // Função para exibir o modal de erro
            function showErrorModal(message) {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                document.getElementById('errorMessage').textContent = message;
                errorModal.show();
            }
    </script>
@endsection
