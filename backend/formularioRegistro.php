<?php

require_once('form.php');
require_once('cliente.php');

class formularioRegistro extends Form{

    public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }

    private function validarDatos($dato, &$errores, $patron, $infoDato){
        if (!preg_match($patron , $dato)) {
            $errores[] = $infoDato . " contiene caracteres inválidos.";

        } else if (strlen($dato) > 32) {
            $errores[] = $infoDato . " solo puede contener hasta 32 caracteres.";

        } else if (strlen($dato) < 3) {
            $errores[] = $infoDato . " debe tener al menos 3 caracteres.";
        }
    }


    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCamposFormulario($datosIniciales){

        $html = '<div class="grupo-control"><h1> Registrarse </h1></div>';

        $html .= '<div class="line-1">';
        $html .= '<div class="grupo-control">';
        $html .= '<p>Nombre de usuario</p> <input type="text" name="username" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Contraseña</p> <input type="password" name="password" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Repite contraseña</p> <input type="password" name="password2" />';
        $html .= '</div>';
        $html .= '</div>'; //Se cierra line-1

        $html .= '<div class="line-2">';
        $html .= '<div class="grupo-control">';
        $html .= '<p>Nombre</p> <input type="text" name="nombre" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Apellidos</p> <input type="text" name="apellidos" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Email</p> <input type="text" name="email" />';
        $html .= '</div>';
        $html .= '</div>'; //Se cierra line-2

        $html .= '<div class="line-3">';
        $html .= '<div class="grupo-control">';
        $html .= '<p>Dirección de Envío</p> <input type="text" name="direccion" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<button type="submit" name="registro">Registrar</button>';
        $html .= '</div>';
        $html .= '</div>'; //Se cierra la linea 3;

        return $html;
    }

    protected function procesaFormulario($datos){

        // Patrón para usar en expresiones regulares (admite letras acentuadas y espacios)
        $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";


        $erroresFormulario = array();

        $username = isset($_POST['username']) ? $_POST['username'] : null;
        if ( empty($username) || mb_strlen($username) < 5 ) {
            $erroresFormulario[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        if ( empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            $erroresFormulario[] = "El email no tiene un formato valido.";
        }
        
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $erroresFormulario[] = "Los passwords deben coincidir";
        }

        $name = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        self::validarDatos($name, $erroresFormulario, $patron_texto, "El nombre");


        $lastname = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
        self::validarDatos($lastname, $erroresFormulario, $patron_texto, "Los apellidos");

        $address = isset($_POST['direccion']) ? $_POST['direccion'] : null;
        self::validarDatos($address, $erroresFormulario, "/[A-Za-z0-9\-\\,.]+/", "La dirección de envío");

        
        if (count($erroresFormulario) === 0) {
            $cliente = Cliente::crea($username, $password, $email, $name, $lastname, $address);

            
            if (! $cliente ) {
                $erroresFormulario[] = "El usuario ya existe";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['cliente'] = serialize($cliente);


                $carpeta = '../backend/mysql/facturas/'.$username;
            
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }


                return "index.php";
            }
        }

        return $erroresFormulario;

    }
}


