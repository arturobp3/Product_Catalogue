<?php
	//Inicio del procesamiento
	require_once("../backend/config.php");
	require_once("../controller.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Producto | Product Catalog</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<div class="contenedor">

		<?php require("comun/cabecera.php"); ?>

		<main>

			<?php 

				//Obtenemos gracias al controlador los productos deseados
				$result = Controller::prodPorId($_GET['id']);

				if($result === false){
					echo "<h1 class='mensaje'> Ups! Ese producto no existe! </h1>";
					exit();
				}
			

				echo "<div class='content'>

						<script src='./javascript/productAvailable.js'></script>
			
						<div class='panel1'>
							<img src='../backend/mysql/products/".$result->id().".jpg'>

							<div class='panel1-2'>
								<h1>".$result->name()."</h1>
								<p> Proveedor: ".$result->brand()."</p>
								<p>Sin cables. Sin líos. Como por arte magia. Si hablamos de auriculares,
								los AirPods son otra historia. Se activan y se conectan solos a tu iPhone,
								Apple Watch, iPad o Mac en cuanto los sacas del estuche. El audio comienza 
								a sonar cuando te los pones y se detiene cuando te los quitas. Y puedes 
								activar Siri con dos toques para ajustar el volumen, cambiar de canción, 
								obtener indicaciones o hacer una llamada. 
								Los AirPods incorporan el chip W1 de Apple y utilizan sensores ópticos y 
								un acelerómetro para detectar si los llevas puestos. Tanto si estás usando 
								los dos como uno solo, el chip W1 distribuye el sonido y activa el micrófono 
								automáticamente. Cuando hablas por teléfono o pides algo a Siri, un segundo 
								acelerómetro activa los micrófonos con tecnología beamforming para filtrar 
								el ruido de fondo y llevar tu voz al primer plano. El chip W1 es tan eficiente 
								que los AirPods funcionan durante 5 horas con una sola carga, algo único en el 
								mercado. Pero es que además están siempre listos para regalarte los oídos 
								gracias al estuche, que te da varias cargas adicionales para que disfrutes de 
								más de 24 horas de uso. ¿Tienes prisa? Mete los auriculares en el estuche 
								durante 15 minutos y los tendrás cargados para 3 horas. </p>
							</div>
						</div>
						<div class='panel2'>
							<h2> Precio: ".$result->price()." € </h2>
							<form action='../backend/crearLista.php?id=".$result->id()."' method='post' id='form'>
								<button type='submit' onclick='button()' name='comprar' id='comprar'>Comprar</button>
							</form>

						</div>

						<div class='panel3'>
							<p> Comentarios mongoDB</p>
						</div>

						<script> cambiarComprar(".$result->quantity()."); </script>

					</div>";
			?>

		</main>

		<?php require("comun/pie.php"); ?>
		

	</div>

</body>
</html>