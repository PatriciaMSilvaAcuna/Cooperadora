CREATE DATABASE  IF NOT EXISTS `cooperadora` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `cooperadora`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cooperadorafinal
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administracion`
--

DROP TABLE IF EXISTS `administracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administracion` (
  `idadministracion` int(11) NOT NULL AUTO_INCREMENT,
  `valorconcepto` int(11) NOT NULL,
  `aniovigente` int(11) NOT NULL,
  `idconcepto` int(11) NOT NULL,
  PRIMARY KEY (`idadministracion`),
  KEY `fk_concepto_administracion_idx` (`idconcepto`),
  CONSTRAINT `fk_concepto_administracion` FOREIGN KEY (`idconcepto`) REFERENCES `concepto` (`idconcepto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administracion`
--

LOCK TABLES `administracion` WRITE;
/*!40000 ALTER TABLE `administracion` DISABLE KEYS */;
INSERT INTO `administracion` VALUES (1,1,2024,1),(2,15000,2024,2),(3,100,2024,3),(4,1500,2024,4);
/*!40000 ALTER TABLE `administracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumno`
--

DROP TABLE IF EXISTS `alumno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumno` (
  `idalumno` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `dni` int(11) NOT NULL,
  `deuda` float NOT NULL,
  `mail` varchar(50) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fechaalta` date NOT NULL,
  PRIMARY KEY (`idalumno`),
  KEY `fk_usuario_alumno_idx` (`idusuario`),
  CONSTRAINT `fk_usuario_alumno` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumno`
--

LOCK TABLES `alumno` WRITE;
/*!40000 ALTER TABLE `alumno` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumno` ENABLE KEYS */;
UNLOCK TABLES;

ALTER TABLE `cooperadora`.`alumno` 
CHANGE COLUMN `dni` `dni` INT(11) NOT NULL ,
ADD UNIQUE INDEX `dni_UNIQUE` (`dni` ASC);
;

--
-- Table structure for table `cargapago`
--

