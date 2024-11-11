@extends('layouts.datas')

@section('content')
<div class="container">
    <h2>Escolha uma data (Datas bloqueadas não podem ser selecionadas)</h2>

    <label for="data">Escolha uma data:</label>
    <input type="text" id="data" name="data">

</div>

<script>
    $(document).ready(function() {
        // Lista de datas bloqueadas no formato YYYY-MM-DD
        const datasBloqueadas = @json($datasBloqueadas);

        // Função para verificar se a data é bloqueada
        function isDateBlocked(date) {
            const dateString = $.datepicker.formatDate('yy-mm-dd', date);
            return datasBloqueadas.includes(dateString);
        }

        // Inicializando o Datepicker
        $("#data").datepicker({
            beforeShowDay: function(date) {
                // Se a data for bloqueada, retorna false para desabilitar
                if (isDateBlocked(date)) {
                    return [false, "", "Data bloqueada"];
                }
                return [true];
            },
            dateFormat: "yy-mm-dd",
            minDate: 0
        });

        // Exibindo aviso quando a data bloqueada é clicada
        ;
    });
</script>
@endsection