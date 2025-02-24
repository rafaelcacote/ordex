@extends('layouts.default')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form class="row g-3 cadastro" method="POST" action="{{ route('pedidos.store') }}" novalidate>
                    @csrf

                    <div class="pagetitle">

                        <button type="submit" class="btn btn-success salvar"><i class="bi bi-save2 me-1"></i> SALVAR</button>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-danger cancelar"><i
                                class="bi bi-backspace me-1"></i> CANCELAR</a>
                        <h1>Pedido - Adicionar</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item">Financeiro</li>
                                <li class="breadcrumb-item active">Pedido</li>
                            </ol>
                        </nav>

                    </div>

                    @error('mensagem')
                        <div class="alert alert-danger" role="alert" id="mensagemErro">
                            {{ $message }}

                        </div>
                    @enderror
                    <!-- -- Final do Titulo da Pagina -- -->

                    <!-- -- Campos do Formuário -- -->
                    <div class="card-body">
                        <!--ABAS -->
                        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#bordered-justified-home" type="button" role="tab"
                                    aria-controls="home" aria-selected="false" tabindex="-1">Geral</button>
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
                            <!-- ABA GERAL -->
                            <div class="tab-pane fade active show" id="bordered-justified-home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row mb-3 mt-4">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="codigo"><strong>Código</strong></label>
                                            <input type="text" name="codigo" id="codigo"
                                                class="form-control @error('codigo') is-invalid @enderror"
                                                value="{{ old('codigo') }}" autocomplete="off">
                                            @error('codigo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="nome"><strong>Fornecedor</strong></label>
                                            <input type="text" name="nome" id="nome" class="form-control"
                                                value="{{ old('nome') }}" autocomplete=off>
                                            <div class="alert alert-warning alert-dismissible fade show invalid-feedback mt-3"
                                                id="fornecedor-error" role="alert" style="display: none;">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                Fornecedor não encontrado!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            <!-- Aqui vai aparecer a tabela com fornecedores -->
                                            <div id="fornecedor-table-container"
                                                style="display: none; position: absolute; max-height: 300px; overflow-y: auto; background: #fff; border: 1px solid #ccc;">
                                                <table class="table table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Nome</th>
                                                            <th>CPF/CNPJ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="fornecedor-list"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 mt-3">
                                        <div class="form-group">
                                            <label for="data"><strong>Data</strong></label>
                                            <input type="date" name="data" id="data" class="form-control"
                                                value="{{ old('data') }}" autocomplete=off>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ABA ITENS --}}
                            <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div class="row m b-3 mt-4">
                                    <!-- Campo Código Produto -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="codigo_produto"><strong>Código</strong></label>
                                            <input type="text" name="codigo_produto" id="codigo_produto"
                                                class="form-control" value="{{ old('codigo_produto') }}">
                                            <input type="hidden" name="produto_id" id="produto_id">

                                        </div>
                                    </div>


                                    <!-- Campo Produto -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nome_produto"><strong>Produto</strong></label>
                                            <input type="text" name="nome_produto" id="nome_produto"
                                                class="form-control" value="{{ old('nome_produto') }}"
                                                autocomplete="off">
                                            <div class="alert alert-warning alert-dismissible fade show invalid-feedback mt-3"
                                                id="produto-error" role="alert" style="display: none;">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                Produto não encontrado!
                                            </div>
                                              <!-- Aqui vai aparecer a tabela com produtos -->
                                              <div id="produto-table-container"
                                              style="display: none; position: absolute; margin-right:-100px; max-height: 300px; overflow-y: auto; background: #fff; border: 1px solid #ccc;">
                                               <table class="table table-hover">
                                                   <thead>
                                                       <tr>
                                                           <th scope="col">Código</th>
                                                           <th scope="col">Nome</th>
                                                           <th scope="col">Valor</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody id="produto-list"></tbody>
                                               </table>
                                           </div>
                                            <!-- Mensagem de erro para item não selecionado -->
                                            <div class="alert alert-warning" id="erro-item"
                                                style="display: none; margin-top: 10px;">
                                                <i class="bi bi-exclamation-triangle me-1"></i> Nenhum Produto selecionado.
                                                Por
                                                favor, escolha um produto.
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Campo Valor Produto -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="estoque"><strong>Valor</strong></label>
                                            <input type="text" name="estoque_produto" id="estoque_produto"
                                                class="form-control" value="{{ old('estoque') }}" readonly>
                                        </div>
                                    </div>

                                    <!-- Campo Quantidade -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="quantidade"><strong>Quantidade</strong></label>
                                            <input type="text" name="quantidade" id="quantidade" class="form-control"
                                                value="{{ old('quantidade') }}">
                                            <!-- Mensagem de erro para quantidade não preenchida -->
                                            <div class="alert alert-warning" id="erro-quantidade"
                                                style="display: none; margin-top: 10px;">
                                                <i class="bi bi-exclamation-triangle me-1"></i> Informe a quantidade.
                                            </div>
                                        </div>
                                    </div>

                                <!-- Tabela de Itens Inseridos -->
                                <div class="col-md-12 table-responsive mt-4">
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
                                        <tbody id="itens-list"></tbody>
                                    </table>
                                    <!-- Total de itens -->
                                    <div class="foote-class">
                                        <span class="font-bold">Quant. Itens:<span id="total-quantidade"
                                                class="font-bold">0</span> </span>

                                        <br>
                                        <span class="font-bold">Total dos Itens: R$<span id="total-valores"
                                                class="font-bold">0.00</span></span>

                                    </div>
                                </div>
                            </div>
                            </div>
                            {{-- ABA FINALIZAR --}}
                            <div class="tab-pane fade" id="bordered-justified-contact" role="tabpanel"
                                aria-labelledby="contact-tab">
                                <div class="row mb-3 mt-4">
                                    <div class="col-md-12">
                                        <label for="observacao" class="form-label"><strong>Observação</strong></label>
                                        <textarea class="form-control " id="observacao" name="observacao"value="{{ old('observacao') }}" autocomplete=off>  </textarea>
                                    </div>
                                </div>

                                <div class="row mb-3 mt-4">
                                    <!-- Campo oculto para o valor total dos itens -->
                                    <input type="hidden" id="valor-total-itens" value="">

                                    <!-- Formulário para Escolha da Forma de Pagamento -->
                                    <div class="col-md-4">
                                        <label for="forma-pagamento">Forma de Pagamento</label>
                                        <select name="forma_pagamento_id " id="forma-pagamento" class="form-select me-2 rounded @error('forma_pagamento_id ') is-invalid @enderror ">
                                            <option value="">Selecione uma categoria</option>
                                            @foreach ($formapagamentos as $forma)
                                                <option value="{{ $forma->tipo }}" data-id="{{ $forma->id }}" {{ old('forma_pagamento_id ') == $forma->id ? 'selected' : '' }}>{{ $forma->nome }}</option>
                                            @endforeach
                                        </select>
                                        <!-- Campo oculto para armazenar o data-id da forma de pagamento -->
                                        <input type="hidden" id="forma-pagamento-id" name="forma_pagamento_id">
                                    </div>

                                    <!-- Formulário Dinheiro (Tipo A) -->
                                    <div class="col-md-4" id="dinheiro-form" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label for="valor-recebido">Valor Recebido</label>
                                                <input type="number" id="valor-recebido" class="form-control">
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button type="button" class="btn btn-sm btn-primary" id="calcular-dinheiro">Calcular</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Formulário Parcelado (Tipo P) -->
                                    <div class="col-md-8" id="parcelado-form" style="display:none;">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <label for="num-parcelas">Número de Parcelas</label>
                                                <input type="number" id="num-parcelas" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="dias-entre-parcelas">Dias Entre Parcelas</label>
                                                <input type="number" id="dias-entre-parcelas" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="valor-recebido-parcelado">Valor Recebido</label>
                                                <input type="number" id="valor-recebido-parcelado" class="form-control">
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <button type="button" class="btn btn-sm btn-primary" id="calcular-parcelado">Calcular Parcelas</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-3 mt-4" >
                                    <div class="col-md-12">
                                         <!-- Tabela de Pagamentos -->
                                         <table id="pagamentos-table"  class="table table-striped" style="display: none;">

                                            <thead>
                                                <tr>
                                                    <th>Forma de Pagamento</th>
                                                    <th>Valor Pago</th>
                                                    <th>Parcelas</th>
                                                    <th>Data de Vencimento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- As informações de pagamento serão inseridas aqui -->
                                            </tbody>

                                        </table>
                                        <!-- Valor a Receber -->
                                                <p id="valor-a-receber">Valor a Receber: R$1500</p>
                                    </div>
                                </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
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
@endsection


