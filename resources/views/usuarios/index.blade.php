@extends('layouts.default')


@section('content')
    <div class="pagetitle">

        <a href="{{ route('usuarios.create') }}" class="btn btn-success novo" role="button"><i
                class="bi bi-plus-square me-1"></i> CADASTRAR</a>

        <h1>Usuários</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Usuários</li>
                <li class="breadcrumb-item active">Pesquisar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class="row">
        <div class="col-lg-12">


            <div class="card">

                <form class="row g-3 pesquisa" method="GET" action="{{ route('usuarios.index') }}">

                    <div class="col-md-4">
                        <label for="name" class="form-label"><span class="badge bg-dark">Nome</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="">
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
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Nome</th>
                                <th scope="col">UserName</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $usuario)
                                <tr data-id="{{ $usuario->id }}">
                                    <th scope="row">{{ $usuario->id }}</th>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->username }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td style="width: 60px;text-align: center">
                                        <a href="{{ route('usuarios.edit', $usuario->id) }}" type="button"
                                            class="btn btn-primary acao" role="button"><i
                                                class="bi bi-pencil-square"></i></a>
                                    </td>

                                    <td style="width: 60px;text-align: center">
                                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete(event, this.form, '{{ $usuario->nome }}')">
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
                        {{ $users->appends(request()->input())->links('pagination::bootstrap-4') }}
                    </ul>
                </div>

            </div>



        </div>
    </div>
@endsection
