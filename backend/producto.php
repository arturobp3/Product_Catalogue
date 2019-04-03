<?php

require_once("config.php");
require_once('aplicacion.php');

class Producto {

    private $id;
    private $name;
    private $quantity;
    private $category;
    private $brand;
    private $price;



    private function __construct($name, $quantity, $category, $brand, $price){
        $this->name= $name;
        $this->quantity = $quantity;
        $this->category = $category;
        $this->brand = $brand;
        $this->price = $price;
    }

    public function id(){ 
        return $this->id; 
    }

    public function name(){
        return $this->name;
    }

    public function quantity(){
        return $this->quantity;
    }

    public function category(){
        return $this->category;
    }

    public function brand(){
        return $this->brand;
    }

    public function price(){
        return $this->price;
    }


    /* Devuelve un objeto cliente con la información del cliente $username,
     o false si no lo encuentra*/
    public static function buscarPorCategoria($category){
        $app = Aplicacion::getInstance();

        $conn = $app->conexionBD();

        $query = sprintf("SELECT * FROM producto U WHERE U.categoria = '%s'", $conn->real_escape_string($category));
        $rs = $conn->query($query);
        $result = false;

        if ($rs) {
            if ( $rs->num_rows > 0) {

                for($i = 0; $i < $rs->num_rows; $i++){
                    $fila = $rs->fetch_assoc();
                    $producto = new Producto($fila['nombre'],  $fila['cantidad'], $fila['categoria'],
                                        $fila['marca'], $fila['precioEuros']);
                    $producto->id = $fila['id'];

                    $resultado[] = $producto;
                }
            }
            $rs->free();
            return $resultado;
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $result;
    }

    
    
    
    public static function actualizaCantidad($producto, $cantidad){
        if ($producto->id !== null) {
            return self::actualiza($producto, $cant);
        }
        else{
            echo "Error al actualizar cantidad. El id del producto no existe: (" . $conn->errno . ") " . utf8_encode($conn->error);
        }
    }


    private static function actualiza($producto, $cant){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query=sprintf("UPDATE producto U SET cantidad='%s' WHERE U.id='%i'"
            , $conn->real_escape_string($cant)
            , $producto->id);

        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el cliente: " . $producto->id;
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $producto;
    }
    
}
