-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 
-- Generation Time: Jun 15, 2022 at 06:14 PM
-- Server version: 5.7.38
-- PHP Version: 8.0.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orders-db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `canc` (IN `clave` INT(11))   BEGIN
DECLARE i date default null;
DECLARE r tinyint(1) DEFAULT 0;
SELECT fechaenviada into i from pedido where idpedido=clave;
IF i is null THEN
	SELECT sw into r from pedido where idpedido=clave;
	IF r=0 THEN
		UPDATE pedido SET SW=1 WHERE idpedido = clave;
	ELSE
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El pedido ya esta cancelado';
	END IF;
ELSE
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El pedido ya fue enviado';
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `contar` ()   BEGIN
DECLARE a int default null;DECLARE b int default null;DECLARE c int default null;DECLARE d int default null;SELECT count(*) INTO a
FROM pedire as p 
where (p.fechaenviada is null and p.sw=0);
SELECT count(*) INTO b
FROM pedire as p 
where p.sw=1;
SELECT count(*) INTO c
FROM pedire as p 
where (p.sw=0 and p.fechaenviada is not null);
SELECT count(*) INTO d
FROM pedido as p 
inner join deuda as dx on dx.idpredido=p.idpedido
where (p.fechaenviada is null and p.sw=0);
select a,b,c,d;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `detaller` (IN `a` INT(11), IN `b` VARCHAR(12), IN `c` INT(11), IN `d` INT(11), IN `e` DOUBLE)   BEGIN
DECLARE id1 int DEFAULT null;SELECT `idpolera` into id1 from `polera` where code=b;IF id1 is null THEN
  call new_polera(b,NULL);
  SELECT LAST_INSERT_ID() into id1;
END IF;
INSERT INTO detalle VALUES(NULL,a,id1,c,e,d);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deudan` (IN `clave` INT(11))   BEGIN
DECLARE id1 int DEFAULT null;
DECLARE id2 int DEFAULT null;
SELECT `idpredido` into id2 from `impresion` where idpredido=clave;
IF id2 is not null THEN   delete from impresion where idpredido=clave;
END IF;
SELECT `idpredido` into id1 from `deuda` where idpredido=clave;
IF id1 is null THEN   INSERT INTO deuda VALUES(clave);
ELSE
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El pedido(s) ya esta en deuda';
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `entreg` (IN `clave` INT(11))   BEGIN
DECLARE j date default null;
DECLARE r tinyint(1) DEFAULT 0;
SELECT fechaenviada into j from pedido where idpedido=clave;
IF j is null THEN
	SELECT sw into r from pedido where idpedido=clave;
	IF r=0 THEN
		SELECT CURRENT_DATE into j;
		UPDATE pedido SET fechaenviada=j WHERE idpedido = clave;
	ELSE
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El pedido esta cancelado';
	END IF;
ELSE
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El pedido esta enviado';
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_cliente` (IN `clave` INT)   BEGIN
SELECT t.nombre,t.ci,t.celular,t.sw FROM  `cliente` AS t
WHERE t.idcliente=clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_destino` (IN `clave` INT)   BEGIN
SELECT t.Nombre,t.sw FROM  `destino` AS t
WHERE t.iddestino=clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_evento` (IN `clave` INT)   BEGIN
SELECT t.nombre,t.sw FROM  `evento` AS t
WHERE t.idevento=clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_polera` (IN `clave` INT)   BEGIN
SELECT t.code,t.descripcion FROM  `polera` AS t
WHERE t.idpolera=clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `modceve` (IN `a` VARCHAR(100), IN `b` TINYINT(1), IN `clave` INT(11))   BEGIN
UPDATE evento SET nombre=a ,sw=b
  WHERE idevento = clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `modenty` (IN `a` VARCHAR(25), IN `clave` INT(11))   BEGIN
UPDATE entidad SET Banco=a 
  WHERE idEntidad = clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `modprocer` (IN `a` VARCHAR(25), IN `clave` INT(11))   BEGIN
UPDATE procedencia SET tipo=a 
  WHERE idprocedencia = clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mod_cliente` (IN `a` VARCHAR(100), IN `b` VARCHAR(12), IN `c` VARCHAR(12), IN `d` TINYINT(1), IN `clave` INT)   BEGIN
