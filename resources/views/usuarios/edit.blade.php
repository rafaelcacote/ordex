@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form class="row g-3 cadastro" method="POST" action="{{ route('usuarios.update', $user->id) }}" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="pagetitle">
                        <button type="submit" class="btn btn-success salvar"><i class="bi bi-save2 me-1"></i> SALVAR</button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-danger cancelar"><i
                                class="bi bi-backspace me-1"></i> CANCELAR</a>
                        <h1>Usuários - Editar</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item">Cadastros</li>
                                <li class="breadcrumb-item active">Usuários</li>
                            </ol>
                        </nav>
                    </div>

                    @error('mensagem')
                        <div class="alert alert-danger" role="alert" id="mensagemErro">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Campos do Formulário -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="name"><strong id="nameLabel">Nome</strong></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="username"><strong id="username">Username</strong></label>
                            <input type="text" name="username" id="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username', $user->username) }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="email"><strong id="emailLabel">E-mail</strong></label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password"><strong id="passwordLabel">Senha</strong></label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation"><strong id="passwordConfirmationLabel">Confirmar
                                    Senha</strong></label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
