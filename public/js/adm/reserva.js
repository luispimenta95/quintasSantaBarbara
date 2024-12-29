import('./../main.js');
function updatePagamento(idReserva) {
  var dados = {id:idReserva};
    if(confirm('Ao gerar o contrato você confirma o pagamento. Deseja continuar?')){
      makeRequest('gerar-contrato', dados,'Contrato Gerado com sucesso!', 'get');
    }
 } 