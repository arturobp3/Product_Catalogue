<?php
	//Inicio del procesamiento
	require_once("../backend/config.php");
	require_once("../backend/producto.php");
	require_once("../backend/cliente.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Producto | Product Catalog</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<script src='./javascript/productAvailable.js'></script>

	<!-- jQuery para la parte de los comentarios-->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="./javascript/comentarios.js"></script>
	<!------------------------------------------->
</head>
<body>

<div class="contenedor">

<?php require("comun/cabecera.php"); ?>

<main>

	<?php 

		//Obtenemos gracias al controlador los productos deseados
		$result = Producto::buscarPorId($_GET['id']);
		$id = $result->id();

		if($result === false){
			echo "<h1 class='mensaje'> Ups! Ese producto no existe! </h1>";
			exit();
		}
			
		$html = "<div class='content'>

			
				<div class='panel1'>
					<img src='../backend/mysql/products/".$result->id().".jpg'>

					<div class='panel1-2'>
						<h1>".$result->name()."</h1>
						<p> Proveedor: ".$result->brand()."</p>
						<br>
						<p>".$result->info()."</p>
					</div>
				</div>
				<div class='panel2'>
					<h2> Precio: ".$result->price()." € </h2>
					<form action='../backend/utilsCarrito/crearListaCompra.php?id=".$result->id()."' method='post' id='form'>
						<button type='submit' onclick='button()' name='comprar' id='comprar'>Comprar</button>
					</form>

				</div>

				<script> cambiarComprar(".$result->quantity()."); </script>

				
				<div class='panel3'>
					<h2 id='texto'> Deja tu comentario </h2>
					<form method='post' id='commentForm'>
						<textarea name='comment' id='comment' rows='2'></textarea>
						<button type='button' onclick='procesarComentario($id)' 
							name='submit' id='submit'> Comentar </button>
					</form>
					<p id='mensaje'></p>
					<div id='comentarios'>";

					for($i = 0; $i < sizeof($result->comentarios()); $i++){

						$html .= "<h2 id='user'>".$result->comentarios()[$i]->nombre."</h2>
								<div id='cajaComentario'>
									<p class='fecha'>".$result->comentarios()[$i]->fecha."</p>
									<p id='comentario'>".$result->comentarios()[$i]->comentario."</p>
									<a id='btnResponse$i' class='btnResponse' onclick='mostrarRespuestas($i)'>Ver respuestas</a>
									<div id='toggleResponse$i' class='toggle'>";

									if(sizeof($result->comentarios()[$i]->respuestas) > 0){
										for($j = 0; $j < sizeof($result->comentarios()[$i]->respuestas); $j++){

											$html .= "
													<p id='user'>".$result->comentarios()[$i]->respuestas[$j]->nombre."</p>
													<div id='cajaRespuesta'>	
														<p class='fecha'>".$result->comentarios()[$i]->respuestas[$j]->fecha."</p>
														<p id='respuesta'>".$result->comentarios()[$i]->respuestas[$j]->comentario."</p>
													</div>";
										}
									}
									else $html .= '<p> No ha respondido nadie </p>';

						$idComment = $result->comentarios()[$i]->_id;
								
									//Cierra id='toggleResponse'
						$html .= "</div> 
								<form method='post' id='responseForm'>
									<button type='button' onclick='mostrarAreaRespuesta($i, $id)' 
										id='responseButton$i'>Responder</button>
									<textarea id='toggleArea$i' class='respuestaArea' name='comment' id='comment' rows='1'></textarea>
									
								</form>
							</div>"; //Cierra id='cajaComentario'
					}
					//Cierra id='comentarios'
			$html .= "</div>
						
			</div>
		</div>";


		echo $html;
	?>

</main>

<?php require("comun/pie.php"); ?>
		
</div>

</body>
</html>