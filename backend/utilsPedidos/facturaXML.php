<?php

class FacturaXML{

    public static function crearFactura($cliente, $pedido){

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


    //$xml = simplexml_load_file($ruta);


}