UPDATE cliente SET nombre=a,ci=b,celular=c,sw=d 
  WHERE idcliente = clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mod_destino` (IN `a` VARCHAR(20), IN `b` TINYINT(1), IN `clave` INT)   BEGIN
UPDATE destino SET Nombre=a,sw=b
  WHERE iddestino = clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mod_pedi` (IN `idp` INT(11), IN `a` VARCHAR(100), IN `b` VARCHAR(100), IN `c` VARCHAR(12), IN `d` VARCHAR(12), IN `e` DOUBLE, IN `f` DATE, IN `g` DATE, IN `h` VARCHAR(20), IN `i` LONGTEXT, IN `j` INT(11), IN `k` INT(11), IN `l` TINYINT(1), IN `m` TINYINT(1), IN `o` TINYINT(1), IN `p` DATE, IN `q` TINYINT(1))   BEGIN
DECLARE id1 int DEFAULT null;DECLARE id2 int DEFAULT null;DECLARE id3 int DEFAULT null;SELECT `idevento` into id1 from `evento` where nombre=a;
IF id1 is null THEN
  call new_evento(a,l);
  SELECT LAST_INSERT_ID() into id1;
ELSE
  update evento set sw=l where idevento=id1;
END IF;
SELECT `idcliente` into id2 from `cliente` where (nombre=b and ci=c);
IF id2 is null THEN
  call neo_cliente(b,c,d,m);
  SELECT LAST_INSERT_ID() into id2;
ELSE
  update cliente set sw=m where idcliente=id2;
END IF;
SELECT `iddestino` into id3 from `destino` where Nombre=h;
IF id3 is null THEN
  call neo_destino(h,o);
  SELECT LAST_INSERT_ID() into id3;
  update destino set sw=o where iddestino=id3;
END IF;
UPDATE pedido SET idcliente=id2,iddestino=id3,idprocedencia=k,identidad=j,idevento=id1,fechaorden=f,fecharequerida=g,fechaenviada=p,acuenta=e,detalle=i,SW=q where idpedido=idp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mod_polera` (IN `a` VARCHAR(12), IN `b` TEXT, IN `clave` INT(11))   BEGIN
UPDATE polera SET `code`=a ,`descripcion`=b
  WHERE idpolera = clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `neo_cliente` (IN `a` VARCHAR(100), IN `b` VARCHAR(12), IN `c` VARCHAR(12), IN `d` TINYINT(1))   BEGIN
INSERT INTO cliente VALUES(NULL,a,b,c,d,null);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `neo_destino` (IN `a` VARCHAR(20), IN `b` TINYINT(1))   BEGIN
INSERT INTO destino VALUES(NULL,a,b);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `newenty` (IN `a` VARCHAR(25))   BEGIN
INSERT INTO entidad VALUES(NULL,a);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `newprocer` (IN `a` VARCHAR(25))   BEGIN
INSERT INTO procedencia VALUES(NULL,a);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_evento` (IN `a` VARCHAR(100), IN `b` TINYINT(1))   BEGIN
INSERT INTO evento VALUES(NULL,a,b);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_pedi` (IN `a` VARCHAR(100), IN `b` VARCHAR(100), IN `c` VARCHAR(12), IN `d` VARCHAR(12), IN `e` DOUBLE, IN `f` DATE, IN `g` DATE, IN `h` VARCHAR(20), IN `i` LONGTEXT, IN `j` INT(11), IN `k` INT(11), IN `l` TINYINT(1), IN `m` TINYINT(1), IN `o` TINYINT(1))   BEGIN
DECLARE id1 int DEFAULT null;DECLARE id2 int DEFAULT null;DECLARE id3 int DEFAULT null;SELECT `idevento` into id1 from `evento` where nombre=a;
IF id1 is null THEN
  call new_evento(a,l);
  SELECT LAST_INSERT_ID() into id1;
ELSE
  update evento set sw=l where idevento=id1;
END IF;
SELECT `idcliente` into id2 from `cliente` where (nombre=b and ci=c);
IF id2 is null THEN
  call neo_cliente(b,c,d,m);
  SELECT LAST_INSERT_ID() into id2;
ELSE
  update cliente set sw=m where idcliente=id2;
END IF;
SELECT `iddestino` into id3 from `destino` where Nombre=h;
IF id3 is null THEN
  call neo_destino(h,o);
  SELECT LAST_INSERT_ID() into id3;
  update destino set sw=o where iddestino=id3;
END IF;
INSERT INTO pedido VALUES(NULL,id2,id3,k,j,id1,f,g,null,e,i,'0');
SELECT LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_polera` (IN `a` VARCHAR(12), IN `b` TEXT)   BEGIN
INSERT INTO polera VALUES(NULL,a,b);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prino` (IN `clave` INT(11))   BEGIN
DECLARE i int default null;
SELECT idpredido into i from impresion where idpredido=clave;
IF i is not null THEN
	delete from impresion where idpredido=clave;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prins` (IN `clave` INT(11))   BEGIN
