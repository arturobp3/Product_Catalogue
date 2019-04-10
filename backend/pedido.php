<?php

require_once("config.php");
require_once('aplicacion.php');

class Pedido {

    private $id;
    private $id_client;
    private $date;
    private $listProduct;
    private $price;


    private function __construct($idPedido, $id_client, $date, $listProduct, $price){
        $this->id = $idPedido;
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

    
    //Inserta una serie de productos en la tabla Pedido y devuelve un array con el id del cliente y 
    // el precio total en caso de que no haya habido ningun error
    private function insertaRealiza($idPedido, $productos){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
   
        $precioTotal = 0;
        //Calculamos el precio total
        foreach($p as $productos){
            $precioTotal += $p->price();
        }

        $cliente = unserialize($_SESSION['cliente']);

        $query=sprintf("INSERT INTO realiza(id_cliente, precioTotal) VALUES('%s', '%s', '%s')" 
        , $conn->real_escape_string($cliente->id())
        , $conn->real_escape_string($precioTotal));

        if (! $conn->query($query) ){
            return array(
                'idCliente' => $cliente->id(),
                'precioTotal' => $precioTotal
            );
        } 
        else{
            return false;
        }

    }

    //Inserta una serie de productos en la tabla Tiene y devuelve true en caso de
    //que no haya habido ningun error
    private function insertaTiene($productos){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        
        $i = 0;
    
        while($i < sizeof($productos) && ! $error){

            $query=sprintf("INSERT INTO tiene(id_producto) VALUES(%s')" 
            , $conn->real_escape_string($productos[$i]));

            if (! $conn->query($query) ){
                $error = true;
            } 

            $i++;
        }

        if($error) return false;
        else return true;
    }

    //Inserta una serie de productos en la tabla Pedido y devuelve un array con el id de insercion y 
    // la fecha actual en caso de que no haya habido ningun error
    private function insertaPedido(){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $fechaActual = date('Y-m-d H:i:s');
        
        $query=sprintf("INSERT INTO pedido(fecha) VALUES('%s')", $conn->real_escape_string($fechaActual));

        if ( $conn->query($query) ){
            $idInsert = $conn->insert_id;

            return array(
                'id' => $idInsert,
                'fecha' => $fechaActual
            );

        } else {
            return false;
        }
    }


    public static function realizarPedido($productos){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $arrayPedidoFecha = self::insertaPedido();

        //Si la primera inserccion en la tabla no ha dado problemas
        if($arrayPedidoFecha !== false){

            /*$segundaInfo = self::insertaTiene($arrayPedidoFecha[0], $productos);

            //Si la segunda inserccion en la tabla no ha dado problemas
            if($segundaInfo !== false){
                
                $arrayClientePrecio = self::insertaRealiza($idPedido, $productos);

                if($arrayClientePrecio === false){
                    echo "Error al guardar la información en la tabla 'realiza': (" . $conn->errno . ") " . utf8_encode($conn->error);
                    return false;
                }
            }
            else{
                echo "Error al guardar la información de los productos: (" . $conn->errno . ") " . utf8_encode($conn->error);
                return false;
            }*/

        } 
        else {
            echo "Error al guardar la información del pedido: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return false;
        }


        /*$pedido = new Pedido($arrayPedidoFecha[0], $arrayClientePrecio[0], $arrayPedidoFecha[1],
                            $productos, $arrayClientePrecio[1]);*/

        return true;
    } 
}
