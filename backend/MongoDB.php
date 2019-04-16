<?php

class MongoDB{

    /*ATRIBUTOS PARA LA CONEXIÓN A MongoDB*/
    /*------------------------------------*/
    //Instancia Singleton (Permite una sola creación de objeto de esta clase)
    private static $instance;

    // Booleano para saber si la aplicación ha sido inicializada
    private $ini;

    // Array con los datos necesarios para conectarse a la BBDD
    private $bdConexion;

    //Conexion con la BD
    private $conn;


    public static function getInstanceMongoDB(){

        if(! isset(self::$instance)){
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function initMongoDB($datosBD){
        if(! $this->ini){

            $this->bdConexion = $datosBD;
            $this->ini = true;
        }
    }

    public function conexionMongoDB(){
        //Si la aplicacion se ha inicializado
        if($this->ini){

            //Si NO se ha creado una conexión con la BD
            if(! $this->conn){
 
                $host = $this->bdConexion['host'];
                $name = $this->bdConexion['name'];

                //Realiza la conexion
                $connection = new MongoClient($host);
                
                if( ! $connection->connected){
                    echo "Error de conexión a la BD MongoDB";
                    exit();
                }
                else{
                    try{
                        $this->conn = $connection->selectDB($name);
                    }
                    catch(Exception $e){
                        echo "No existe la base de datos ".$name." en MongoDB";
                        exit();
                    }
                }
            }

            return $this->conn; 
        }
        else{
            echo "Aplicacion no inicializada";
            exit();
        } 
    }

    public function shutdownMongoDB(){

        //Si la aplicacion se ha inicializado
        if($this->ini){
            //Si se ha realizado una conexion
            if ($this->conn !== null) {
                $this->conn->close();
            }
        }
        else{
            echo "Aplicacion no inicializada";
            exit();
        }
    }
}