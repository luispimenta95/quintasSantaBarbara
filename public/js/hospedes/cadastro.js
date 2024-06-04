var limit = 4;
var count = 1;

adicionarLinha();
removerLinha();

function adicionarLinha() {
    if (count == 1) {
        $(".deleteRow").prop("disabled", true);
    }
    $("thead").on("click", ".addRow", function () {
        count++;
        var linha =
            "<tr>" +
            "<td><input type='text' name='nome[]' class='form-control' required /></td>" +
            "<td><input type='date' name='nascimento[]' class='form-control' required /></td>" +
            "<td><input type='text' name='cpf[]' class='form-control' required/></td>" +
            "<td><input type='email' name='email[]' class='form-control' required/></td>" +
            "<td><input type='text' name='telefone[]' class='form-control' required/></td>" +
            "<td><a href='javascript:void(0)' class='btn btn-danger deleteRow'>Remover</a></td>" +
            "</tr>";
        $("tbody").append(linha);
        if (count == limit) {
            $(".addRow").hide();
        }
    });
}

function removerLinha() {
    $("tbody").on("click", ".deleteRow", function () {
        count--;
        $(this).parent().parent().remove();
        if (count < limit) {
            $(".addRow").show();
        }
    });
}

function validateForm() {
    var dataInicial = new Date(document.getElementById("dataInicial").value);
    var dataFinal = new Date(document.getElementById("dataFinal").value);
    var isValid = true;
    var mensagem = "Dados salvos com sucesso. Aguarde a confirmação da sua reserva.";
    $(".form-control").each(function () {
        if ($(this).val() == "") {
            mensagem = "Por favor, informe corretamente os dados dos hóspedes.";
            isValid = false;
        }
    });
    // Check if any date is invalid
    if (isNaN(dataInicial.getTime()) || isNaN(dataFinal.getTime())) {
        mensagem = "Por favor informe datas válidas.";
        isValid = false;
    }
    // Compare the dates
    if (dataInicial > dataFinal) {
        mensagem = "A data de entrada não pode ser maior que a data de saída.";
        isValid = false;
    }

    alert(mensagem);
    return isValid;
}

$("#limpar").on("click", function (e) {
    e.preventDefault();
    $(".form-control").each(function () {
        $(this).val("");
    });
});
