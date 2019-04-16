<?php

require_once("config.php");
require_once('MySQL.php');

class Pedido {

    private $id;
    private $id_client;
    private $date;
    private $productList;
    private $price;


    public function __construct($id_client, $date, $productList, $price){
        $this->id_client= $id_client;
        $this->date = $date;
        $this->productList = $productList;
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

    public function productList(){
        return $this->productList;
    }

    public function price(){
        return $this->price;
    }

    
    //Inserta la información correspondiente en la tabla realiza de la bbdd
    private function insertaRealiza($pedido){
        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

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

        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

        $i = 0;

        $productos = $pedido->productList;
        
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

        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

        
        $query=sprintf("INSERT INTO pedido(fecha) VALUES('%s')", $conn->real_escape_string($pedido->date));

        if ( $conn->query($query) ){
            $pedido->id = $conn->insert_id;

        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        }

        return $pedido;
    }

    public static function cancelarPedido($id){
        
        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

        //No se puede producir inyeccion SQL puesto que esta función se la llama en un archivo donde 
        //se recibe un id por GET de manera estática y seguidamente redirige a otra página.
        $query=sprintf("DELETE FROM pedido WHERE id=$id");

        if ( $conn->query($query) ) {
            if (! $conn->affected_rows == 1) {
                echo "Error al borrar de la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }

        } else {
            echo "Error al borrar de la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $pedido;
    }


    //Funcion principal para poder realizar un pedido
    public static function realizarPedido($pedido){

        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

        //Inserta en la primera tabla
        $pedido = self::insertaPedido($pedido);

        if($pedido !== false){
                
            //Inserta en la segunda tabla
            $pedido = self::insertaTiene($pedido);
            
            if($pedido !== false){
                //Inserta en la tercera
                $pedido = self::insertaRealiza($pedido);

                //Se acaba la ejecución
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
