<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    <!-- Link para o Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f7f6, #e0e5ec);
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* Alinha verticalmente o conteúdo */
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 15px;
            margin-bottom: 15px;


        }

        .header img {
            max-width: 100px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header .info {
            text-align: right;
            margin-top: -70px;
            /* Ajuste o valor conforme necessário */
        }

        .header h1 {
            font-size: 22px;
            color: #2c3e50;
            margin: 0;
        }

        .header p {
            margin: 2px 0;
            color: #777;
            font-size: 13px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h2 {
            font-size: 16px;
            color: #34495e;
            border-bottom: 2px solid #34495e;
            padding-bottom: 5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            margin-top: 0px;
        }

        .section h2 i {
            margin-right: 8px;
            color: #2c3e50;
            font-size: 14px;
        }

        .section p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        .table th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: 600;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .total {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
            color: #2c3e50;
        }

        .total span {
            color: #777;
            font-weight: normal;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .footer p {
            margin: 3px 0;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ $logo }}" alt="Logo da Empresa">
            <div class="info">
                <h1>Pedido</h1>
                <p>Número: {{ $pedido->id }}</p>
                <p>Data: {{ date('d/m/Y', strtotime($pedido->data)) }}</p>
            </div>
        </div>

        <div class="section">
            <h2><i class="fas fa-file-alt"></i>Dados do Fornecedor</h2>
            <p><strong>Nome:</strong> {{ $fornecedor->nome }}</p>
            <p><strong>Fantasia:</strong> {{ $fornecedor->fantasia }}</p>
            <p><strong>Endereço:</strong> {{ $fornecedor->logradouro }}, {{ $fornecedor->numero }} -
                {{ $fornecedor->bairro }}</p>
            <p><strong>Telefone:</strong> {{ $fornecedor->telefone1 }}</p>
        </div>

        <div class="section">
            <h2><i class="fas fa-box-open"></i>Itens do Pedido</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itens as $item)
                        <tr>
                            <td>{{ $item->produto->nome }} <br>
                                @if ($item->observacao)
                                    <span class="small-text text-muted" style="font-size: 9px;">
                                        <strong>{{ $item->observacao }}</strong>
                                    </span>
                                @endif
                            </td>
                            <td>{{ $item->quantidade }}</td>
                            <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <p class="total"><span>Total Itens:</span> {{ $pedido->total_itens }}</p>
            <p class="total"><span>Total Pedido:</span> R$
                {{ number_format($pedido->total_pedido, 2, ',', '.') }}
            </p>
        </div>
        <div class="section">
            <p>
                @if ($pedido->observacao)
                <span style="font-size: 12px;"> <strong>Observação:</strong></span>
                    <span class="small-text text-muted" style="font-size: 12px;">
                          {{ $pedido->observacao }}
                    </span>
                @endif
              </p>
        </div>


        <div class="footer">
            <p>Esse Pedido foi gerado para impressão. Para mais informações, entre em contato.</p>
            <p>© 2024 Ordex. Todos os direitos reservados.</p>
        </div>
    </div>
</body>

</html>
