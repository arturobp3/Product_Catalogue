//JQuery para poner los comentarios en forma de acordeón

//Es lo mismo que: $(document).ready(function{
                        //Acordeon
                // });
$( function() {
    $( "#comentarios").accordion({heightStyle: "content"});
} );

$(function(){
    $('.toggle').hide();
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
                    $('#comentarios').prepend(response.html);
                }
                else{
                    $('#mensaje').html(response.error);
                }
            }
        });

    });
}


function mostrarRespuestas(i){

    $(document).ready(function() {
         
        var selectedEffect = "blind";
     
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