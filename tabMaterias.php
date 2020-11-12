<?php
include_once("modelo/Materia.php");
include_once("modelo/Usuario.php");
session_start();
$sErr="";
$sNom="";
$sTipo="";
$oMat = new Materia();
$oUsu = new Usuario();
if (isset($_SESSION["usu"])){
		$oUsu = $_SESSION["usu"];
		$sNom = $oUsu->getNombre();
		$sTipo = $_SESSION["tipo"];
	}
	else
		$sErr = "Falta establecer el login";
	
	if ($sErr == ""){
		include_once("arriba.php");
		include_once("menu.php");
	}
	else{
		header("Location: error.php?sErr=".$sErr);
		exit();
	}
 ?>
 		<div id="contenido">
			<section>
				<script src="js/tablaMateria.js"></script>
				<div id="espacio1">
				
				</div>
			</section>
		</div>
<?php
include_once("abajo.php");
?>


