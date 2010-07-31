-- phpMyAdmin SQL Dump
-- version 3.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='okul adlari' AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `eo_1okul`
--

INSERT INTO `eo_1okul` (`id`, `okulAdi`) VALUES
(3, 'Meslek Lisesi'),
(5, 'Teknik Lise');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_2sinif`
--

CREATE TABLE IF NOT EXISTS `eo_2sinif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sinifAdi` varchar(50) NOT NULL,
  `okulID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='sinif adlari' AUTO_INCREMENT=12 ;

--
-- Tablo döküm verisi `eo_2sinif`
--

INSERT INTO `eo_2sinif` (`id`, `sinifAdi`, `okulID`) VALUES
(2, '10.Sinif', 5),
(5, '11.Sinif', 3),
(10, 'Web11', 5);

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_3ders`
--

CREATE TABLE IF NOT EXISTS `eo_3ders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dersAdi` varchar(50) NOT NULL,
  `sinifID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='ders adlari' AUTO_INCREMENT=19 ;

--
-- Tablo döküm verisi `eo_3ders`
--

INSERT INTO `eo_3ders` (`id`, `dersAdi`, `sinifID`) VALUES
(7, 'Bilisim Teknolojileri Temelleri', 2),
(13, 'Ag S. ve Y. Switch', 5),
(14, 'Grafik ve Animasyon', 10),
(15, 'Web Tasarimi ve Programlama', 10),
(17, 'Veritabani', 10),
(18, 'Ag S. ve Y. Router', 5);

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
  `calismaSuresiDakika` int(11) NOT NULL,
  `calismaHakSayisi` int(11) NOT NULL,
  `sadeceKayitlilarGorebilir` tinyint(1) NOT NULL,
  `sinifaDahilKullaniciGorebilir` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='konu adlari' AUTO_INCREMENT=3;

--
-- Tablo döküm verisi `eo_4konu`
--

INSERT INTO `eo_4konu` (`id`, `konuAdi`, `dersID`, `bitisTarihi`, `oncekiKonuID`, `konuyuKilitle`, `calismaSuresiDakika`, `calismaHakSayisi`, `sadeceKayitlilarGorebilir`, `sinifaDahilKullaniciGorebilir`) VALUES
(2, 'Anakart', 7, '0000-00-00', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_5sayfa`
--

CREATE TABLE IF NOT EXISTS `eo_5sayfa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anaMetin` varchar(10000) DEFAULT NULL,
  `konuID` int(11) NOT NULL,
  `secenek1` varchar(1000) NOT NULL,
  `secenek2` varchar(1000) NOT NULL,
  `secenek3` varchar(1000) NOT NULL,
  `secenek4` varchar(1000) NOT NULL,
  `secenek5` varchar(1000) NOT NULL,
  `secenek6` varchar(1000) NOT NULL,
  `cevap` varchar(50) NOT NULL,
  `ekleyenID` int(11) NOT NULL,
  `eklenmeTarihi` datetime NOT NULL,
  `sayfaSirasi` int(11) NOT NULL,
  `slideGecisSuresi` int(11) NOT NULL,
  `cevapSuresi` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='sayfa icerigi' AUTO_INCREMENT=2;

--
-- Tablo döküm verisi `eo_5sayfa`
--

-- --------------------------------------------------------
INSERT INTO `eo_5sayfa` (`id`, `anaMetin`, `konuID`, `secenek1`, `secenek2`, `secenek3`, `secenek4`, `secenek5`,`secenek6`, `cevap`, `ekleyenID`, `eklenmeTarihi`, `sayfaSirasi`, `slideGecisSuresi`, `cevapSuresi`) VALUES
(1, 'anakart ne ise yarar', 2, '', '', '', '', '', '', '', 1, '2010-07-04 20:07:56', 0, 60, 30);

--
-- Tablo yapısı: `eo_comments`
--

CREATE TABLE IF NOT EXISTS `eo_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `konuID` int(11) NOT NULL,
  `comment` varchar(1000) DEFAULT NULL,
  `commentDate` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Tablo döküm verisi `eo_comments`
--
CREATE TABLE IF NOT EXISTS `eo_files` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`userID` INT NOT NULL ,
	`fileName` VARCHAR( 50 ) NOT NULL ,
	`downloadCount` INT NOT NULL
) ENGINE = MYISAM COMMENT = 'uploads';
-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_floodprotection`
--

CREATE TABLE IF NOT EXISTS `eo_floodprotection` (
  `IP` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `TIME` char(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`IP`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `eo_floodprotection`
--

INSERT INTO `eo_floodprotection` (`IP`, `TIME`) VALUES
(' 127.0.0.1', '1278259471');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Tablo döküm verisi `eo_rating`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

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
(1, 'Net Logo', 'version', 15, 10, 15, 10, 10, 60, 'admin@eogr.com', '1-1-1-1-1-1-1-1-1-1-1-1-1-1-1');

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
  `ayarlar` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userEmail` (`userEmail`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;

--
-- Tablo döküm verisi `eo_users`
--

INSERT INTO `eo_users` (`id`, `userName`, `userPassword`, `realName`, `userEmail`, `userBirthDate`, `userType`, `requestDate`, `ayarlar`) VALUES
(1, 'admin', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'Super Kullanici', 'admin@eogr.com', '2008-11-15', 2, '2008-11-15 00:00:00', '1-1-1-1-1-1-1-1-1-1-1-1-1-1-1');

-- --------------------------------------------------------

--
-- Tablo yapısı: `eo_usertrack`
--

CREATE TABLE IF NOT EXISTS `eo_usertrack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `dateTime` datetime NOT NULL,
  `processName` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `userName` varchar(15) NOT NULL,
  `otherInfo` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='user Tracking' AUTO_INCREMENT=1;

--
-- Tablo döküm verisi `eo_usertrack`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='kullanici calisma' AUTO_INCREMENT=1;

--
-- Tablo döküm verisi `eo_userworks`
--

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
(1, 'eOgr', 'eOgrenme - eLearning RSS Feed', 'http://www.yoursite.com/eogr', 'TR', '', '', '', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Tablo döküm verisi `eo_webref_rss_items`
--

INSERT INTO `eo_webref_rss_items` (`id`, `title`, `description`, `link`, `pubDate`) VALUES
(2, 'Ag Dersleri', 'Ogretmenimiz Aziz Bektas`a hazirladigi dersler icin tesekkur ederiz.', '', '2009-12-24 10:00:00'),
(8, 'Uyelik Tekrarlari', 'Tekrar uyeliklerde eski uyelikler silinecektir. Parolanizi unuttuysaniz tekrar parola isteginde bulunabilirsiniz.', 'passwordRemember.php', '2010-05-01 13:15:44');