var limit = 4; // Limite de 4 linhas
var count = 1; // Inicializando com 1 linha (a primeira linha não pode ser excluída)
var today = new Date();
var yyyy = today.getFullYear();
var mm = String(today.getMonth() + 1).padStart(2, '0'); // Mês começa em 0
var dd = String(today.getDate()).padStart(2, '0');
today = yyyy + '-' + mm + '-' + dd;
var linha =
    "<tr>" +
    "<td><input type='text' name='nome[]' class='form-control' required /></td>" +
    "<td><input type='date' name='nascimento[]' class='form-control' required max='" + today + "' /></td>" +
    "<td><input type='text' name='cpf[]' class='form-control' required/></td>" +
    "<td><input type='email' name='email[]' class='form-control' required/></td>" +
    "<td><input type='text' name='telefone[]' class='form-control' required/></td>" +
    "<td><a href='javascript:void(0)' class='btn btn-danger deleteRow'>Remover</a></td>" +
    "</tr>";

// Função para adicionar uma linha à tabela
function adicionarLinha() {
    if (count < limit) { // Verifica se o número de linhas é menor que o limite
        count++; // Incrementa o contador de linhas
        $("tbody").append(linha); // Adiciona a linha à tabela
        // Desabilitar o botão de adicionar quando atingir o limite de 4 linhas
        if (count == limit) {
            $(".addRow").prop("disabled", true); // Esconde o botão de adicionar após atingir o limite

        }
    } else {
        $(".addRow").show(); // Mostra o botão de adicionar caso o número de linhas seja inferior ao limite

    }
}

// Função para remover uma linha da tabela
function removerLinha() {
    $("tbody").on("click", ".deleteRow", function () {
        // Impede a remoção se for a primeira linha ou se houver apenas uma linha
        if ($(this).closest("tr").index() === 0) {
            return; // Não faz nada se for a primeira linha ou se count <= 1
        }

        $(this).closest("tr").remove(); // Remove a linha
        count--; // Decrementa o contador de linhas

        if (count <= 0) {
            count = 1; // Zera o contador de linhas
        }

        // Habilita o botão de adicionar se o número de linhas for menor que o limite
        if (count < limit) {
            $(".addRow").show();
        }
    });
}

// Função de exemplo para inicializar a tabela
$(document).ready(function () {
    // Atribuindo o evento de adicionar linha ao botão de adicionar
    $(".addRow").on("click", function () {
        adicionarLinha(); // Chama a função para adicionar uma linha
    });

    // Chama a função para remover a linha quando o botão "Remover" for clicado
    removerLinha();
});


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
