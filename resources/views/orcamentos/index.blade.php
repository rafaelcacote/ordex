@extends('layouts.default')


@section('content')
    <div class="pagetitle">

        <a href="{{ route('orcamentos.create') }}" class="btn btn-success novo" role="button"><i
                class="bi bi-plus-square me-1"></i> CADASTRAR</a>

        <h1>Cotação</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Financeiro</li>
                <li class="breadcrumb-item active">Pesquisar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class="row">
        <div class="col-lg-12">


            <div class="card">

                <form class="row g-3 pesquisa" method="GET" id="pesquisaForm" action="{{ route('orcamentos.index') }}">

                    <div class="col-md-2">
                        <label for="id" class="form-label"><span class="badge bg-dark">Código</span></label>
                        <input type="text" class="form-control" id="id" name="id" value="">
                    </div>
                    <div class="col-md-4">
                        <label for="nome" class="form-label"><span class="badge bg-dark">Nome</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" value="">
                    </div>
                    <div class="col-md-4 botao">
                        <button type="submit" class="btn btn-warning">Pesquisar</button>
                        <button type="button" class="btn btn-danger"
                            onclick="window.location='{{ route('orcamentos.index') }}'"><i
                                class="bi bi-backspace"></i></button>
                    </div>

                </form>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    @if ($orcamentos->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Nenhuma Cotação encontrada.
                    </div>
                @else
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Prazo</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orcamentos as $orcamento)
                                <tr>
                                    <td><strong>{{ $orcamento->id }}</strong></td>
                                    <td>{{ $orcamento->fornecedor->nome }}</td>
                                    <td>{{ $orcamento->prazo_formatado }}</td>
                                    <td>{{ $orcamento->total_orcamento_formatado }}</td>
                                    <td>
                                        <!-- Exibir o status com a badge -->
                                        @if ($orcamento->status == 'Aberto')
                                            <span class="badge bg-success">Aberto</span>
                                        @elseif($orcamento->status == 'Enviado')
                                            <span class="badge bg-info">Enviado</span>
                                        @elseif($orcamento->status == 'Respondido')
                                            <span class="badge bg-warning">Respondido</span>
                                        @elseif($orcamento->status == 'Finalizado')
                                            <span class="badge bg-secondary">Finalizado</span>
                                        @else
                                            <span class="badge bg-light">Indefinido</span>
                                        @endif
                                    </td>

                                    <td align="center">
                                        <a href="{{ route('orcamentos.edit', $orcamento->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('orcamento.pdf', $orcamento->id) }}"
                                            class="btn btn-sm btn-primary" target="_blank">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                        <form action="{{ route('orcamentos.destroy', $orcamento->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete(event, this.form, '{{ $orcamento->nome }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @endif
                    <!-- End Table with stripped rows -->
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <ul class="pagination">
                        {{-- Loop pelas páginas --}}
                        {{ $orcamentos->appends(request()->input())->links('pagination::bootstrap-4') }}
                    </ul>
                </div>

            </div>



        </div>
    </div>

              {{-- Script para ativar submit ao pressionar ENTER na tela de index --}}
              <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('pesquisaForm');
                    form.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault(); // Impede o comportamento padrão do ENTER
                            form.submit(); // Submete o formulário
                        }
                    });
                });
            </script>


    <script>
        function confirmDelete(event, form, nome) {
            event.preventDefault(); // Impede o envio imediato do formulário

            // Define a mensagem no modal
            document.getElementById('modalBody').innerHTML =
                `Tem certeza que deseja deletar o orçamento <strong>${nome}</strong>?`;

            // Exibe o modal
            var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();

            // Quando o botão de confirmação é clicado, envia o formulário
            document.getElementById('confirmDeleteButton').onclick = function() {
                form.submit();
            };
        }
    </script>
@endsection