DECLARE i int default null;
SELECT idpredido into i from impresion where idpredido=clave;
IF i is null THEN
	insert into impresion values(clave);
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_cancelados` ()   BEGIN
SELECT lk.nro,e.nombre,c.nombre,c.ci,c.celular,vi.Total,ciu.Nombre,en.Banco,pr.tipo,DATE_FORMAT(p.fechaorden, "%d-%m-%Y"),DATE_FORMAT(p.fecharequerida, "%d-%m-%Y") as 'requi',p.detalle
FROM pedire as p 
inner join nume as lk on lk.ipfedido=p.idpedido
inner join stta as vi on vi.idpedido=p.idpedido
inner join evento as e on e.idevento=p.idevento
inner join cliente as c on c.idcliente=p.idcliente
inner join entidad as en on en.idEntidad=p.idEntidad
inner join procedencia as pr on pr.idprocedencia=p.idprocedencia
inner join destino as ciu on ciu.iddestino=p.iddestino
where p.sw=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_deudas` ()  NO SQL BEGIN
SELECT lk.nro,e.nombre,c.nombre,c.ci,c.celular,vi.Total,ciu.Nombre,en.Banco,pr.tipo,DATE_FORMAT(p.fechaorden, "%d-%m-%Y"),DATE_FORMAT(p.fecharequerida, "%d-%m-%Y") as 'requi',p.detalle
FROM pedido as p 
inner join nume as lk on lk.ipfedido=p.idpedido
inner join deuda as dx on dx.idpredido=p.idpedido
inner join stta as vi on vi.idpedido=p.idpedido
inner join evento as e on e.idevento=p.idevento
inner join cliente as c on c.idcliente=p.idcliente
inner join entidad as en on en.idEntidad=p.idEntidad
inner join procedencia as pr on pr.idprocedencia=p.idprocedencia
inner join destino as ciu on ciu.iddestino=p.iddestino
where (p.fechaenviada is null and p.sw=0);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_entregados` ()   BEGIN
  SELECT lk.nro,e.nombre,c.nombre,c.ci,c.celular,vi.Total,ciu.Nombre,en.Banco,pr.tipo,DATE_FORMAT(p.fechaorden, "%d-%m-%Y") as 'orde',DATE_FORMAT(p.fecharequerida, "%d-%m-%Y") as 'requi',DATE_FORMAT(p.fechaenviada, "%d-%m-%Y") as 'envi',p.detalle
  FROM pedire as p 
  inner join nume as lk on lk.ipfedido=p.idpedido
  inner join stta as vi on vi.idpedido=p.idpedido
  inner join evento as e on e.idevento=p.idevento
  inner join cliente as c on c.idcliente=p.idcliente
  inner join entidad as en on en.idEntidad=p.idEntidad
  inner join procedencia as pr on pr.idprocedencia=p.idprocedencia
  inner join destino as ciu on ciu.iddestino=p.iddestino
  where (p.sw=0 and p.fechaenviada is not null);
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_pedido` (IN `clave` INT)   BEGIN
SELECT e.nombre,e.sw,c.nombre,c.ci,c.celular,c.sw,p.acuenta,p.idEntidad,DATE_FORMAT(p.fechaorden, "%Y-%m-%d") as 'orde',DATE_FORMAT(p.fecharequerida, "%Y-%m-%d") as 'requi',DATE_FORMAT(p.fechaenviada, "%Y-%m-%d") as 'envi',p.SW,ciu.Nombre,ciu.sw,p.idprocedencia,p.detalle
FROM pedido as p 
inner join evento as e on e.idevento=p.idevento
inner join cliente as c on c.idcliente=p.idcliente
inner join destino as ciu on ciu.iddestino=p.iddestino
where p.idpedido=clave;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_pedidos` ()   BEGIN
SELECT lk.nro,e.nombre,c.nombre,c.ci,c.celular,vi.Total,ciu.Nombre,en.Banco,pr.tipo,DATE_FORMAT(p.fechaorden, "%d-%m-%Y"),DATE_FORMAT(p.fecharequerida, "%d-%m-%Y") as 'requi',p.detalle
FROM pedire as p 
inner join nume as lk on lk.ipfedido=p.idpedido
inner join stta as vi on vi.idpedido=p.idpedido
inner join evento as e on e.idevento=p.idevento
inner join cliente as c on c.idcliente=p.idcliente
inner join entidad as en on en.idEntidad=p.idEntidad
inner join procedencia as pr on pr.idprocedencia=p.idprocedencia
inner join destino as ciu on ciu.iddestino=p.iddestino
where (p.fechaenviada is null and p.sw=0);
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `lastOrden` (`idCli` INT) RETURNS DATE NO SQL return (select p.fechaorden from pedido as p inner join cliente as c on c.idcliente=p.idcliente where c.idcliente=idCli order by p.fechaorden desc limit 1)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `morado` (`id` INT) RETURNS CHAR(1) CHARSET latin1 NO SQL return(SELECT IF(p.fecharequerida<now(),'1','0') from pedido as p where idpedido=id)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `recibi` (`numx` VARCHAR(7)) RETURNS INT(11) NO SQL return(select ipfedido from nume where nro=`numx`)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total` (`id` INT) RETURNS DOUBLE NO SQL return(select sum(cantidad*precio_u) from detalle where idpedido=id)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ci` varchar(12) NOT NULL,
  `celular` varchar(12) NOT NULL,
  `sw` tinyint(1) NOT NULL,
  `idTarjeta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nombre`, `ci`, `celular`, `sw`, `idTarjeta`) VALUES
(187, 'Andres', '-', '-', 1, NULL),
(188, 'Jose Perez', '-', '555333222', 0, NULL);

--
-- Triggers `cliente`
--
DELIMITER $$
CREATE TRIGGER `tr1` AFTER INSERT ON `cliente` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'cliente');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr2` AFTER UPDATE ON `cliente` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'cliente');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE `codes` (
  `id` int(11) NOT NULL,
  `number` varchar(16) NOT NULL,
  `swr` tinyint(1) NOT NULL,
  `modi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `destino`
--

CREATE TABLE `destino` (
  `iddestino` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `sw` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `destino`
--

INSERT INTO `destino` (`iddestino`, `Nombre`, `sw`) VALUES
(2, 'Santa Cruz', 1),
(5, 'Cochabamba', 1),
(6, 'Oruro', 1),
(7, 'Sucre', 1),
(9, 'Potosi', 1),
(10, 'Trinidad', 1),
(11, 'Tupiza', 1),
(12, 'Tarija', 1),
(14, 'Yacuiba', 0),
(15, 'La Paz', 0);

--
-- Triggers `destino`
--
DELIMITER $$
CREATE TRIGGER `tr3` AFTER INSERT ON `destino` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'destino');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr4` AFTER UPDATE ON `destino` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'destino');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle`
--

CREATE TABLE `detalle` (
  `iddetalle` int(11) NOT NULL,
  `idpedido` int(11) NOT NULL,
  `idpolera` int(11) NOT NULL,
  `idtallas` int(11) NOT NULL,
  `precio_u` double NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detalle`
