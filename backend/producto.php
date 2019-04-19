<?php

require_once("config.php");
require_once('MySQL.php');
require_once('MongoDB.php');

class Producto {

    private $id;
    private $name;
    private $quantity;
    private $category;
    private $brand;
    private $price;
    private $infoMongoDB;
    private $comentarios;



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

    public function info(){
        return $this->infoMongoDB;
    }

    public function comentarios(){
        return $this->comentarios;
    }


    /* Devuelve un objeto cliente con la información del cliente $username,
     o false si no lo encuentra*/
    public static function buscarPorCategoria($category){
        $app = MySQL::getInstanceMySQL();

        $conn = $app->conexionMySQL();

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

                    $result[] = $producto;
                }
            }
            $rs->free();
            return $result;
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $result;
    }

    public static function buscarPorId($id){
        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

        $query = sprintf("SELECT * FROM producto U WHERE U.id = '%s'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;

        if ($rs) {
            if ( $rs->num_rows > 0) {

                $mongo = MongoDB::getInstanceMongoDB();
                $connectMongo = $mongo->conexionMongoDB();


                //Creamos las condiciones para la consulta
                $filter = ['_id' => $id];

                $query = new MongoDB\Driver\Query($filter);


                //Seleccionamos la base de datos y la coleccion sobre la que vamos a realizar la consulta
                $rsMongoCursor = $connectMongo->executeQuery("Product_Catalogue.InfoProducto", $query);
                //Ha devuelto un cursor


                //Convertimos los datos del cursor en un array
                $datosMongoDB = $rsMongoCursor->toArray()[0];

                
                $fila = $rs->fetch_assoc();
                $producto = new Producto($fila['nombre'],  $fila['cantidad'], $fila['categoria'],
                                    $fila['marca'], $fila['precioEuros']);
                $producto->id = $fila['id'];

                $producto->infoMongoDB = $datosMongoDB->informacion;
                $producto->comentarios = $datosMongoDB->comentarios;

               
                $result = $producto;
            }
            $rs->free();
            
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $result;
    }


    private static function actualiza($producto, $cantidad){
        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

        $query=sprintf("UPDATE producto U SET cantidad = cantidad + $cantidad WHERE U.id='%s'"
            , $producto);

        if ( $conn->query($query) ) {

            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el producto: " . $producto->id;
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $producto;
    }

    public static function decrementQuantity($productList){

        foreach($productList as $p){

            //Si tiene una cantidad mayor que 0 se actualiza.
            if($p->quantity > 0){

                $p->quantity = $p->quantity - 1;
                self::actualiza($p->id, -1);
            }
        }

        return $productList;
    }

    public static function incrementQuantity($id_pedido){
        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

        $query = sprintf("SELECT * FROM tiene U WHERE U.id_pedido = '%s'", $conn->real_escape_string($id_pedido));
        $rs = $conn->query($query);
        $result = false;

        if ($rs) {
            if ( $rs->num_rows > 0) {

                for($i = 0; $i < $rs->num_rows; $i++){
                    
                    $fila = $rs->fetch_assoc();

                    self::actualiza($fila['id_producto'], 1);
                }
            }

            $rs->free();
            
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function buscarProductos($string){
        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

        $string = $conn->real_escape_string($string);

        if($string === '') return false;

        $query = "SELECT * FROM producto U WHERE U.nombre LIKE '%{$string}%'";


        $rs = $conn->query($query);
        $result = false;

        if ($rs) {
            if ( $rs->num_rows > 0) {

                for($i = 0; $i < $rs->num_rows; $i++){
                    $fila = $rs->fetch_assoc();
                    $producto = new Producto($fila['nombre'],  $fila['cantidad'], $fila['categoria'],
                                        $fila['marca'], $fila['precioEuros']);
                    $producto->id = $fila['id'];

                    $result[] = $producto;
                }
            }
            $rs->free();
            return $result;
            
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $result;
    }

    //genera 10 numeros aleatorios entre 1 y el maximo de productos y obtiene esos productos
    //por su id
    public static function productosAleatorios(){
        $app = MySQL::getInstanceMySQL();
        $conn = $app->conexionMySQL();

        $rs = $conn->query("SELECT * FROM producto");

        $result = false;

        if ($rs) {
            //obtenemos 10 id's aleatorios entre 1 y el maximo de productos
            $arrayIndices = self::getRandArray(1, $rs->num_rows);

            //Obtenemos esos productos pertenecientes a los id's previamente seleccionados
            foreach($arrayIndices as $i){
                $rs = $conn->query("SELECT * FROM producto U WHERE U.id = $i");

                $fila = $rs->fetch_assoc();

                $producto = new Producto($fila['nombre'],  $fila['cantidad'], $fila['categoria'],
                                    $fila['marca'], $fila['precioEuros']);
                $producto->id = $fila['id'];


                $result[] = $producto;
            }

            $rs->free();
        }

        return $result;

    }

    private function getRandArray($min, $max){
 
        $array = array();

        while(sizeof($array) < 10){
            $num = rand($min, $max);

            if(! in_array($num, $array)){
                $array[] = $num; 
            }
        }

        return $array;
    }

    
}
