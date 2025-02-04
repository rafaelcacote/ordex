@extends('layouts.default')


@section('content')

<div class="card">


    <form class="row g-3 cadastro" method="POST" action="{{ route('fornecedores')}}" novalidate>
        @csrf

        <div class="pagetitle">

          <button type="submit" class="btn btn-success salvar"><i class="bi bi-save2 me-1"></i> SALVAR</button> 
          <a href="{{ route('fornecedores') }}" class="btn btn-danger cancelar"><i class="bi bi-backspace me-1"></i> CANCELAR</a> 
          <h1>Fornecedores - Editar</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route ('home')}}">Home</a></li>
              <li class="breadcrumb-item">Cadastros</li>
              <li class="breadcrumb-item active">Fornecedores</li>
            </ol>
          </nav>
          
        </div>

        @error('mensagem')
        <div class="alert alert-danger" role="alert" id="mensagemErro">
            {{$message}}
          
        </div>
        @enderror
        <!-- -- Final do Titulo da Pagina -- -->

        
        <!-- -- Campos do Formuário -- -->
        <div class="row mb-3">
            <div class="col-md-2">
                <label for="tipo"><strong>Tipo</strong></label>
                <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" onchange="toggleFields()">
                    <option value="F">Pessoa Física</option>
                    <option value="J">Pessoa Jurídica</option>
                </select>
                @error('tipo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="cpf_cnpj"><strong>CPF/CNPJ</strong></label>
                <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control @error('cpf_cnpj') is-invalid @enderror" value="{{ old('cpf_cnpj') }}">
                @error('cpf_cnpj')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="nome"><strong id="nomeLabel">Nome</strong></label>
                <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}">
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <!-- Campos de Pessoa Jurídica -->
        <div id="juridicaFields" style="display: none;">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="ins_estadual"><strong>Inscrição Estadual</strong></label>
                    <input type="text" name="ins_estadual" class="form-control" value="{{ old('ins_estadual') }}">
                </div>
                <div class="col-md-4">
                    <label for="ins_municipal"><strong>Inscrição Municipal</strong></label>
                    <input type="text" name="ins_municipal" class="form-control" value="{{ old('ins_municipal') }}">
                </div>
                <div class="col-md-4">
                    <label for="fantasia"><strong id="fantasiaLabel">Nome Fantasia</strong></label>
                    <input type="text" name="fantasia" id="fantasia" class="form-control" value="{{ old('fantasia') }}">
                </div>
            </div>
        </div>

         <!-- Telefones -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="telefone1"><strong>Telefone 1</strong></label>
                <input type="text" name="telefone1" id="telefone1" class="form-control @error('telefone1') is-invalid @enderror" value="{{ old('telefone1') }}">
                @error('telefone1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="telefone2"><strong>Telefone 2</strong></label>
                <input type="text" name="telefone2" class="form-control" value="{{ old('telefone2') }}">
            </div>
            <div class="col-md-4">
                <label for="contato"><strong>Contato</strong></label>
                <input type="text" name="contato" class="form-control" value="{{ old('contato') }}">
            </div>
        </div>

        <!-- Endereço -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="cep"><strong>CEP</strong></label>
                <input type="text" name="cep" id="cep" class="form-control @error('cep') is-invalid @enderror" value="{{ old('cep') }}">
                @error('cep')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="logradouro"><strong>Logradouro</strong></label>
                <input type="text" name="logradouro" id="logradouro" class="form-control @error('logradouro') is-invalid @enderror" value="{{ old('logradouro') }}">
                @error('logradouro')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="numero"><strong>Número</strong></label>
                <input type="text" name="numero" class="form-control" value="{{ old('numero') }}">
            </div>
        </div>

        <!-- Bairro, CEP e Cidade -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="bairro"><strong>Bairro</strong></label>
                <input type="text" name="bairro" id="bairro" class="form-control @error('bairro') is-invalid @enderror" value="{{ old('bairro') }}">
                @error('bairro')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="cidade_id"><strong>Estados</strong></label>
                <select name="cidade_id" class="form-select">
                    @foreach ($estados as $estado)
                        <optgroup label="{{ $estado->nome }}">
                            @foreach ($estado->cidades as $cidade)
                                <option value="{{ $cidade->id }}" {{ old('cidade_id') == $cidade->id ? 'selected' : '' }}>{{ $cidade->nome }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>


            <div class="col-md-4">
                <label for="cidade_id"><strong>Cidade</strong></label>
                <select name="cidade_id" class="form-select">
                    @foreach ($estados as $estado)
                        <optgroup label="{{ $estado->nome }}">
                            @foreach ($estado->cidades as $cidade)
                                <option value="{{ $cidade->id }}" {{ old('cidade_id') == $cidade->id ? 'selected' : '' }}>{{ $cidade->nome }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>




        </div>




    </form>


</div>

@endsection