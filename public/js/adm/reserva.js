function updatePagamento(idReserva) {
   if(confirm('Ao gerar o contrato você confirma o pagamento. Deseja continuar?')){
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
}
