drop database if exists ETVDB;
create database if not exists ETVDB;

use ETVDB;

create table `IDIOMES`
(
    `ID_IDIOMA`  INT         not null auto_increment,
    `NOM_IDIOMA` VARCHAR(50) not null,
    primary key (`ID_IDIOMA`)
);

create table `TIPUS`
(
    `ID_TIPUS`  INT         not null auto_increment,
    `NOM_TIPUS` VARCHAR(50) not null,
    primary key (`ID_TIPUS`)
);

create table `SERVEIS`
(
    `ID_SERVEI`  INT         not null auto_increment,
    `NOM_SERVEI` VARCHAR(50) not null,
    primary key (`ID_SERVEI`)
);

create table `VACANCES`
(
    `ID_VACANCES`  INT         not null auto_increment,
    `NOM_VACANCES` VARCHAR(50) not null,
    primary key (`ID_VACANCES`)
);

create table `TRADUCCIO_TIPUS`
(
    `FK_ID_TIPUS`     INT         not null,
    `FK_ID_IDIOMA`    INT         not null,
    `TRADUCCIO_TIPUS` VARCHAR(50) not null,
    primary key (`FK_ID_TIPUS`, `FK_ID_IDIOMA`),
    foreign key (`FK_ID_TIPUS`) references `TIPUS` (`ID_TIPUS`),
    foreign key (`FK_ID_IDIOMA`) references `IDIOMES` (`ID_IDIOMA`)
);

create table `TRADUCCIO_VACANCES`
(
    `FK_ID_VACANCES` INT         not null,
    `FK_ID_IDIOMA`   INT         not null,
    `TRADUCCIO_VAC`  VARCHAR(50) not null,
    primary key (`FK_ID_VACANCES`, `FK_ID_IDIOMA`),
    foreign key (`FK_ID_VACANCES`) references `VACANCES` (`ID_VACANCES`),
    foreign key (`FK_ID_IDIOMA`) references `IDIOMES` (`ID_IDIOMA`)
);

create table `TRADUCCIO_SERVEIS`
(
    `FK_ID_SERVEI`     INT         not null,
    `FK_ID_IDIOMA`     INT         not null,
    `TRADUCCIO_SERVEI` VARCHAR(50) not null,
    primary key (`FK_ID_SERVEI`, `FK_ID_IDIOMA`),
    foreign key (`FK_ID_SERVEI`) references `SERVEIS` (`ID_SERVEI`),
    foreign key (`FK_ID_IDIOMA`) references `IDIOMES` (`ID_IDIOMA`)
);

create table `MUNICIPIS`
(
    `ID_MUNICIPI`  INT         not null auto_increment,
    `NOM_MUNICIPI` VARCHAR(50) not null,
    primary key (`ID_MUNICIPI`)
);

create table `USUARIS`
(
    `ID_USUARI`         INT         not null auto_increment,
    `DNI`               VARCHAR(9)  not null,
    `NOM_COMPLET`       VARCHAR(50) not null,
    `CORREU_ELECTRONIC` VARCHAR(50) not null,
    `CONTRASENYA`       VARCHAR(64) not null,
    `TELEFON`           VARCHAR(9)  not null,
    `ADMINISTRADOR`     BOOLEAN     not null,
    primary key (`ID_USUARI`)
);

create table `CATEGORIA`
(
    `ID_CATEGORIA`  INT         not null auto_increment,
    `NOM_CATEGORIA` VARCHAR(50) not null,
    `TARIFA`        FLOAT       not null,
    primary key (`ID_CATEGORIA`)
);

