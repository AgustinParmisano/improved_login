<?php
//REALIZA LAS ALTAS Y MODIFICACIONES

require_once '../../model/rol_interface.php';
require_once '../../model/test_input.php';

if (isset($_POST['action'])){
	//RECOBRAR LOS DATOS POR EL POST
	if ((!isset($_POST['descripcion']))or(!test_input($_POST['descripcion']))){
		die('5'); //NO PASA VALIDACION DEL LADO DEL SERVIDOR
	}	

	$descripcion = $_POST['descripcion'];
	
	if ($_POST['action'] == 'editar'){
		$id_rol = $_POST['id_rol'];
		if((!isset($_POST['id_rol']))or(!test_input($_POST['id_rol']))){
			die('5'); //NO PASA VALIDACION DEL LADO DEL SERVIDOR
		}else{
			//HACE EL UPDATE
			$rol = new Rol ();
			$rol->setId_rol($id_rol);
			$rol->setDescripcion($descripcion);
			$result = ORM_rol::actualizar_rol($rol);
			if($result == 0)
			{	
				die('3');
			}
		}
	}
	elseif ($_POST['action'] == 'alta'){
		//HACE EL INSERT
		$result = ORM_rol::agregar_rol($descripcion);
		if($result == 0)
		{
			die('4');
		}
	}
	die('1');
}
?>