<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Lista de reservas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Codigo da reserva</th>
                    <th>Data de entrada</th>
                    <th>Data de saída</th>
                    <th> Status Pagamento
                    <th>Locador responsável</th>
                    <th>Valor </th>
                    <th>Telefone para contato</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id }}</td>
                    <td><?php echo date('d/m/Y', strtotime($reserva->dataInicial)) ?></td>
                    <td><?php echo date('d/m/Y', strtotime($reserva->dataFinal)) ?></td>
                    <?php
                    if ($reserva->reservaConfirmada == 0) {
                        $status = "Aguardando Pagamento";
                    } else {
                        $status = "Pago";
                    }
                    ?>
                    <td>{{ $status }}</td>
                    <td>{{ $reserva->hospedeResponsavel->nome }}</td>
                    <td>R$ {{ number_format($reserva->valorReserva, 2, ',', '.') }}</td>
                    <td>{{ $reserva->hospedeResponsavel->telefone }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>