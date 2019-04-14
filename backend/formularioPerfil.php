<?php

require_once('form.php');
require_once('cliente.php');

class formularioPerfil extends Form{

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

        $datos = unserialize($_SESSION['cliente']);

        $html = '<div class="grupo-control"><h1> Perfil </h1></div>';

        $html .= '<div class="line-2">';
        $html .= '<div class="grupo-control">';
        $html .= '<p>Nombre</p>';
        $html .= '<input type="text" name="nombre"  placeholder="'.$datos->name().'" readonly/>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Apellidos</p>';
        $html .= '<input type="text" name="apellidos"  placeholder="'.$datos->lastname().'" readonly/>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Dirección de Envío</p>';
        $html .= '<input type="text" name="direccion"  placeholder="'.$datos->address().'" readonly/>';
        $html .= '</div>';
        $html .= '</div>'; //Se cierra la linea 2;

        $html .= '<div class="line-2">';
        $html .= '<div class="grupo-control">';
        $html .= '<p>Email</p>';
        $html .= '<input type="text" name="email"  placeholder="'.$datos->email().'" readonly/>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Nombre de usuario</p>';
        $html .= '<input type="text" name="username" placeholder="'.$datos->username().'" readonly/>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Cambia contraseña</p>';
        $html .= '<input type="text" name="password2" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<button type="submit" name="registro"> Cambiar </button>';
        $html .= '</div>';
        $html .= '</div>'; //Se cierra line-2

        $html .= '<div class="line-3">';

        $pedidos = $datos->getPedidos();

        if($pedidos !== false){
            /*$html .= '<p> (Rechazar Pedido) (Ver factura) del pedido 1: Al dar click hará unas consultas en un xml generado previamente
                    y mostrará la información </p>';*/ 
            foreach($pedidos as $p){
                $html .= '<div class="pedido">';
                $html .= '<p>Número de pedido: '.$p['id'].'</p>';
                $html .= '<p>Fecha: '.$p['fecha'].'</p>';
                $html .= '<a href="../backend/utilsPedidos/cancelarPedido.php?id='.$p['id'].'&user='.$datos->username().'">
                            Cancelar</a>';
                $html .= '<a href="../backend/utilsPedidos/verFactura.php?id='.$p['id'].'user='.$datos->username().'">
                            Ver factura</a>';
                $html .= '</div>';
            }
        }
        else{
            $html .= '<h2 class="mensaje"> No se han realizado pedidos aún </h2>';
        }

        $html .= '</div>';

        return $html;
    }


    //Funcion llamada por el boton cancelar de cada uno de los pedidos
    private function cancelarPedido($p){
        echo $p['id'];
        exit();

    }


    protected function procesaFormulario($datos){


        $erroresFormulario = array();

        
        $password = isset($_POST['password2']) ? $_POST['password2'] : null;
        if ( (empty($password) || mb_strlen($password) < 5 )  ) {
            $erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        else{
            //Obtenemos los datos del cliente de la sesion
            $datos = unserialize($_SESSION['cliente']);

            //Cambiamos su contraseña
            $datos->cambiaPassword($_POST['password2']);

            //Guardamos los cambios
            Cliente::guarda($datos);

            return "index.php";
        }

        
        if(array_key_exists('cancel',$_POST)){
            self::cancelarPedido($_POST);
        }
        else if(array_key_exists('factura',$_POST)){
            //self::verFactura();
            echo "Hola";
        }

        return $erroresFormulario;

    }
}


