@extends('layouts.default')


@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">


                <form class="row g-3 cadastro" method="POST" action="{{ route('categorias.store') }}" novalidate>
                    @csrf

                    <div class="pagetitle">

                        <button type="submit" class="btn btn-success salvar"><i class="bi bi-save2 me-1"></i> SALVAR</button>
                        <a href="{{ route('categorias.index') }}" class="btn btn-danger cancelar"><i
                                class="bi bi-backspace me-1"></i> CANCELAR</a>
                        <h1>Categorias - Adicionar</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item">Cadastros</li>
                                <li class="breadcrumb-item active">Categorias</li>
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
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="nome"><strong id="nomeLabel">Nome</strong></label>
                            <input type="text" name="nome" id="nome"
                                class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}">
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
