function updatePagamento(idReserva) {
    $.ajax({
        'processing': true, 
        'serverSide': false,
          type: "GET",
          data: {id: idReserva},
          url: "/qsb/public/gerar-contrato",
          success: function() {
            alert('Contrato gerado com sucesso');
          }
      });
}
