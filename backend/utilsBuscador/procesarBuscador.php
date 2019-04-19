<?php

    require_once("../config.php");
    require_once('../MySQL.php');
    require_once('../producto.php');

    $html = '';
    $error ='';


    $texto = $_POST['textoBuscado'];


    $productosEncontrados = Producto::buscarProductos($texto);


    if($productosEncontrados === false){
        $html = "<h1 class='mensaje'> No se han encontrado productos </h1>";
    }
    else{
        $html .= "
				<script src='./javascript/contentMain.js'></script>";

					foreach ($productosEncontrados as $key => $value) {
						if($value->quantity() > 0) $stock = "En stock";
						else $stock = "Agotado";

						$html .= "<a id='productos' href='./producto.php?id=".$value->id()."'>
								<div id='panelProducto'>
									<p>".$value->name()."</p>
									<div id='parteInf'>
										<img src='../backend/mysql/products/".$value->id().".jpg'>
										<p class='stock'>".$stock."</p>
										<p id='precio'>".$value->price()."€</p>
									</div>
								</div>
							</a>";
					}
				

        $html .="<script> cambiaStock(); </script>";
    }

        
    //Codificamos la información
    $data = array(
        'html' => $html
    );

    //La enviamos en forma de JSON al cliente
    echo json_encode($data);