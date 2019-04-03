<?php
//Cargamos las clases necesarias primero

require_once("../backend/producto.php");

?>

<div id="content">
<?php

	if( isset($_SESSION["queryProductos"]) && $_SESSION["queryProductosCorrecta"] === true){

		$result = unserialize($_SESSION["queryProductos"]);

		foreach ($result as $key => $value) {
			echo 	"<a href='#'>
						<div class='panelProducto'>
							<p>".$value->name()."</p>
							<div id='parteInf'>
								<img src='../backend/mysql/products/".$value->id().".jpg'>
								<p id='precio'>".$value->price()."€</p>
							</div>
						</div>
					</a>";
		}

		

		unset($_SESSION["queryProductos"]);
	}
	else{
		echo "NO";
		//Aqui deberian salir productos random


		//header('Location: procesarRandom.php');
	}


?>
</div>