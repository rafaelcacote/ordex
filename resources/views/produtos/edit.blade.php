@extends('layouts.default')


@section('content')
    <div class="card">
        <form class="row g-3 cadastro" method="POST" action="{{ route('produtos.update', $produto->id) }}" novalidate>
            @csrf
            @method('PUT')
            <div class="pagetitle">

                <button type="submit" class="btn btn-success salvar"><i class="bi bi-save2 me-1"></i> SALVAR</button>
                <a href="{{ route('produtos.index') }}" class="btn btn-danger cancelar"><i class="bi bi-backspace me-1"></i>
                    CANCELAR</a>
                <h1>Produto - Editar</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Cadastros</li>
                        <li class="breadcrumb-item active">Produto</li>
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
                  <!-- Primeira Linha: Código e Nome -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="codigo"><strong>Código</strong></label>
                    <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo', $produto->codigo) }}">
                    @error('codigo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome"><strong>Nome</strong></label>
                    <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $produto->nome) }}">
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Segunda Linha: Tipo e Categoria -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipo"><strong>Tipo</strong></label>
                    <select name="tipo" id="tipo" class="form-select me-2 rounded @error('tipo') is-invalid @enderror">
                        <option value="">Selecione</option>
                        <option value="P" {{ old('tipo', $produto->tipo) == 'P' ? 'selected' : '' }}>Produto</option>
                        <option value="S" {{ old('tipo', $produto->tipo) == 'S' ? 'selected' : '' }}>Serviço</option>
                    </select>
                    @error('tipo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="categoria_id"><strong>Categoria</strong></label>
                    <select name="categoria_id" id="categoria_id" class="form-select me-2 rounded @error('categoria_id') is-invalid @enderror">
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $produto->categoria_id) == $categoria->id ? 'selected' : '' }}>{{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Terceira Linha: Estoque e Medida -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="estoque"><strong>Estoque</strong></label>
                    <input type="text" name="estoque" id="estoque" class="form-control" value="{{ old('estoque', $produto->estoque) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="medida"><strong>Medida</strong></label>
                    <input type="number" name="medida" id="medida" step="0.01" class="form-control" value="{{ old('medida', $produto->medida) }}">
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
