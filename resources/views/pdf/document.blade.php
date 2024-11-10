<!doctype html>
<html lang="en">

@include('layout.header')

<body>
    <h6 class="text-center">{{ $empresa }}</h6>
    <br>
    <p>{{ $cidade }} - {{$uf}}, {{$dia}} </p>
    <br>
    <h5 class="text-center">Dados do proprietário</h5>
    <br>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td scope="col">Nome: {{ $nome }}</td>
                <td scope="col">Numero da unidade: {{$numero}}</td>
            </tr>
            <tr>
                <td scope="col">CPF: {{ $cpf }}</td>
                <td scope="col">Fração: {{$fracao}}</td>
            </tr>
            <tr>
                <td scope="col">E-mail: {{ $email }}</td>
                <td scope="col">Bloco: {{$bloco}}</td>
            </tr>
            <tr>
                <td scope="col">Telefone: {{ $telefone }}</td>
                <td scope="col">Tipo do quarto: {{$tipo_quarto}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <h5 class="text-center"><u>Solicitação de reserva</u></h5>

    <p> Eu, {{ $nome }} proprietária do apartamento acima referenciado, solícito a reserva para os seguintes hóspedes na data de {{$dataInicial}} à {{$dataFinal}}. </p>

    <br>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td scope="col">Nome:</td>
                <td scope="col">CPF:</td>
                <td scope="col">Data de nascimento:</td>

            </tr>
            @foreach($hospedes as $hospede)
            <tr>
                <td> {{ $hospede['nome'] }} </td>
                <td> {{ $hospede['cpf'] }} </td>
                <td> {{ $hospede['nascimento'] }} </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>

    <div class="text-center">

<img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(public_path('imagens/signature.png'))); ?>" width="300">
        <p>Assinatura do propietário</p>

    </div>



    <!--
    <img src="{{ asset('images/assinatura.jpg') }}" />
-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>