DROP TABLE IF EXISTS `cargapago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargapago` (
  `idcargapago` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `valorabonado` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idmetodopago` int(11) NOT NULL,
  `idalumno` int(11) NOT NULL,
  `idconcepto` int(11) NOT NULL,
  PRIMARY KEY (`idcargapago`),
  KEY `fk_usuario_cargapago_idx` (`idusuario`),
  KEY `fk_alumno_cargapago_idx` (`idalumno`),
  KEY `fk_metodopago_cargapago_idx` (`idmetodopago`),
  KEY `fk_concepto_cargapago_idx` (`idconcepto`),
  CONSTRAINT `fk_alumno_cargapago` FOREIGN KEY (`idalumno`) REFERENCES `alumno` (`idalumno`),
  CONSTRAINT `fk_concepto_cargapago` FOREIGN KEY (`idconcepto`) REFERENCES `concepto` (`idconcepto`),
  CONSTRAINT `fk_metodopago_cargapago` FOREIGN KEY (`idmetodopago`) REFERENCES `metodopago` (`idmetodopago`),
  CONSTRAINT `fk_usuario_cargapago` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargapago`
--

LOCK TABLES `cargapago` WRITE;
/*!40000 ALTER TABLE `cargapago` DISABLE KEYS */;
/*!40000 ALTER TABLE `cargapago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrera`
--

DROP TABLE IF EXISTS `carrera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrera` (
  `idcarrera` int(11) NOT NULL AUTO_INCREMENT,
  `carrera` varchar(45) NOT NULL,
  PRIMARY KEY (`idcarrera`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrera`
--

LOCK TABLES `carrera` WRITE;
/*!40000 ALTER TABLE `carrera` DISABLE KEYS */;
INSERT INTO `carrera` VALUES (1,'Enfermeria A 1er año'),(2,'Enfermeria B 1er año'),(3,'Enfermeria A 2do año'),(4,'Enfermeria B 2do año'),(5,'Enfermeria A y B 3er año'),(6,'Higiene y Seguridad'),(7,'Sistemas'),(8,'RRHH'),(9,'Instrumentación Quirurgica');
/*!40000 ALTER TABLE `carrera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `concepto`
--

DROP TABLE IF EXISTS `concepto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `concepto` (
  `idconcepto` int(11) NOT NULL AUTO_INCREMENT,
  `concepto` varchar(45) NOT NULL,
  PRIMARY KEY (`idconcepto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `concepto`
--

LOCK TABLES `concepto` WRITE;
/*!40000 ALTER TABLE `concepto` DISABLE KEYS */;
INSERT INTO `concepto` VALUES (1,'Donaciones'),(2,'Cuota social'),(3,'Formulario'),(4,'Libreta');
/*!40000 ALTER TABLE `concepto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion`
--

DROP TABLE IF EXISTS `inscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscripcion` (
  `idinscripcion` int(11) NOT NULL AUTO_INCREMENT,
  `fechaanual` int(11) NOT NULL,
  `idalumno` int(11) NOT NULL,
  `idcarrera` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  PRIMARY KEY (`idinscripcion`),
  KEY `fk_carrera_inscripcion_idx` (`idcarrera`),
  KEY `fk_usuario_inscripcion_idx` (`idusuario`),
  KEY `fk_alumno_inscripcion_idx` (`idalumno`),
  CONSTRAINT `fk_alumno_inscripcion` FOREIGN KEY (`idalumno`) REFERENCES `alumno` (`idalumno`),
  CONSTRAINT `fk_carrera_inscripcion` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`idcarrera`),
  CONSTRAINT `fk_usuario_inscripcion` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion`
--

LOCK TABLES `inscripcion` WRITE;
/*!40000 ALTER TABLE `inscripcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodopago`
--

DROP TABLE IF EXISTS `metodopago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodopago` (
  `idmetodopago` int(11) NOT NULL AUTO_INCREMENT,
  `metodopago` varchar(45) NOT NULL,
  PRIMARY KEY (`idmetodopago`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodopago`
--

LOCK TABLES `metodopago` WRITE;
/*!40000 ALTER TABLE `metodopago` DISABLE KEYS */;
INSERT INTO `metodopago` VALUES (1,'Efectivo'),(2,'Transferencia');
/*!40000 ALTER TABLE `metodopago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro`
--

DROP TABLE IF EXISTS `registro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro` (
  `idregistro` int(11) NOT NULL AUTO_INCREMENT,
  `registro` varchar(200) NOT NULL,
  PRIMARY KEY (`idregistro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro`
--

LOCK TABLES `registro` WRITE;
/*!40000 ALTER TABLE `registro` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipousuario` (
  `idtipousuario` int(11) NOT NULL,
  `tipousuario` varchar(15) NOT NULL,
  PRIMARY KEY (`idtipousuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipousuario`
--

LOCK TABLES `tipousuario` WRITE;
/*!40000 ALTER TABLE `tipousuario` DISABLE KEYS */;
INSERT INTO `tipousuario` VALUES (0,'Administrador'),(1,'Operador');
/*!40000 ALTER TABLE `tipousuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `dniusuario` int(11) NOT NULL,
  `contrasenia` varchar(45) NOT NULL,
  `mailusuario` varchar(45) NOT NULL,
  `idtipousuario` int(11) NOT NULL,
  `usuarioactivo` int(11) NOT NULL,
  PRIMARY KEY (`idusuario`),
  KEY `fk_tipousuario_usuario_idx` (`idtipousuario`),
  CONSTRAINT `fk_tipousuario_usuario` FOREIGN KEY (`idtipousuario`) REFERENCES `tipousuario` (`idtipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,11111111,'1234','isft182@gmail.com',0,1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
ALTER TABLE `cooperadora`.`usuario` 
ADD UNIQUE INDEX `dniusuario_UNIQUE` (`dniusuario` ASC);
;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-16 20:09:34
-- se agrega campo alumnoactivo 0 inactivo 1 activo
ALTER TABLE `cooperadora`.`alumno` 
ADD COLUMN `alumnoactivo` INT(1) NOT NULL AFTER `fechaalta`;

drop trigger if exists actualizar_deuda_alumno 

DELIMITER //
CREATE TRIGGER actualizar_deuda_alumno
AFTER INSERT ON inscripcion -- DESPUES DE UNA INSCRIPCION DE CARRERA
FOR EACH ROW
BEGIN
    DECLARE v_valorconcepto DECIMAL(10,2);
    DECLARE deuda_actual DECIMAL (10,2);
    DECLARE nueva_deuda DECIMAL(10,2);
    DECLARE ultimo_anio_actualizacion DECIMAL(10,2);
    DECLARE cantidad_inscripciones DECIMAL(10,2);
	DECLARE idmaximo DECIMAL(10,2);
    
	-- Obtener el último AÑO de inscripcion del alumno
    SELECT (MAX(fechaanual))
    INTO ultimo_anio_actualizacion -- GUARDA VALOR 2024
    FROM inscripcion
    WHERE idalumno = NEW.idalumno;
    
    	-- Obtener si posee más de una inscripción en el mismo año
    SELECT COUNT(*) 
    INTO cantidad_inscripciones -- GUARDA LA CANTIDAD DE 4
    FROM inscripcion
    WHERE idalumno = NEW.idalumno
    AND fechaanual = ultimo_anio_actualizacion;
    
	SELECT max(idadministracion)
	INTO idmaximo
	FROM administracion
    WHERE aniovigente = (SELECT MAX(aniovigente) FROM administracion)
    AND idconcepto = 2;
	
    select valorconcepto
    INTO v_valorconcepto
    FROM administracion 
    where idconcepto=2
	and idadministracion = idmaximo;   
    
    if cantidad_inscripciones = 1 then
		UPDATE alumno
		SET deuda = v_valorconcepto
		WHERE idalumno = NEW.idalumno;
    END IF;
    
END//
DELIMITER 

DROP TRIGGER IF EXISTS actualizar_deuda_alumno_con_pago;

DELIMITER //
CREATE TRIGGER actualizar_deuda_alumno_con_pago
AFTER INSERT ON cargapago
FOR EACH ROW
BEGIN
    DECLARE deuda_actual DECIMAL(10,2);
    DECLARE nueva_deuda DECIMAL(10,2);

    -- Obtener la deuda actual del alumno
    SELECT deuda 
    INTO deuda_actual 
    FROM alumno
    WHERE idalumno = NEW.idalumno;

    -- Verificar si el concepto es el deseado (por ejemplo, si idconcepto = 2)
    IF NEW.idconcepto = 2 THEN
        -- Restar el valor abonado a la deuda actual
        SET nueva_deuda = deuda_actual - NEW.valorabonado;

        -- Actualizar la deuda del alumno
        UPDATE alumno
        SET deuda = nueva_deuda
        WHERE idalumno = NEW.idalumno;
    END IF;

END//
DELIMITER ;

DROP procedure IF EXISTS resetDeuda;
DELIMITER //
CREATE PROCEDURE resetDeuda()
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE batchSize INT DEFAULT 1000;
    DECLARE minId INT;
    DECLARE maxId INT;
    DECLARE currentYear INT;

    -- Obtener el año actual
    SET currentYear = YEAR(CURDATE());

    -- Obtener el rango inicial de IDs de alumnos con inscripciones anteriores al año vigente
    SELECT MIN(a.idalumno) INTO minId 
    FROM alumno a
    WHERE EXISTS (
        SELECT 1
        FROM inscripcion i
        WHERE a.idalumno = i.idalumno
        AND i.fechaanual < currentYear
    );

    SELECT MAX(a.idalumno) INTO maxId 
    FROM alumno a
    WHERE EXISTS (
        SELECT 1
        FROM inscripcion i
        WHERE a.idalumno = i.idalumno
        AND i.fechaanual < currentYear
    );

    WHILE minId IS NOT NULL AND minId <= maxId DO
        -- Actualizar deudas del lote actual
        UPDATE alumno
        SET deuda = 0
        WHERE idalumno IN (
            SELECT DISTINCT i.idalumno
            FROM inscripcion i
            WHERE i.fechaanual < currentYear
        ) AND idalumno >= minId AND idalumno < minId + batchSize;

        -- Mover al siguiente lote
        SET minId = minId + batchSize;
    END WHILE;
    
END //
DELIMITER ;
-- SP Consulta de recaudacion
DELIMITER $$

CREATE PROCEDURE obtener_recaudacion_carrera(
    IN idcarrera INT
)
BEGIN
    -- Consulta para los detalles
    SELECT 
        c.carrera, 
        CONCAT(a.nombre, ' ', a.apellido) AS alumno, 
        co.concepto, 
        cp.valorabonado, 
        cp.fecha
    FROM 
        inscripcion i
    INNER JOIN 
        cargapago cp ON i.idalumno = cp.idalumno
    INNER JOIN 
        alumno a ON a.idalumno = cp.idalumno
    INNER JOIN 
        carrera c ON c.idcarrera = i.idcarrera
    INNER JOIN 
        concepto co ON co.idconcepto = cp.idconcepto
    WHERE 
        i.idcarrera = idcarrera
    AND 
        (cp.idconcepto != 2  -- Excluir cuota social
        OR (cp.idconcepto = 2 
            AND i.idinscripcion IN (
                SELECT MIN(i2.idinscripcion)
                FROM inscripcion i2
                WHERE i2.idalumno = i.idalumno
            )
        ))
    ORDER BY 
        cp.fecha;

    -- Consulta para el total
    SELECT 
        SUM(cp.valorabonado) AS total_recaudado
    FROM 
        inscripcion i
    INNER JOIN 
        cargapago cp ON i.idalumno = cp.idalumno
    WHERE 
        i.idcarrera = idcarrera
    AND 
        (cp.idconcepto != 2
        OR (cp.idconcepto = 2 
            AND i.idinscripcion IN (
                SELECT MIN(i2.idinscripcion)
                FROM inscripcion i2
                WHERE i2.idalumno = i.idalumno
            )
        ));
END$$

DELIMITER ;

