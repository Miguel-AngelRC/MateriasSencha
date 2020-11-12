<?php

include_once("modelo/Alumno.php");
include_once("modelo/Materia.php");
session_start();
$sErr="";
$sCve="";
$sNom="";
$sPwd="";	
$oUsu = new Usuario();
$oAlum = new Alumno();
$materias = new Materia();
$sRetJSON="";
$arrMaterias=null;

	try{
		//Realizar búsqueda mediante objeto de Alumno
		$arrMaterias = $materias->buscarTodos();
		
	}catch(Exception $e){
		error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
		$sErr = "Error en base de datos";
	}
	
	//Tiene que armar la cadena JSON
	if ($sErr == ""){
		$sRetJSON='{"arrMaterias":['; //Inicio de la cadena JSON
		if ($arrMaterias == null){
			$sRetJSON = '{"arrMaterias":["{
							"clave": -1, 
							"nombre":"No hay datos", 
							"creditos":""
						}';
		}else{
			foreach($arrMaterias as $mat){
				$sRetJSON = $sRetJSON.'{
						"clave": '.$mat->getNumClave().', 
						"nombre":"'.$mat->getNombre().'", 
						"creditos":'.$mat->getNumCreditos().' 
						},';
			}
			//Sobra una coma, eliminarla
			$sRetJSON = substr($sRetJSON,0, strlen($sRetJSON)-1);
		}
		//Fin de la cadena JSON
		$sRetJSON = $sRetJSON.']
					}';
	}else{
		$oErr->setError($nErr);
		$sRetJSON='{"arrMaterias":[{
						"clave": -1, 
						"nombre":"'.$oErr->getTextoError().'", 
						"creditos": -1
						}]
					}';
	}
	header('Content-type: application/json');
	echo $sRetJSON;
?>