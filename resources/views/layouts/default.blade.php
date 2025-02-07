<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ordex - OMBOAT</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">


    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    @include('layouts.topo')

    <!-- ======= Sidebar ======= -->
    @include('layouts.menu')


    <main id="main" class="main">

        <section class="section">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="mensagemGeral">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('layouts.rodape')

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                    <!-- A mensagem será inserida aqui via JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="bi bi-backspace"></i> Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton"><i class="bi bi-trash"></i>
                        Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/jquery.inputmask.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        // Função para abrir o modal e confirmar a desativação
        function confirmDelete(event, form, nomeCategoria) {
            event.preventDefault(); // Impede o envio do formulário

            // Atualiza o conteúdo do modal com o nome da categoria
            document.getElementById('modalBody').innerHTML =
                `Tem certeza que deseja excluir <strong>${nomeCategoria}</strong>?`;

            // Exibe o modal
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();

            // Configura o botão "Desativar" para enviar o formulário
            document.getElementById('confirmDeleteButton').onclick = function() {
                form.submit();
            };
        }
    </script>

    <script>
        // Fecha o alerta automaticamente após 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerta = document.getElementById('mensagemGeral');
            if (alerta) {
                setTimeout(() => {
                    alerta.classList.remove('show');
                    alerta.classList.add('fade');
                    setTimeout(() => alerta.remove(), 150); // Remove o alerta após a animação
                }, 3000); // 3000 = 3 segundos
            }
        });
    </script>

    <script>
        $('#telefone').inputmask('(99) 99999-9999', {
            greedy: false, // Permite que a máscara seja flexível
            clearIncomplete: true, // Limpa o campo se a entrada estiver incompleta
            placeholder: '_', // Define o caractere de placeholder
            definitions: {
                '9': { // Define o padrão para o dígito 9
                    validator: '[0-9]', // Aceita apenas números
                    cardinality: 1 // Cada "9" representa um único dígito
                }
            }

            // Máscara para CPF
            $('#cpf').inputmask('999.999.999-99');

            // Máscara para CNPJ
            $('#cnpj').inputmask('99.999.999/9999-99');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecionar todos os campos de formulário
            const formFields = document.querySelectorAll('input, textarea, select');

            // Adicionar um evento keydown para cada campo
            formFields.forEach(function(field) {
                field.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault(); // Impede o envio do formulário

                        // Verifica se o campo está em um formulário com a classe 'pesquisar' para permitir o envio
                        if (shouldSubmitForm(field)) {
                            const form = field.closest('form');
                            if (form) {
                                form.submit(); // Envia o formulário
                            }
                        } else {
                            // Caso contrário, move o foco para o próximo campo
                            let nextField = getNextField(field);
                            if (nextField) {
                                nextField.focus();
                            }
                        }
                    }
                });
            });

            // Função para decidir quando o formulário deve ser enviado
            function shouldSubmitForm(field) {
                // Verifica se o formulário possui a classe 'pesquisar'
                return field.closest('form') && field.closest('form').classList.contains('pesquisar');
            }

            // Função para encontrar o próximo campo de formulário
            function getNextField(currentField) {
                let next = currentField.nextElementSibling;
                while (next && next.tagName !== 'INPUT' && next.tagName !== 'TEXTAREA' && next.tagName !==
                    'SELECT') {
                    next = next.nextElementSibling;
                }
                return next;
            }
        });
    </script>



</body>

</html>
