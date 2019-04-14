<?php

class Factura{


        $doc = new DOMDocument();
        $doc->load('http://www.example.com/some.xml');
        $xpd = new DOMXPath($doc);


        $result = $xpd->query('//a/b');
        foreach($result as $node){
            echo $node->nodeName.'<br />';
        }




        $dom = new DOMDocument('1.0', 'utf-8');

        $element = $dom->createElement('test', 'This is the root element!');

        // Insertamos el nuevo elemento como raíz (hijo del documento)
        $strings_xml = $dom->saveXML(); 

        var_dump($strings_xml);
        exit();
        //$xml->save('mysql/"prueba.xml'); 
}