--

INSERT INTO `detalle` (`iddetalle`, `idpedido`, `idpolera`, `idtallas`, `precio_u`, `cantidad`) VALUES
(915, 228, 239, 1, 51, 2),
(916, 228, 240, 6, 950, 1);

--
-- Triggers `detalle`
--
DELIMITER $$
CREATE TRIGGER `pe3` AFTER INSERT ON `detalle` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'pedido');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pe4` AFTER UPDATE ON `detalle` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'pedido');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `deuda`
--

CREATE TABLE `deuda` (
  `idpredido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `entidad`
--

CREATE TABLE `entidad` (
  `identidad` int(11) NOT NULL,
  `Banco` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `entidad`
--

INSERT INTO `entidad` (`identidad`, `Banco`) VALUES
(4, 'Efectivo'),
(3, 'Tigo Money');

--
-- Triggers `entidad`
--
DELIMITER $$
CREATE TRIGGER `tr7` AFTER INSERT ON `entidad` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'entidad');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr8` AFTER UPDATE ON `entidad` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'entidad');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

CREATE TABLE `evento` (
  `idevento` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `sw` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evento`
--

INSERT INTO `evento` (`idevento`, `nombre`, `sw`) VALUES
(14, 'No evento', 0),
(15, 'Fiesta 15 de Noviembre', 0);

