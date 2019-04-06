function cambiarComprar(cantidad){

    var button = document.getElementById("comprar");

    if(button.innerHTML == "Comprar" && cantidad <= 0){
        button.innerHTML = "Agotado";
        button.style.backgroundColor = "red";
       
    }
    else{
        button.style.backgroundColor = "green";
        button.innerHTML = "Comprar";
    }

}

function button(){
    var button = document.getElementById("comprar");

    if(button.innerHTML == "Comprar"){
        button.style.backgroundColor = "#4DE319";
    }
    else{
        button.style.backgroundColor = "red";
    }
}