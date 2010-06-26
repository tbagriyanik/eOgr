<?php
session_start();

	$taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili="EN";
      if ($taraDili=="TR")
        require("lib/tr.php"); 
      elseif ($taraDili=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         

require 'database.php'; 
require("conf.php");	
		   
//if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	

function baglan2()
{
	global  $_host;
	global  $_username;
	global  $_password;
    return 	@mysql_connect($_host, $_username, $_password);
}

if(!baglan2())   
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();

	if (!@mysql_select_db($_db, $yol1))
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href=install.php>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href=install.php>installing page</a>!<br/>
			 </font>");
	}

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
    $metin = str_replace("<", "‹", $metin);
    $metin = str_replace(">", "›", $metin);
    $metin = trim(htmlspecialchars($metin));
    return $metin;
}

function cevapKontrol($cevap, $id)
{
	global $yol1;	
	global $metin;
	
	$cevap  = iconv( "UTF-8","ISO-8859-9", $cevap);
	
    $sql1 = "SELECT id FROM eo_5sayfa where UPPER(cevap)=UPPER('$cevap') and id='$id' limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
	   $sonuc = "<span><img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[348]</span>";   
	   
	   $_SESSION["cevaplar"][$id] = "D";
	   
       return $sonuc;
    }else {
	   return "<p><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[349]</p>";
	}
}

/*main*/

 if(isset($_POST['cevap'])&& isset($_POST['id'])) {
	   echo iconv( "ISO-8859-9","UTF-8", cevapKontrol(temizle2($_POST['cevap']), temizle2($_POST['id'])));
	   die();
 		} else
		echo "EMPTY!";
?>