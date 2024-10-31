-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para dbpnl
CREATE DATABASE IF NOT EXISTS `dbpnl` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `dbpnl`;

-- Volcando estructura para tabla dbpnl.denuncia
CREATE TABLE IF NOT EXISTS `denuncia` (
  `iddenuncia` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `ciudadano` varchar(100) DEFAULT NULL,
  `telefono_ciudadano` varchar(15) DEFAULT NULL,
  `estado_denuncia` tinyint(4) DEFAULT 1,
  `fecha_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`iddenuncia`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla dbpnl.denuncia: ~4 rows (aproximadamente)
INSERT INTO `denuncia` (`iddenuncia`, `titulo`, `descripcion`, `ubicacion`, `estado`, `ciudadano`, `telefono_ciudadano`, `estado_denuncia`, `fecha_registro`) VALUES
	(1, 'Denuncia de Acumulación de Basura', 'los ciudadanos de mi cuadra no son limpios y dejan su basura en las calles, sabiendo que no pasa el carro recolector el día de hoy.', 'la victoria - chiclayo', 'En Proceso', 'FLOR PAZ', '901254365', 1, '0000-00-00 00:00:00'),
	(2, 'Denuncia de Ruido Excesivo', 'Por las noches el trafico no permite estar tranquilo en nuestros hogares', 'centro de chiclayo', 'Pendiente', 'CARLOS', '986623556', 1, '0000-00-00 00:00:00'),
	(3, 'Denuncia de Obras Sin Permiso', 'MI VECINO HA CERRADO LA CUADRA PARA CONSTRUIR SIN HABER SOLICITADO UN PERMISO A LA MUNICIPALIDAD', 'CARRETERA PIMENTEL', 'Pendiente', 'JOSÉ SANTAMARIA', '784596325', 1, '0000-00-00 00:00:00'),
	(4, 'MALESTAR POR RUIDO EN LAS NOCHES', 'DEBIDO AL EXCESO DE TRAFICO POR LAS NOCHES EN EL CENTRO DE CHICLAYO, TENEMOS A LA POBLACIÓN, ESTRESADA POR EL MISMO RUIDO QUE CAUSAN LOS VEHICULOS', 'CENTRO DE CHICLAYO - AV. SANJOSÉ', 'Resuelto', 'CARLOS ALBERTO ACOSTA ACOSTA', '980098157', 1, '0000-00-00 00:00:00');

-- Volcando estructura para tabla dbpnl.perfil
CREATE TABLE IF NOT EXISTS `perfil` (
  `idperfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`idperfil`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla dbpnl.perfil: ~3 rows (aproximadamente)
INSERT INTO `perfil` (`idperfil`, `nombre`, `estado`) VALUES
	(1, 'Administrador', 1),
	(2, 'jefe de Área', 1),
	(3, 'Asistente', 1);

-- Volcando estructura para tabla dbpnl.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(8) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `clave` text DEFAULT NULL,
  `idperfil` int(11) NOT NULL,
  `estado` smallint(6) DEFAULT NULL,
  `imagen_usuario` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idusuario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla dbpnl.usuario: ~0 rows (aproximadamente)
INSERT INTO `usuario` (`idusuario`, `dni`, `nombre`, `correo`, `usuario`, `clave`, `idperfil`, `estado`, `imagen_usuario`) VALUES
	(1, '11111111', 'Carlos Acosta Acosta', 'aacosta@uss.edu.pe', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 1, 'imagenes/usuario/IMG_1_user1_128x128.jpg');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
