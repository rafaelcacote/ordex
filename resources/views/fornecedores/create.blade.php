@extends('layouts.default')


@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">

                <form class="row g-3 cadastro" method="POST" action="{{ route('fornecedores.store') }}" novalidate>
                    @csrf

                    <div class="pagetitle">

                        <button type="submit" class="btn btn-success salvar"><i class="bi bi-save2 me-1"></i> SALVAR</button>
                        <a href="{{ route('fornecedores.index') }}" class="btn btn-danger cancelar"><i
                                class="bi bi-backspace me-1"></i> CANCELAR</a>
                        <h1>Fornecedores - Adicionar</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item">Cadastros</li>
                                <li class="breadcrumb-item active">Fornecedores</li>
                            </ol>
                        </nav>

                    </div>

                    @error('mensagem')
                        <div class="alert alert-danger" role="alert" id="mensagemErro">
                            {{ $message }}

                        </div>
                    @enderror
                    <!-- -- Final do Titulo da Pagina -- -->


                    <!-- Tipo de Fornecedor -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="tipo"><strong>Tipo</strong></label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror"
                                onchange="toggleFields()">
                                <option value="J">Pessoa Jurídica</option>
                                <option value="F">Pessoa Física</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="cpf_cnpj"><strong id="cpfcnpjLabel">CNPJ</strong></label>
                            <input type="text" name="cpf_cnpj" id="cpf_cnpj"
                                class="form-control  @error('cpf_cnpj') is-invalid @enderror" value="{{ old('cpf_cnpj') }}"
                                autocomplete="off">
                            @error('cpf_cnpj')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nome"><strong id="nomeLabel">Nome</strong></label>
                            <input type="text" name="nome" id="nome"
                                class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}">
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <!-- Campos de Pessoa Jurídica -->
                    <div id="juridicaFields" style="display: block;">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="ins_estadual"><strong>Inscrição Estadual</strong></label>
                                <input type="text" name="ins_estadual" class="form-control"
                                    value="{{ old('ins_estadual') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="ins_municipal"><strong>Inscrição Municipal</strong></label>
                                <input type="text" name="ins_municipal" class="form-control"
                                    value="{{ old('ins_municipal') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="fantasia"><strong id="fantasiaLabel">Nome Fantasia</strong></label>
                                <input type="text" name="fantasia" id="fantasia" class="form-control"
                                    value="{{ old('fantasia') }}">
                            </div>
                        </div>
                    </div>



                    <!-- Telefones -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="telefone1"><strong>Telefone 1</strong></label>
                            <input type="text" name="telefone1" id="telefone1"
                                class="form-control telefone @error('telefone1') is-invalid @enderror"
                                value="{{ old('telefone1') }}">
                            @error('telefone1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="telefone2"><strong>Telefone 2</strong></label>
                            <input type="text" name="telefone2" id="telefone2" class="form-control telefone"
                                value="{{ old('telefone2') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="contato"><strong>Contato</strong></label>
                            <input type="text" name="contato" id="contato" class="form-control"
                                value="{{ old('contato') }}">
                        </div>
                    </div>

                    <!-- Endereço -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="cep"><strong>CEP</strong></label>
                            <input type="text" name="cep" id="cep"
                                class="form-control @error('cep') is-invalid @enderror" value="{{ old('cep') }}">
                            @error('cep')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="logradouro"><strong>Logradouro</strong></label>
                            <input type="text" name="logradouro" id="logradouro"
                                class="form-control @error('logradouro') is-invalid @enderror"
                                value="{{ old('logradouro') }}">
                            @error('logradouro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="numero"><strong>Número</strong></label>
                            <input type="text" name="numero" id="numero" class="form-control"
                                value="{{ old('numero') }}">
                        </div>
                    </div>

                    <!-- Bairro, CEP e Cidade -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bairro"><strong>Bairro</strong></label>
                            <input type="text" name="bairro" id="bairro"
                                class="form-control @error('bairro') is-invalid @enderror" value="{{ old('bairro') }}">
                            @error('bairro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="estado"><strong>Estado</strong></label>
                                <select name="estado_id" id="estado_id"
                                    class="form-select me-2 rounded @error('estado_id') is-invalid @enderror ">
                                    <option value="">Selecione um estado</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado->id }}"
                                            {{ old('estado_id') == $estado->id ? 'selected' : '' }}>{{ $estado->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('estado_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="cidade_id"><strong>Cidade</strong></label>
                            <select name="cidade_id" id="cidade_id" class="form-select">
                                <option value="">Selecione a cidade...</option>
                                <!-- As cidades serão carregadas aqui via AJAX -->
                            </select>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>




    {{-- CPF ou CNPJ --}}
    <script>
        function toggleFields() {
            var tipo = document.getElementById("tipo").value;
            var juridicaFields = document.getElementById("juridicaFields");
            var nomeLabel = document.getElementById("nomeLabel");
            var cpfCnpjInput = document.getElementById("cpf_cnpj");
            var cpfcnpjLabel = document.getElementById("cpfcnpjLabel");

            // Exibe ou oculta os campos de Pessoa Jurídica com base no tipo selecionado
            if (tipo == "J") {
                juridicaFields.style.display = "block";
                cpfCnpjInput.value = ""; // Limpa o campo de CPF/CNPJ
                nomeLabel.innerHTML = "Razão Social"; // Altera o nome do label para Razão Social
                cpfcnpjLabel.innerHTML = "CNPJ"; // Altera o label de CPF/CNPJ para CNPJ
                cpfCnpjInput.setAttribute("placeholder", "CNPJ"); // Altera o placeholder para CNPJ
                $(cpfCnpjInput).inputmask('99.999.999/9999-99'); // Aplica a máscara de CNPJ
                cpfCnpjInput.focus(); // Coloca o foco no campo de CNPJ
            } else {
                juridicaFields.style.display = "none";
                cpfCnpjInput.value = ""; // Limpa o campo de CPF/CNPJ
                nomeLabel.innerHTML = "Nome"; // Altera o nome do label para Nome
                cpfCnpjInput.setAttribute("placeholder", "CPF"); // Altera o placeholder para CPF
                cpfcnpjLabel.innerHTML = "CPF"; // Altera o label de CPF/CNPJ para CPF
                $(cpfCnpjInput).inputmask('999.999.999-99'); // Aplica a máscara de CPF
                cpfCnpjInput.focus(); // Coloca o foco no campo de CPF
            }
        }

        // Executa a função inicialmente para garantir que os campos estejam visíveis ou ocultos ao carregar a página
        document.addEventListener("DOMContentLoaded", function() {
            toggleFields(); // Chama a função para garantir que a exibição esteja correta
        });

        // Adiciona um listener para o campo "tipo" para alterar a máscara dinamicamente
        document.getElementById("tipo").addEventListener("change", function() {
            toggleFields(); // Chama a função para atualizar a máscara e os campos
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const estadoSelect = document.querySelector('[name="estado_id"]');
            const cidadeSelect = document.querySelector('[name="cidade_id"]');

            if (estadoSelect && cidadeSelect) {
                estadoSelect.addEventListener('change', function() {
                    const estadoId = estadoSelect.value;
                    console.log('Estado selecionado: ' + estadoId);

                    // Limpa o campo de cidades
                    cidadeSelect.innerHTML = '<option value="">Selecione a cidade...</option>';

                    if (estadoId) {
                        fetch(`/cidades/${estadoId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Erro ao carregar as cidades');
                                }
                                return response.json();
                            })
                            .then(cidades => {
                                console.log(cidades);
                                cidades.forEach(cidade => {
                                    const option = document.createElement('option');
                                    option.value = cidade.id;
                                    option.textContent = cidade.nome;
                                    cidadeSelect.appendChild(option);
                                });
                            })
                            .catch(error => {
                                console.error('Erro ao carregar as cidades:', error);
                            });
                    }
                });
            } else {
                console.error('Elementos estadoSelect ou cidadeSelect não encontrados no DOM.');
            }
        });
    </script>


    {{-- CEP --}}
    <script>
        $(document).ready(function() {
            inputnumero = document.getElementById('numero');
            inputcep = document.getElementById('cep');
            // Função para aplicar a máscara no campo CEP
            $('#cep').on('input', function() {
                var cep = $(this).val().replace(/\D/g, ''); // Remove tudo que não for número
                if (cep.length === 8) { // Verifica se o CEP tem 8 caracteres
                    // Realiza a consulta via AJAX na API do ViaCEP
                    $.ajax({
                        url: `https://viacep.com.br/ws/${cep}/json/`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data.erro) {
                                // Caso o CEP não seja encontrado, avisa o usuário
                                alert('CEP não encontrado');
                                $('#cep').focus(function() {
                                    $(this).select();
                                });

                            } else {
                                // Preenche os campos do formulário com os dados retornados

                                inputnumero.focus();
                                $('#logradouro').val(data.logradouro);
                                $('#bairro').val(data.bairro);

                                // Busca o ID do estado com base na UF retornada pela API
                                var uf = data.uf; // UF é a sigla do estado
                                if (uf) {
                                    $.ajax({
                                        url: `/estado/por-uf/${uf}`,
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(response) {
                                            console.log(response);
                                            if (response.id) {
                                                // Define o valor do estado_id com o ID retornado
                                                $('#estado_id').val(response.id)
                                                    .trigger('change');

                                                // Agora, carregue as cidades com base no estado selecionado
                                                var estadoId = response.id;
                                                if (estadoId) {
                                                    fetch(`/cidades/${estadoId}`)
                                                        .then(response => response
                                                            .json())
                                                        .then(cidades => {
                                                            var cidadeSelect =
                                                                $('#cidade_id');
                                                            cidadeSelect
                                                                .empty(); // Limpa as opções atuais
                                                            cidadeSelect.append(
                                                                '<option value="">Selecione a cidade...</option>'
                                                            );
                                                            cidades.forEach(
                                                                cidade => {
                                                                    cidadeSelect
                                                                        .append(
                                                                            new Option(
                                                                                cidade
                                                                                .nome,
                                                                                cidade
                                                                                .id
                                                                            )
                                                                        );
                                                                });

                                                            // Define o valor da cidade com base no nome retornado pela API
                                                            var cidadeNome =
                                                                data.localidade;
                                                            var cidadeOption =
                                                                cidadeSelect
                                                                .find('option')
                                                                .filter(
                                                                    function() {
                                                                        return $(
                                                                                this
                                                                            )
                                                                            .text()
                                                                            .toLowerCase() ===
                                                                            cidadeNome
                                                                            .toLowerCase();
                                                                    });

                                                            if (cidadeOption
                                                                .length > 0) {
                                                                cidadeSelect
                                                                    .val(
                                                                        cidadeOption
                                                                        .val());
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error(
                                                                'Erro ao carregar as cidades:',
                                                                error);
                                                        });
                                                }
                                            } else {
                                                console.error(
                                                    'Estado não encontrado no banco de dados.'
                                                );
                                            }
                                        },
                                        error: function() {
                                            console.error(
                                                'Erro ao buscar o ID do estado.'
                                            );
                                        }
                                    });
                                }
                            }
                        },
                        error: function() {
                            alert('Erro ao consultar o CEP');
                        }
                    });
                }
            });
        });
    </script>
@endsection