--
-- Triggers `evento`
--
DELIMITER $$
CREATE TRIGGER `ty2` AFTER INSERT ON `evento` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'evento');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ty3` AFTER UPDATE ON `evento` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'evento');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `historia`
--

CREATE TABLE `historia` (
  `idHistoria` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `tabla` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `historia`
--

INSERT INTO `historia` (`idHistoria`, `fecha`, `tabla`) VALUES
(1, '2019-06-13 23:05:53', 'tallas'),
(2, '2022-06-15 17:02:24', 'cliente'),
(3, '2019-01-25 13:52:21', 'procedencia'),
(4, '2019-02-01 05:55:09', 'entidad'),
(5, '2022-06-15 17:02:24', 'evento'),
(6, '2022-06-15 17:02:24', 'pedido'),
(7, '2020-02-28 16:12:28', 'destino'),
(8, '2022-06-15 17:02:24', 'polera'),
(9, '2022-06-15 04:22:01', 'backup'),
(10, '2019-11-03 23:25:24', 'codes'),
(11, '2019-11-04 00:00:00', 'Partida-PRO');

-- --------------------------------------------------------

--
-- Table structure for table `impresion`
--

CREATE TABLE `impresion` (
  `idpredido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `impresion`
--

INSERT INTO `impresion` (`idpredido`) VALUES
(228);

-- --------------------------------------------------------

--
-- Table structure for table `nume`
--

CREATE TABLE `nume` (
  `ipfedido` int(11) NOT NULL,
  `nro` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nume`
--

INSERT INTO `nume` (`ipfedido`, `nro`) VALUES
(228, '228');

-- --------------------------------------------------------

--
-- Stand-in structure for view `okey`
-- (See below for the actual view)
--
CREATE TABLE `okey` (
`idpedido` int(11)
,`idcliente` int(11)
,`iddestino` int(11)
,`idprocedencia` int(11)
,`identidad` int(11)
,`idevento` int(11)
,`fechaorden` date
,`fecharequerida` date
,`fechaenviada` date
,`acuenta` double
,`detalle` longtext
,`SW` tinyint(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE `pedido` (
  `idpedido` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `iddestino` int(11) NOT NULL,
  `idprocedencia` int(11) NOT NULL,
  `identidad` int(11) NOT NULL,
  `idevento` int(11) NOT NULL,
  `fechaorden` date NOT NULL,
  `fecharequerida` date NOT NULL,
  `fechaenviada` date DEFAULT NULL,
  `acuenta` double NOT NULL,
  `detalle` longtext,
  `SW` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pedido`
--

INSERT INTO `pedido` (`idpedido`, `idcliente`, `iddestino`, `idprocedencia`, `identidad`, `idevento`, `fechaorden`, `fecharequerida`, `fechaenviada`, `acuenta`, `detalle`, `SW`) VALUES
(228, 187, 6, 2, 3, 14, '2022-06-15', '2022-06-25', NULL, 1000, 'Suma urgencia', 0);

--
-- Triggers `pedido`
--
DELIMITER $$
CREATE TRIGGER `pc1` BEFORE DELETE ON `pedido` FOR EACH ROW begin
delete from impresion WHERE idpredido=old.idpedido;
delete from deuda WHERE idpredido=old.idpedido;
delete from nume WHERE ipfedido=old.idpedido;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pe1` AFTER INSERT ON `pedido` FOR EACH ROW BEGIN
insert into impresion(idpredido) values(new.idpedido);
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'pedido');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pe2` AFTER UPDATE ON `pedido` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'pedido');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `pedire`
-- (See below for the actual view)
--
CREATE TABLE `pedire` (
`idpedido` int(11)
,`idcliente` int(11)
,`iddestino` int(11)
,`idprocedencia` int(11)
,`identidad` int(11)
,`idevento` int(11)
,`fechaorden` date
,`fecharequerida` date
,`fechaenviada` date
,`acuenta` double
,`detalle` longtext
,`SW` tinyint(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `polera`
--

CREATE TABLE `polera` (
  `idpolera` int(11) NOT NULL,
  `code` varchar(12) NOT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `polera`
--

INSERT INTO `polera` (`idpolera`, `code`, `descripcion`) VALUES
(238, 'PLM1', 'Polera general'),
(239, 'PLG-1', NULL),
(240, 'PLG-2', NULL);

--
-- Triggers `polera`
--
DELIMITER $$
CREATE TRIGGER `ar1` AFTER INSERT ON `polera` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'polera');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ar2` AFTER UPDATE ON `polera` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'polera');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `procedencia`
--

CREATE TABLE `procedencia` (
  `idprocedencia` int(11) NOT NULL,
  `tipo` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procedencia`
--

INSERT INTO `procedencia` (`idprocedencia`, `tipo`) VALUES
(2, 'Facebook'),
(3, 'Tienda'),
(1, 'Whatsapp');

--
-- Triggers `procedencia`
--
DELIMITER $$
CREATE TRIGGER `tr5` AFTER INSERT ON `procedencia` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'procedencia');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr6` AFTER UPDATE ON `procedencia` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'procedencia');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `stta`
-- (See below for the actual view)
--
CREATE TABLE `stta` (
`idpedido` int(11)
,`Total` double
);

-- --------------------------------------------------------

--
-- Table structure for table `tallas`
--

CREATE TABLE `tallas` (
  `idtallas` int(11) NOT NULL,
  `talla` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tallas`
--

INSERT INTO `tallas` (`idtallas`, `talla`) VALUES
(2, '10'),
(3, '12'),
(10, '14'),
(1, '8'),
(6, 'L'),
(5, 'M'),
(4, 'S'),
(7, 'XL'),
(9, 'XXL');

--
-- Triggers `tallas`
--
DELIMITER $$
CREATE TRIGGER `wr3` AFTER INSERT ON `tallas` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'tallas');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `wr4` AFTER UPDATE ON `tallas` FOR EACH ROW BEGIN
	UPDATE historia
	SET fecha = NOW()
	WHERE (historia.tabla = 'tallas');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ap_paterno` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ap_materno` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `nivel` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `ap_paterno`, `ap_materno`, `usuario`, `password`, `is_active`, `nivel`) VALUES
