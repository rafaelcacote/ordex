@extends('layouts.default')


@section('content')
    <div class="pagetitle">

        <a href="{{ route('categorias.create') }}" class="btn btn-success novo" role="button"><i
                class="bi bi-plus-square me-1"></i> CADASTRAR</a>

        <h1>Categorias</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Categorias</li>
                <li class="breadcrumb-item active">Pesquisar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class="row">
        <div class="col-lg-12">


            <div class="card">

                <form class="row g-3 pesquisa" method="GET" id="pesquisaForm" action="{{ route('categorias.index') }}">
                    @csrf
                    <div class="col-md-4">
                        <label for="for_nome" class="form-label"><span class="badge bg-dark">Nome</span></label>
                        <input type="text" class="form-control" id="for_nome" name="for_nome" value="">
                    </div>
                    <div class="col-md-4 botao">
                        <button type="submit" class="btn btn-warning">Pesquisar</button>
                        <button type="button" class="btn btn-danger"
                            onclick="window.location='{{ route('categorias.index') }}'"><i
                                class="bi bi-backspace"></i></button>
                    </div>

                </form>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    @if ($categorias->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Nenhuma categoria encontrada.
                        </div>
                    @else
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $categoria)
                                <tr data-id="{{ $categoria->for_codigo }}">
                                    <th scope="row">{{ $categoria->id }}</th>
                                    <td>{{ $categoria->nome }}</td>
                                    <td style="width: 60px;text-align: center">
                                        <a href="{{ route('categorias.edit', $categoria->id) }}" type="button"
                                            class="btn btn-primary acao" role="button"><i
                                                class="bi bi-pencil-square"></i></a>
                                    </td>

                                    <td style="width: 60px;text-align: center">
                                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete(event, this.form, '{{ $categoria->nome }}')">
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
                        {{ $categorias->appends(request()->input())->links('pagination::bootstrap-4') }}
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
