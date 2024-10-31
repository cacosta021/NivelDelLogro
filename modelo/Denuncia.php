<?php 
require_once("conexion.php");

class Denuncia{

    function listar($titulo){
        $sql = "SELECT u.* FROM denuncia u WHERE estado_denuncia = :estado_denuncia AND u.titulo LIKE :titulo ";
        $parametros = array(':titulo'=>$titulo, ':estado_denuncia'=>'1');
        $sql.=" ORDER BY u.titulo ASC";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }  
    
 
    function consultarDenuncia($iddenuncia){
        $sql = "SELECT * FROM denuncia WHERE iddenuncia=:iddenuncia";
        
       global $cnx;
       $pre = $cnx->prepare($sql);
       $parametros = array(':iddenuncia'=>$iddenuncia); 
       $pre->execute($parametros);
        return $pre;
    }

    function insertar($titulo, $descripcion, $ubicacion, $ciudadano, $telefono_ciudadano){
        
        $sql = "INSERT INTO denuncia(iddenuncia, titulo, descripcion, ubicacion, ciudadano, telefono_ciudadano, estado, fecha_registro) VALUES 
                                   (NULL,:titulo, :descripcion, :ubicacion, :ciudadano, :telefono_ciudadano, :estado, :fecha_registro)";
        global $cnx;
        $parametros = array(":titulo"=>$titulo,
                            ":descripcion"=>$descripcion, 
                            ":ubicacion"=>$ubicacion,
                            ":ciudadano"=>$ciudadano,
                            ":telefono_ciudadano"=>$telefono_ciudadano,
                            ":estado"=>'Pendiente',
                            ":fecha_registro"=>"now()");
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($iddenuncia, $titulo, $descripcion, $ubicacion, $ciudadano, $telefono_ciudadano, $estado){
        $sql = "UPDATE denuncia 
                SET titulo=:titulo,
                    descripcion=:descripcion,
                    ubicacion=:ubicacion,
                    ciudadano=:ciudadano,
                    telefono_ciudadano=:telefono_ciudadano,
                    estado=:estado";
        
        $parametros = array(":iddenuncia"=>$iddenuncia, 
                            ":descripcion"=>$descripcion, 
                            ":titulo"=>$titulo, 
                            ":ubicacion"=>$ubicacion, 
                            ":ciudadano"=>$ciudadano,
                            ":telefono_ciudadano"=>$telefono_ciudadano,
                            ":estado"=>$estado);
 
        $sql.=" WHERE iddenuncia=:iddenuncia";
        global $cnx;
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($iddenuncia, $estado_denuncia){
        $sql = "UPDATE denuncia SET estado_denuncia=:estado_denuncia WHERE iddenuncia=:iddenuncia";
        global $cnx;
        $parametros = array(":iddenuncia"=>$iddenuncia, ":estado_denuncia"=>$estado_denuncia);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function consultarDenunciaNombre($titulo, $iddenuncia=0){
        $sql = "SELECT * FROM denuncia WHERE titulo=? AND iddenuncia<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($titulo,$iddenuncia));
        return $pre;
    }

}

?>