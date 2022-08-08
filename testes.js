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