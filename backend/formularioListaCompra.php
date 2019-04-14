<?php

require_once('form.php');
require_once('cliente.php');
require_once('pedido.php');
require_once("producto.php");
require_once("utilsPedidos/facturaXML.php");

class formularioListaCompra extends Form{

    public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }


    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCamposFormulario($datosIniciales){

        //Obtenemos los productos deseados
        if( ! isset($_SESSION['listaProductos']) || sizeof($_SESSION['listaProductos']) === 0){
            $result = false;
        }
        else{
            $result = $_SESSION['listaProductos'];
        }
        
		if($result === false){
			echo "<h1 class='grupo-control'> No hay productos en tu lista </h1>";
			exit();
        }
        else{
            $html = '<div class="grupo-control"><h1> Lista de la Compra </h1></div>';
         
            $html .= '<div class="grupo-control">';
            foreach ($result as $value) {
                $producto = unserialize($value);
                $html .= '<div class="line-4">';
                $html .= '<h3>'.$producto->id().'</h3>';
                $html .= '<h3>'.$producto->name().'</h3>';
                $html .= '<h3>'.$producto->price().' €</h3>';
                $html .= '<a href="../backend/utilsCarrito/borrarListaCompra.php?id='.$producto->id().'">Borrar</a>';
                $html .= '</div>';

            }

            $html .= '<button type="submit" name="pedido"> Aceptar pedido </button>';
            $html .= '</div>';

        }


        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $productos = $_SESSION['listaProductos'];

        //Obtenemos los productos en una lista de objetos y se los pasamos a realizar pedido
        $listaProductos = null;
        $price = 0;
        foreach($productos as $key => $value){
            $p = unserialize($value);
            $price += $p->price();
            $listaProductos[] = $p;
        }

        //Obtenemos la información del cliente
        $client = unserialize($_SESSION['cliente']);

        //Creamos la fecha actual del pedido
        $fecha = date('Y-m-d H:i:s');

        //Realizamos el pedido
        $pedido = new Pedido($client->id(), $fecha, $listaProductos, $price);
        $estado = Pedido::realizarPedido($pedido);
 
        if($estado === false){
            $erroresFormulario[] = "Ha habido algun problema al realizar el pedido";
        }
        else{
            $productList = Producto::decrementQuantity($listaProductos);


            //Creamos la factura del pedido realizado por el cliente
            FacturaXML::crearFactura($client, $pedido);
        }
        
        unset($_SESSION['listaProductos']);

        return $erroresFormulario;

    }
}


