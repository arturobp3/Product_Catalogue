<?php

require_once("../backend/producto.php");

class Controller{


    //Si encuentra los productos los devuelve, sino devuelve false
    public static function prodPorCategoria($categoria){

        return Producto::buscarPorCategoria($categoria);
    }

    public static function prodPorId($id){
        
        return Producto::buscarPorId($id);
    }


    public static function productosEnLista(){

        if( ! isset($_SESSION['listaProductos']) || sizeof($_SESSION['listaProductos']) === 0){
            return false;
        }
        else{
            return $_SESSION['listaProductos'];
        }
    }



}