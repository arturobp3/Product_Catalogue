<?php

require_once('aplicacion.php');

class Cliente {

    private $id;
    private $username;
    private $password;
    private $email;
    private $name;
    private $lastname;
    private $address;


    private function __construct($username, $password, $email, $name, $lastname, $address){
        $this->username= $username;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->address = $address;
       
    }

    public function id(){ 
        return $this->id; 
    }


    public function username(){
        return $this->username;
    }

    public function email(){
        return $this->email;
    }

    public function name(){
        return $this->name;
    }

    public function lastname(){
        return $this->lastname;
    }

    public function address(){
        return $this->address;
    }


    //Revisar esta función
    public function cambiaPassword($nuevoPassword){
        $this->password = self::hashPassword($nuevoPassword);
    }


    /* Devuelve un objeto cliente con la información del cliente $username,
     o false si no lo encuentra*/
    public static function buscacliente($username){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT * FROM cliente U WHERE U.user = '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $result = false;

        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Cliente($fila['user'], $fila['pass'], $fila['email'],
                                    $fila['nombre'], $fila['apellidos'], $fila['direccion']);
                $user->id = $fila['id'];


                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $result;
    }

    /*Comprueba si la contraseña introducida coincide con la del cliente.*/
    public function compruebaPassword($password){
        return password_verify($password, $this->password);
    }

    /* Devuelve un objeto cliente si el cliente existe y coincide su contraseña. En caso contrario,
     devuelve false.*/
    public static function login($username, $password){
        $user = self::buscacliente($username);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }
    
    /* Crea un nuevo cliente con los datos introducidos por parámetro. */
    public static function crea($username, $password, $email, $name, $lastname, $address){
        $user = self::buscacliente($username);
        if ($user) {
            return false;
        }
        $user = new cliente($username, password_hash($password, PASSWORD_DEFAULT),
                            $email, $name, $lastname, $address);


        return self::guarda($user);
    }
    
    
    public static function guarda($cliente){
        if ($cliente->id !== null) {
            return self::actualiza($cliente);
        }
        return self::inserta($cliente);
    }
    
    private static function inserta($cliente){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("INSERT INTO cliente(user, pass, email, nombre, apellidos, direccion) 
                        VALUES('%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($cliente->username)
            , $conn->real_escape_string($cliente->password)
            , $conn->real_escape_string($cliente->email)
            , $conn->real_escape_string($cliente->name)
            , $conn->real_escape_string($cliente->lastname)
            , $conn->real_escape_string($cliente->address));

        if ( $conn->query($query) ){
            $cliente->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $cliente;
    }
    
    private static function actualiza($cliente){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("UPDATE cliente U SET user = '%s', pass='%s', email='%s', nombre='%s', apellidos='%s', direccion='%s'
                        WHERE U.id=%i"
            , $conn->real_escape_string($cliente->username)
            , $conn->real_escape_string($cliente->password)
            , $conn->real_escape_string($cliente->email)
            , $conn->real_escape_string($cliente->name)
            , $conn->real_escape_string($cliente->lastname)
            , $conn->real_escape_string($cliente->address)
            , $cliente->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el cliente: " . $cliente->id;
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $cliente;
    }
    
}