create table `ALLOTJAMENTS`
(
    `ID_ALLOTJAMENT`   INT          not null auto_increment,
    `NOM_COMERCIAL`    VARCHAR(50)  not null,
    `NUM_REGISTRE`     VARCHAR(50)  not null,
    `DESCRIPCIO`       VARCHAR(500) not null,
    `LLITS`            INT          not null,
    `PERSONES`         INT          not null,
    `BANYS`            INT          not null,
    `ADREÇA`           VARCHAR(50)  not null,
    `DESTACAT`         BOOLEAN      not null,
    `VALORACIO_GLOBAL` INT default null,
    `FK_ID_MUNICIPI`   INT          not null,
    `FK_ID_TIPUS`      INT          not null,
    `FK_ID_VACANCES`   INT          not null,
    `FK_ID_CATEGORIA`  INT          not null,
    `FK_ID_USUARI`     INT          not null,
    primary key (`ID_ALLOTJAMENT`),
    foreign key (`FK_ID_MUNICIPI`) references `MUNICIPIS` (`ID_MUNICIPI`),
    foreign key (`FK_ID_TIPUS`) references `TIPUS` (`ID_TIPUS`),
    foreign key (`FK_ID_VACANCES`) references `VACANCES` (`ID_VACANCES`),
    foreign key (`FK_ID_CATEGORIA`) references `CATEGORIA` (`ID_CATEGORIA`),
    foreign key (`FK_ID_USUARI`) references `USUARIS` (`ID_USUARI`)
);

create table `RESERVA`
(
    `ID_RESERVA`        INT     not null auto_increment,
    `FK_ID_USUARI`      INT     not null,
    `FK_ID_ALLOTJAMENT` INT     not null,
    `DATA_INICIAL`      DATE    not null,
    `DATA_FINAL`        DATE    not null,
    `CONFIRMADA`        BOOLEAN not null,
    primary key (`ID_RESERVA`),
    foreign key (`FK_ID_USUARI`) references `USUARIS` (`ID_USUARI`),
    foreign key (`FK_ID_ALLOTJAMENT`) references `ALLOTJAMENTS` (`ID_ALLOTJAMENT`)
);

create table `COMENTARIS`
(
    `ID_COMENTARI`      INT          not null auto_increment,
    `DESCRIPCIO`        VARCHAR(500) not null,
    `DATA`              DATE         not null,
    `HORA`              TIME         not null,
    `FK_ID_USUARI`      INT          not null,
    `FK_ID_ALLOTJAMENT` INT          not null,
    primary key (`ID_COMENTARI`),
    foreign key (`FK_ID_USUARI`) references `USUARIS` (`ID_USUARI`),
    foreign key (`FK_ID_ALLOTJAMENT`) references `ALLOTJAMENTS` (`ID_ALLOTJAMENT`)
);

create table `VALORACIONS`
(
    `ID_VALORACIO`      INT not null auto_increment,
    `PUNTUACIO`         INT not null,
    `FK_ID_USUARI`      INT not null,
    `FK_ID_ALLOTJAMENT` INT not null,
    primary key (`ID_VALORACIO`),
    foreign key (`FK_ID_USUARI`) references `USUARIS` (`ID_USUARI`),
    foreign key (`FK_ID_ALLOTJAMENT`) references `ALLOTJAMENTS` (`ID_ALLOTJAMENT`)
);

create table `ALLOTJAMENTS_SERVEIS`
(
    `FK_ID_ALLOT`  INT not null,
    `FK_ID_SERVEI` INT not null,
    primary key (`FK_ID_ALLOT`, `FK_ID_SERVEI`),
    foreign key (`FK_ID_ALLOT`) references `ALLOTJAMENTS` (`ID_ALLOTJAMENT`),
    foreign key (`FK_ID_SERVEI`) references `SERVEIS` (`ID_SERVEI`)
);

create table `FOTOGRAFIES`
(
    `ID_FOTO`           INT         not null auto_increment,
    `FOTO`              VARCHAR(50) not null,
    `FK_ID_ALLOTJAMENT` INT         not null,
    primary key (`ID_FOTO`, `FK_ID_ALLOTJAMENT`),
    foreign key (`FK_ID_ALLOTJAMENT`) references `ALLOTJAMENTS` (`ID_ALLOTJAMENT`)
);

delimiter $$
create trigger `CALCULAR_VALORACIO_GLOBAL`
    after insert
    on `VALORACIONS`
    for each row
begin
    update ALLOTJAMENTS
    set VALORACIO_GLOBAL = (select avg(PUNTUACIO) from VALORACIONS where FK_ID_ALLOTJAMENT = NEW.FK_ID_ALLOTJAMENT)
    where ID_ALLOTJAMENT = NEW.FK_ID_ALLOTJAMENT;
end$$