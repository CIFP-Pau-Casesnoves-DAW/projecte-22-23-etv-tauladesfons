-- ! INSERTS

INSERT INTO `IDIOMES` (`ID_IDIOMA`, `NOM_IDIOMA`) VALUES
    (1, "ESPANYOL"),
    (2,"CATALA"),
    (3,"ANGLES");

INSERT INTO `TIPUS`(`NOM_TIPUS`) VALUES
	('Hotel'),
	('Apartament'),
	('Casa Rural'),
	('Hostal'),
	('Camping'),
	('Piscina'),
	('Restaurant'),
	('Bar'),
	('Gimnas'),
	('Spa');

INSERT INTO `SERVEIS`(`ID_SERVEI`,`NOM_SERVEI`) VALUES
	(1,'Platja'),
	(2,'Jardí'),
	(3,'Wifi'),
	(4,'Ascensor');

INSERT INTO `VACANCES` (`ID_VACANCES`, `NOM_VACANCES`) VALUES
	(1, 'Platja'),
	(2, 'Muntanya'),
	(3, 'Urbà'),
	(4, 'Rural'),
	(5, 'Cultural');

INSERT INTO `TRADUCCIO_TIPUS`(`FK_ID_TIPUS`,`FK_ID_IDIOMA`,`TRADUCCIO_TIPUS`) VALUES
	(1,1,'Hotel'),(1,2,'Hotel'),(1,3,'Hotel'),
	(2,1, 'Apartamento'),(2,2,'Apartament'),(2,3,'Apartment'),
	(3,1,'Casa Rural'),(3,2,'Casa Rural'),(3,3,'Cottage'),
	(4,1,'Hostal'),(4,2, 'Hostal'),(4,3,'Hostel'),
	(5,1,'Cámping'),(5,2,'Campament'),(5,3,'Camping'),
	(6,1,'Piscina'),(5,2,'Piscina'),(6,3,'Swimming pool'),
	(7,1,'Restaurante'),(7,2,'Restaurant'),(7,3,'Restaurant'),
	(8,1,'Bar'),(8,2,'Bar'),(8,3,'Pub'),
	(9,1,'Gimnasio'),(9,2,'Gimnas'),(9,3,'Gym'),
	(10,1,'Spa'),(10,2,'Spa'),(10,3,'Spa');

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

INSERT INTO `TRADUCCIO_SERVEIS`(`FK_ID_SERVEI`,`FK_ID_IDIOMA`,`TRADUCCIO_SERVEI`) VALUES
	(1,1,'Playa'),(1,2,'Platja'),(1,3,'Beach'),
	(2,1, 'Jardín'),(2,2,'Jardí'),(2,3,'Garden'),
	(3,1,'WiFi'),(3,2,'WiFi'),(3,3,'WiFi'),
	(4,1,'Ascensor'),(4,2, 'Ascensor'),(4,3,'Lift');

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

INSERT INTO `USUARIS` (`ID_USUARI`, `DNI`, `NOM_COMPLET`, `CORREU_ELECTRONIC`, `CONTRASENYA`, `TELEFON`, `ADMINISTRADOR`) VALUES
	(1, '11111111A', 'Joan Toni Ramon Crespí', 'joanantoniramon@paucasesnovescifp.cat', 'joantoni1234', '666555444', TRUE),
	(2, '22222222B', 'Jaume Truyols Sosa', 'jaumetruyols@paucasesnovescifp.cat', 'jaume1234', '666333222', TRUE),
	(3, '33333333C', 'Isaac Palou Gijón', 'isaacpalou@paucasesnovescifp.cat', 'isaac1234', '666111999', TRUE),
	(4 '44444444D', 'Maria Ferrer Bleda', 'mariamargalidaferrer@paucasesnovescifp.cat', 'maria1234', '666888777', TRUE);

INSERT INTO `CATEGORIA`(`ID_CATEGORIA`,`NOM_CATEGORIA`,`TARIFA`) VALUES
	(1,'Luxe',FALSE),
	(2,'Normal',FALSE),
	(3,'Basica',FALSE);

INSERT INTO `ALLOTJAMENTS` (`ID_ALLOTJAMENT`,`NOM_COMERCIAL`, `NUM_REGISTRE`, `DESCRIPCIO`, `LLITS`, `PERSONES`, `BANYS`, `ADREÇA`, `DESTACAT`, `FK_ID_MUNICIPI`, `FK_ID_TIPUS`, `FK_ID_VACANCES`, `FK_ID_CATEGORIA`, `FK_ID_USUARI`) VALUES
	(1,ProvaAllotjament1,'provaA123','Lorem ipsum dolor sit amet, consectetur adipiscing elit.',3,6,2,'C/Prova, 1', TRUE, 1, 1, 1, 1, 1);
	(2,ProvaAllotjament2,'provaB456','Nulla nec dictum nibh.',1,2,1,'C/Prova, 2', FALSE, 2, 2, 2, 2, 2);

INSERT INTO `RESERVA` (`ID_RESERVA`, `FK_ID_USUARI`, `FK_ID_ALLOTJAMENT`, `DATA_INICIAL`, `DATA_FINAL`, `CONFIRMADA`) VALUES
	(1, 1, 1, 2022-03-13, 2022-03-15, TRUE),
	(2, 2, 1, 2022-04-01, 2022-04-05, TRUE),
	(3, 3, 1, 2023-06-14, 2023-06-18, FALSE);

INSERT INTO `COMENTARIS` (`ID_COMENTARI`, `DESCRIPCIO`, `DATA`, `HORA`, `FK_ID_USUARI`, `FK_ID_ALLOTJAMENT`) VALUES
	(1, 'Una estància meravellosa. Repetirem segur.', 2022-03-16, 12:25:00, 1, 1),
	(2, 'Estava molt brut. Ens vàrem queixar i no ens van donar cap solució.', 2022-04-06, 21:30:07, 2, 1);

INSERT INTO `VALORACIONS` (`ID_VALORACIO`, `PUNTUACIO`, `FK_ID_USUARI`, `FK_ID_ALLOTJAMENT`) VALUES
	(1, 10, 1, 1),
	(2, 9, 1, 2),
	(3, 4, 2, 1),
	(4, 5, 2, 2),
	(5, 6, 3, 1),
	(6, 3, 3, 2),
	(7, 8, 4, 1),
	(8, 9, 4, 2);

INSERT INTO `ALLOTJAMENTS_SERVEIS` (`FK_ID_ALLOT`, `FK_ID_SERVEI`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(2, 1),
	(2, 2),
	(2, 3);