(1, 'Jhordy', 'Gavinchu', 'M', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1);

-- --------------------------------------------------------

--
-- Structure for view `okey`
--
DROP TABLE IF EXISTS `okey`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `okey`  AS SELECT `p`.`idpedido` AS `idpedido`, `p`.`idcliente` AS `idcliente`, `p`.`iddestino` AS `iddestino`, `p`.`idprocedencia` AS `idprocedencia`, `p`.`identidad` AS `identidad`, `p`.`idevento` AS `idevento`, `p`.`fechaorden` AS `fechaorden`, `p`.`fecharequerida` AS `fecharequerida`, `p`.`fechaenviada` AS `fechaenviada`, `p`.`acuenta` AS `acuenta`, `p`.`detalle` AS `detalle`, `p`.`SW` AS `SW` FROM ((`pedire` `p` join `cliente` `c` on((`c`.`idcliente` = `p`.`idcliente`))) join `codes` `co` on((`co`.`id` = `c`.`idTarjeta`))) WHERE ((`p`.`fechaenviada` is not null) AND ((select `historia`.`fecha` from `historia` where (`historia`.`idHistoria` = 11)) <= now()) AND (`p`.`SW` = 0) AND (`co`.`swr` = 1))  ;

-- --------------------------------------------------------

--
-- Structure for view `pedire`
--
DROP TABLE IF EXISTS `pedire`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pedire`  AS SELECT `pedido`.`idpedido` AS `idpedido`, `pedido`.`idcliente` AS `idcliente`, `pedido`.`iddestino` AS `iddestino`, `pedido`.`idprocedencia` AS `idprocedencia`, `pedido`.`identidad` AS `identidad`, `pedido`.`idevento` AS `idevento`, `pedido`.`fechaorden` AS `fechaorden`, `pedido`.`fecharequerida` AS `fecharequerida`, `pedido`.`fechaenviada` AS `fechaenviada`, `pedido`.`acuenta` AS `acuenta`, `pedido`.`detalle` AS `detalle`, `pedido`.`SW` AS `SW` FROM (`pedido` left join `deuda` on((`deuda`.`idpredido` = `pedido`.`idpedido`))) WHERE isnull(`deuda`.`idpredido`)  ;

-- --------------------------------------------------------

--
-- Structure for view `stta`
--
DROP TABLE IF EXISTS `stta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stta`  AS SELECT `p`.`idpedido` AS `idpedido`, `total`(`p`.`idpedido`) AS `Total` FROM `pedido` AS `p`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD UNIQUE KEY `idTarjeta_2` (`idTarjeta`),
  ADD KEY `idTarjeta` (`idTarjeta`);

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `destino`
--
ALTER TABLE `destino`
  ADD PRIMARY KEY (`iddestino`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indexes for table `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`iddetalle`),
  ADD KEY `idpedido` (`idpedido`),
  ADD KEY `idpolera` (`idpolera`),
  ADD KEY `idtallas` (`idtallas`);

