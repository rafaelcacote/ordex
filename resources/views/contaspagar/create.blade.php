@extends('layouts.default')


@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">


                <form class="row g-3 cadastro" method="POST" action="{{ route('contaspagar.store') }}" novalidate>
                    @csrf

                    <div class="pagetitle">

                        <button type="submit" class="btn btn-success salvar"><i class="bi bi-save2 me-1"></i> SALVAR</button>
                        <a href="{{ route('contaspagar.index') }}" class="btn btn-danger cancelar"><i
                                class="bi bi-backspace me-1"></i> CANCELAR</a>
                        <h1>Contas a Pagar - Adicionar</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item">Financeiro</li>
                                <li class="breadcrumb-item active">Contas a Pagar</li>
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
                            <!-- Primeira Linha: Código e Nome -->

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="descricao"><strong id="descricaoLabel">Descrição</strong></label>
                                    <input type="text" name="descricao" id="descricao"
                                        class="form-control @error('descricao') is-invalid @enderror" value="{{ old('descricao') }}">
                                    @error('descricao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="documento"><strong id="documentoLabel">Documento</strong></label>
                                    <input type="text" name="documento" id="documento"
                                        class="form-control @error('documento') is-invalid @enderror" value="{{ old('documento') }}">
                                    @error('documento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data"><strong>Data</strong></label>
                                        <input type="date" name="data" id="data" class="form-control"
                                            value="{{ old('data') }}" autocomplete=off>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3" >
                                <div class="col-md-4">
                                    <label for="valor_quitacao"><strong id="valor_quitacaoLabel">Valor Total</strong></label>
                                    <input type="text" name="valor_quitacao" id="valor_quitacao"
                                        class="form-control moeda @error('valor_quitacao') is-invalid @enderror" value="{{ old('valor_quitacao') }}">
                                    @error('valor_quitacao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="multa"><strong id="multaLabel">Multas</strong></label>
                                    <input type="text" name="multa" id="multa"
                                        class="form-control moeda @error('multa') is-invalid @enderror" value="{{ old('multa') }}">
                                    @error('multa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="juros"><strong id="jurosLabel">Juros</strong></label>
                                    <input type="text" name="juros" id="juros"
                                        class="form-control moeda @error('juros') is-invalid @enderror" value="{{ old('juros') }}">
                                    @error('juros')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mb-4" >
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vencimento"><strong>Vencimento</strong></label>
                                        <input type="date" name="vencimento" id="vencimento" class="form-control"
                                            value="{{ old('data') }}" autocomplete=off>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="parcela"><strong id="parcelaLabel">Parcela</strong></label>
                                    <input type="text" name="parcela" id="parcela"
                                        class="form-control @error('parcela') is-invalid @enderror" value="{{ old('parcela') }}">
                                    @error('parcela')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="status"><strong>Status</strong></label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" onchange="toggleFields()">
                                        <option value="Pago" {{ old('status') == 'Pago' ? 'selected' : '' }}>Pago</option>
                                        <option value="Pendente" {{ old('status') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>






                </form>
            </div>
        </div>
    </div>

@endsection
