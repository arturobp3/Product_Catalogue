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
        $html .= '<p>Nombre de usuario</p>';
        $html .= '<input type="text" name="username" placeholder="'.$datos->username().'" readonly/>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Contraseña</p>';
        $html .= '<input type="text" name="password" placeholder="'.$datos->password().'" readonly/>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<p>Cambia contraseña</p>';
        $html .= '<input type="text" name="password2" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<button type="submit" name="registro"> Cambiar </button>';
        $html .= '</div>';
        $html .= '</div>'; //Se cierra line-2

        $html .= '<div class="line-2">';
        $html .= '<div class="grupo-control">';
        $html .= '<p>Email</p>';
        $html .= '<input type="text" name="email"  placeholder="'.$datos->email().'" readonly/>';
        $html .= '</div>';

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


        $html .= '<div class="line-3">';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';
        $html .= '<p> Aqui van los pedidos </p>';

        $html .= '</div>';



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
                $erroresFormulario[] = "El cliente ya existe";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['cliente'] = $cliente;


                /*$carpeta = './mysql/img/'.$username;
            
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }*/


                return "index.php";
            }
        }

        return $erroresFormulario;

    }
}


