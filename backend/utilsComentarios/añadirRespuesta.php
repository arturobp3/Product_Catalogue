<?php

require_once("../config.php");
require_once('../MongoDB.php');
require_once('../cliente.php');


$error = '';
$html = '';

$user = unserialize($_SESSION['cliente']);
$username = $user->username();
$hoy = date("d-m-Y H:i:s");


if(empty($_POST['respuesta'])){
    $error = 'Debes escribir una respuesta primero';
}
else{

    $id_Prod = $_POST['idProd'];
    $id_comment = $_POST['idComment'];


    $mongo = MongoDB::getInstanceMongoDB();
    $connectMongo = $mongo->conexionMongoDB();

    //Creamos el objero de MongoDB que nos va a permitir actualizar o crear el documento
    $bulk = new MongoDB\Driver\BulkWrite();

    //Establecemos la actualización que queremos hacer
    $bulk->update(['_id' => $id_Prod, 'comentarios._id' => $id_comment], ['$push' => ['comentarios.$.respuestas' => 
        [
            'nombre' => $username,
            'fecha' => date("d-m-Y H:i"),
            'comentario' => $_POST['respuesta'],
        ] 
    ] ] );

    //Realizamos la actualización
    $result = $connectMongo->executeBulkWrite('Product_Catalogue.InfoProducto', $bulk);


    $html = "<p id='user'>".$username."</p>
        <div id='cajaRespuesta'>
        <p class='fecha'>".date("d-m-Y H:i")."</p>
        <p id='respuesta'>".$_POST['respuesta']."</p>
        </div>";

}

//Codificamos la información
$data = array(
    'error' => $error,
    'html' => $html
);

//La enviamos en forma de JSON al cliente
echo json_encode($data);
