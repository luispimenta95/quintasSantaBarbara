<!doctype html>
<html lang="en">

@include('layout.header')


<body class="bg-light">


    <!-- START DATA -->
    <div class="container">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <!-- FORM PENCARIAN -->
            <div class="pb-3">
                <form class="d-flex" action="" method="post">
                    <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Informe o nome para realizar a pesquisa" aria-label="Search">
                    <button class="btn btn-secondary" type="submit">Pesquisar</button>
                </form>
            </div>


            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col">Numero da reserva</th>
                        <th class="col">Data inicial</th>
                        <th class="col">Data final</th>

                        <th class="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->id }}</td>
                        <td><?php echo date('d/m/Y', strtotime($reserva->dataInicial)) ?></td>
                        <td><?php echo date('d/m/Y', strtotime($reserva->dataFinal)) ?></td>
                        <td>
                            <a href='' class="btn btn-warning btn-sm">Edit</a>
                            <a href='' class="btn btn-danger btn-sm">Del</a>
                            <form action="/gerar-contrato">
                                <input type="hidden" name="id" value="{{ $reserva->id }}" />
                                <button type="submit" class="btn btn-success btn-sm">Gerar</button>
                            </form>

                        </td>
                        @endforeach
                        {{ $reservas->links()}}
                </tbody>
            </table>

        </div>
    </div>
    <!-- AKHIR DATA -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>