<?php
require_once("../modelo/Denuncia.php");

controlador($_POST['proceso']);

function controlador($proceso)
{
    $objDenuncia = new Denuncia();
    switch ($proceso) {

        case "NUEVO":
            try {
                $duplicado = $objDenuncia->consultarDenunciaNombre($_POST['titulo']);
                if ($duplicado->rowCount() == 0) {
                    $resultado = $objDenuncia->insertar(
                        $_POST['titulo'],
                        $_POST['descripcion'],
                        $_POST['ubicacion'],
                        $_POST['ciudadano'],
                        $_POST['telefono_ciudadano'],
                    );
                    echo 1;
                } else {
                    echo 2;
                }
            } catch (Exception $ex) {
                echo 0;
            }
            break;

        case "ACTUALIZAR":
            try {
                $duplicado = $objDenuncia->consultarDenunciaNombre($_POST['titulo'], $_POST['iddenuncia']);
                if ($duplicado->rowCount() == 0) {
                    $resultado = $objDenuncia->actualizar($_POST['iddenuncia'], $_POST['titulo'], $_POST['descripcion'], $_POST['ubicacion'], $_POST['ciudadano'], $_POST['telefono_ciudadano'], $_POST['estado']);
                    echo 1;
                } else {
                    echo 2;
                }
            } catch (Exception $ex) {
                echo 0;
            }
            break;

        case "ELIMINAR":
            try {
                $resultado = $objDenuncia->actualizarEstado($_POST['iddenuncia'], 2);
                echo 1;
            } catch (Exception $ex) {
                echo 0;
            }
            break;
        case "ANULAR":
            try {
                $resultado = $objDenuncia->actualizarEstado($_POST['iddenuncia'], 0);
                echo 1;
            } catch (Exception $ex) {
                echo 0;
            }
            break;
        case "ACTIVAR":
            try {
                $resultado = $objDenuncia->actualizarEstado($_POST['iddenuncia'], 1);
                echo 1;
            } catch (Exception $ex) {
                echo 0;
            }
            break;
        case "CONSULTAR":
            $retorno = array();
            try {
                $resultado = $objDenuncia->consultarDenuncia($_POST['iddenuncia']);
                if ($resultado->rowCount() > 0) {
                    $retorno = $resultado->fetch(PDO::FETCH_NAMED);
                }
            } catch (Exception $ex) {
                $retorno = array();
            }
            echo json_encode($retorno);
            break;

       
        default:
            echo "No se ha definido el proceso solicitado";
            break;
    }
}
