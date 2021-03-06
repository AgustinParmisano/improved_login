<?php	

session_start();
// include and register Twig auto-loader
require_once '../view/lib/Twig/Autoloader.php'; 
	
Twig_Autoloader::register();

try {

	// define template directory location
	$loader = new Twig_Loader_Filesystem('../view/templates');

	// initialize Twig environment
	$twig = new Twig_Environment($loader,array(
			//'debug'=> TRUE,
			//'cache' => 'compilation_cache',
			'auto_reload' => TRUE
		));

	if (((isset($_POST['user']))and($_POST['user']!=''))and((isset($_POST['password']))and($_POST['password']!=''))){
		require '../model/usuario_interface.php';
		require '../model/menu_interface.php';
		require '../model/rol_interface.php';

		//$usuario = new ORM_usuario();
		$usuario = ORM_usuario::buscar_usuario_login($_POST['user'],$_POST['password']);

		if ($usuario){
			//entra porque encontro al usuario
			
			$usuarioLogeado = $usuario; //ORM_usuario::buscar_usuario($result);
	
			if (($usuarioLogeado->getActivo())) {

				$idRolUsuario = $usuarioLogeado->getId_rol();
				$filaRol = ORM_rol::buscar_rol($idRolUsuario);
				$descripcionRol = $filaRol->getDescripcion();

				$perfil = $descripcionRol;
				if (($descripcionRol != 'Administrador')and($descripcionRol != 'FBA'))
					$perfil = str_replace($descripcionRol,'Laboratorio',$perfil);
				
				$menuPerfil = ORM_menu::buscar_menu_perfil($perfil);
				$destino = $menuPerfil[0]['destino'];//segun su perfil/rol le setea el destino de la vista

				$_SESSION['usuarioLogeado']['username'] = $usuarioLogeado->getUsername();
				$_SESSION['usuarioLogeado']['rol'] = $descripcionRol;
				$_SESSION['usuarioLogeado']['barnav'] = $destino;
				

				$template = $twig->loadTemplate('templateInicio.html');
				$template->display(array(
					'barnav' => $destino
					));

				}

				else{

					//esta inactivo
					header("Location: index.php?error=USUARIO INACTIVO");
					exit();
			}

		}
		else{	/*USUARIO INEXISTENTE CON ESE NOMBRE Y PASS*/
			header("Location: index.php?error=ERROR AL INICIAR SESION");
		}				
	}
	else{
		header("Location: index.php?error=NO HAY DATOS INGRESADOS");
			
	} 
} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}
?>