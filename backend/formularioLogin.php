<?php

require_once('form.php');
require_once('cliente.php');


class formularioLogin extends Form{

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
        
        $html = '<div class="grupo-control"><h1> Iniciar Sesión </h1></div>';
        $html .= '<div class="grupo-control">';                            
        $html .= '<p>Nombre de usuario</p> <input type="text" name="nombrecliente" />';
        $html .= '</div>';
        $html .= '<div class="grupo-control">';
        $html .= '<p>Contraseña</p> <input type="password" name="password" />';
        $html .= '</div>';
        $html .= '<div class="grupo-control"><button type="submit" name="login">Entrar</button></div>';

        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $username = isset($datos['nombrecliente']) ? $datos['nombrecliente'] : null;

        if ( empty($username) ) {
            $erroresFormulario[] = "El nombre de cliente no puede estar vacío";
        }

        $password = isset($datos['password']) ? $datos['password'] : null;
        if ( empty($password) ) {
            $erroresFormulario[] = "El password no puede estar vacío.";
        }

        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php


            $cliente = cliente::login($username, $password);
            
            if (!$cliente) {
                $erroresFormulario[] = "El cliente o el password no coinciden";
            }
            else return "index.php";
        }

        return $erroresFormulario;
    }

}