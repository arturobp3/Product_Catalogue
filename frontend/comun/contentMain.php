<?php
//Cargamos las clases necesarias primero

require_once("../backend/producto.php");

?>

<div class="content">
<script src='./javascript/contentMain.js'></script>

<?php

	if( isset($_SESSION["queryProductos"]) && $_SESSION["queryProductosCorrecta"] === true){

		$result = unserialize($_SESSION["queryProductos"]);

		foreach ($result as $key => $value) {

			if($value->quantity() > 0) $stock = "En stock";
			else $stock = "Agotado";

			echo 	"<a id='productos' href='#'>
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

			echo "<script>
					cambiaStock();
				</script>";

		

		unset($_SESSION["queryProductos"]);
	}


?>
</div>