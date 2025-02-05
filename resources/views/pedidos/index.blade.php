@extends('layouts.default')


@section('content')
    <div class="pagetitle">

        <a href="{{ route('pedidos.create') }}" class="btn btn-success novo" role="button"><i
                class="bi bi-plus-square me-1"></i> CADASTRAR</a>

        <h1>Pedidos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Pedidos</li>
                <li class="breadcrumb-item active">Pesquisar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class="row">
        <div class="col-lg-12">


            <div class="card">

                <form class="row g-3 pesquisa" method="GET" action="{{ route('pedidos.index') }}">

                    <div class="col-md-2">
                        <label for="codigo" class="form-label"><span class="badge bg-dark">Código</span></label>
                        <input type="text" class="form-control" id="codigo" name="codigo" value="">
                    </div>
                    <div class="col-md-4">
                        <label for="nome" class="form-label"><span class="badge bg-dark">Nome</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" value="">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label"><span class="badge bg-dark">Status</span></label>
                        <select name="status" id="status" class="form-select me-2 rounded @error('status') is-invalid @enderror">
                            <option value="">Selecione Status</option>
                            <option value="Aberto" {{ old('tipo') == 'Aberto' ? 'selected' : '' }}>Aberto</option>
                            <option value="Enviado" {{ old('tipo') == 'Enviado' ? 'selected' : '' }}>Enviado</option>
                            <option value="Respondido" {{ old('tipo') == 'Respondido' ? 'selected' : '' }}>Respondido</option>
                            <option value="Finalizado" {{ old('tipo') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                    </div>
                    <div class="col-md-4 botao">
                        <button type="submit" class="btn btn-warning">Pesquisar</button>
                        <button type="button" class="btn btn-danger"
                            onclick="window.location='{{ route('pedidos.index') }}'"><i
                                class="bi bi-backspace"></i></button>
                    </div>

                </form>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    @if($pedidos->count() > 0)
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Fornecedor</th>
                                <th scope="col">Data</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                        <tr>
                            <td><strong>{{ $pedido->id }}</strong></td>
                            <td>{{ $pedido->fornecedor->nome }}</td>
                            <td>{{ $pedido->DataFormatada }}</td>
                            <td>{{ number_format($pedido->total_pedido, 2, ',', '.') }}</td>
                            <td>
                                <!-- Exibir o status com a badge -->
                                @if($pedido->status == 'Aberto')
                                    <span class="badge bg-success">Aberto</span>
                                @elseif($pedido->status == 'Enviado')
                                    <span class="badge bg-info">Enviado</span>
                                @elseif($pedido->status == 'Respondido')
                                    <span class="badge bg-warning">Respondido</span>
                                @elseif($pedido->status == 'Finalizado')
                                    <span class="badge bg-secondary">Finalizado</span>
                                @else
                                    <span class="badge bg-light">Indefinido</span>
                                @endif
                            </td>
                            <td align="center">
                                <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('pedido.pdf', $pedido->id) }}" class="btn btn-sm btn-primary" target="_blank">
                                    <i class="bi bi-printer"></i>
                                </a>
                                <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(event, this.form, '{{ $pedido->id }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-warning" role="alert">
                        Nenhum pedido encontrado.
                    </div>
                    @endif
                    <!-- End Table with stripped rows -->
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <ul class="pagination">
                        {{-- Loop pelas páginas --}}
                        {{ $pedidos->appends(request()->input())->links('pagination::bootstrap-4') }}
                    </ul>
                </div>

            </div>



        </div>
    </div>
@endsection
