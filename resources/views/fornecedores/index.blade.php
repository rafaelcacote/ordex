@extends('layouts.default')

@section('content')
    <div class="pagetitle">
        <a href="{{ route('fornecedores.create') }}" class="btn btn-success novo" role="button"><i
                class="bi bi-plus-square me-1"></i> CADASTRAR</a>

        <h1>Fornecedores</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Fornecedores</li>
                <li class="breadcrumb-item active">Pesquisar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form class="row g-3 pesquisa" id="pesquisaForm" method="GET" action="{{ route('fornecedores.index') }}">
                    <div class="col-md-4">
                        <label for="nome" class="form-label"><span class="badge bg-dark">Nome</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" value="" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label for="cpf_cnpj" class="form-label"><span class="badge bg-dark">CPF / CNPJ</span></label>
                        <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="" autocomplete="off">
                    </div>
                    <div class="col-md-4 botao">
                        <button type="submit" class="btn btn-warning">Pesquisar</button>
                        <button type="button" class="btn btn-danger"
                            onclick="window.location='{{ route('fornecedores.index') }}'"><i
                                class="bi bi-backspace"></i></button>
                    </div>
                </form>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    @if ($fornecedores->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Nenhum Fornecedor encontrado.
                    </div>
                @else
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Nome</th>
                                <th scope="col">CPF / CNPJ</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fornecedores as $fornecedor)
                                <tr data-id="{{ $fornecedor->for_codigo }}">
                                    <th scope="row">{{ $fornecedor->id }}</th>
                                    <td>{{ $fornecedor->nome }}</td>
                                    <td>{{ $fornecedor->cpf_cnpj }}</td>
                                    <td>{{ $fornecedor->telefone1 }}</td>
                                    <td style="width: 60px;text-align: center">
                                        <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" type="button"
                                            class="btn btn-primary acao" role="button"><i
                                                class="bi bi-pencil-square"></i></a>
                                    </td>
                                    <td style="width: 60px;text-align: center">
                                        <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete(event, this.form, '{{ $fornecedor->nome }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @endif
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <ul class="pagination">
                        {{ $fornecedores->appends(request()->input())->links('pagination::bootstrap-4') }}
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
