-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.41-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema bdtutorial
--

CREATE DATABASE IF NOT EXISTS bdtutorial;
USE bdtutorial;

--
-- Definition of table `detalleventa`
--

DROP TABLE IF EXISTS `detalleventa`;
CREATE TABLE `detalleventa` (
  `codigoVenta` int(11) NOT NULL,
  `codigoProducto` int(11) NOT NULL,
  `cantidad` decimal(18,2) NOT NULL,
  `descuento` decimal(18,2) NOT NULL,
  PRIMARY KEY  (`codigoVenta`,`codigoProducto`),
  KEY `FK_DetalleVenta_Producto` (`codigoProducto`),
  CONSTRAINT `FK_DetalleVenta_Producto` FOREIGN KEY (`codigoProducto`) REFERENCES `producto` (`codigoProducto`),
  CONSTRAINT `FK_DetalleVenta_Venta` FOREIGN KEY (`codigoVenta`) REFERENCES `venta` (`codigoVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detalleventa`
--

/*!40000 ALTER TABLE `detalleventa` DISABLE KEYS */;
INSERT INTO `detalleventa` (`codigoVenta`,`codigoProducto`,`cantidad`,`descuento`) VALUES 
 (1,3,'12.00','0.00'),
 (1,4,'23.00','230.00'),
 (2,1,'12.00','0.00'),
 (2,2,'3.00','0.00'),
 (2,4,'12.00','120.00'),
 (3,4,'1.00','10.00'),
 (3,5,'1.00','22.50'),
 (3,6,'2.00','7.00');
/*!40000 ALTER TABLE `detalleventa` ENABLE KEYS */;


--
-- Definition of table `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `codigoProducto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(18,2) NOT NULL,
  PRIMARY KEY  (`codigoProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `producto`
--

/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` (`codigoProducto`,`nombre`,`precio`) VALUES 
 (1,'COCA COLA','2.00'),
 (2,'RELLENITA','0.50'),
 (3,'CIGARROS','0.20'),
 (4,'PARLANTES','200.00'),
 (5,'COMPUTADORA','450.00'),
 (6,'TECLADO','70.00');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;


--
-- Definition of table `venta`
--

DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta` (
  `codigoVenta` int(11) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY  (`codigoVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venta`
--

/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
INSERT INTO `venta` (`codigoVenta`,`cliente`,`fecha`) VALUES 
 (1,'MARIA','2011-03-06 00:00:00'),
 (2,'LUIS','2011-03-06 00:00:00'),
 (3,'HENRY WONG','2011-03-06 00:00:00');
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;


--
-- Definition of procedure `spF_producto_all`
--

DROP PROCEDURE IF EXISTS `spF_producto_all`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spF_producto_all`(
)
BEGIN

SELECT
	p.codigoProducto,
	p.nombre,
	p.precio
FROM
	producto p
ORDER BY
	P.nombre

;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `spF_producto_one`
--

DROP PROCEDURE IF EXISTS `spF_producto_one`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spF_producto_one`(
  _codigoProducto  int
)
BEGIN

SELECT
	p.codigoProducto,
	p.nombre,
	p.precio
FROM
	producto p
WHERE
	p.codigoProducto=_codigoProducto
ORDER BY
	P.nombre
;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `spF_venta_All`
--

DROP PROCEDURE IF EXISTS `spF_venta_All`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spF_venta_All`(
  
)
BEGIN

SELECT
	v.codigoVenta AS CodigoVenta,
	v.cliente AS Cliente, 
	v.fecha AS Fecha,
	d.codigoProducto AS CodigoProducto, 
	p.nombre AS Nombre,
	p.precio AS Precio, 
	d.cantidad AS Cantidad,
	d.descuento AS Descuento,
	p.precio*d.cantidad AS Parcial,
	((p.precio*d.cantidad)-d.descuento) AS SubTotal,
	(
	SELECT     
		SUM((dT.cantidad * pT.precio)-dT.descuento) AS TotalPagar
	FROM         
		DetalleVenta AS dT INNER JOIN
		Producto AS pT ON dT.codigoProducto = pT.codigoProducto
	WHERE
		dT.codigoVenta=v.codigoVenta
	) AS TotalPagar
FROM 
	Venta AS v INNER JOIN
	DetalleVenta AS d ON v.codigoVenta = d.codigoVenta INNER JOIN
	Producto AS p ON d.codigoProducto = p.codigoProducto
ORDER BY
	CodigoVenta, Nombre
 ;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `spF_venta_one`
--

DROP PROCEDURE IF EXISTS `spF_venta_one`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spF_venta_one`(
  _codigoVenta  int
)
BEGIN

SELECT
	v.codigoVenta AS CodigoVenta,
	v.cliente AS Cliente, 
	v.fecha AS Fecha, 
	d.codigoProducto AS CodigoProducto, 
	p.nombre AS Nombre,
	p.precio AS Precio, 
	d.cantidad AS Cantidad, 
	d.descuento AS Descuento,
	p.precio*d.cantidad AS Parcial,
	((p.precio*d.cantidad)-d.descuento) AS SubTotal,
	(
	SELECT     
		SUM((dT.cantidad * pT.precio)-dT.descuento) AS TotalPagar
	FROM         
		DetalleVenta AS dT INNER JOIN
		Producto AS pT ON dT.codigoProducto = pT.codigoProducto
	WHERE
		dT.codigoVenta=v.codigoVenta
	) AS TotalPagar
FROM 
	Venta AS v INNER JOIN
	DetalleVenta AS d ON v.codigoVenta = d.codigoVenta INNER JOIN
	Producto AS p ON d.codigoProducto = p.codigoProducto
WHERE
	v.codigoVenta=_codigoVenta
ORDER BY
	Nombre
;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `spI_detalleventa`
--

DROP PROCEDURE IF EXISTS `spI_detalleventa`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spI_detalleventa`(
   _codigoVenta  int ,
   _codigoProducto  int ,
   _cantidad  decimal(18, 2) ,
   _descuento  decimal(18, 2)
)
BEGIN

INSERT INTO `detalleventa`(
   `codigoVenta`,
   `codigoProducto`,
   `cantidad`,
   `descuento`
)
VALUES (
   _codigoVenta,
   _codigoProducto,
   _cantidad,
   _descuento
);
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `spI_producto`
--

DROP PROCEDURE IF EXISTS `spI_producto`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spI_producto`(
   INOUT  _codigoProducto  int ,
   _nombre  varchar(100) ,
   _precio  decimal(18, 2)
)
BEGIN
-- Genera una especie de autoincremental pero yo controlo los codigos
-- que genero
SELECT IFNULL(MAX(codigoProducto),0)+1 into _codigoProducto FROM `producto`;
INSERT INTO `producto`(
   `codigoProducto`,
   `nombre`,
   `precio`
)
VALUES (
   _codigoProducto,
   _nombre,
   _precio
);
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `spI_venta`
--

DROP PROCEDURE IF EXISTS `spI_venta`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spI_venta`(
   out _codigoVenta  int ,
   _cliente  varchar(100) 
)
BEGIN
-- Codigo autogenerado
SELECT IFNULL(MAX(codigoVenta),0)+1 into _codigoVenta FROM `venta`;
INSERT INTO `venta`(
   `codigoVenta`,
   `cliente`,
   `fecha`
)
VALUES (
   _codigoVenta,
   _cliente,
   CURDATE()
);
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `spU_producto`
--

DROP PROCEDURE IF EXISTS `spU_producto`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spU_producto`(
   _codigoProducto  int ,
   _nombre  varchar(100) ,
   _precio  decimal(18, 2)
)
BEGIN

UPDATE producto
SET 
   `nombre` = _nombre,
   `precio` = _precio
WHERE
    `codigoProducto` = _codigoProducto
;
END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
