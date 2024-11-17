<!DOCTYPE html>
<html lang="pt-BR">
@include('layout.header')

<body>
    <?php
    $msgStatus = "As datas destacadas em vermelho estão reservadas mediante pagamento prévio enquanto as em destaque amarelo foram pré selecionadas e aguardam pagamento.";
    ?>
    <div class="container">

        <div class="row">
            <div class="form-group col-md-12">
                <h4 class="text-center text-primary mt-3 mb-3 text-bold">Reserva apartamento <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-info" aria-hidden="true"></i>
                    </button>
                </h4>
            </div>
        </div>

        <div class="row">
            <div class="form group col-xl-12 col-lg-12 col-md-12 col-12 child-repeater-table">
                <form action="{{url('/salvar-reserva')}}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Data de entrada</label>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <!-- Cabeçalho da Modal -->
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Informações importantes</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <!-- Corpo da Modal -->
                                        <div class="modal-body">
                                            <ul class="list-group">
                                                <li class="list-group-item"><?php echo $msgStatus ?></li>
                                                <li class="list-group-item">O tempo máximo para pagamento da reserva é de um (01) dia útil, via PIX caso contrário, a solicitação de reserva <b>será cancelada </b>
                                                </li>
                                                <li class="list-group-item">A reserva permite um número máximo de quatro (04) pessoas, independente da idade.</li>
                                                <li class="list-group-item">É permitido somente um período de sessenta (60) dias de antecedência para realizar a reserva.</li>
                                            </ul>
                                        </div>
                                        <!-- Rodapé da Modal -->

                                    </div>
                                </div>
                            </div>

                            <input type="text" id="dataInicial" name="dataInicial" class="form-control" required>

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
                                <td><input type='text' name='nome[]' class='form-control obrigatorio' required /></td>
                                <td><input type='date' name='nascimento[]' class='form-control obrigatorio' max="<?= date('Y-m-d'); ?>" required /></td>
                                <td><input type='text' name='cpf[]' class='form-control cpf' maxlength="11" required /></td>
                                <td><input type='email' name='email[]' class='form-control obrigatorio' required /></td>
                                <td><input type='text' name='telefone[]' class='form-control obrigatorio tel' maxlength="15" oninput="mascaraTelefone(this)" required /></td>

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
            $('[data-toggle="tooltip"]').tooltip();
            maxInterval = 60;
            // Lista de datas bloqueadas no formato YYYY-MM-DD
            const datasBloqueadas = @json($datasBloqueadas);
            const datasConfirmadas = @json($datasConfirmadas);

            // Função para verificar se a data é bloqueada
            function isDateBlocked(date) {
                const dateString = $.datepicker.formatDate('yy-mm-dd', date);
                return datasBloqueadas.includes(dateString);
            }

            function isDateConfirmed(date) {
                const dateString = $.datepicker.formatDate('yy-mm-dd', date);
                return datasConfirmadas.includes(dateString);
            }

            // Inicializando o Datepicker
            $("#dataInicial").datepicker({
                beforeShowDay: function(date) {
                    // Se a data for bloqueada, retorna false e aplica a classe "blocked" ao link
                    if (isDateBlocked(date)) {
                        return [false, "blocked", "Data bloqueada"]; // Desabilita a data e aplica a classe "blocked"
                    }

                    if (isDateConfirmed(date)) {
                        return [false, "analisando", "Data aguardando pagamento"]; // Desabilita a data e aplica a classe "blocked"
                    }
                    return [true]; // Caso contrário, a data é habilitada
                },
                dateFormat: "yy-mm-dd",
                minDate: 0,
                maxDate: maxInterval,
                onChangeMonthYear: function(year, month, inst) {
                    // Este evento é disparado quando o mês ou ano é alterado
                    var dates = inst.dpDiv.find('a'); // Encontra todos os links <a> dentro do datepicker
                    dates.each(function() {
                        var $this = $(this);
                        var currentDate = new Date(inst.selectedYear, inst.selectedMonth, $this.text()); // Cria um objeto Date com o ano, mês e dia

                        // Verifica se a data está bloqueada
                        if (isDateBlocked(currentDate)) {
                            $this.addClass('blocked'); // Se a data for bloqueada, adiciona a classe 'blocked' ao <a>

                            // Agora, procura por um <span> dentro do <a> e adiciona a classe 'blocked'
                            var span = $this.find('span'); // Procura um <span> dentro do <a>
                            if (span.length) {
                                span.addClass('blocked'); // Adiciona a classe 'blocked' ao <span> se ele existir
                            }
                        } else {
                            $this.removeClass('blocked'); // Se não for bloqueada, remove a classe 'blocked'

                            // Remove a classe 'blocked' do <span> dentro do <a> se existir
                            var span = $this.find('span');
                            if (span.length) {
                                span.removeClass('blocked'); // Remove a classe 'blocked' do <span>
                            }
                        }

                        // Verifica se a data está bloqueada
                        if (isDateConfirmed(currentDate)) {
                            $this.addClass('analisando'); // Se a data for bloqueada, adiciona a classe 'analisando' ao <a>

                            // Agora, procura por um <span> dentro do <a> e adiciona a classe 'analisando'
                            var span = $this.find('span'); // Procura um <span> dentro do <a>
                            if (span.length) {
                                span.addClass('analisando'); // Adiciona a classe 'analisando' ao <span> se ele existir
                            }
                        } else {
                            $this.removeClass('analisando'); // Se não for bloqueada, remove a classe 'analisando'

                            // Remove a classe 'analisando' do <span> dentro do <a> se existir
                            var span = $this.find('span');
                            if (span.length) {
                                span.removeClass('analisando'); // Remove a classe 'blocked' do <span>
                            }
                        }
                    });
                }
            });

            $("#dataFinal").datepicker({
                beforeShowDay: function(date) {
                    // Se a data for bloqueada, retorna false e aplica a classe "blocked" ao link
                    if (isDateBlocked(date)) {
                        return [false, "blocked", "Data bloqueada"]; // Desabilita a data e aplica a classe "blocked"
                    }

                    if (isDateConfirmed(date)) {
                        return [false, "analisando", "Data aguardando pagamento"]; // Desabilita a data e aplica a classe "blocked"
                    }
                    return [true]; // Caso contrário, a data é habilitada
                },
                dateFormat: "yy-mm-dd",
                minDate: 0,
                maxDate: maxInterval,
                onChangeMonthYear: function(year, month, inst) {
                    // Este evento é disparado quando o mês ou ano é alterado
                    var dates = inst.dpDiv.find('a'); // Encontra todos os links <a> dentro do datepicker
                    dates.each(function() {
                        var $this = $(this);
                        var currentDate = new Date(inst.selectedYear, inst.selectedMonth, $this.text()); // Cria um objeto Date com o ano, mês e dia

                        // Verifica se a data está bloqueada
                        if (isDateBlocked(currentDate)) {
                            $this.addClass('blocked'); // Se a data for bloqueada, adiciona a classe 'blocked' ao <a>

                            // Agora, procura por um <span> dentro do <a> e adiciona a classe 'blocked'
                            var span = $this.find('span'); // Procura um <span> dentro do <a>
                            if (span.length) {
                                span.addClass('blocked'); // Adiciona a classe 'blocked' ao <span> se ele existir
                            }
                        } else {
                            $this.removeClass('blocked'); // Se não for bloqueada, remove a classe 'blocked'

                            // Remove a classe 'blocked' do <span> dentro do <a> se existir
                            var span = $this.find('span');
                            if (span.length) {
                                span.removeClass('blocked'); // Remove a classe 'blocked' do <span>
                            }
                        }

                        // Verifica se a data está bloqueada
                        if (isDateConfirmed(currentDate)) {
                            $this.addClass('analisando'); // Se a data for bloqueada, adiciona a classe 'analisando' ao <a>

                            // Agora, procura por um <span> dentro do <a> e adiciona a classe 'analisando'
                            var span = $this.find('span'); // Procura um <span> dentro do <a>
                            if (span.length) {
                                span.addClass('analisando'); // Adiciona a classe 'analisando' ao <span> se ele existir
                            }
                        } else {
                            $this.removeClass('analisando'); // Se não for bloqueada, remove a classe 'analisando'

                            // Remove a classe 'analisando' do <span> dentro do <a> se existir
                            var span = $this.find('span');
                            if (span.length) {
                                span.removeClass('analisando'); // Remove a classe 'blocked' do <span>
                            }
                        }
                    });
                }
            });


            // Exibindo aviso quando a data bloqueada é clicada
        });
    </script>




</body>

</html>