<main>

    <?php
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)){
			
				require_once('backend/comun/sideBarIzq.php');

				echo '<div id="content">
						<p>Articulos random</p>
					</div>';
			}
			else{
				echo '<div id="panelVacio">
						<p> Informacion de qué va el proyecto y explicar que esta hecho para una asignatura</p>
					</div>';
			}
	?>


</main>