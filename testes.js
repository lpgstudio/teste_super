// Função para Deixar as primeiras letras do endereço das farmácias Maiúscula
function tratarEnd(end){
    const str = end;
    
    //Certifica que todas as letras estão em lowerCase e separa elas
    const arr = str.toLowerCase().split(" ");

    //Roda um loop transformando "toUpperCase" a primeira letra.
    for (var i = 0; i < arr.length; i++) {
        arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
    }

    //Junta todos os elementos de volta separados por um espaço  
    const str2 = arr.join(" ");
    return(str2);
}

// Carregar mais posts 
var load_flag = 9;
var urlparams = $.urlParam('s');

jQuery(document).ready(function(){
  jQuery('#loadMore').click(function(){
    load_flag += 9;

    $.ajax({
      type: 'POST',
      //https://ecliente2.com.br/producao/acfarma
      url: '<?= get_site_url(); ?>/wp-content/themes/acfarma/load-posts-blog.php',
      async: true,
      data: {
        'start': load_flag,
        's': urlparams
      },
      success: function(response) {
        document.getElementById('loadmoreposts').innerHTML += response;
        ScrollReveal().reveal('.postcounter', { 
          duration: 1500,
          origin: 'bottom',
          opacity: 0,
          distance: '100px' });
          ScrollReveal().reveal('.postcounter', { interval: 250, delay: 0 });
      }
    });          
    return false;
  });
});