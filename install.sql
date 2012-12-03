-- phpMyAdmin SQL Dump
-- version home.pl
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 03 Gru 2012, 10:18
-- Wersja serwera: 5.5.28-log
-- Wersja PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `adrianzandberg5`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_ceny_uzyskane`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_ceny_uzyskane` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tury` int(11) NOT NULL,
  `id_produktu` int(11) NOT NULL,
  `cena` decimal(10,5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=1783 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_config`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_config` (
  `aktualna_tura` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_fundusz`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_fundusz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usera` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `kwota` decimal(7,2) DEFAULT NULL,
  `stan` decimal(7,2) NOT NULL,
  `opis` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_kategorie`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_kategorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_ludzie`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_ludzie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_osoba` int(11) NOT NULL,
  `id_tura` int(11) NOT NULL,
  `rola` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_produkty`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_produkty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(255) NOT NULL,
  `jednostka` varchar(50) NOT NULL,
  `ilosc_rozliczeniowa` int(11) NOT NULL,
  `cena_za_jednostke` decimal(10,2) NOT NULL,
  `kategoria` int(11) NOT NULL,
  `sezon` varchar(12) NOT NULL,
  `dostepne` varchar(3) NOT NULL DEFAULT 'nie',
  `nasza_cena` decimal(10,5) DEFAULT NULL,
  `cena_sklepowa` decimal(10,2) DEFAULT NULL,
  `stan` float(6,2) NOT NULL DEFAULT '0.00',
  `uwagi` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=366 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_stan`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_stan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stan` float(4,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_transakcje`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_transakcje` (
  `id_transakcji` int(11) NOT NULL AUTO_INCREMENT,
  `id_produkt` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_tury` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `ilosc_doszla` float(8,2) DEFAULT NULL,
  `ilosc_wyszla` float(8,2) DEFAULT NULL,
  `kwota` decimal(10,5) DEFAULT NULL,
  PRIMARY KEY (`id_transakcji`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=2926 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_tury_zakupow`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_tury_zakupow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(255) NOT NULL,
  `aktywna` tinyint(1) NOT NULL DEFAULT '1',
  `sery_zam` int(11) DEFAULT NULL,
  `godz_waz` varchar(15) DEFAULT NULL,
  `dzien_eko` date NOT NULL,
  `godz_eko` varchar(5) NOT NULL,
  `dzien_ser` date NOT NULL,
  `godz_ser` varchar(5) NOT NULL,
  `koszt_trans` decimal(5,2) DEFAULT NULL,
  `koszt_sery` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_userzy`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_userzy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `nazwisko` varchar(255) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `czy_prawko` int(2) NOT NULL DEFAULT '0',
  `admin` int(2) NOT NULL DEFAULT '0',
  `czy_samochod` bit(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=136 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_wplaty`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_wplaty` (
  `id_wplaty` int(11) NOT NULL AUTO_INCREMENT,
  `id_usera` int(11) NOT NULL,
  `id_tury` int(11) NOT NULL,
  `data` date NOT NULL,
  `kwota` decimal(5,2) NOT NULL,
  `uwagi` text,
  PRIMARY KEY (`id_wplaty`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spoldzielnia_zamowienia`
--

CREATE TABLE IF NOT EXISTS `spoldzielnia_zamowienia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produktu` int(11) NOT NULL,
  `id_tury` int(11) NOT NULL,
  `id_usera` int(11) NOT NULL,
  `ilosc` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 AUTO_INCREMENT=12991 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transakcje_zapis`
--

CREATE TABLE IF NOT EXISTS `transakcje_zapis` (
  `id_usera` int(11) DEFAULT NULL,
  `id_tury` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zakupy_dodatkowe`
--

CREATE TABLE IF NOT EXISTS `zakupy_dodatkowe` (
  `id_pelne_zakupy` int(11) DEFAULT NULL,
  `id_tury` int(11) DEFAULT NULL,
  `id_usera` int(11) DEFAULT NULL,
  `id_produktu` int(11) DEFAULT NULL,
  `ilosc` decimal(10,2) DEFAULT NULL,
  UNIQUE KEY `id_dodatkowe_zakupy` (`id_pelne_zakupy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
