<?php
//REALIZA LAS ALTAS Y MODIFICACIONES

require_once '../../model/calibrador_interface.php';
require_once '../../model/test_input.php';

if (isset($_POST['action'])){
	//RECOBRAR LOS DATOS POR EL POST
	if ((!isset($_POST['descripcion']))or(!test_input($_POST['descripcion']))
		or (!isset($_POST['id_calibrador']))or(!test_input($_POST['id_calibrador']))
		or (!isset($_POST['analitos']))or(!test_input($_POST['analitos']))){
			die ('5'); //NO PASA VALIDACION DEL LADO DEL SERVIDOR
	}
	
	$descripcion = $_POST['descripcion'];
	$id_calibrador = $_POST['id_calibrador'];
	$analitos = $_POST['analitos'];	//HACER EXPLODE
	$analitosArray = explode(",", $analitos);
	
	if ($_POST['action'] == 'editar'){
		//HACE EL UPDATE
		$calibrador = new Calibrador ();
		$calibrador->setId_calibrador($id_calibrador);
		$calibrador->setDescripcion($descripcion);
		ORM_calibrador::actualizar_calibrador($calibrador);		//DEBERIA ACTUALIZAR LAS DEPENDENCIAS VER COMO!!!
		if($result == 0){
			die ('0');		//ERROR DE UPDATE
		}
		die('1');
	}
	elseif ($_POST['action'] == 'alta'){
		//HACE EL INSERT
		$result = ORM_calibrador::agregar_calibrador($descripcion);			//VER LAS DEPENDENCIAS
		/*foreach ($analitosArray as $id_an) 
			$result = ORM_calibrador::combinar_calibrador_analito($descripcion,$id_an);	//VER LAS DEPENDENCIAS
			*/
		if($result == 0){
			die ('0');		//ERROR DE INSERCION
		}
		die('1');
	}

}
?>