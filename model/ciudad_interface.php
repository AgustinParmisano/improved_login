<?php

require_once "conexion.php";
require_once "ciudad.php";

class ORM_ciudad{

public static function buscar_ciudad($id_ciudad)
  {
    $conexion = new Conexion();
    $query = $conexion->consulta("SELECT * FROM ciudad WHERE id_ciudad=?",array($id_ciudad));
    $row = $query[0];

    $ciudad = new Ciudad();
    /*
    $ciudad->setId_ciudad($row['id_ciudad']);
    $ciudad->setdescripcion($row['descripcion']);
    $ciudad->setcod_postal($row['cod_postal']);
    $ciudad->setid_pais($row['id_pais']);
    $ciudad->setId_rol($row['id_rol']);
    */
    // implementacion del metodo init
    $ciudad->init($row['id_ciudad'],$row['descripcion'],$row['cod_postal'],$row['id_pais']);
    return $ciudad;
  }

public static function buscar_ciudad_codPostal($descripcion, $cod_postal)
  {
    $conexion = new Conexion();
    $query = $conexion->consulta_fetch("SELECT id_ciudad FROM ciudad WHERE descripcion=? and cod_postal=?",array($descripcion,$cod_postal));
    $id_ciudad = $query['id_ciudad'];
    return (int)$id_ciudad;
  }

public static function obtener_todos_ciudad()
  {
    $conexion = new Conexion();
    $query = $conexion->consulta("SELECT * FROM ciudad");
    return $query;
  }
/*
public static function agregar_ciudad($ciudad)
  {
    $conexion = new Conexion();
    $sql_insert = "INSERT INTO ciudad (descripcion, cod_postal, id_pais, id_rol, activo) VALUES (?,?,?,?)";
    $campos = array($ciudad->getdescripcion(), $ciudad->getcod_postal(), $ciudad->getid_pais(), $ciudad->getId_rol(), $ciudad->getActivo());
    $query = $conexion->consulta_row($sql_insert,$campos);
    return $query;
  }
*/
public static function agregar_ciudad_campos($descripcion, $cod_postal, $id_pais)
  {
    $conexion = new Conexion();
    $sql_insert = "INSERT INTO ciudad (descripcion, cod_postal, id_pais) VALUES (?,?,?)";
    $campos = array($descripcion, $cod_postal, $id_pais);
    $query = $conexion->consulta_row($sql_insert,$campos);
    return $query;
  }

public static function eliminar_ciudad($id_ciudad)
  {
    $conexion = new Conexion();
    $sql_delete = "delete from ciudad where id_ciudad=?";
    $campos = array($id_ciudad);
    $query = $conexion->consulta_row($sql_delete,$campos);
    return $query;
  }


public static function actualizar_ciudad($ciudad)
  {
    $conexion = new Conexion();
    $sql_update = "UPDATE ciudad SET descripcion=?,cod_postal=?,id_pais=? WHERE id_ciudad=?";
    $campos = array($ciudad->getDescripcion(), $ciudad->getCod_postal(), $ciudad->getId_pais(), $ciudad->getId_ciudad());
    $query = $conexion->consulta_row($sql_update,$campos);
    return $query;
  }
  
public static function buscar_por_clave($descripcion)
  {
    $conexion = new Conexion();
    $query = $conexion->consulta_fetch("SELECT id_ciudad FROM ciudad WHERE descripcion=?",array($descripcion));
    $id_ciudad = $query['id_ciudad'];
    return (int)$id_ciudad;
  }
	
public static function agregar_ciudad($descripcion, $cod_postal, $id_pais)
  {
	$existe = ORM_ciudad::buscar_ciudad_codPostal($descripcion, $cod_postal);
    if (!$existe){
      $row_affected = ORM_ciudad::agregar_ciudad_campos($descripcion, $cod_postal, $id_pais);
  	  return $row_affected;
	  }
		return 0;
  }

  public static function obtener_todos_ciudad_Twig()
  {
    $conexion = new Conexion();
    $query = $conexion->consulta("SELECT id_ciudad, ciudad.descripcion, cod_postal, pais.descripcion AS descripcionPais FROM ciudad INNER JOIN pais ON (ciudad.id_pais = pais.id_pais)");
	return $query;
  }

  public static function buscar_ciudad_Twig($id_ciudad)
  {
    $conexion = new Conexion();
    $calibrador = $conexion->consulta_fetch("SELECT * FROM ciudad WHERE id_ciudad=?",array($id_ciudad));
    return $calibrador;
  }

    public static function buscar_pais_ciudad_Twig($id_ciudad)
  {
    $conexion = new Conexion();
    $ciudad = $conexion->consulta("SELECT *, IF(pais.id_pais IN (SELECT id_pais FROM ciudad WHERE id_ciudad = ?), 'selected', '') AS activo FROM pais",array($id_ciudad));
    return $ciudad;
  }

    public static function buscar_lab_ciudad_Twig($id_lab)
  {
    $conexion = new Conexion();
    $ciudad = $conexion->consulta("SELECT *, IF(ciudad.id_ciudad IN (SELECT laboratorio.id_ciudad FROM laboratorio WHERE id_lab = ?), 'selected', '') AS activo FROM ciudad",array($id_lab));
    return $ciudad;
  }
}
?>
