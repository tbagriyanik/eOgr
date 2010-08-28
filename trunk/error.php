<?php 
if (!file_exists("siteLock.php")){
	require("conf.php");
	checkLoginLang(false,true,"error.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>eOgr -<?php echo $metin[489]?></title>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/stilGenel.css" type="text/css" media="all" />
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<style type="text/css">
* {
	font-family:Verdana, Geneva, sans-serif;
}
</style>
</head>

<body bgcolor="#FFCCCC">
<?php 
 if (!file_exists("siteLock.php")){
?>
<h1 align="center">eOgr - <?php echo $metin[489]?></h1>
<p style="margin-top:50px;"> <font color="#FF0000" size="+1"> <?php echo $metin[402]?> </font> </p>
<?php
	 switch ($_GET["error"]){
		 case "1":
		  echo "<font id='hata'> $metin[400]</font>"; //not login
		  break;
		 case "2":
		  echo "<font id='hata'> $metin[403]</font>"; //empty username
		  break;
		 case "3":
		  echo "<font id='hata'> $metin[295]</font>"; //source error
		  break;
		 case "4":
		  echo "<font id='hata'> $metin[401]</font>"; //flood
		  break;		 
		 case "5":			 //installation
		  echo "<font id='hata'> $metin[487]</font>";
		  break;		  		  
		 case "6":			//tables not found	
		  echo "<font id='hata'> $metin[488]</font>";
		  break;		  
		 case "7":			//bad login
		  echo "<font id='hata'> ".$metin[404]."</font><br/>".$metin[402];
		  break;		  
 		 case "8":			//file name error
		  echo "<font id='hata'>$metin[449]</font>";
		  break;	
 		 case "9":			//not allowed for students/teachers
		  echo "<font id='hata'>$metin[447]</font>";
		  break;	
 		 case "10":			//not allowed for students
		  echo "<font id='hata'>$metin[448]</font>";
		  break;	
 		 case "11":			//site is closed 
		  echo "<font id='hata'>$metin[527]</font>";
		  break;	
		 default:			//file not found
		  echo "<font id='hata'>$metin[468]</font>";		  	  
	}
?>
<p>
  <?php
 echo "<strong>$metin[491] :</strong> ".RemoveXSS($_SERVER['REMOTE_ADDR'])."<br/>";  
// echo "Sunucu adresi : ".$_SERVER['SERVER_ADDR']."<br/>"; 
if(!empty($_SERVER['HTTP_REFERER']))
	 echo "<strong>$metin[493] :</strong> ".RemoveXSS($_SERVER['HTTP_REFERER'])."<br/>";  
 echo "<strong>$metin[492] :</strong> ".RemoveXSS($_SERVER['REQUEST_URI' ])."<br/>";  
// echo "Istek turu : ".RemoveXSS($_SERVER['REQUEST_METHOD'])."<br/>"; 
// echo "Calisan dosya adi : ".basename(RemoveXSS($_SERVER['SCRIPT_FILENAME']))."<br/>"; 
 echo "<strong>$metin[129] :</strong> ".date("d-m-Y H:i:s")."<br/>"; 
?>
</p>
<h5>
<?php echo $metin[490]?>
</h5>
<?php
 }else{
?>
<h1 align="center">eOgr - Site Maintenance</h1>
<p style="margin-top:50px;"> <font color="#FF0000" size="+1">Please, visit later. Site is closed for now.</font> </p>
<?php
 }
?>
<script type="text/javascript" language="javascript">
if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
</script>
</body>
</html>
<!--
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://www.tuzlaatl.k12.tr/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
-->