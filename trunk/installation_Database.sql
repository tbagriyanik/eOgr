-- phpMyAdmin SQL Dump
-- version 3.2.2.1
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 25 Ekim 2009 saat 15:03:17
-- Sunucu sürümü: 5.1.37
-- PHP Sürümü: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `eogr`
--

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_1okul`
--

CREATE TABLE IF NOT EXISTS `eo_1okul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `okulAdi` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `okulAdi` (`okulAdi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `eo_1okul`
--

INSERT INTO `eo_1okul` (`id`, `okulAdi`) VALUES
(1, 'Meslek Lisesi');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_2sinif`
--

CREATE TABLE IF NOT EXISTS `eo_2sinif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sinifAdi` varchar(50) NOT NULL,
  `okulID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `eo_2sinif`
--

INSERT INTO `eo_2sinif` (`id`, `sinifAdi`, `okulID`) VALUES
(1, '10.sinif', 1),
(2, '11.sinif', 1);

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_3ders`
--

CREATE TABLE IF NOT EXISTS `eo_3ders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dersAdi` varchar(50) NOT NULL,
  `sinifID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Tablo döküm verisi `eo_3ders`
--

INSERT INTO `eo_3ders` (`id`, `dersAdi`, `sinifID`) VALUES
(1, 'Matematik', 1),
(2, 'Turkce', 1),
(3, 'Turkce', 2),
(4, 'Matematik', 2),
(5, 'Bilisim Temelleri', 1),
(6, 'Paket Programlama', 1);

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_4konu`
--

CREATE TABLE IF NOT EXISTS `eo_4konu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `konuAdi` varchar(50) NOT NULL,
  `dersID` int(11) NOT NULL,
  `bitisTarihi` date NOT NULL,
  `oncekiKonuID` int(11) NOT NULL,
  `konuyuKilitle` tinyint(1) NOT NULL,
  `sadeceKayitlilarGorebilir` tinyint(1) NOT NULL,
  `sinifaDahilKullaniciGorebilir` tinyint(1) NOT NULL,
  `calismaSuresiDakika` int(11) NOT NULL,
  `calismaHakSayisi` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `eo_4konu`
--

INSERT INTO `eo_4konu` (`id`, `konuAdi`, `dersID`, `bitisTarihi`, `oncekiKonuID`, `konuyuKilitle`, `sadeceKayitlilarGorebilir`, `sinifaDahilKullaniciGorebilir`, `calismaSuresiDakika`, `calismaHakSayisi`) VALUES
(1, 'Programlama Temelleri', 5, '0000-00-00', 0, 0, 0, 0, 0, 0),
(2, 'Anakart', 5, '0000-00-00', 0, 0, 0, 0, 0, 0),
(3, 'Kelime Islemci Programi', 6, '0000-00-00', 0, 0, 0, 0, 0, 0),
(4, 'Hesap Tablosu Programi', 6, '0000-00-00', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_5sayfa`
--

CREATE TABLE IF NOT EXISTS `eo_5sayfa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anaMetin` varchar(10000) NOT NULL,
  `konuID` int(11) NOT NULL,
  `secenek1` varchar(1000) NOT NULL,
  `secenek2` varchar(1000) NOT NULL,
  `secenek3` varchar(1000) NOT NULL,
  `secenek4` varchar(1000) NOT NULL,
  `secenek5` varchar(1000) NOT NULL,
  `cevap` varchar(50) NOT NULL,
  `ekleyenID` int(11) NOT NULL,
  `eklenmeTarihi` datetime NOT NULL,
  `sayfaSirasi` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `eo_5sayfa`
--

INSERT INTO `eo_5sayfa` (`id`, `anaMetin`, `konuID`, `secenek1`, `secenek2`, `secenek3`, `secenek4`, `secenek5`, `cevap`, `ekleyenID`, `eklenmeTarihi`, `sayfaSirasi`) VALUES
(1, 'ilk eklenen konu... algoritma nedir ne ise yarar', 1, 'sudur budur', 'falan filan', '', '', '', '', 1, '2009-01-20 18:29:54', 0),
(2, 'programlama nedir ne ile yazilir <span style="text-decoration: underline;">neden </span><span style="font-style: italic;">....</span>', 1, 'sudur budur', 'falan filan', '', '', '', '', 1, '2009-10-22 20:50:02', 0);

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_comments`
--

CREATE TABLE IF NOT EXISTS `eo_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `konuID` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `commentDate` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `eo_comments`
--


-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_floodprotection`
--

CREATE TABLE IF NOT EXISTS `eo_floodprotection` (
  `IP` char(32) NOT NULL,
  `TIME` char(20) NOT NULL,
  PRIMARY KEY (`IP`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `eo_floodprotection`
--

INSERT INTO `eo_floodprotection` (`IP`, `TIME`) VALUES
(' 127.0.0.1', '1256233829');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_rating`
--

CREATE TABLE IF NOT EXISTS `eo_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `konuID` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `rateDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `eo_rating`
--

INSERT INTO `eo_rating` (`id`, `userID`, `konuID`, `value`, `rateDate`) VALUES
(1, 1, 2, 2, '2009-10-22 20:29:15');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_shoutbox`
--

CREATE TABLE IF NOT EXISTS `eo_shoutbox` (
  `messageid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `url` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `ip` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`messageid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `eo_shoutbox`
--


-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_sinifogre`
--

CREATE TABLE IF NOT EXISTS `eo_sinifogre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `sinifID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Tablo döküm verisi `eo_sinifogre`
--


-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_sitesettings`
--

CREATE TABLE IF NOT EXISTS `eo_sitesettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `okulGenelAdi` varchar(15) NOT NULL,
  `versiyon` varchar(10) NOT NULL,
  `sayfaBlokSayisi` int(11) NOT NULL,
  `sayfaKullaniciSayisi` int(11) NOT NULL,
  `veriHareketleriSayisi` int(11) NOT NULL,
  `ayar1int` int(11) NOT NULL,
  `ayar2int` int(11) NOT NULL,
  `ayar3int` int(11) NOT NULL,
  `ayar4char` varchar(50) DEFAULT NULL,
  `ayar5char` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `eo_sitesettings`
--

INSERT INTO `eo_sitesettings` (`id`, `okulGenelAdi`, `versiyon`, `sayfaBlokSayisi`, `sayfaKullaniciSayisi`, `veriHareketleriSayisi`, `ayar1int`, `ayar2int`, `ayar3int`, `ayar4char`, `ayar5char`) VALUES
(1, 'Net Okul', 'version', 5, 10, 10, 5, 10, 10, 'admin@eogr.com', '1-1-1-1-1-1-1-1-1-1-1-1-1-1-1');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_users`
--

CREATE TABLE IF NOT EXISTS `eo_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `userPassword` varchar(40) NOT NULL,
  `realName` varchar(50) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userBirthDate` date NOT NULL,
  `userType` tinyint(4) NOT NULL DEFAULT '0',
  `requestDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userName` (`userName`),
  UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `eo_users`
--

INSERT INTO `eo_users` (`id`, `userName`, `userPassword`, `realName`, `userEmail`, `userBirthDate`, `userType`, `requestDate`) VALUES
(1, 'admin', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'super kullanici', 'admin@eogr.com', '2008-11-15', 2, '2008-11-15 00:00:00');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_usertrack`
--

CREATE TABLE IF NOT EXISTS `eo_usertrack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(40) NOT NULL,
  `dateTime` datetime NOT NULL,
  `processName` varchar(20) NOT NULL,
  `userName` varchar(15) NOT NULL,
  `otherInfo` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `eo_usertrack`
--

INSERT INTO `eo_usertrack` (`id`, `IP`, `dateTime`, `processName`, `userName`, `otherInfo`) VALUES
(1, '127.0.0.1', '2009-10-22 20:25:19', 'login.php', 'admin', 'success,Login'),
(2, '127.0.0.1', '2009-10-22 20:30:14', 'dataCommentList2.php', 'admin', 'CmtUpd-1-2'),
(3, '127.0.0.1', '2009-10-22 20:50:02', 'lessonsEdit.php', 'admin', 'sayfa, Update'),
(4, '127.0.0.1', '2009-10-22 20:50:29', 'login.php', 'admin', 'success,Login');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_userworks`
--

CREATE TABLE IF NOT EXISTS `eo_userworks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `konuID` int(11) NOT NULL,
  `toplamZaman` int(11) NOT NULL,
  `lastPage` int(11) NOT NULL,
  `calismaTarihi` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `eo_userworks`
--

INSERT INTO `eo_userworks` (`id`, `userID`, `konuID`, `toplamZaman`, `lastPage`, `calismaTarihi`) VALUES
(1, 1, 1, 27, 50, '2009-10-22 20:31:26');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_webref_rss_details`
--

CREATE TABLE IF NOT EXISTS `eo_webref_rss_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` mediumtext NOT NULL,
  `link` text,
  `language` text,
  `image_title` text,
  `image_url` text,
  `image_link` text,
  `image_width` text,
  `image_height` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `eo_webref_rss_details`
--

INSERT INTO `eo_webref_rss_details` (`id`, `title`, `description`, `link`, `language`, `image_title`, `image_url`, `image_link`, `image_width`, `image_height`) VALUES
(1, 'eOgr', 'eOgrenme - eLearning RSS Feed', 'http://eogr.com', 'TR', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_webref_rss_items`
--

CREATE TABLE IF NOT EXISTS `eo_webref_rss_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` mediumtext NOT NULL,
  `link` text,
  `pubDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `eo_webref_rss_items`
--

INSERT INTO `eo_webref_rss_items` (`id`, `title`, `description`, `link`, `pubDate`) VALUES
(1, 'eOgr', 'Bir haber ornegi...', '', '2009-06-14 21:29:13');
