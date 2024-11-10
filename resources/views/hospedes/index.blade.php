<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloquear Datas Específicas com jQuery UI Datepicker</title>

    <!-- Incluir o jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluir o jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <style>
        /* Opcional: Estilo para o aviso */
        #aviso {
            color: red;
            display: none;
        }
    </style>
</head>
<body>

    <div class="container">

        <div class="row">
            <div class="form-group col-md-12">
                <h4 class="text-center text-primary mt-3 mb-3 text-bold">Reserva apartamento</h4>
            </div>
        </div>

        <div class="row">
            <div class="form group col-xl-12 col-lg-12 col-md-12 col-12 child-repeater-table">
                <form action="{{url('/salvar-reserva')}}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Data de entrada</label>
                            <input type='date' name='dataInicial' id="dataInicial" class='form-control' min="<?= date('Y-m-d'); ?>" required />
                            <p id="aviso" style="color: red; display: none;">Esta data não é permitida!</p>
                        </div>
                        <div class=" form-group col-md-6">
                            <label>Data de saída</label>
                            <input type='date' name='dataFinal' id="dataFinal" class='form-control' required />
                            <p id="aviso" style="color: red; display: none;">Esta data não é permitida!</p>
                        </div>
                    </div>

                    <h4 class="text-center text-primary mt-3 mb-3 text-bold">Dados dos hospedes</h4>
                    <br>
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data de nascimento</th>
                                <th>CPF</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th><a href="javascript:void(0)" class="btn btn-primary addRow"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type='text' name='nome[]' class='form-control' /></td>
                                <td><input type='date' name='nascimento[]' class='form-control' /></td>
                                <td><input type='text' name='cpf[]' class='form-control' /></td>
                                <td><input type='email' name='email[]' class='form-control' /></td>
                                <td><input type='text' name='telefone[]' class='form-control' /></td>

                                <td><a href="javascript:void(0)" class="btn btn-danger deleteRow">Remover</a></td>

                            </tr>
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-success">Salvar dados</button>
                    <button id="limpar" type="button" class="btn btn-primary">Limpar dados</button>

                </form>
            </div>
        </div>
    </div>







    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
    <script src="{{ asset('js/hospedes/cadastro.js') }}" defer></script>




</body>

</html>