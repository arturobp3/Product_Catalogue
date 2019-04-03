function cambiaStock(){

    var docs = document.getElementsByClassName("stock");

    for(i = 0; i < docs.length; i++){

        if(docs[i].innerHTML == "En stock"){
            docs[i].style.color = "green";
        }
        else{
            docs[i].style.color = "red";
        }
    }



}