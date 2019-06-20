-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Giu 20, 2019 alle 13:13
-- Versione del server: 5.6.33-log
-- PHP Version: 5.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my_sharemyhouse`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Abitazioni`
--

CREATE TABLE IF NOT EXISTS `Abitazioni` (
  `IDAbitazione` int(11) NOT NULL AUTO_INCREMENT,
  `NomeAbitazione` varchar(50) NOT NULL,
  `Proprietario` varchar(50) NOT NULL,
  `scadenzaDisponibilita` date NOT NULL,
  `postiTotali` int(3) NOT NULL DEFAULT '0',
  `postiOccupati` int(3) NOT NULL DEFAULT '0',
  `Idonea` int(1) NOT NULL DEFAULT '0',
  `AccessoDisabili` int(1) NOT NULL DEFAULT '0',
  `Regione` varchar(50) NOT NULL,
  `Provincia` varchar(50) NOT NULL,
  `Citta` varchar(50) NOT NULL,
  `Indirizzo` varchar(50) NOT NULL,
  `Latitudine` varchar(50) NOT NULL,
  `Longitudine` varchar(50) NOT NULL,
  PRIMARY KEY (`IDAbitazione`),
  KEY `IDAbitazione` (`IDAbitazione`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dump dei dati per la tabella `Abitazioni`
--

INSERT INTO `Abitazioni` (`IDAbitazione`, `NomeAbitazione`, `Proprietario`, `scadenzaDisponibilita`, `postiTotali`, `postiOccupati`, `Idonea`, `AccessoDisabili`, `Regione`, `Provincia`, `Citta`, `Indirizzo`, `Latitudine`, `Longitudine`) VALUES
(1, 'Villetta a Barletta', 'CODICEFISCALE1', '2021-03-08', 5, 0, 0, 1, 'Puglia', 'BT', 'Barletta', 'Via Milano, 15', '41.318396', '16.278103'),
(42, 'Appartamento a Benevento', 'CODICEFISCALE1', '2020-01-01', 3, 2, 1, 0, 'Campania', 'BN', 'Benevento', 'Via Fratelli Rosselli, 15', '41.111470', '14.801485'),
(10, 'Casa Al Mare', 'CODICEFISCALE1', '2020-01-01', 2, 0, 0, 1, 'Calabria', 'CS', 'Scalea', 'Via Lauro, 15', '39.8133363', '15.7928808'),
(15, 'Casetta Caserta', 'CODICEFISCALE1', '2025-05-19', 6, 0, 1, 0, 'Campania', 'CA', 'Caserta', 'Via Roma, 43', '41.0702173', '14.3332657'),
(16, 'Casa Firenze', 'CODICEFISCALE1', '2020-05-30', 5, 0, 0, 1, 'Toscana', 'FI', 'Firenze', 'Via Ricasoli, 10', '43.7742317', '11.2567592'),
(54, 'Casa1', 'CODICEFISCALE1', '2019-05-22', 2, 0, 0, 0, 'Calabria', 'CS', 'Scalea', 'Via nuova', '39.8141152', '15.7912677'),
(55, 'Casa2', 'CODICEFISCALE1', '2019-05-31', 2, 0, 0, 1, 'Calabria', 'CS', 'Scalea', 'Via vecchia', '39.8071164', '15.7907432');

-- --------------------------------------------------------

--
-- Struttura della tabella `InfoUtente`
--

CREATE TABLE IF NOT EXISTS `InfoUtente` (
  `CF` varchar(50) NOT NULL,
  `Regione` varchar(50) NOT NULL,
  `Provincia` varchar(50) NOT NULL,
  `Citta` varchar(50) NOT NULL,
  `Indirizzo` varchar(250) NOT NULL,
  `AccessoDisabiliNecessario` int(1) NOT NULL,
  `DataNascita` date NOT NULL,
  `mail` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `latitudine` varchar(50) NOT NULL,
  `longitudine` varchar(50) NOT NULL,
  `idImmobileAssegnato` int(10) DEFAULT NULL,
  PRIMARY KEY (`CF`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `InfoUtente`
--

INSERT INTO `InfoUtente` (`CF`, `Regione`, `Provincia`, `Citta`, `Indirizzo`, `AccessoDisabiliNecessario`, `DataNascita`, `mail`, `telefono`, `latitudine`, `longitudine`, `idImmobileAssegnato`) VALUES
('CODICEFISCALE1', 'Campania', 'BN', 'Benevento', 'Via Garibaldi, 19', 1, '1989-04-01', 'cf1@mailinator.com', '3394440001', '41.132388', '14.772882', 0),
('CITTADINO1', 'Calabria', 'CS', 'Scalea', 'Via Lauro, 150', 0, '2017-09-11', 'festa670@gmail.com', '3662891824', '39.809115', '15.795484', 42),
('CITTADINO2', 'Campania', 'NA', 'Napoli', 'Piazza Garibaldi, 5', 1, '2017-09-11', 'festa670@gmail.com', '3662891824', '40.851607', '14.267509', 58),
('CITTADINO3', 'Campania', 'NA', 'Poggiomarino', 'Via nuova san marzano, 10', 1, '1996-10-10', 'CITTADINO@mail.com', '3525615042', '40.7974366', '14.5430346', 57),
('CITTADINO4', 'Emilia-Romagna', 'BO', 'Bologna', 'Via verdi, 7', 0, '1995-10-10', 'aurelio@aurelio.com', '3669851545', '44.4962284', '11.3505879', 0),
('cittadino5', 'Lazio', 'RM', 'Roma', 'Via roma, 7', 0, '2000-01-01', 'myy@gg.vv', '3659841212', '41.7896339', '12.6690769', 42),
('asdasdasdasdasda', 'Basilicata', 'PZ', 'Palermo', 'casa mia', 0, '1991-01-30', 'asdasd@asd.asd', '1231231231', '38.1169971', '13.3700454', NULL),
('VNANLL95L11H931K', 'Campania', 'NA', 'San Giuseppe Vesuviano', 'Cortile Bianchi 6', 0, '1995-07-11', 'anielloavino@libero.it', '3112378146', '40.8260033', '14.5014479', NULL),
('SCDPQL95L26H931B', 'Campania', 'NA', 'Ottaviano', 'Via Franzesi, 26', 0, '1995-07-26', 'scudieripasquale@gmail.com', '3348903831', '40.842248', '14.5065592', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `province`
--

CREATE TABLE IF NOT EXISTS `province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `id_regione` int(11) NOT NULL,
  `sigla` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

--
-- Dump dei dati per la tabella `province`
--

INSERT INTO `province` (`id`, `nome`, `id_regione`, `sigla`) VALUES
(12, 'Agrigento', 11, 'AG'),
(5, 'Alessandria', 13, 'AL'),
(1, 'Ancona', 1, 'AN'),
(77, 'Aosta', 16, 'AO'),
(4, 'Ascoli Piceno', 1, 'AP'),
(45, 'L''Aquila', 2, 'AQ'),
(48, 'Arezzo', 12, 'AR'),
(6, 'Asti', 13, 'AT'),
(34, 'Avellino', 8, 'AV'),
(29, 'Bari', 6, 'BA'),
(90, 'Bergamo', 19, 'BG'),
(7, 'Biella', 13, 'BI'),
(66, 'Belluno', 17, 'BL'),
(35, 'Benevento', 8, 'BN'),
(57, 'Bologna', 14, 'BO'),
(30, 'Brindisi', 6, 'BR'),
(91, 'Brescia', 19, 'BS'),
(102, 'Bolzano', 5, 'BZ'),
(78, 'Cagliari', 10, 'CA'),
(87, 'Campobasso', 4, 'CB'),
(36, 'Caserta', 8, 'CE'),
(44, 'Chieti', 2, 'CH'),
(105, 'Carbonia Iglesias', 10, 'CI'),
(13, 'Caltanissetta', 11, 'CL'),
(8, 'Cuneo', 13, 'CN'),
(92, 'Como', 19, 'CO'),
(93, 'Cremona', 19, 'CR'),
(22, 'Cosenza', 7, 'CS'),
(14, 'Catania', 11, 'CT'),
(21, 'Catanzaro', 7, 'CZ'),
(15, 'Enna', 11, 'EN'),
(59, 'Forli Cesena', 14, 'FC'),
(58, 'Ferrara', 14, 'FE'),
(31, 'Foggia', 6, 'FG'),
(49, 'Firenze', 12, 'FI'),
(39, 'Frosinone', 9, 'FR'),
(82, 'Genova', 18, 'GE'),
(73, 'Gorizia', 15, 'GO'),
(50, 'Grosseto', 12, 'GR'),
(83, 'Imperia', 18, 'IM'),
(86, 'Isernia', 4, 'IS'),
(23, 'Crotone', 7, 'KR'),
(94, 'Lecco', 19, 'LC'),
(32, 'Lecce', 6, 'LE'),
(51, 'Livorno', 12, 'LI'),
(95, 'Lodi', 19, 'LO'),
(40, 'Latina', 9, 'LT'),
(52, 'Lucca', 12, 'LU'),
(2, 'Macerata', 1, 'MC'),
(16, 'Messina', 11, 'ME'),
(97, 'Milano', 19, 'MI'),
(96, 'Mantova', 19, 'MN'),
(60, 'Modena', 14, 'MO'),
(53, 'Massa Carrara', 12, 'MS'),
(27, 'Matera', 3, 'MT'),
(37, 'Napoli', 8, 'NA'),
(9, 'Novara', 13, 'NO'),
(79, 'Nuoro', 10, 'NU'),
(107, 'Ogliastra', 10, 'OG'),
(80, 'Oristano', 10, 'OR'),
(108, 'Olbia Tempio', 10, 'OT'),
(17, 'Palermo', 11, 'PA'),
(62, 'Piacenza', 14, 'PC'),
(67, 'Padova', 17, 'PD'),
(46, 'Pescara', 2, 'PE'),
(88, 'Perugia', 20, 'PG'),
(54, 'Pisa', 12, 'PI'),
(74, 'Pordenone', 15, 'PN'),
(103, 'Prato', 12, 'PO'),
(61, 'Parma', 14, 'PR'),
(55, 'Pistoia', 12, 'PT'),
(3, 'Pesaro Urbino', 1, 'PU'),
(98, 'Pavia', 19, 'PV'),
(28, 'Potenza', 3, 'PZ'),
(63, 'Ravenna', 14, 'RA'),
(24, 'Reggio Calabria', 7, 'RC'),
(64, 'Reggio Emilia', 14, 'RE'),
(18, 'Ragusa', 11, 'RG'),
(41, 'Rieti', 9, 'RI'),
(42, 'Roma', 9, 'RM'),
(65, 'Rimini', 14, 'RN'),
(68, 'Rovigo', 17, 'RO'),
(38, 'Salerno', 8, 'SA'),
(56, 'Siena', 12, 'SI'),
(99, 'Sondrio', 19, 'SO'),
(85, 'La Spezia', 18, 'SP'),
(19, 'Siracusa', 11, 'SR'),
(81, 'Sassari', 10, 'SS'),
(84, 'Savona', 18, 'SV'),
(33, 'Taranto', 6, 'TA'),
(47, 'Teramo', 2, 'TE'),
(101, 'Trento', 5, 'TN'),
(11, 'Torino', 13, 'TO'),
(20, 'Trapani', 11, 'TP'),
(89, 'Terni', 20, 'TR'),
(76, 'Trieste', 15, 'TS'),
(69, 'Treviso', 17, 'TV'),
(75, 'Udine', 15, 'UD'),
(100, 'Varese', 19, 'VA'),
(104, 'Verbania', 13, 'VB'),
(10, 'Vercelli', 13, 'VC'),
(70, 'Venezia', 17, 'VE'),
(72, 'Vicenza', 17, 'VI'),
(71, 'Verona', 17, 'VR'),
(106, 'Medio Campidano', 10, 'VS'),
(43, 'Viterbo', 9, 'VT'),
(25, 'Vibo Valentia', 7, 'VV'),
(109, 'Barletta-Andria-Trani', 6, 'BT');

-- --------------------------------------------------------

--
-- Struttura della tabella `Regione`
--

CREATE TABLE IF NOT EXISTS `Regione` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Regione`
--

INSERT INTO `Regione` (`id`, `nome`) VALUES
(2, 'Abruzzo'),
(3, 'Basilicata'),
(7, 'Calabria'),
(8, 'Campania'),
(14, 'Emilia-Romagna'),
(15, 'Friuli-Venezia Giulia'),
(9, 'Lazio'),
(18, 'Liguria'),
(19, 'Lombardia'),
(1, 'Marche'),
(4, 'Molise'),
(13, 'Piemonte'),
(6, 'Puglia'),
(10, 'Sardegna'),
(11, 'Sicilia'),
(12, 'Toscana'),
(5, 'Trentino-Alto Adige'),
(20, 'Umbria'),
(16, 'Valle d''Aosta'),
(17, 'Veneto');

-- --------------------------------------------------------

--
-- Struttura della tabella `Utente`
--

CREATE TABLE IF NOT EXISTS `Utente` (
  `CF` varchar(40) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Cognome` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `tipoutente` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CF`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Utente`
--

INSERT INTO `Utente` (`CF`, `Nome`, `Cognome`, `password`, `tipoutente`) VALUES
('OPERATORE1', 'Operatore', 'NumeroUno', 'password', 1),
('SCDPQL95L26H931B', 'Pasquale', 'Scudieri', 'password', 0),
('VNANLL95L11H931K', 'Aniello', 'Avino', 'nellobello', 0),
('CODICEFISCALE1', 'Cittadino', 'Numero1', 'password', 0),
('asdasdasdasdasda', 'luigi', 'pasquale', 'asdasdasd', 0),
('CITTADINO1', 'Luca', 'De Rosa', '', 2),
('CITTADINO2', 'Mario', 'De Rosa', '', 2),
('CITTADINO3', 'Marco', 'Rossi', 'vuoto', 2),
('CITTADINO4', 'Aurelio', 'DiMartino', 'vuoto', 2),
('cittadino5', 'Matteo', 'Verdini', 'vuoto', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
