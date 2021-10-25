<?php
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$nombre_local = (isset($_POST['nombre_local'])) ? $_POST['nombre_local'] : '';
$calle_local = (isset($_POST['calle_local'])) ? $_POST['calle_local'] : '';
$cp_local = (isset($_POST['cp_local'])) ? $_POST['cp_local'] : '';
$ciudad_local = (isset($_POST['ciudad_local'])) ? $_POST['ciudad_local'] : '';
$lat_local = (isset($_POST['lat_local'])) ? $_POST['lat_local'] : '';
$long_local = (isset($_POST['long_local'])) ? $_POST['long_local'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_local = (isset($_POST['id_local'])) ? $_POST['id_local'] : '';


switch($opcion){
    case 1:
        $consulta = "INSERT INTO locales (nombre_local, calle_local, cp_local, ciudad_local, lat_local, long_local) VALUES('$nombre_local', '$calle_local', '$cp_local', '$ciudad_local', '$lat_local', '$long_local') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        
        $consulta = "SELECT * FROM locales ORDER BY id_local DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);       
        break;    
    case 2:        
        $consulta = "UPDATE locales SET nombre_local='$nombre_local', calle_local='$calle_local', cp_local='$cp_local', ciudad_local='$ciudad_local', lat_local='$lat_local', long_local='$long_local' WHERE id_local='$id_local' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM locales WHERE id_local='$id_local' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:        
        $consulta = "DELETE FROM locales WHERE id_local='$id_local' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
    case 4:    
        $consulta = "SELECT * FROM locales";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;