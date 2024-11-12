<!DOCTYPE html>
<html lang="pt-BR">
@include('layout.header')

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
                            <input type="text" id="dataInicial" name="dataInicial" class="form-control" required>
                            <p id="aviso" style="color: red; display: none;">Esta data não é permitida!</p>
                        </div>
                        <div class=" form-group col-md-6">
                            <label>Data de saída</label>
                            <input type="text" id="dataFinal" name="dataFinal" class="form-control" required>
                        </div>
                    </div>

                    <h4 class="text-center text-primary mt-3 mb-3 text-bold">Dados dos hospedes</h4>
                    <br>
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Nascimento</th>
                                <th>CPF</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th><a href="javascript:void(0)" class="btn btn-primary addRow"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type='text' name='nome[]' class='form-control' /></td>
                                <td><input type='date' name='nascimento[]' class='form-control' max="<?= date('Y-m-d'); ?>" /></td>
                                <td><input type='text' name='cpf[]' class='form-control' /></td>
                                <td><input type='email' name='email[]' class='form-control' /></td>
                                <td><input type='text' name='telefone[]' class='form-control' /></td>

                                <td><a href=" javascript:void(0)" class="btn btn-danger deleteRow">Remover</a></td>

                            </tr>
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-success">Salvar dados</button>
                    <button id="limpar" type="button" class="btn btn-primary">Limpar dados</button>

                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            maxInterval = 60;
            // Lista de datas bloqueadas no formato YYYY-MM-DD
            const datasBloqueadas = @json($datasBloqueadas);

            // Função para verificar se a data é bloqueada
            function isDateBlocked(date) {
                const dateString = $.datepicker.formatDate('yy-mm-dd', date);
                return datasBloqueadas.includes(dateString);
            }

            // Inicializando o Datepicker
            $("#dataInicial").datepicker({
                beforeShowDay: function(date) {
                    // Se a data for bloqueada, retorna false para desabilitar
                    if (isDateBlocked(date)) {
                        return [false, "", "Data bloqueada"];
                    }
                    return [true];
                },
                dateFormat: "yy-mm-dd",
                minDate: 0,
                maxDate: maxInterval
            });
            $("#dataFinal").datepicker({

                beforeShowDay: function(date) {
                    // Se a data for bloqueada, retorna false para desabilitar
                    if (isDateBlocked(date)) {
                        return [false, "", "Data bloqueada"];
                    }
                    return [true];
                },
                dateFormat: "yy-mm-dd",
                minDate: 0,
                maxDate: maxInterval
            });

            // Exibindo aviso quando a data bloqueada é clicada
            ;
        });
    </script>




</body>

</html>