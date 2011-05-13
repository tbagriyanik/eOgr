<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
	@session_start();

	require "conf.php";	
	
	checkLoginLang(false,true,"getFullList.php");

	$seciliTema= temaBilgisi(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
    <link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
    <title>eOgr</title>
    <link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="theme/page.css" type="text/css" media="screen" />
    <script type="text/javascript" src="lib/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script>
    <script src="lib/jquery.anythingslider.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="lib/jquery.easing.1.2.js"></script>
    <link rel="stylesheet" href="lib/anythingslider.css" type="text/css" media="screen" />
    <script type="text/javascript">
    
$(function () {

$('#anythingSlider').anythingSlider({
  // Appearance
  width               : null,      // Override the default CSS width
  height              : null,      // Override the default CSS height
  resizeContents      : true,      // If true, solitary images/objects in the panel will expand to fit the viewport
  tooltipClass        : 'tooltip', // Class added to navigation & start/stop button (text copied to title if it is hidden by a negative text indent)
  theme               : 'metallic', // Theme name
  themeDirectory      : 'lib/theme-{theme}.css',

  // Navigation
  startPanel          : 1,         // This sets the initial panel
  hashTags            : false,      // Should links change the hashtag in the URL?
  enableKeyboard      : true,      // if false, keyboard arrow keys will not work for the current panel.
  buildArrows         : true,      // If true, builds the forwards and backwards buttons
  toggleArrows        : true,     // if true, side navigation arrows will slide out on hovering & hide @ other times
  buildNavigation     : true,      // If true, builds a list of anchor links to link to each panel
  enableNavigation    : true,      // if false, navigation links will still be visible, but not clickable.
  toggleControls      : false,     // if true, slide in controls (navigation + play/stop button) on hover and slide change, hide @ other times
  appendControlsTo    : null,      // A HTML element (jQuery Object, selector or HTMLNode) to which the controls will be appended if not null
  navigationFormatter : null,      // Details at the top of the file on this use (advanced use)
  forwardText         : "&raquo;", // Link text used to move the slider forward (hidden by CSS, replaced with arrow image)
  backText            : "&laquo;", // Link text used to move the slider back (hidden by CSS, replace with arrow image)

  // Slideshow options
  enablePlay          : true,      // if false, the play/stop button will still be visible, but not clickable.
  autoPlay            : true,      // This turns off the entire slideshow FUNCTIONALY, not just if it starts running or not
  startStopped        : true,     // If autoPlay is on, this can force it to start stopped
  pauseOnHover        : true,      // If true & the slideshow is active, the slideshow will pause on hover
  resumeOnVideoEnd    : true,      // If true & the slideshow is active & a youtube video is playing, it will pause the autoplay until the video is complete
  stopAtEnd           : false,     // If true & the slideshow is active, the slideshow will stop on the last page
  playRtl             : false,     // If true, the slideshow will move right-to-left
  startText           : "&raquo;",   // Start button text
  stopText            : "&curren;",    // Stop button text
  delay               : 3000,      // How long between slideshow transitions in AutoPlay mode (in milliseconds)
  animationTime       : 100,       // How long the slideshow transition takes (in milliseconds)
//  easing              : "swing",   // Anything other than "linear" or "swing" requires the easing plugin

  // Callbacks
  onBeforeInitialize  : null,      // Callback before the plugin initializes
  onInitialized       : null,      // Callback when the plugin finished initializing
  onShowStart         : null,      // Callback on slideshow start
  onShowStop          : null,      // Callback after slideshow stops
  onShowPause         : null,      // Callback when slideshow pauses
  onShowUnpause       : null,      // Callback when slideshow unpauses - may not trigger properly if user clicks on any controls
  onSlideInit         : null,      // Callback when slide initiates, before control animation
  onSlideBegin        : null,      // Callback before slide animates
  onSlideComplete     : null,      // Callback when slide completes

  // Interactivity
  clickArrows         : "click",         // Event used to activate arrow functionality (e.g. "click" or "mouseenter")
  clickControls       : "click focusin", // Events used to activate navigation control functionality
  clickSlideshow      : "click",         // Event used to activate slideshow play/stop button

  // Misc options
  addWmodeToObject    : "opaque",  // If your slider has an embedded object, the script will automatically add a wmode parameter with this setting, if swfobject.js is active
  maxOverallWidth     : 32766      // Max width (in pixels) of combined sliders (side-to-side); set to 32766 to prevent problems with Opera
});			        
        });
    </script>
    </head>
    <body>
    <?php
/*
baglan2:
veritabanı bağlantısı
*/
function baglan2()
{
	global  $_host;
	global  $_username;
	global  $_password;
    return 	@mysql_connect($_host, $_username, $_password);
}

if(!baglan2())   
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href='install.php'  target='_parent'>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();

	if (!@mysql_select_db($_db, $yol1))
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href='install.php'  target='_parent'>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href='install.php'  target='_parent'>installing page</a>!<br/>
			 </font>");
	}
