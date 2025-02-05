<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento</title>
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
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .header img {
            max-width: 100px; /* Logo um pouco menor */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .header .info {
            text-align: right;
        }
        .header h1 {
            font-size: 22px; /* Fonte um pouco menor */
            color: #2c3e50;
            margin: 0;
        }
        .header p {
            margin: 2px 0; /* Espaçamento menor */
            color: #777;
            font-size: 13px; /* Fonte menor */
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 16px; /* Fonte menor */
            color: #34495e;
            border-bottom: 2px solid #34495e;
            padding-bottom: 5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .section h2 i {
            margin-right: 8px;
            color: #2c3e50;
            font-size: 14px; /* Ícone menor */
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 13px; /* Fonte menor */
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 6px; /* Padding menor */
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
            font-size: 14px; /* Fonte menor */
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
                <h1>Orçamento</h1>
                <p>Número: {{ $orcamento->id }}</p>
                <p>Data: {{ $orcamento->data }}</p>
            </div>
        </div>

        <div class="section">
            <h2><i class="fas fa-file-alt"></i>Dados do Fornecedor</h2>
            <p><strong>Nome:</strong> {{ $fornecedor->nome }}</p>
            <p><strong>Fantasia:</strong> {{ $fornecedor->fantasia }}</p>
            <p><strong>Endereço:</strong> {{ $fornecedor->logradouro }}, {{ $fornecedor->numero }} - {{ $fornecedor->bairro }}</p>
            <p><strong>Telefone:</strong> {{ $fornecedor->telefone1 }}</p>
        </div>

        <div class="section">
            <h2><i class="fas fa-box-open"></i>Itens do Orçamento</h2>
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
                            <td>{{ $item->produto->nome }}</td>
                            <td>{{ $item->quantidade }}</td>
                            <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <p class="total"><span>Total Itens:</span> {{$orcamento->total_itens}}</p>
            <p class="total"><span>Total Orçamento:</span> R$ {{ number_format($orcamento->total_orcamento, 2, ',', '.') }}</p>
        </div>

        <div class="footer">
            <p>Este orçamento foi gerado para impressão. Para mais informações, entre em contato.</p>
            <p>© 2024 Ordex. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
