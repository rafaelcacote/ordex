@extends('layouts.default')


@section('content')
    <div class="pagetitle">

        <a href="{{ route('contaspagar.create') }}" class="btn btn-success novo" role="button"><i
                class="bi bi-plus-square me-1"></i> CADASTRAR</a>

        <h1>Contas a Pagar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Financeiro</li>
                <li class="breadcrumb-item">Contas a Pagar</li>
                <li class="breadcrumb-item active">Pesquisar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class="row">
        <div class="col-lg-12">


            <div class="card">

                <form class="row g-3 pesquisa" method="GET" id="pesquisaForm" action="{{ route('contaspagar.index') }}">

                    <div class="col-md-3">
                        <label for="for_nome" class="form-label"><span class="badge bg-dark">Fornecedor</span></label>
                        <input type="text" class="form-control" id="for_nome" name="for_nome" value="">
                    </div>
                    <div class="col-md-3">
                        <label for="descricao" class="form-label"><span class="badge bg-dark">Descricao</span></label>
                        <input type="text" class="form-control" id="descricao" name="descricao" value="">
                    </div>
                    <div class="col-md-2">
                        <label for="Categoria" class="form-label"><span class="badge bg-dark">Status</span></label>
                        <select name="status" id="status" class="form-select me-2 rounded @error('status') is-invalid @enderror">
                            <option value="">Selecione</option>
                            <option value="P" {{ old('status') == 'Paga' ? 'selected' : '' }}>Paga</option>
                            <option value="S" {{ old('status') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                        </select>
                    </div>


                    <div class="col-md-4 botao">
                        <button type="submit" class="btn btn-warning">Pesquisar</button>
                        <button type="button" class="btn btn-danger"
                            onclick="window.location='{{ route('contaspagar.index') }}'"><i
                                class="bi bi-backspace"></i></button>
                    </div>

                </form>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    @if ($contaspagar->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Nenhuma Contas a pagar encontrado.
                    </div>
                @else
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Vencimento</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Parcela</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contaspagar as $item)
                                <tr data-id="{{ $item->for_codigo }}">
                                    <td><strong>{{ $item->id }}</strong></td>
                                    <td>{{ $item->descricao }}</td>
                                    <td>{{ $item->vencimento }}</td>
                                    <td>{{ $item->valor_quitacao }}</td>
                                    <td>{{ $item->parcela }}</td>
                                    <td>
                                        <!-- Exibir o status com a badge -->
                                        @if ($item->status == 'Pago')
                                            <span class="badge bg-success"><i
                                                class="bi bi-check-circle me-1"></i>Pago</span>
                                        @elseif($item->status == 'Pendente')
                                            <span class="badge bg-danger"><i
                                                class="bi bi-clock-history me-1"></i>Pendente</span>
                                        @endif
                                    </td>
                                    <td style="width: 60px;text-align: center">
                                        <a href="{{ route('contaspagar.edit', $item->id) }}" type="button"
                                            class="btn btn-primary acao" role="button"><i
                                                class="bi bi-pencil-square"></i></a>
                                    </td>
                                    {{-- <td style="width: 60px;text-align: center">
                                        <a href="" type="button" class="btn btn-info acao"><i class="bi bi-plus-square"></i></a> --}}

                                    <td style="width: 60px;text-align: center">
                                        <form action="{{ route('contaspagar.destroy', $item->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete(event, this.form, '{{ $item->nome }}')">
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
                        {{ $contaspagar->appends(request()->input())->links('pagination::bootstrap-4') }}
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
@endsection
