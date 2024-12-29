const hostPath = '/qsb/public/';
const defaultMetod = 'POST';
function makeRequest(rota, dados,msg , metodo = defaultMetod){
$.ajax({
    'processing': true, 
    'serverSide': false,
      type: metodo, 
      data: dados, 
      url: hostPath + rota, 
      success: function() {
        alert(msg);
      }
  });

}