@section('js')
    {{-- rege o campo codigo do fornecedor --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const codigoInput = document.getElementById('codigo');
            const nomeInput = document.getElementById('nome');
            const fornecedorError = document.getElementById('fornecedor-error');

            // Detectar pressionamento da tecla Enter no campo 'codigo'
            codigoInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    let codigo = codigoInput.value;

                    if (codigo) {
                        // Fazer requisição AJAX para buscar o fornecedor
                        fetch(`{{ route('buscar.fornecedor', '') }}/${codigo}`)

                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Se encontrar, preenche o campo 'nome' com o nome do fornecedor
                                    nomeInput.value = data.nome;
                                    // Ocultar a mensagem de erro, caso o fornecedor seja encontrado
                                    fornecedorError.style.display = 'none';
                                } else {
                                    // Se não encontrar, coloca o foco no campo 'nome' para o usuário digitar
                                    nomeInput.focus();
                                    codigoInput.value = ""; // Limpar campo
                                    nomeInput.value = ""; // Limpar campo
                                    // Exibir a mensagem de erro
                                    fornecedorError.style.display = 'block';

                                    // Ocultar a mensagem após 3 segundos
                                    setTimeout(function() {
                                        fornecedorError.style.display = 'none';
                                    }, 3000); // 3000 milissegundos = 3 segundos
                                }
                            })
                            .catch(error => {
                                console.error("Erro ao buscar fornecedor:", error);
                                fornecedorError.style.display =
                                    'block'; // Exibir erro em caso de falha na requisição

                                // Ocultar a mensagem após 3 segundos
                                setTimeout(function() {
                                    fornecedorError.style.display = 'none';
                                }, 1000); // 3000 milissegundos = 3 segundos
                            });
                    } else {
                        // Se o código estiver vazio, coloca o foco no campo 'nome'
                        nomeInput.focus();
                        fornecedorError.style.display = 'none'; // Ocultar erro se não houver código
                    }
                }
            });
        });
    </script>
    {{-- rege o campo nome do fornecedor com a pesquisa e seleção do fornecedor --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nomeInput = document.getElementById('nome');
            const codigoInput = document.getElementById('codigo'); // Novo campo para código
            const fornecedorList = document.getElementById('fornecedor-list');
            const fornecedorTableContainer = document.getElementById('fornecedor-table-container');
            let currentIndex = -1; // Índice do item selecionado na tabela

            // Função para buscar fornecedores enquanto o usuário digita
            nomeInput.addEventListener('input', function() {
                const termo = nomeInput.value;

                if (termo.length >= 3) { // Inicia a busca apenas se o termo tiver pelo menos 3 caracteres
                    fetch("{{ route('buscar.fornecedor.nome') }}?nome=" + encodeURIComponent(termo))
                        .then(response => response.json())
                        .then(data => {
                            // Limpa a tabela de resultados anteriores
                            fornecedorList.innerHTML = '';

                            if (data.length > 0) {
                                fornecedorTableContainer.style.display = 'block'; // Exibe a tabela

                                data.forEach((fornecedor, index) => {
                                    // Cria uma linha para cada fornecedor
                                    const tr = document.createElement('tr');
                                    tr.classList.add('fornecedor-item');
                                    tr.setAttribute('data-id', fornecedor.id);
                                    tr.setAttribute('data-nome', fornecedor.nome);
                                    tr.setAttribute('data-cpf_cnpj', fornecedor.cpf_cnpj);

                                    tr.innerHTML = `
                                    <td>${fornecedor.id}</td>
                                    <td>${fornecedor.nome}</td>
                                    <td>${fornecedor.cpf_cnpj}</td>
                                `;

                                    // Adiciona evento de clique para preencher os campos
                                    tr.addEventListener('click', function() {
                                        nomeInput.value = fornecedor.nome;
                                        codigoInput.value = fornecedor
                                            .id; // Preenche o código (ID)
                                        nomeInput.setAttribute('data-id', fornecedor
                                            .id); // Armazena o ID
                                        fornecedorTableContainer.style.display =
                                            'none'; // Fecha a tabela
                                    });

                                    fornecedorList.appendChild(tr);
                                });
                            } else {
                                fornecedorTableContainer.style.display =
                                    'none'; // Se não houver resultados, esconde a tabela
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao buscar fornecedores:', error);
                        });
                } else {
                    fornecedorTableContainer.style.display =
                        'none'; // Esconde a tabela se o termo for menor que 3 caracteres
                }
            });

            // Navegação com as setas do teclado
            nomeInput.addEventListener('keydown', function(event) {
                const rows = document.querySelectorAll('.fornecedor-item');
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
                    const id = selectedRow.getAttribute('data-id');
                    const nome = selectedRow.getAttribute('data-nome');
                    const cpf_cnpj = selectedRow.getAttribute('data-cpf_cnpj');

                    // Preenche os campos nome e código
                    nomeInput.value = nome;
                    codigoInput.value = id; // Preenche o campo de código (ID)
                    nomeInput.setAttribute('data-id', id); // Armazena o ID do fornecedor

                    fornecedorTableContainer.style.display = 'none'; // Fecha a tabela
                }
            });

            // Função para destacar a linha selecionada
            function highlightRow(rows) {
                rows.forEach((row, index) => {
                    if (index === currentIndex) {
                        row.classList.add('table-active'); // Bootstrap class to highlight row
                    } else {
                        row.classList.remove('table-active');
                    }
                });
            }

            // Fechar a tabela se o usuário clicar fora
            document.addEventListener('click', function(event) {
                if (!fornecedorTableContainer.contains(event.target) && event.target !== nomeInput) {
                    fornecedorTableContainer.style.display = 'none';
                }
            });

                        // Fechar a tabela de pesquisa ao pressionar ESC
                        document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    fornecedorTableContainer.style.display = 'none';
                    currentIndex = -1;
                }
            });
        });
    </script>

    {{-- rege os campos de inserir os itens --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const idprodutoInput = document.getElementById('produto_id');
            const nomeprodutoInput = document.getElementById('nome_produto');
            const codigoprodutoInput = document.getElementById('codigo_produto');
            const estoqueprodutoInput = document.getElementById('estoque_produto');
            const quantidadeprodutoInput = document.getElementById('quantidade');
            const produtoList = document.getElementById('produto-list');
            const produtoTableContainer = document.getElementById('produto-table-container');
            const produtoError = document.getElementById('produto-error');
            const erroItem = document.getElementById('erro-item');
            const erroQuantidade = document.getElementById('erro-quantidade');
            const itensList = document.getElementById(
                'itens-list'); // Supondo que você tenha essa tabela para os itens inseridos
            const totalQuantidadeElem = document.getElementById('total-quantidade');
            const totalValoresElem = document.getElementById('total-valores');
            let currentIndex = -1;

            // Variáveis para controlar o total de itens e o valor total
            let totalQuantidade = 0;
            let totalValores = 0;

            // Função para atualizar os totais
            function atualizarTotais() {
                totalQuantidadeElem.textContent = totalQuantidade;
                totalValoresElem.textContent = totalValores.toLocaleString('pt-BR', {
                    style: 'decimal',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            }

            // Função para buscar produtos enquanto o usuário digita no nome_produto
            nomeprodutoInput.addEventListener('input', function() {
                const termo = nomeprodutoInput.value;
                const rect = nomeprodutoInput
                    .getBoundingClientRect(); // Pega a posição do campo nome_produto

                if (termo.length >= 3) {
                    fetch("{{ route('buscar.produto.nome') }}?nome=" + termo)
                        .then(response => response.json())
                        .then(data => {
                            produtoList.innerHTML = '';
                            if (data.length > 0) {
                                produtoTableContainer.style.display = 'block';
                                // Posiciona a tabela abaixo do campo
                                produtoTableContainer.style.left = `${rect.left}px`;
                                produtoTableContainer.style.top = `${rect.bottom + window.scrollY}px`;
                                console.log(produtoList);
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
                                        currentIndex = -1;
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
                    currentIndex = -1;
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

            // Fechar a tabela de pesquisa ao pressionar ESC
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    produtoTableContainer.style.display = 'none';
                    currentIndex = -1;
                }
            });

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

            // Adicionar item à lista de itens inseridos quando pressionar Enter no campo de quantidade
            quantidadeprodutoInput.addEventListener('keydown', function(event) {
                console.log('Tecla pressionada:', event.key);
                if (event.key === 'Enter') {
                    event.preventDefault(); // Evita o comportamento padrão de "Enter"

                    // Verifica se os campos necessários estão preenchidos
                    const inputcodigo = document.getElementById('codigo_produto');
                    const codigo = codigoprodutoInput.value;
                    const nome = nomeprodutoInput.value;
                    const estoque = estoqueprodutoInput.value;
                    const quantidade = quantidadeprodutoInput.value;
                    const produtoId = document.getElementById('produto_id').value;

                    // Reseta as mensagens de erro
                    erroItem.style.display = 'none';
                    erroQuantidade.style.display = 'none';
                    setTimeout(() => {
                        inputcodigo.focus();
                    }, 100); // Pequeno atraso para garantir que o foco seja aplicado corretamente


                    if (!codigo || !nome || !estoque) {
                        // Se algum dos campos estiver vazio, exibe a mensagem de erro de item não selecionado
                        erroItem.style.display = 'block';
                        setTimeout(function() {
                            erroItem.style.display = 'none';
                        }, 1000);
                    } else if (!quantidade) {
                        // Se o campo quantidade estiver vazio, exibe a mensagem de erro de quantidade
                        erroQuantidade.style.display = 'block';

                        setTimeout(function() {
                            erroItem.style.display = 'none';
                        }, 1000);

                    } else {
                        // Se todos os campos estiverem preenchidos corretamente, adiciona à tabela
                        const total = parseFloat(estoque) * parseInt(quantidade);

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                    <td>${codigo}</td>
                    <td>${nome}</td>
                    <td>${estoque}</td>
                    <td>${quantidade}</td>
                    <td>${total.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm edit-item"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-danger btn-sm delete-item"><i class="bi bi-trash"></i></button>
                    </td>
                `;
                        tr.setAttribute('data-produto-id', produtoId);

                        // Adiciona a nova linha à tabela de itens
                        itensList.appendChild(tr);

                        // Atualiza a quantidade total e o valor total
                        totalQuantidade += 1;
                        totalValores += total;

                        // Atualiza os totais
                        atualizarTotais();

                        // Limpa os campos após adicionar o item
                        codigoprodutoInput.value = '';
                        nomeprodutoInput.value = '';
                        estoqueprodutoInput.value = '';
                        quantidadeprodutoInput.value = '';
                        document.getElementById('produto_id').value = '';

                        // Foca no campo Código após a adição
                        setTimeout(() => {
                            inputcodigo.focus();
                        }, 100); // Pequeno atraso para garantir que o foco seja aplicado corretamente


                    }
                }
            });

            // Função para excluir item da lista

            function excluirItem(event) {
                // Verifica se o clique foi no botão ou no ícone dentro do botão
                const deleteButton = event.target.closest('.delete-item');
                if (deleteButton) {
                    const row = deleteButton.closest('tr'); // Captura a linha que será removida
                    const valorTotalItem = parseFloat(row.querySelector('td:nth-child(5)')
                        .textContent); // Captura o valor total do item

                    // Atualiza a quantidade total e o valor total
                    totalQuantidade -= 1;
                    totalValores -= valorTotalItem;

                    // Remove a linha da tabela
                    row.remove();

                    // Atualiza os totais
                    atualizarTotais();
                }
            }
            // Excluir item ao clicar no botão "Excluir"
            itensList.addEventListener('click', excluirItem);
        });
    </script>

    {{-- Definir a data atual no campo de data --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataInput = document.getElementById('data');
            const today = new Date().toISOString().split('T')[0]; // Formata a data no formato YYYY-MM-DD
            dataInput.value = today;
        });
    </script>


    {{-- Adicionar a lógica para abrir o modal e salvar a observação --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const itensList = document.getElementById('itens-list'); // Defina itensList aqui

            // Variável para armazenar a linha atual que está sendo editada
            let currentRow = null;

            // Função para abrir o modal de edição de observação
            function openObservacaoModal(row) {
                // Recupera a observação salva no atributo data-observacao
                const observacao = row.getAttribute('data-observacao') || '';
                document.getElementById('observacaoText').value = observacao; // Preenche o textarea
                currentRow = row; // Armazena a linha atual
                const modal = new bootstrap.Modal(document.getElementById('observacaoModal'));
                modal.show();
            }

            // Adicionar evento de clique ao botão de editar
            itensList.addEventListener('click', function(event) {
                const editButton = event.target.closest('.edit-item');
                if (editButton) {
                    const row = editButton.closest('tr');
                    openObservacaoModal(row); // Abre o modal com a observação salva
                }
            });

            // Salvar a observação quando o botão de salvar no modal for clicado
            document.getElementById('salvarObservacao').addEventListener('click', function() {
                const observacao = document.getElementById('observacaoText').value;
                if (currentRow) {
                    const nomeCell = currentRow.querySelector('td:nth-child(2)');
                    const nomeProduto = nomeCell.textContent.trim(); // Captura o nome do produto (sem a observação)

                    // Verifica se já existe uma observação na célula
                    const existingObservacao = nomeCell.querySelector('.small-text');

                    if (observacao) {
                        // Se já existe uma observação, atualiza o conteúdo dela
                        if (existingObservacao) {
                            existingObservacao.innerHTML = `<strong>${observacao}</strong>`;
                        } else {
                            // Se não existe uma observação, adiciona o <br> e a observação
                            nomeCell.innerHTML = `
                                ${nomeProduto}
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


    {{-- funcao para salvar o orcamento e os itens --}}
    <script>
        document.querySelector('.btn-success').addEventListener('click', function(event) {
            event.preventDefault(); // Impede o envio do formulário para validação

            const fornecedorId = document.getElementById('codigo').value;
            const totalQuantidade = document.getElementById('total-quantidade').textContent;
            const data = document.getElementById('data').value;
            const observacao = document.getElementById('observacao').value;
            const itensList = document.querySelectorAll('#itens-list tr');

            // Verifica se o fornecedor foi selecionado
            if (!fornecedorId) {
                showErrorModal('Nenhum fornecedor foi selecionado. Por favor, selecione um fornecedor.');
                return;
            }

            // Verifica se há itens na lista
            if (itensList.length === 0) {
                showErrorModal('Nenhum produto foi adicionado. Por favor, adicione pelo menos um produto.');
                return;
            }

            // Continua com o processo de salvar
            const totalValores = document.getElementById('total-valores').textContent
                .replace('R$', '')
                .replace(/\./g, '')
                .replace(',', '.');

            const itens = [];
            itensList.forEach(row => {
                const produtoId = row.getAttribute('data-produto-id');
                const estoque = row.children[2].textContent;
                const quantidade = row.children[3].textContent;
                const valorTotal = row.children[4].textContent;
                const observacao = row.getAttribute('data-observacao') || '';


                itens.push({
                    produto_id: produtoId,
                    estoque: estoque,
                    quantidade: quantidade,
                    valor_total: valorTotal,
                    observacao: observacao,
                });
            });

            // console.log(itens);

            // const dataToSend = {
            //     fornecedor_id: fornecedorId,
            //     total_itens: totalQuantidade,
            //     total_pedido: totalValores,
            //     data: data,
            //     itens: itens,
            //     observacao: observacao,
            // };


                            // Captura os dados da tabela de formas de pagamento
                const pagamentosList = document.querySelectorAll('#pagamentos-table tbody tr');
                const pagamentos = [];

                pagamentosList.forEach(row => {
                    const tipoPagamento = row.children[0].textContent.trim(); // Tipo (Dinheiro/Parcelado)
                    const valorPago = row.children[1].textContent.trim().replace('R$', '').replace(',', '.'); // Valor pago
                    const parcelas = row.children[2].textContent.trim(); // Número de parcelas
                    const vencimento = row.children[3].textContent.trim(); // Data de vencimento
                    // Captura o data-id da forma de pagamento
                    const formaPagamentoId = row.querySelector('input[name="forma_pagamento_id[]"]').value;

                    pagamentos.push({
                        tipo_pagamento: tipoPagamento,
                        valor_pago: parseFloat(valorPago),
                        parcelas: parcelas,
                        vencimento: vencimento,
                        forma_pagamento_id: formaPagamentoId, // Adiciona o data-id ao objeto
                    });
                })

        console.log('Itens:', itens);
        console.log('Pagamentos:', pagamentos);

                    const dataToSend = {
                fornecedor_id: fornecedorId,
                total_itens: totalQuantidade,
                total_pedido: totalValores,
                data: data,
                itens: itens,
                observacao: observacao,
                pagamentos: pagamentos, // Adiciona os pagamentos ao objeto
            };

            // Envia os dados para o backend
            fetch("{{ route('pedido.salvar', '') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                    },
                    body: JSON.stringify(dataToSend),
                })
                .then(response => response.json())
                .then(data => {
                    const routePedidos = @json(route('pedidos.index'));
                    if (data.success) {
                        // Exibe a mensagem de sucesso
                        showSuccessModal('Pedido salvo com sucesso!');
                        // Redireciona para a página de orçamentos após um pequeno delay
                        setTimeout(() => {
                            window.location.href = routePedidos;
                        }, 2000); // 2 segundos de delay
                    } else {
                        showErrorModal('Erro ao salvar pedido: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showErrorModal('Erro inesperado ao salvar pedido');
                });
        });

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


{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    const formaPagamentoSelect = document.getElementById('forma_pagamento');
    const parcelaContainer = document.getElementById('parcela_container');
    const diasContainer = document.getElementById('dias_container');
    const buttonCalcular = document.getElementById('button_calcular');

    // Variável global para controlar o valor restante a receber
    let valorRestante = 0;

    // Atualiza o valor a ser recebido
    function atualizarAReceber(valor) {
        valorRestante = valor;
        document.getElementById('aReceber').textContent = valorRestante.toFixed(2).replace('.', ',');
    }

    // Mostra ou oculta os campos de parcelas e dias dependendo da forma de pagamento
    formaPagamentoSelect.addEventListener('change', function() {
        if (this.value === 'parcelado') {
            parcelaContainer.style.display = 'block';
            diasContainer.style.display = 'block';
            buttonCalcular.style.display = 'block';
        } else {
            parcelaContainer.style.display = 'none';
            diasContainer.style.display = 'none';
            buttonCalcular.style.display = 'block';
        }
    });

    document.getElementById('calcular').addEventListener('click', function() {
        const formaPagamento = formaPagamentoSelect.value;
        const numeroParcelas = document.getElementById('numero_parcelas').value || 1;
        const numeroDias = document.getElementById('numero_dias').value || 0;
        const valorRecebido = parseFloat(document.getElementById('valor_recebido').value);
        const totalValoresItens = document.getElementById('total-valores').textContent
                .replace('R$', '')
                .replace(/\./g, '')
                .replace(',', '.');

        if (!formaPagamento || !valorRecebido) {
            alert('Preencha todos os campos obrigatórios.');
            return;
        }

        const dataToSend = {
            forma_pagamento: formaPagamento,
            numero_parcelas: numeroParcelas,
            numero_dias: numeroDias,
            valor_total: totalValoresItens,  // Utiliza o valor dos itens
            valor_recebido: valorRecebido,
        };

        // Calcular o valor restante
        let valorAReceber = totalValoresItens - valorRecebido;

        // Se o valor recebido for maior ou igual ao valor total, não há valor a receber
        if (valorAReceber < 0) {
            valorAReceber = 0;
        }

        // Atualiza o valor "A Receber" com o valor restante
        atualizarAReceber(valorAReceber);

        if (formaPagamento === 'à vista') {
            // Adiciona uma nova linha na tabela para "à vista"
            const parcelasBody = document.getElementById('parcelas-body');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>1</td> <!-- Apenas uma linha para à vista -->
                <td>R$ ${valorAReceber.toFixed(2)}</td>
                <td>À Vista</td>
            `;
            parcelasBody.appendChild(row);

            // Exibe a tabela e o botão "Limpar Tudo"
            document.getElementById('resultados').style.display = 'block';
        } else if (formaPagamento === 'parcelado') {
            // Aqui, verificamos se o valor restante deve ser parcelado
            fetch("{{ route('calcular.parcelas', '') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),
                },
                body: JSON.stringify(dataToSend),
            })
            .then(response => response.json())
            .then(data => {
                const parcelas = data.parcelas;
                const aReceber = data.aReceber;

                const parcelasBody = document.getElementById('parcelas-body');

                // Adiciona as novas parcelas na tabela
                parcelas.forEach(parcela => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${parcela.parcela}</td>
                        <td>R$ ${parcela.valor.toFixed(2)}</td>
                        <td>${parcela.data_vencimento}</td>
                    `;
                    parcelasBody.appendChild(row);
                });

                // Atualiza o valor a receber
                atualizarAReceber(aReceber);

                // Exibe a tabela e o botão "Limpar Tudo"
                document.getElementById('resultados').style.display = 'block';
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao calcular as parcelas.');
            });
        }
    });

    // Botão para limpar tudo
    document.getElementById('limpar-tudo').addEventListener('click', function() {
        // Limpa o conteúdo da tabela
        document.getElementById('parcelas-body').innerHTML = '';

        // Reseta o valor "A Receber" para zero
        atualizarAReceber(0);

        // Oculta a tabela e o botão "Limpar Tudo"
        document.getElementById('resultados').style.display = 'none';

        // Opcional: Resetar os campos do formulário, se necessário
        document.getElementById('valor_recebido').value = '';
        document.getElementById('numero_parcelas').value = '2';
        document.getElementById('numero_dias').value = '30';
        document.getElementById('forma_pagamento').value = '';

        // Oculta os campos de parcelas e dias, se estiverem visíveis
        document.getElementById('parcela_container').style.display = 'none';
        document.getElementById('dias_container').style.display = 'none';
        document.getElementById('button_calcular').style.display = 'none';
    });
    });

</script> --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Atualiza o valor total a partir de "total-valores" dinâmico
    function atualizarTotais() {
        let valorTotalItens = document.getElementById('total-valores').textContent
            .replace('R$', '')
            .replace(/\./g, '')
            .replace(',', '.');

        valorTotalItens = parseFloat(valorTotalItens);

        if (isNaN(valorTotalItens)) {
            valorTotalItens = 0;
        }

        document.getElementById('valor-a-receber').textContent = `Valor a Receber: R$${valorTotalItens.toFixed(2)}`;
        document.getElementById('valor-total-itens').value = valorTotalItens.toFixed(2);
    }

    // Inicializa os valores quando a página carregar
    atualizarTotais();

    // Elementos de exibição
    const valorReceberElem = document.getElementById("valor-a-receber");
    const totalValoresElem = document.getElementById("total-valores");
    const valorTotalItensElem = document.getElementById("valor-total-itens");

    // Tabela de pagamentos
    const pagamentosTable = document.getElementById("pagamentos-table").getElementsByTagName("tbody")[0];

    // Mostrar os campos conforme a forma de pagamento escolhida
    const formaPagamentoSelect = document.getElementById("forma-pagamento");
    const dinheiroForm = document.getElementById("dinheiro-form");
    const parceladoForm = document.getElementById("parcelado-form");

    // Campo oculto para armazenar o data-id da forma de pagamento
    const formaPagamentoIdInput = document.getElementById("forma-pagamento-id");

    formaPagamentoSelect.addEventListener("change", function() {
        const formaPagamento = formaPagamentoSelect.value;
        const selectedOption = formaPagamentoSelect.options[formaPagamentoSelect.selectedIndex];
        const formaPagamentoId = selectedOption.getAttribute("data-id");

        // Armazena o data-id no campo oculto
        formaPagamentoIdInput.value = formaPagamentoId;

        console.log("Forma de pagamento selecionada:", formaPagamento, "ID:", formaPagamentoId);

        // Esconder ambos os formulários e mostrar o correto
        dinheiroForm.style.display = "none";
        parceladoForm.style.display = "none";

        if (formaPagamento === "A") {
            dinheiroForm.style.display = "block";
        } else if (formaPagamento === "P") {
            parceladoForm.style.display = "block";
        }
    });

    // Calcular pagamento em dinheiro (Tipo A)
    const calcularDinheiroBtn = document.getElementById("calcular-dinheiro");
    calcularDinheiroBtn.addEventListener("click", function() {
        const valorRecebido = parseFloat(document.getElementById("valor-recebido").value);
        const formaPagamentoId = formaPagamentoIdInput.value; // Captura o data-id

        // Pega o valor a receber atual
        let valorAReceber = parseFloat(document.getElementById('valor-total-itens').value);

        // Verifica se o valor recebido é válido e menor ou igual ao valor a receber
        if (valorRecebido > 0 && valorRecebido <= valorAReceber) {
            valorAReceber -= valorRecebido;

            // Atualiza o valor a receber
            valorReceberElem.textContent = `Valor a Receber: R$${valorAReceber}`;
            totalValoresElem.textContent = `R$${valorAReceber}`;

            // Atualiza o campo hidden
            atualizarTotais();

            // Adiciona o pagamento à tabela
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>Dinheiro</td>
                <td>R$${valorRecebido.toFixed(2)}</td>
                <td>---</td>
                <td>---</td>
                <td><input type="hidden" name="forma_pagamento_id[]" value="${formaPagamentoId}"></td>
            `;
            pagamentosTable.appendChild(tr);

            // Mostra a tabela se estiver escondida
            if (pagamentosTable.rows.length > 0) {
                document.getElementById("pagamentos-table").style.display = "table";
            }

            // Limpa o campo de valor recebido
            document.getElementById("valor-recebido").value = "";
        }
    });

    // Calcular pagamento parcelado (Tipo P)
    const calcularParceladoBtn = document.getElementById("calcular-parcelado");
    calcularParceladoBtn.addEventListener("click", function() {
        const valorRecebidoParcelado = parseFloat(document.getElementById("valor-recebido-parcelado").value);
        const numParcelas = parseInt(document.getElementById("num-parcelas").value);
        const diasEntreParcelas = parseInt(document.getElementById("dias-entre-parcelas").value);
        const formaPagamentoId = formaPagamentoIdInput.value; // Captura o data-id

        // Pega o valor a receber atual
        let valorAReceber = parseFloat(document.getElementById('valor-total-itens').value);

        // Verifica se o valor recebido parcelado é válido e as parcelas também
        if (valorRecebidoParcelado > 0 && numParcelas > 0 && diasEntreParcelas > 0) {
            const valorParcelado = valorRecebidoParcelado / numParcelas;

            for (let i = 0; i < numParcelas; i++) {
                const vencimento = new Date();
                vencimento.setDate(vencimento.getDate() + (i * diasEntreParcelas));

                // Adiciona as parcelas à tabela
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>Parcelado</td>
                    <td>R$${valorParcelado.toFixed(2)}</td>
                    <td>${i + 1} de ${numParcelas}</td>
                    <td>${vencimento.toLocaleDateString()}</td>
                    <td><input type="hidden" name="forma_pagamento_id[]" value="${formaPagamentoId}"></td>
                `;
                pagamentosTable.appendChild(tr);
            }

            valorAReceber -= valorRecebidoParcelado;

            // Atualiza o valor a receber
            valorReceberElem.textContent = `Valor a Receber: R$${valorAReceber}`;
            totalValoresElem.textContent = `R$${valorAReceber}`;

            // Atualiza o campo hidden
            atualizarTotais();

            // Mostra a tabela se estiver escondida
            if (pagamentosTable.rows.length > 0) {
                document.getElementById("pagamentos-table").style.display = "table";
            }

            // Limpa os campos de parcelamento
            document.getElementById("valor-recebido-parcelado").value = "";
            document.getElementById("num-parcelas").value = "";
            document.getElementById("dias-entre-parcelas").value = "";
        }
    });
});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Função para atualizar o valor de "valor-a-receber" e o campo hidden
    function atualizarValores() {
        // Pega o valor exibido em total-valores, remove o "R$", troca os pontos por nada e vírgula por ponto
        let valorTotal = document.getElementById('total-valores').textContent
            .replace('R$', '')   // Remove o "R$"
            .replace(/\./g, '')  // Remove os pontos
            .replace(',', '.');  // Substitui a vírgula por ponto

        // Converte para número
        valorTotal = parseFloat(valorTotal).toFixed(2);

        // Atualiza o valor de "valor-a-receber"
        document.getElementById('valor-a-receber').textContent = `Valor a Receber: R$${valorTotal}`;

        // Atualiza o valor do campo hidden "valor-total-itens"
        document.getElementById('valor-total-itens').value = valorTotal;
    }

    // Chama a função para garantir que o valor de valor-a-receber e o hidden sejam corretos ao carregar
    atualizarValores();

    // Supondo que o total-valores mude durante o processo, chame a função novamente sempre que isso acontecer
    const totalValoresElem = document.getElementById('total-valores');
    const observer = new MutationObserver(function() {
        atualizarValores();  // Chama a função sempre que total-valores mudar
    });

    observer.observe(totalValoresElem, { childList: true, subtree: true });
    });

</script>










@endsection
