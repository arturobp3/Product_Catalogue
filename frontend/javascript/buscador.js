

function actualizaBuscador(){

    $(document).ready(function(){

        $.ajax({
            url: "../backend/utilsBuscador/procesarBuscador.php",
            type: "post",
            data: {textoBuscado : $('#buscador').val()},
            dataType: "JSON",
            success: function(response){
                
                $('main .content').html(response.html);
              
            }

        });

    });
}