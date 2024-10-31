<?php
session_start();

/**codigo de la session */

// Máxima duración de sesión activa en hora
define( 'MAX_SESSION_TIEMPO', 5000 );

// Controla cuando se ha creado y cuando tiempo ha recorrido 
if ( isset( $_SESSION[ 'ULTIMA_ACTIVIDAD' ] ) && 
     ( time() - $_SESSION[ 'ULTIMA_ACTIVIDAD' ] > MAX_SESSION_TIEMPO ) ) {

    // Si ha pasado el tiempo sobre el limite destruye la session
    destruir_session();
}
$_SESSION[ 'ULTIMA_ACTIVIDAD' ] = time();

function destruir_session() {

    $_SESSION = array();
    if ( ini_get( 'session.use_cookies' ) ) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - MAX_SESSION_TIEMPO,
            $params[ 'path' ],
            $params[ 'domain' ],
            $params[ 'secure' ],
            $params[ 'httponly' ] );
    }

    @session_destroy();
}

/**fin de código de la session */



if(!(isset($_SESSION['idusuario']) && $_SESSION['idusuario']>0)){
    if(!(isset($_POST['proceso']) && $_POST['proceso']=="LOGIN")){
        header("Location: index.php");
    }
}

$manejador = "mysql";
$servidor = "localhost";
$usuario = "root"; // usuario con acceso a la base de datos, generalmente root
$pass = "";// aquí coloca la clave de la base de datos del servidor o hosting
$base = "dbpnl"; //nombre de la base de datos
$cadena = "$manejador:host=$servidor;dbname=$base";

$cnx = new PDO($cadena, $usuario, $pass, array(PDO::ATTR_PERSISTENT => "true", PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

?>