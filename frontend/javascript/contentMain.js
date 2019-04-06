function cambiaStock(){

    var docs = document.getElementsByClassName("stock");
    var imgs = document.getElementsByTagName("img");

    for(i = 0; i < docs.length; i++){

        if(docs[i].innerHTML == "En stock"){
            docs[i].style.color = "green";
            imgs[i].style.border = "6px solid green";
           
        }
        else{
            docs[i].style.color = "red";
            imgs[i].style.border = "6px solid red";
        }
    }
}