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
                    <th>Ações</th>

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
                    <td>R$ {{ number_format($reserva->valor, 2, ',', '.') }}</td>
                    <td>{{ $reserva->hospedeResponsavel->telefone }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm gerar-contrato-btn" data-id="{{ $reserva->id }}">Gerar Contrato</button>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function showAlert(message) {
                var existing = document.getElementById('gerar-contrato-alert');
                if (!existing) {
                    var div = document.createElement('div');
                    div.id = 'gerar-contrato-alert';
                    div.innerHTML = '<div class="alert alert-info" role="alert">' + message + '</div>';
                    var container = document.querySelector('.container');
                    if (container) container.insertBefore(div, container.firstChild);
                } else {
                    existing.innerHTML = '<div class="alert alert-info" role="alert">' + message + '</div>';
                }
            }

            document.querySelectorAll('.gerar-contrato-btn').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    var id = this.getAttribute('data-id');
                    if (!id) return;

                    // Show non-blocking message
                    showAlert('Aguarde a geração do contrato...');

                    // disable button briefly to avoid duplicate clicks
                    this.disabled = true;

                    // Create a hidden iframe to start the download without navigating away
                    var iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = '/gerar-contrato?id=' + encodeURIComponent(id);
                    document.body.appendChild(iframe);

                    // Re-enable button after a short timeout (downloads may take longer)
                    setTimeout(function () {
                        btn.disabled = false;
                    }, 50000);
                });
            });
        });
    </script>
</body>

</html>