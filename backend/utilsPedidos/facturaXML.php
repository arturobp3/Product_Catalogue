<?php

class FacturaXML{

    private $ruta;
    private $ObjetoXML;

    public function __construct($id_pedido, $user){
        //Establecemos la ruta donde está la factura
        $this->ruta = "../backend/mysql/facturas/".$user."/pedido".$id_pedido.".xml";

        if (file_exists($this->ruta)) {
            //Cargamos el objetoXML
            $this->ObjetoXML = simplexml_load_file($this->ruta);
        }
        else{
            $this->ObjetoXML = null;
        }
    }

    //Genera la factura en la carpeta adecuada
    public static function generarFactura($cliente, $pedido){

        //Elemento principal: <Factura>
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="iso-8859-1" ?><Factura/>');

        $xml->addChild('id_Pedido', $pedido->id());
        $xml->addChild('Fecha', $pedido->date());
        $xml->addChild('Empresa', 'Product Catalogue');
        $xml->addChild('ModoCompra', 'Online');
        $c = $xml->addChild('Cliente');
        $c->addChild('id', $cliente->id());
        $c->addChild('Usuario', $cliente->username());
        $c->addChild('Nombre', $cliente->name());
        $c->addChild('Apellidos', $cliente->lastname());
        $c->addChild('DireccionEnvio', $cliente->address());

        $productList = $xml->addChild('ListaProductos');

        foreach($pedido->productList() as $p){
            $product = $productList->addChild('Producto');
            $product->addChild('id', $p->id());
            $product->addChild('Proveedor', $p->brand());
            $product->addChild('Nombre', $p->name());
            $product->addChild('Precio', $p->price());
        }

        $xml->addChild('PrecioTotal', $pedido->price());

        
        //Creamos un documento DOM para poder indentar el codigo XML
        $dom = new DOMDocument("1.0", "utf-8");
        
        //Con estas sentencias lo indentamos
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        //Cargamos el XML creado previamente
        $dom->loadXML($xml->asXML());


        $ruta = "../backend/mysql/facturas/".$cliente->username()."/pedido".$pedido->id().".xml";

        $dom->save($ruta);

        //$xml->saveXML($ruta); Para guardar sin formato
    }


    //Devuelve los datos del archivo xml
    public function getFactura(){

        if($this->ObjetoXML !== null ){

            //Realizamos la consulta en XPATH
            return $this->ObjetoXML->xpath("/Factura")[0];
        }
        else{
            return null;
        }
    }
}