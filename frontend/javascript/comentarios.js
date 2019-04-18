//JQuery para poner los comentarios en forma de acordeón

//Es lo mismo que: $(document).ready(function{
                        //Acordeon
                // });

$(function(){
    $('.toggle').hide();
    $('.respuestaArea').hide();
});


//AJAX para los comentarios:
function procesarComentario(id){

    $(document).ready(function(){

        $.ajax({
            data: { "comentario": $('#comment').val(), "idProd" : id },
            url:'../backend/utilsComentarios/añadirComentario.php',
            type:'post',
            dataType:'JSON', //Esto esta relacionado con el tipo de dato que devuelve el servidor
            success: function(response){
    
                //Se puede hacer un if de esta manera porque el servidor devuelve un JSON
                if(response.error == ''){
     
                    $('#mensaje').html("Comentario añadido correctamente");
                    $('#comment').val("");
                    $('#comentarios').append(response.html);
                }
                else{
                    $('#mensaje').html(response.error);
                }
            }
        });

    });
}

//Código para las respuestas

function mostrarRespuestas(i){

    $(document).ready(function() {
         
        var selectedEffect = "blind";
     
        //Abrimos la caja de las respuestas
        $( "#toggleResponse"+i ).toggle( selectedEffect, 500);

        if($('#btnResponse'+i).text() == "Ver respuestas"){
            $('#btnResponse'+i).html("Ocultar respuestas");
        }
        else{
            $('#btnResponse'+i).html("Ver respuestas");
        }
    ;

    } );
}

function mostrarAreaRespuesta(idx, idProd){

    $(document).ready(function(){
        
        var selectedEffect = "slide";
     
        //Si pone responder
        if($('#responseButton'+idx).text() == "Responder"){

            //Si no se han mostrado las respuestas
            if($('#btnResponse'+idx).text() == "Ver respuestas"){
                mostrarRespuestas(idx); //Abrimos las respuestas
            }

            //Cambiamos a enviar
            $('#responseButton'+idx).html("Enviar");
        }

        else{
            //Procesamos la respuesta que el usuario ha puesto
            procesarRespuesta(idx, idProd);

            //Cambiamos a responder
            $('#responseButton'+idx).html("Responder");
        }

        $( "#toggleArea"+idx).toggle( selectedEffect, 200); //Abrimos el area
    });
}

//Procesa al respuesta mandando una petición AJAX
function procesarRespuesta(idx, id, id_comment){

    //Texto escrito en la respuesta
    var valor = $('#toggleArea'+idx).val();

    $(document).ready(function() {

        $.ajax({
            url: '../backend/utilsComentarios/añadirRespuesta.php', //A quien se lo envias
            type: 'post',                                           //Cómo se lo envias
            data: { "respuesta": valor, "idProd" : id, "idComment" : id_comment }, //El qué le envias
            dataType: 'JSON',                                      //De qué manera responde
            success: function(response){                           //Qué haces si todo ha salido bien
                if(response.error == ''){   //Si no ha habido error
     
                    $('#toggleArea'+idx).val("");

                    $('#toggleResponse'+idx).append(response.html);
                }
            }
            
        });
    });
}