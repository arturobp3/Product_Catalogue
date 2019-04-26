<main>

    <?php
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)){
			
				require_once('comun/sideBarIzq.php');

				$html = "";

				$result = Producto::productosAleatorios();

				if($result !== false){

					$html = "
						<div class='content'>
							<script src='./javascript/contentMain.js'></script>";

								foreach ($result as $key => $value) {
									if($value->quantity() > 0) $stock = "En stock";
									else $stock = "Agotado";

									$html.= "<a id='productos' href='./producto.php?id=".$value->id()."'>
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

					$html .= "<script> cambiaStock(); </script>
						</div>
					";
				}

				echo $html;


			}
	?>


</main>