--
-- Indexes for table `deuda`
--
ALTER TABLE `deuda`
  ADD UNIQUE KEY `idpredido` (`idpredido`);

--
-- Indexes for table `entidad`
--
ALTER TABLE `entidad`
  ADD PRIMARY KEY (`identidad`),
  ADD UNIQUE KEY `Banco` (`Banco`);

--
-- Indexes for table `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idevento`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `historia`
--
ALTER TABLE `historia`
  ADD PRIMARY KEY (`idHistoria`);

--
-- Indexes for table `impresion`
--
ALTER TABLE `impresion`
  ADD UNIQUE KEY `idpredido` (`idpredido`);

--
-- Indexes for table `nume`
--
ALTER TABLE `nume`
  ADD UNIQUE KEY `ipfedido` (`ipfedido`),
  ADD UNIQUE KEY `nro` (`nro`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idpedido`),
  ADD KEY `idcliente` (`idcliente`),
  ADD KEY `iddestino` (`iddestino`),
  ADD KEY `idprocedencia` (`idprocedencia`),
  ADD KEY `identidad` (`identidad`),
  ADD KEY `idevento` (`idevento`);

--
-- Indexes for table `polera`
--
ALTER TABLE `polera`
  ADD PRIMARY KEY (`idpolera`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `procedencia`
--
ALTER TABLE `procedencia`
  ADD PRIMARY KEY (`idprocedencia`),
  ADD UNIQUE KEY `tipo` (`tipo`);

--
-- Indexes for table `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`idtallas`),
  ADD UNIQUE KEY `talla` (`talla`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `destino`
--
ALTER TABLE `destino`
  MODIFY `iddestino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `detalle`
--
ALTER TABLE `detalle`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=917;

--
-- AUTO_INCREMENT for table `entidad`
--
ALTER TABLE `entidad`
  MODIFY `identidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `evento`
--
ALTER TABLE `evento`
  MODIFY `idevento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `historia`
--
ALTER TABLE `historia`
  MODIFY `idHistoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idpedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `polera`
--
ALTER TABLE `polera`
  MODIFY `idpolera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `procedencia`
--
ALTER TABLE `procedencia`
  MODIFY `idprocedencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tallas`
--
ALTER TABLE `tallas`
  MODIFY `idtallas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`idTarjeta`) REFERENCES `codes` (`id`);

--
-- Constraints for table `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `detalle_ibfk_1` FOREIGN KEY (`idpedido`) REFERENCES `pedido` (`idpedido`),
  ADD CONSTRAINT `detalle_ibfk_2` FOREIGN KEY (`idpolera`) REFERENCES `polera` (`idpolera`),
  ADD CONSTRAINT `detalle_ibfk_3` FOREIGN KEY (`idtallas`) REFERENCES `tallas` (`idtallas`);

--
-- Constraints for table `deuda`
--
ALTER TABLE `deuda`
  ADD CONSTRAINT `deuda_ibfk_1` FOREIGN KEY (`idpredido`) REFERENCES `pedido` (`idpedido`);

--
-- Constraints for table `impresion`
--
ALTER TABLE `impresion`
  ADD CONSTRAINT `impresion_ibfk_1` FOREIGN KEY (`idpredido`) REFERENCES `pedido` (`idpedido`);

--
-- Constraints for table `nume`
--
ALTER TABLE `nume`
  ADD CONSTRAINT `nume_ibfk_1` FOREIGN KEY (`ipfedido`) REFERENCES `pedido` (`idpedido`);

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`iddestino`) REFERENCES `destino` (`iddestino`),
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`idprocedencia`) REFERENCES `procedencia` (`idprocedencia`),
  ADD CONSTRAINT `pedido_ibfk_4` FOREIGN KEY (`identidad`) REFERENCES `entidad` (`identidad`),
  ADD CONSTRAINT `pedido_ibfk_5` FOREIGN KEY (`idevento`) REFERENCES `evento` (`idevento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
