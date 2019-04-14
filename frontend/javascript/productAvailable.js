

//Maneja el boton comprar de dentro de un producto para que puedas utilizarlo o no.
function cambiarComprar(cantidad){

    var button = document.getElementById("comprar");

    if(button.innerHTML == "Comprar" && cantidad <= 0){
        button.innerHTML = "Agotado";
        button.style.backgroundColor = "red";
        button.disabled = true;
       
    }
    else{
        button.style.backgroundColor = "green";
        button.innerHTML = "Comprar";
        button.disabled = false;
    }

}

//Utilizada cuando pulsas un boton del producto.
function button(){
    var button = document.getElementById("comprar");

    if(button.innerHTML == "Comprar"){
        button.style.backgroundColor = "#4DE319";
    }
    else{
        button.style.backgroundColor = "red";
    }
}