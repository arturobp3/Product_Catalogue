<?php

require_once('form.php');
require_once('../controller.php');
require_once('cliente.php');
require_once('pedido.php');

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

        //Obtenemos gracias al controlador los productos deseados

        $result = Controller::productosEnLista();
        
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
                $html .= '<a href="../backend/borrarLista.php?id='.$producto->id().'">Borrar</a>';
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
        $listProduct = null;
        $price = 0;
        foreach($productos as $key => $value){
            $p = unserialize($value);
            $price += $p->price();
            $listProduct[] = $p;
        }

        $client = unserialize($_SESSION['cliente']);
        $fecha = date('Y-m-d H:i:s');

        $pedido = new Pedido($client->id(), $fecha, $listProduct, $price);

        $estado = Pedido::realizarPedido($pedido);

        if($pedido === false){
            $erroresFormulario[] = "Ha habido algun problema al realizar el pedido";
        }
        else{

            //Generar factura XML

        }
        
        unset($_SESSION['listaProductos']);

        return $erroresFormulario;

    }
}


