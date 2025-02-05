@extends('layouts.default')


@section('content')
    <div class="pagetitle">

        <a href="{{ route('produtos.create') }}" class="btn btn-success novo" role="button"><i
                class="bi bi-plus-square me-1"></i> CADASTRAR</a>

        <h1>Produtos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Produtos</li>
                <li class="breadcrumb-item active">Pesquisar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class="row">
        <div class="col-lg-12">


            <div class="card">

                <form class="row g-3 pesquisa" method="GET" action="{{ route('produtos.index') }}">
                    @csrf
                    <div class="col-md-1">
                        <label for="codigo" class="form-label"><span class="badge bg-dark">Código</span></label>
                        <input type="text" class="form-control" id="codigo" name="codigo" value="">
                    </div>
                    <div class="col-md-5">
                        <label for="nome" class="form-label"><span class="badge bg-dark">Nome</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" value="">
                    </div>
                    <div class="col-md-2">
                        <label for="Categoria" class="form-label"><span class="badge bg-dark">Tipo</span></label>
                        <select name="tipo" id="tipo" class="form-select me-2 rounded @error('tipo') is-invalid @enderror">
                            <option value="">Selecione Tipo</option>
                            <option value="P" {{ old('tipo') == 'P' ? 'selected' : '' }}>Produto</option>
                            <option value="S" {{ old('tipo') == 'S' ? 'selected' : '' }}>Serviço</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="Categoria" class="form-label"><span class="badge bg-dark">Categoria</span></label>
                        <select name="categoria_id" id="categoria_id" class="form-select me-2 rounded @error('categoria_id') is-invalid @enderror ">
                            <option value="">Selecione</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 botao">
                        <button type="submit" class="btn btn-warning">Pesquisar</button>
                        <button type="button" class="btn btn-danger"
                            onclick="window.location='{{ route('produtos.index') }}'"><i
                                class="bi bi-backspace"></i></button>
                    </div>

                </form>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                                <tr data-id="{{ $produto->for_codigo }}">
                                    <th scope="row">{{ $produto->codigo }}</th>
                                    <td>{{ $produto->nome }}</td>
                                    <td>{{ $produto->tipo_display }}</td>
                                    <td>{{ $produto->categoria->nome }}</td>
                                    <td style="width: 60px;text-align: center">
                                        <a href="{{ route('produtos.edit', $produto->id) }}" type="button"
                                            class="btn btn-primary acao" role="button"><i
                                                class="bi bi-pencil-square"></i></a>
                                    </td>
                                    {{-- <td style="width: 60px;text-align: center">
                                        <a href="" type="button" class="btn btn-info acao"><i class="bi bi-plus-square"></i></a> --}}

                                    <td style="width: 60px;text-align: center">
                                        <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete(event, this.form, '{{ $produto->nome }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <ul class="pagination">
                        {{-- Loop pelas páginas --}}
                        {{ $produtos->appends(request()->input())->links('pagination::bootstrap-4') }}
                    </ul>
                </div>

            </div>



        </div>
    </div>
@endsection
