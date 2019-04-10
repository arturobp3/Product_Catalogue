<?php

require_once('form.php');
require_once('../controller.php');
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
        $listProduct;
        foreach($productos as $key => $value){
            $listProduct[] = unserialize($value);
        }

        $pedido = Pedido::realizarPedido($listProduct);

        if($pedido === false){
            $erroresFormulario[] = "Ha habido algun problema al realizar el pedido";
        }
        else{
            $erroresFormulario[] = "Pedido realizado correctamente. Por favor compruebe en su perfil la 
                                    información del pedido.";
        }
        
        unset($_SESSION['listaProductos']);

        return $erroresFormulario;

    }
}