/*
temizle2:
xss temizleme
*/
function temizle2($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("'", "`", $metin);
    //$metin = str_replace('"', '¨', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "<", $metin);
    $metin = str_replace(">", ">", $metin);
    $metin = iconv( "UTF-8", "ISO-8859-9",trim(htmlspecialchars($metin)));
    return $metin;
}
/*
getUserIDcomment:
kullanıcı kimlik numarası
*/
function getUserIDcomment($usernam, $passwor)
{
	global $yol1;
	
	$usernam = substr(temizle2($usernam),0,15);
    $sql1 = "SELECT id, userName, userPassword FROM eo_users where userName='".temizle2($usernam)."' AND userPassword='".temizle2($passwor)."' limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
       return (mysql_result($result1, 0, "id"));
    }else {
	   return ("");
	}
}
/*
listeGetir:
belli bir tablodan istenen veri listesini alma (facebox için)
*/
function listeGetir($userID, $durum){
	global $yol1;							
	global $metin;	
	$ekle = "";
		if(!empty($durum) && !empty($userID)) {			  
				
				$num = (int) substr($durum,0,15);
				
				switch($num){
					case 2:
					//en fazla &ccedil;alışılan konular
							$sql1 =    "SELECT eo_4konu.id  as id, eo_4konu.konuAdi as konuAdi, count(*) as toplam 
										FROM eo_4konu,eo_userworks 
										WHERE eo_4konu.id = eo_userworks.konuID
										GROUP BY konuAdi
										ORDER BY toplam DESC, konuAdi";							

							$result1 = mysql_query($sql1, $yol1);
							if ($result1)
							{
							   if(mysql_num_rows($result1)==0)  return "";
							   
							   $ekle = "<ul id='anythingSlider'><li>";
							   $donguSon = mysql_num_rows($result1);
							   for($i=0; $i<$donguSon ;$i++){
									$data = mysql_fetch_assoc($result1);
									if($i % 15 == 0 and $i>0){
											$ekle .=  "</li><li>";
										}
									
									$ekle .=  ($i+1)." <a href=\"lessons.php?konu=".$data["id"]."\" target='_parent'>".$data["konuAdi"]." </a> <font size='-3'>".($data["toplam"])."</font><br/>";										
									
									}
										$ekle .=  "</li>";
									  	$ekle .= "</ul>";										
							  
							   echo $ekle;	
							   return ($ekle);
							}else {
							   return ("");
							}
							
							break;
					case 11:
					//şu anki kullanıcının &ccedil;alışma konuları ve sayıları
							$sql1 =    "SELECT eo_4konu.id  as id, eo_4konu.konuAdi as konuAdi, 
												count(*) as toplam 
										FROM eo_4konu,eo_userworks, eo_users 
										WHERE eo_4konu.id = eo_userworks.konuID 
											  and eo_users.id = eo_userworks.userID
											  and eo_users.id = '".$userID."'
										GROUP BY konuAdi
										ORDER BY toplam DESC, konuAdi";
							
							$result1 = mysql_query($sql1, $yol1);
							if ($result1)
							{
							   if(mysql_num_rows($result1)==0) return "";							   
							   								
							   $ekle = "<ul id='anythingSlider'><li>";
							   $donguSon = mysql_num_rows($result1);
							   for($i=0; $i<$donguSon ;$i++){
									$data = mysql_fetch_assoc($result1);
									if($i % 15 == 0 and $i>0){
											$ekle .=  "</li><li>";
										}
									
									$ekle .=  ($i+1)." <a href=\"lessons.php?konu=".$data["id"]."\"  target='_parent'>".$data["konuAdi"]." </a> <font size='-3'>".($data["toplam"])."</font><br/>";										
									
									}
								$ekle .=  "</li>";
								$ekle .= "</ul>";
										
								echo $ekle;
							   return true;
							}else {
							   return "";
							}
							
							break;
							
					case 12:
					//şu anki kullanıcının bitirdiği dersler
					if($_GET["user"]!="")
					//eğer başka kullanıcı inceleniyor ise
					  $userID = temizle($_GET["user"]);
					  
							$sql1 =    "SELECT  eo_3ders.dersAdi as dersAdi, eo_4konu.konuAdi as konuAdi, 
												eo_2sinif.sinifAdi as sinifAdi, eo_1okul.okulAdi as okulAdi,
												eo_3ders.id as dersID, 
												sum(eo_userworks.toplamZaman) as toplam 
										FROM eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_userworks, eo_users 
										WHERE eo_4konu.id = eo_userworks.konuID and 
											  eo_users.id = eo_userworks.userID and
											  eo_3ders.id = eo_4konu.dersID and
											  eo_2sinif.id = eo_3ders.sinifID and
											  eo_1okul.id = eo_2sinif.okulID and
											  eo_users.id = '".$userID."'
										GROUP BY dersAdi
										ORDER BY toplam DESC";
							
							$result1 = mysql_query($sql1, $yol1);
							if ($result1)
							{
							   if(mysql_num_rows($result1)==0) return "";	 
							   								
							   $ekle = "<ul id='anythingSlider'><li>";
							   $donguSon = mysql_num_rows($result1);
							   for($i=0; $i<$donguSon ;$i++){
									$row_gelen = mysql_fetch_assoc($result1);
									if($i % 15 == 0 and $i>0){
											$ekle .=  "</li><li>";
										}
									
									$ekle .=  ($i+1)." ".$row_gelen['okulAdi']. " " .$row_gelen['sinifAdi']." - <a href='kursDetay.php?kurs=".$row_gelen['dersID']."&amp;user=$userID' target='_parent'>".$row_gelen['dersAdi']."</a> <font size='-3'>".Sec2Time2($row_gelen['toplam'])."</font><br/>";										
									
									}
										$ekle .=  "</li>";
									  	$ekle .= "</ul>";
								echo $ekle;
							   return ($ekle);
							}else {
							   return ("");
							}
							
							break;
					
					case 13:
					//son g&uuml;ncellenen konular
							$sql = "SELECT eo_5sayfa.konuID as idsi, eo_4konu.konuAdi as kadi,".
								   "eo_3ders.dersAdi as dersAdi, max(eo_5sayfa.eklenmeTarihi) as tarih ".
								   "from eo_5sayfa, eo_4konu, eo_3ders ".
								   "where eo_5sayfa.konuID=eo_4konu.id ".
								   "and eo_4konu.dersID=eo_3ders.id ".
								   "GROUP BY kadi ".
								   "order by tarih desc,kadi";	

							$result = mysql_query($sql, $yol1);
							if($result)
							 {
								 if (@mysql_numrows($result) > 0) {
									
									  $ekle = "<ul id='anythingSlider'><li>";
									$donguSon = mysql_num_rows($result);
							   		for($i=0; $i<$donguSon ;$i++){
										$data = mysql_fetch_assoc($result);
										if($i % 15 == 0 and $i>0){
											$ekle .=  "</li><li>";
										}
										
				     	$humanRelativeDate = new HumanRelativeDate();
						$insansi = $humanRelativeDate->getTextForSQLDate($data["tarih"]);							
										
										if ($data["tarih"]=="0000-00-00 00:00:00")
											$ekle .=  ($i+1)." "."<a href=\"lessons.php?konu=".$data["idsi"]."\" target='_parent'>".$data["kadi"]." - ".$data["dersAdi"]."</a><br/>";
											else
											$ekle .=  ($i+1)." "."<a href=\"lessons.php?konu=".$data["idsi"]."\" target='_parent'>".$data["kadi"]." - ".$data["dersAdi"]."</a>"." <font size='-3'>".$insansi."</font><br/>";	
									}
										$ekle .=  "</li>";
									  	$ekle .= "</ul>";
								 }		
								echo $ekle; 
								return $ekle; 
							}else {
							   return ("");
							}
							
							break;		
					case 14:
					//en fazla oy verilen konular
							$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
								   " avg(eo_rating.value) as ortalama, count(eo_rating.value) as toplam ".
								   "from eo_rating, eo_4konu ".
								   "where eo_rating.konuID=eo_4konu.id ".
								   "GROUP BY kadi ".
								   "order by ortalama desc,toplam DESC,konuAdi";	

							$result = mysql_query($sql, $yol1);
							if($result)
							 {
								 if (@mysql_numrows($result) > 0) {
								$donguSon = @mysql_numrows($result);
								
									  	$ekle .= "<ul id='anythingSlider'>";
										$ekle .=  "<li>";
										
								for($i=0; $i<$donguSon ;$i++){
									$data = mysql_fetch_assoc($result);
									if($i % 15 == 0 and $i>0){
											$ekle .=  "</li><li>";
										}
									
									$ekle .=  ($i+1)." <a href=\"lessons.php?konu=".$data["idsi"]."\" target='_parent'>".$data["kadi"]."</a>"." <font size='1' title='$metin[273] : ".$data["toplam"].", $metin[274] : ".round($data["ortalama"],1)."'>".$data["toplam"]."/".(round($data["ortalama"],1))."</font><br/>";										
									
									}
										$ekle .=  "</li>";
									  	$ekle .= "</ul>";
								 }		
								 echo $ekle;
								return $ekle; 
							}else {
							   return ("");
							}
							
							break;		
					case 15:
					//en fazla yorum eklenen konular
							$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
								   " count(*) as toplam ".
								   "from eo_comments, eo_4konu ".
								   "where eo_comments.konuID=eo_4konu.id ".
								   " and eo_comments.active=1 ".
								   "GROUP BY kadi ".
								   "order by toplam desc,kadi";	

							$result = mysql_query($sql, $yol1);
							if($result)
							 {
								 if (@mysql_numrows($result) > 0) {
								$donguSon = @mysql_numrows($result);
								
									  	$ekle .= "<ul id='anythingSlider'>";
										$ekle .=  "<li>";
										
								for($i=0; $i<$donguSon ;$i++){
									$data = mysql_fetch_assoc($result);
									if($i % 15 == 0 and $i>0){
											$ekle .=  "</li><li>";
										}
									
									$ekle .=  ($i+1)." <a href=\"lessons.php?konu=".$data["idsi"]."\"  target='_parent'>".$data["kadi"]." </a> <font size='-3'>".($data["toplam"])."</font><br/>";										
									
									}
										$ekle .=  "</li>";
									  	$ekle .= "</ul>";
								 }		
								 echo $ekle;
								return $ekle; 
							}else {
							   return ("");
							}
							
							break;		
				case 16:
				//son demo çalışmaları
						$sql = "SELECT eo_4konu.id as idsi, eo_4konu.konuAdi as kadi,".
							   " count(*) as toplam ".
							   "from eo_userworks, eo_4konu ".
							   "where eo_userworks.konuID=eo_4konu.id ".
							  // " and eo_userworks.userID=-1 ".
							   "GROUP BY kadi ".
							   "order by toplam desc,kadi";	
						$result = mysql_query($sql, $yol1);
						if($result)
						 {
							 if (@mysql_numrows($result) > 0) {
								
								$donguSon = @mysql_numrows($result);
								
									  	$ekle .= "<ul id='anythingSlider'>";
										$ekle .=  "<li>";
										
								for($i=0; $i<$donguSon ;$i++){
									$data = mysql_fetch_assoc($result);
									if($i % 15 == 0 and $i>0){
											$ekle .=  "</li><li>";
										}
									
									$ekle .=  ($i+1)." <a href=\"lessons.php?konu=".$data["idsi"]."\"  target='_parent'>".$data["kadi"]." </a> <font size='-3'>".($data["toplam"])."</font><br/>";										
									
									}
										$ekle .=  "</li>";
									  	$ekle .= "</ul>";
									
							 }		
							 @mysql_free_result($result);
							 echo $ekle;
							return $ekle; 
						}else {
						   return ("");
						}
						
						break;	
							
					case 19:
					//şu anki kullanıcının bitirdiği dersler
					if($_SESSION["kursUser2"]!="")
					//eğer başka kullanıcı inceleniyor ise
					  $userID = temizle($_SESSION["kursUser2"]);
					  
							$sql1 =    "SELECT  eo_3ders.dersAdi as dersAdi, eo_4konu.konuAdi as konuAdi, 
												eo_2sinif.sinifAdi as sinifAdi, eo_1okul.okulAdi as okulAdi,
												eo_3ders.id as dersID, 
												sum(eo_userworks.toplamZaman) as toplam 
										FROM eo_1okul, eo_2sinif, eo_3ders, eo_4konu, eo_userworks, eo_users 
										WHERE eo_4konu.id = eo_userworks.konuID and 
											  eo_users.id = eo_userworks.userID and
											  eo_3ders.id = eo_4konu.dersID and
											  eo_2sinif.id = eo_3ders.sinifID and
											  eo_1okul.id = eo_2sinif.okulID and
											  eo_users.id = ".$userID."
										GROUP BY dersAdi
										ORDER BY toplam DESC";
							
							$result1 = mysql_query($sql1, $yol1);
							if ($result1)
							{
							   if(mysql_num_rows($result1)==0) return "";	 
							   								
							   $ekle = "<ul id='anythingSlider'><li>";
							   $donguSon = mysql_num_rows($result1);
							   for($i=0; $i<$donguSon ;$i++){
									$row_gelen = mysql_fetch_assoc($result1);
									if($i % 15 == 0 and $i>0){
											$ekle .=  "</li><li>";
										}
									
									$ekle .=  ($i+1)." ".$row_gelen['okulAdi']. " " .$row_gelen['sinifAdi']." - <a href='kursDetay2.php?kurs=".$row_gelen['dersID']."&amp;kisi=$userID' target='_parent'>".$row_gelen['dersAdi']."</a> <font size='-3'>".Sec2Time2($row_gelen['toplam'])."</font><br/>";										
									
									}
										$ekle .=  "</li>";
									  	$ekle .= "</ul>";
								echo $ekle;
							   return ($ekle);
							}else {
							   return ("");
							}
							
							break;
					
					default:
						die("");	
				} //switch	
			
			return "";

}
		
	return false;
}

if(!isset($_SESSION["usern"]) or !isset($_SESSION["userp"])){
	$_SESSION["usern"]="";
	$_SESSION["userp"]="";
} 

if (isset($_GET['case'])){
	 if(!empty($_GET['case']) && getUserIDcomment($_SESSION["usern"],$_SESSION["userp"])!="" ) {
		if ( !listeGetir(getUserIDcomment($_SESSION["usern"],$_SESSION["userp"]), temizle2($_GET['case'])) )		
			echo "Error!";
	} elseif (in_array($_GET['case'],array("13","16","19"))) {
		if ( !listeGetir("-1", temizle2($_GET['case'])) )		
			echo "Error!";
	} elseif (in_array($_GET['case'],array("19"))) {
		if ( !listeGetir($_SESSION["kursUser2"], temizle2($_GET['case'])) )		
			echo "Error!";
	}
}
else
   echo "?";
   

?>
</body>
</html>