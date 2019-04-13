<?php

require_once("config.php");
require_once('aplicacion.php');

class Pedido {

    private $id;
    private $id_client;
    private $date;
    private $listProduct;
    private $price;


    public function __construct($id_client, $date, $listProduct, $price){
        $this->id_client= $id_client;
        $this->date = $date;
        $this->listProduct = $listProduct;
        $this->price = $price;
    }

    public function id(){ 
        return $this->id; 
    }

    public function cliente(){
        return $this->id_client;
    }

    public function date(){
        return $this->date;
    }

    public function listProduct(){
        return $this->listProduct;
    }

    public function price(){
        return $this->price;
    }

    
    //Inserta la información correspondiente en la tabla realiza de la bbdd
    private function insertaRealiza($pedido){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query=sprintf("INSERT INTO realiza(id_cliente, id_pedido, precioTotal) VALUES('%s', '%s', '%s')" 
        , $conn->real_escape_string($pedido->id_client)
        , $conn->real_escape_string($pedido->id)
        , $conn->real_escape_string($pedido->price));

        if (! $conn->query($query) ){
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        } 
  
        return $pedido;
    }

    //Inserta una serie de productos en la tabla Tiene y devuelve true en caso de
    //que no haya habido ningun error
    private function insertaTiene($pedido){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $i = 0;

        $productos = $pedido->listProduct;
        
        $error = false;
        while($i < sizeof($productos) && ! $error){

            $query=sprintf("INSERT INTO tiene(id_producto, id_pedido) VALUES('%s', '%s')" 
            , $productos[$i]->id(), $pedido->id);

            if (! $conn->query($query) ){
                $error = true;
            }

            $i++;
        }

        if($error) return false;
        else return $pedido;
    }

    //Inserta un pedido en la tabla Pedido 
    private function insertaPedido($pedido){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        
        $query=sprintf("INSERT INTO pedido(fecha) VALUES('%s')", $conn->real_escape_string($pedido->date));

        if ( $conn->query($query) ){
            $pedido->id = $conn->insert_id;

        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        }

        return $pedido;
    }


    //Funcion principal para poder realizar un pedido
    public static function realizarPedido($pedido){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $pedido = self::insertaPedido($pedido);

        if($pedido !== false){
                
            $pedido = self::insertaTiene($pedido);
            
            if($pedido !== false){
                $pedido = self::insertaRealiza($pedido);
            }
            else{
                return false;
            }

            return true;
        }
        else{
            return false;
        }


    } 
}
