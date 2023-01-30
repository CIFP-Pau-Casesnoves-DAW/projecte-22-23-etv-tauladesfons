-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-01-2023 a las 17:59:05
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `etvdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ALLOTJAMENTS`
--

CREATE TABLE `ALLOTJAMENTS` (
  `ID_ALLOTJAMENT` int(11) NOT NULL,
  `NOM_COMERCIAL` varchar(50) NOT NULL,
  `NUM_REGISTRE` varchar(50) NOT NULL,
  `DESCRIPCIO` varchar(500) NOT NULL,
  `LLITS` int(11) NOT NULL,
  `PERSONES` int(11) NOT NULL,
  `BANYS` int(11) NOT NULL,
  `ADREÇA` varchar(50) NOT NULL,
  `DESTACAT` tinyint(1) NOT NULL,
  `VALORACIO_GLOBAL` int(11) DEFAULT NULL,
  `FK_ID_MUNICIPI` int(11) NOT NULL,
  `FK_ID_TIPUS` int(11) NOT NULL,
  `FK_ID_VACANCES` int(11) NOT NULL,
  `FK_ID_CATEGORIA` int(11) NOT NULL,
  `FK_ID_USUARI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ALLOTJAMENTS`
--

INSERT INTO `ALLOTJAMENTS` (`ID_ALLOTJAMENT`, `NOM_COMERCIAL`, `NUM_REGISTRE`, `DESCRIPCIO`, `LLITS`, `PERSONES`, `BANYS`, `ADREÇA`, `DESTACAT`, `VALORACIO_GLOBAL`, `FK_ID_MUNICIPI`, `FK_ID_TIPUS`, `FK_ID_VACANCES`, `FK_ID_CATEGORIA`, `FK_ID_USUARI`) VALUES
(1, 'ProvaAllotjament1', 'provaA123', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3, 6, 2, 'C/Prova, 1', 1, 7, 1, 1, 1, 1, 1),
(2, 'ProvaAllotjament2', 'provaB456', 'Nulla nec dictum nibh.', 1, 2, 1, 'C/Prova, 2', 0, 7, 2, 2, 2, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ALLOTJAMENTS_SERVEIS`
--

CREATE TABLE `ALLOTJAMENTS_SERVEIS` (
  `FK_ID_ALLOT` int(11) NOT NULL,
  `FK_ID_SERVEI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ALLOTJAMENTS_SERVEIS`
--

INSERT INTO `ALLOTJAMENTS_SERVEIS` (`FK_ID_ALLOT`, `FK_ID_SERVEI`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CATEGORIA`
--

CREATE TABLE `CATEGORIA` (
  `ID_CATEGORIA` int(11) NOT NULL,
  `NOM_CATEGORIA` varchar(50) NOT NULL,
  `TARIFA` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `CATEGORIA`
--

INSERT INTO `CATEGORIA` (`ID_CATEGORIA`, `NOM_CATEGORIA`, `TARIFA`) VALUES
(1, 'Luxe', 0),
(2, 'Normal', 0),
(3, 'Basica', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMENTARIS`
--

CREATE TABLE `COMENTARIS` (
  `ID_COMENTARI` int(11) NOT NULL,
  `DESCRIPCIO` varchar(500) NOT NULL,
  `DATA` date NOT NULL,
  `HORA` time NOT NULL,
  `FK_ID_USUARI` int(11) NOT NULL,
  `FK_ID_ALLOTJAMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `COMENTARIS`
--

INSERT INTO `COMENTARIS` (`ID_COMENTARI`, `DESCRIPCIO`, `DATA`, `HORA`, `FK_ID_USUARI`, `FK_ID_ALLOTJAMENT`) VALUES
(1, 'Una estància meravellosa. Repetirem segur.', '2022-03-16', '12:25:00', 1, 1),
(2, 'Estava molt brut. Ens vàrem queixar i no ens van donar cap solució.', '2022-04-06', '21:30:07', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FOTOGRAFIES`
--

CREATE TABLE `FOTOGRAFIES` (
  `ID_FOTO` int(11) NOT NULL,
  `FOTO` varchar(50) NOT NULL,
  `FK_ID_ALLOTJAMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `IDIOMES`
--

CREATE TABLE `IDIOMES` (
  `ID_IDIOMA` int(11) NOT NULL,
  `NOM_IDIOMA` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `IDIOMES`
--

INSERT INTO `IDIOMES` (`ID_IDIOMA`, `NOM_IDIOMA`) VALUES
(1, 'ESPANYOL'),
(2, 'CATALA'),
(3, 'ANGLES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `MUNICIPIS`
--

CREATE TABLE `MUNICIPIS` (
  `ID_MUNICIPI` int(11) NOT NULL,
  `NOM_MUNICIPI` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `MUNICIPIS`
--

INSERT INTO `MUNICIPIS` (`ID_MUNICIPI`, `NOM_MUNICIPI`) VALUES
(1, 'Alaior'),
(2, 'Alaró'),
(3, 'Alcúdia'),
(4, 'Algaida'),
(5, 'Andratx'),
(6, 'Ariany'),
(7, 'Artà'),
(8, 'Banyalbufar'),
(9, 'Binissalem'),
(10, 'Búger'),
(11, 'Bunyola'),
(12, 'Calvià'),
(13, 'Campanet'),
(14, 'Campos'),
(15, 'Capdepera'),
(16, 'es Castell'),
(17, 'Ciutadella de Menorca'),
(18, 'Consell'),
(19, 'Costitx'),
(20, 'Deià'),
(21, 'Eivissa'),
(22, 'Escorca'),
(23, 'Esporles'),
(24, 'Estellencs'),
(25, 'Felanitx'),
(26, 'Ferreries'),
(27, 'Formentera'),
(28, 'Fornalutx'),
(29, 'Inca'),
(30, 'Lloret de Vistalegre'),
(31, 'Lloseta'),
(32, 'Llubí'),
(33, 'Llucmajor'),
(34, 'Maó'),
(35, 'Manacor'),
(36, 'Mancor de la Vall'),
(37, 'Maria de la Salut'),
(38, 'Marratxí'),
(39, 'Es Mercadal'),
(40, 'Es Migjorn Gran'),
(41, 'Montuïri'),
(42, 'Muro'),
(43, 'Palma'),
(44, 'Petra'),
(45, 'Sa Pobla'),
(46, 'Pollença'),
(47, 'Porreres'),
(48, 'Puigpunyent'),
(49, 'Ses Salines'),
(50, 'Sant Antoni de Portmany'),
(51, 'Sant Joan'),
(52, 'Sant Joan de Labritja'),
(53, 'Sant Josep de sa Talaia'),
(54, 'Sant Llorenç des Cardassar'),
(55, 'Sant Lluís'),
(56, 'Santa Eugènia'),
(57, 'Santa Eulària des Riu'),
(58, 'Santa Margalida'),
(59, 'Santa Maria del Camí'),
(60, 'Santanyí'),
(61, 'Selva'),
(62, 'Sencelles'),
(63, 'Sineu'),
(64, 'Sóller'),
(65, 'Son Servera'),
(66, 'Valldemossa'),
(67, 'Vilafranca de Bonany');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RESERVA`
--

CREATE TABLE `RESERVA` (
  `ID_RESERVA` int(11) NOT NULL,
  `FK_ID_USUARI` int(11) NOT NULL,
  `FK_ID_ALLOTJAMENT` int(11) NOT NULL,
  `DATA_INICIAL` date NOT NULL,
  `DATA_FINAL` date NOT NULL,
  `CONFIRMADA` tinyint(1) NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `RESERVA`
--

INSERT INTO `RESERVA` (`ID_RESERVA`, `FK_ID_USUARI`, `FK_ID_ALLOTJAMENT`, `DATA_INICIAL`, `DATA_FINAL`, `CONFIRMADA`) VALUES
(1, 1, 1, '2022-03-13', '2022-03-15', 1),
(2, 2, 1, '2022-04-01', '2022-04-05', 1),
(3, 3, 1, '2023-06-14', '2023-06-18', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SERVEIS`
--

CREATE TABLE `SERVEIS` (
  `ID_SERVEI` int(11) NOT NULL,
  `NOM_SERVEI` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `SERVEIS`
--

INSERT INTO `SERVEIS` (`ID_SERVEI`, `NOM_SERVEI`) VALUES
(1, 'Platja'),
(2, 'Jardí'),
(3, 'Wifi'),
(4, 'Ascensor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TIPUS`
--

CREATE TABLE `TIPUS` (
  `ID_TIPUS` int(11) NOT NULL,
  `NOM_TIPUS` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `TIPUS`
--

INSERT INTO `TIPUS` (`ID_TIPUS`, `NOM_TIPUS`) VALUES
(1, 'Hotel'),
(2, 'Apartament'),
(3, 'Casa Rural'),
(4, 'Hostal'),
(5, 'Camping'),
(6, 'Piscina'),
(7, 'Restaurant'),
(8, 'Bar'),
(9, 'Gimnas'),
(10, 'Spa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TRADUCCIO_SERVEIS`
--

CREATE TABLE `TRADUCCIO_SERVEIS` (
  `FK_ID_SERVEI` int(11) NOT NULL,
  `FK_ID_IDIOMA` int(11) NOT NULL,
  `TRADUCCIO_SERVEI` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `TRADUCCIO_SERVEIS`
--

INSERT INTO `TRADUCCIO_SERVEIS` (`FK_ID_SERVEI`, `FK_ID_IDIOMA`, `TRADUCCIO_SERVEI`) VALUES
(1, 1, 'Playa'),
(1, 2, 'Platja'),
(1, 3, 'Beach'),
(2, 1, 'Jardín'),
(2, 2, 'Jardí'),
(2, 3, 'Garden'),
(3, 1, 'WiFi'),
(3, 2, 'WiFi'),
(3, 3, 'WiFi'),
(4, 1, 'Ascensor'),
(4, 2, 'Ascensor'),
(4, 3, 'Lift');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TRADUCCIO_TIPUS`
--

CREATE TABLE `TRADUCCIO_TIPUS` (
  `FK_ID_TIPUS` int(11) NOT NULL,
  `FK_ID_IDIOMA` int(11) NOT NULL,
  `TRADUCCIO_TIPUS` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `TRADUCCIO_TIPUS`
--

INSERT INTO `TRADUCCIO_TIPUS` (`FK_ID_TIPUS`, `FK_ID_IDIOMA`, `TRADUCCIO_TIPUS`) VALUES
(1, 1, 'Hotel'),
(1, 2, 'Hotel'),
(1, 3, 'Hotel'),
(2, 1, 'Apartamento'),
(2, 2, 'Apartament'),
(2, 3, 'Apartment'),
(3, 1, 'Casa Rural'),
(3, 2, 'Casa Rural'),
(3, 3, 'Cottage'),
(4, 1, 'Hostal'),
(4, 2, 'Hostal'),
(4, 3, 'Hostel'),
(5, 1, 'Cámping'),
(5, 2, 'Campament'),
(5, 3, 'Camping'),
(6, 1, 'Piscina'),
(6, 2, 'Piscina'),
(6, 3, 'Swimming pool'),
(7, 1, 'Restaurante'),
(7, 2, 'Restaurant'),
(7, 3, 'Restaurant'),
(8, 1, 'Bar'),
(8, 2, 'Bar'),
(8, 3, 'Pub'),
(9, 1, 'Gimnasio'),
(9, 2, 'Gimnas'),
(9, 3, 'Gym'),
(10, 1, 'Spa'),
(10, 2, 'Spa'),
(10, 3, 'Spa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TRADUCCIO_VACANCES`
--

CREATE TABLE `TRADUCCIO_VACANCES` (
  `FK_ID_VACANCES` int(11) NOT NULL,
  `FK_ID_IDIOMA` int(11) NOT NULL,
  `TRADUCCIO_VAC` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `TRADUCCIO_VACANCES`
--

INSERT INTO `TRADUCCIO_VACANCES` (`FK_ID_VACANCES`, `FK_ID_IDIOMA`, `TRADUCCIO_VAC`) VALUES
(1, 1, 'Playa'),
(1, 2, 'Platja'),
(1, 3, 'Beach'),
(2, 1, 'Montaña'),
(2, 2, 'Muntanya'),
(2, 3, 'Mountain'),
(3, 1, 'Urbano'),
(3, 2, 'Urbà'),
(3, 3, 'Urban'),
(4, 1, 'Rural'),
(4, 2, 'Rural'),
(4, 3, 'Rural'),
(5, 1, 'Cultural'),
(5, 2, 'Cultural'),
(5, 3, 'Cultural');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIS`
--

CREATE TABLE `USUARIS` (
  `ID_USUARI` int(11) NOT NULL,
  `DNI` varchar(9) NOT NULL,
  `NOM_COMPLET` varchar(50) NOT NULL,
  `CORREU_ELECTRONIC` varchar(50) NOT NULL,
  `CONTRASENYA` varchar(64) NOT NULL,
  `TELEFON` varchar(9) NOT NULL,
  `ADMINISTRADOR` tinyint(1) NOT NULL,
  `TOKEN` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `USUARIS`
--

INSERT INTO `USUARIS` (`ID_USUARI`, `DNI`, `NOM_COMPLET`, `CORREU_ELECTRONIC`, `CONTRASENYA`, `TELEFON`, `ADMINISTRADOR`, `TOKEN`) VALUES
(1, '11111111A', 'Joan Toni Ramon Crespí', 'joanantoniramon@paucasesnovescifp.cat', 'joantoni1234', '666555444', 1, NULL),
(2, '22222222B', 'Jaume Truyols Sosa', 'jaumetruyols@paucasesnovescifp.cat', 'jaume1234', '666333222', 1, NULL),
(3, '33333333C', 'Isaac Palou Gijón', 'isaacpalou@paucasesnovescifp.cat', 'isaac1234', '666111999', 1, NULL),
(4, '44444444D', 'Maria Ferrer Bleda', 'mariamargalidaferrer@paucasesnovescifp.cat', 'maria1234', '666888777', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `VACANCES`
--

CREATE TABLE `VACANCES` (
  `ID_VACANCES` int(11) NOT NULL,
  `NOM_VACANCES` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `VACANCES`
--

INSERT INTO `VACANCES` (`ID_VACANCES`, `NOM_VACANCES`) VALUES
(1, 'Platja'),
(2, 'Muntanya'),
(3, 'Urbà'),
(4, 'Rural'),
(5, 'Cultural');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `VALORACIONS`
--

CREATE TABLE `VALORACIONS` (
  `ID_VALORACIO` int(11) NOT NULL,
  `PUNTUACIO` int(11) NOT NULL,
  `FK_ID_USUARI` int(11) NOT NULL,
  `FK_ID_ALLOTJAMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `VALORACIONS`
--

INSERT INTO `VALORACIONS` (`ID_VALORACIO`, `PUNTUACIO`, `FK_ID_USUARI`, `FK_ID_ALLOTJAMENT`) VALUES
(1, 10, 1, 1),
(2, 9, 1, 2),
(3, 4, 2, 1),
(4, 5, 2, 2),
(5, 6, 3, 1),
(6, 3, 3, 2),
(7, 8, 4, 1),
(8, 9, 4, 2);

--
-- Disparadores `VALORACIONS`
--
DELIMITER $$
CREATE TRIGGER `CALCULAR_VALORACIO_GLOBAL` AFTER INSERT ON `VALORACIONS` FOR EACH ROW begin
    update ALLOTJAMENTS
    set VALORACIO_GLOBAL = (select avg(PUNTUACIO) from VALORACIONS where FK_ID_ALLOTJAMENT = NEW.FK_ID_ALLOTJAMENT)
    where ID_ALLOTJAMENT = NEW.FK_ID_ALLOTJAMENT;
end
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ALLOTJAMENTS`
--
ALTER TABLE `ALLOTJAMENTS`
  ADD PRIMARY KEY (`ID_ALLOTJAMENT`),
  ADD KEY `FK_ID_MUNICIPI` (`FK_ID_MUNICIPI`),
  ADD KEY `FK_ID_TIPUS` (`FK_ID_TIPUS`),
  ADD KEY `FK_ID_VACANCES` (`FK_ID_VACANCES`),
  ADD KEY `FK_ID_CATEGORIA` (`FK_ID_CATEGORIA`),
  ADD KEY `FK_ID_USUARI` (`FK_ID_USUARI`);

--
-- Indices de la tabla `ALLOTJAMENTS_SERVEIS`
--
ALTER TABLE `ALLOTJAMENTS_SERVEIS`
  ADD PRIMARY KEY (`FK_ID_ALLOT`,`FK_ID_SERVEI`),
  ADD KEY `FK_ID_SERVEI` (`FK_ID_SERVEI`);

--
-- Indices de la tabla `CATEGORIA`
--
ALTER TABLE `CATEGORIA`
  ADD PRIMARY KEY (`ID_CATEGORIA`);

--
-- Indices de la tabla `COMENTARIS`
--
ALTER TABLE `COMENTARIS`
  ADD PRIMARY KEY (`ID_COMENTARI`),
  ADD KEY `FK_ID_USUARI` (`FK_ID_USUARI`),
  ADD KEY `FK_ID_ALLOTJAMENT` (`FK_ID_ALLOTJAMENT`);

--
-- Indices de la tabla `FOTOGRAFIES`
--
ALTER TABLE `FOTOGRAFIES`
  ADD PRIMARY KEY (`ID_FOTO`,`FK_ID_ALLOTJAMENT`),
  ADD KEY `FK_ID_ALLOTJAMENT` (`FK_ID_ALLOTJAMENT`);

--
-- Indices de la tabla `IDIOMES`
--
ALTER TABLE `IDIOMES`
  ADD PRIMARY KEY (`ID_IDIOMA`);

--
-- Indices de la tabla `MUNICIPIS`
--
ALTER TABLE `MUNICIPIS`
  ADD PRIMARY KEY (`ID_MUNICIPI`);

--
-- Indices de la tabla `RESERVA`
--
ALTER TABLE `RESERVA`
  ADD PRIMARY KEY (`ID_RESERVA`),
  ADD KEY `FK_ID_USUARI` (`FK_ID_USUARI`),
  ADD KEY `FK_ID_ALLOTJAMENT` (`FK_ID_ALLOTJAMENT`);

--
-- Indices de la tabla `SERVEIS`
--
ALTER TABLE `SERVEIS`
  ADD PRIMARY KEY (`ID_SERVEI`);

--
-- Indices de la tabla `TIPUS`
--
ALTER TABLE `TIPUS`
  ADD PRIMARY KEY (`ID_TIPUS`);

--
-- Indices de la tabla `TRADUCCIO_SERVEIS`
--
ALTER TABLE `TRADUCCIO_SERVEIS`
  ADD PRIMARY KEY (`FK_ID_SERVEI`,`FK_ID_IDIOMA`),
  ADD KEY `FK_ID_IDIOMA` (`FK_ID_IDIOMA`);

--
-- Indices de la tabla `TRADUCCIO_TIPUS`
--
ALTER TABLE `TRADUCCIO_TIPUS`
  ADD PRIMARY KEY (`FK_ID_TIPUS`,`FK_ID_IDIOMA`),
  ADD KEY `FK_ID_IDIOMA` (`FK_ID_IDIOMA`);

--
-- Indices de la tabla `TRADUCCIO_VACANCES`
--
ALTER TABLE `TRADUCCIO_VACANCES`
  ADD PRIMARY KEY (`FK_ID_VACANCES`,`FK_ID_IDIOMA`),
  ADD KEY `FK_ID_IDIOMA` (`FK_ID_IDIOMA`);

--
-- Indices de la tabla `USUARIS`
--
ALTER TABLE `USUARIS`
  ADD PRIMARY KEY (`ID_USUARI`),
  ADD UNIQUE KEY `TOKEN` (`TOKEN`);

--
-- Indices de la tabla `VACANCES`
--
ALTER TABLE `VACANCES`
  ADD PRIMARY KEY (`ID_VACANCES`);

--
-- Indices de la tabla `VALORACIONS`
--
ALTER TABLE `VALORACIONS`
  ADD PRIMARY KEY (`ID_VALORACIO`),
  ADD KEY `FK_ID_USUARI` (`FK_ID_USUARI`),
  ADD KEY `FK_ID_ALLOTJAMENT` (`FK_ID_ALLOTJAMENT`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ALLOTJAMENTS`
--
ALTER TABLE `ALLOTJAMENTS`
  MODIFY `ID_ALLOTJAMENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `CATEGORIA`
--
ALTER TABLE `CATEGORIA`
  MODIFY `ID_CATEGORIA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `COMENTARIS`
--
ALTER TABLE `COMENTARIS`
  MODIFY `ID_COMENTARI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `FOTOGRAFIES`
--
ALTER TABLE `FOTOGRAFIES`
  MODIFY `ID_FOTO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `IDIOMES`
--
ALTER TABLE `IDIOMES`
  MODIFY `ID_IDIOMA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `MUNICIPIS`
--
ALTER TABLE `MUNICIPIS`
  MODIFY `ID_MUNICIPI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `RESERVA`
--
ALTER TABLE `RESERVA`
  MODIFY `ID_RESERVA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `SERVEIS`
--
ALTER TABLE `SERVEIS`
  MODIFY `ID_SERVEI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `TIPUS`
--
ALTER TABLE `TIPUS`
  MODIFY `ID_TIPUS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `USUARIS`
--
ALTER TABLE `USUARIS`
  MODIFY `ID_USUARI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `VACANCES`
--
ALTER TABLE `VACANCES`
  MODIFY `ID_VACANCES` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `VALORACIONS`
--
ALTER TABLE `VALORACIONS`
  MODIFY `ID_VALORACIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ALLOTJAMENTS`
--
ALTER TABLE `ALLOTJAMENTS`
  ADD CONSTRAINT `ALLOTJAMENTS_ibfk_1` FOREIGN KEY (`FK_ID_MUNICIPI`) REFERENCES `MUNICIPIS` (`ID_MUNICIPI`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ALLOTJAMENTS_ibfk_2` FOREIGN KEY (`FK_ID_TIPUS`) REFERENCES `TIPUS` (`ID_TIPUS`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ALLOTJAMENTS_ibfk_3` FOREIGN KEY (`FK_ID_VACANCES`) REFERENCES `VACANCES` (`ID_VACANCES`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ALLOTJAMENTS_ibfk_4` FOREIGN KEY (`FK_ID_CATEGORIA`) REFERENCES `CATEGORIA` (`ID_CATEGORIA`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ALLOTJAMENTS_ibfk_5` FOREIGN KEY (`FK_ID_USUARI`) REFERENCES `USUARIS` (`ID_USUARI`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ALLOTJAMENTS_SERVEIS`
--
ALTER TABLE `ALLOTJAMENTS_SERVEIS`
  ADD CONSTRAINT `ALLOTJAMENTS_SERVEIS_ibfk_1` FOREIGN KEY (`FK_ID_ALLOT`) REFERENCES `ALLOTJAMENTS` (`ID_ALLOTJAMENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ALLOTJAMENTS_SERVEIS_ibfk_2` FOREIGN KEY (`FK_ID_SERVEI`) REFERENCES `SERVEIS` (`ID_SERVEI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `COMENTARIS`
--
ALTER TABLE `COMENTARIS`
  ADD CONSTRAINT `COMENTARIS_ibfk_1` FOREIGN KEY (`FK_ID_USUARI`) REFERENCES `USUARIS` (`ID_USUARI`) ON UPDATE CASCADE,
  ADD CONSTRAINT `COMENTARIS_ibfk_2` FOREIGN KEY (`FK_ID_ALLOTJAMENT`) REFERENCES `ALLOTJAMENTS` (`ID_ALLOTJAMENT`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `FOTOGRAFIES`
--
ALTER TABLE `FOTOGRAFIES`
  ADD CONSTRAINT `FOTOGRAFIES_ibfk_1` FOREIGN KEY (`FK_ID_ALLOTJAMENT`) REFERENCES `ALLOTJAMENTS` (`ID_ALLOTJAMENT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `RESERVA`
--
ALTER TABLE `RESERVA`
  ADD CONSTRAINT `RESERVA_ibfk_1` FOREIGN KEY (`FK_ID_USUARI`) REFERENCES `USUARIS` (`ID_USUARI`) ON UPDATE CASCADE,
  ADD CONSTRAINT `RESERVA_ibfk_2` FOREIGN KEY (`FK_ID_ALLOTJAMENT`) REFERENCES `ALLOTJAMENTS` (`ID_ALLOTJAMENT`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `TRADUCCIO_SERVEIS`
--
ALTER TABLE `TRADUCCIO_SERVEIS`
  ADD CONSTRAINT `TRADUCCIO_SERVEIS_ibfk_1` FOREIGN KEY (`FK_ID_SERVEI`) REFERENCES `SERVEIS` (`ID_SERVEI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TRADUCCIO_SERVEIS_ibfk_2` FOREIGN KEY (`FK_ID_IDIOMA`) REFERENCES `IDIOMES` (`ID_IDIOMA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `TRADUCCIO_TIPUS`
--
ALTER TABLE `TRADUCCIO_TIPUS`
  ADD CONSTRAINT `TRADUCCIO_TIPUS_ibfk_1` FOREIGN KEY (`FK_ID_TIPUS`) REFERENCES `TIPUS` (`ID_TIPUS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TRADUCCIO_TIPUS_ibfk_2` FOREIGN KEY (`FK_ID_IDIOMA`) REFERENCES `IDIOMES` (`ID_IDIOMA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `TRADUCCIO_VACANCES`
--
ALTER TABLE `TRADUCCIO_VACANCES`
  ADD CONSTRAINT `TRADUCCIO_VACANCES_ibfk_1` FOREIGN KEY (`FK_ID_VACANCES`) REFERENCES `VACANCES` (`ID_VACANCES`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TRADUCCIO_VACANCES_ibfk_2` FOREIGN KEY (`FK_ID_IDIOMA`) REFERENCES `IDIOMES` (`ID_IDIOMA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `VALORACIONS`
--
ALTER TABLE `VALORACIONS`
  ADD CONSTRAINT `VALORACIONS_ibfk_1` FOREIGN KEY (`FK_ID_USUARI`) REFERENCES `USUARIS` (`ID_USUARI`) ON UPDATE CASCADE,
  ADD CONSTRAINT `VALORACIONS_ibfk_2` FOREIGN KEY (`FK_ID_ALLOTJAMENT`) REFERENCES `ALLOTJAMENTS` (`ID_ALLOTJAMENT`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

