<?php
//DRY don't repeat yourself
$tipo_usuario = array('Adm','FBA','Lab');

require_once '../validarSesion.php';
require_once '../../model/encuesta_interface.php';

$parametro_template = 'abm/vista_encuesta.html';
$parametro_datos = ORM_encuesta::buscar_encuesta_Twig2($_POST['id_encuesta']);

$parametro_display = array(
    'encuesta' => $parametro_datos
  );

require '../controller.generico.php';

?>