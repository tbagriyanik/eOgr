<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net

Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
	
	@session_start();
	ob_start (); // Buffer output
	header("Content-Type: text/html; charset=utf-8");          

	$taraDili=(isset($_COOKIE["lng"]))?$_COOKIE["lng"]:"";    
   if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili="EN";
      if ($taraDili=="TR")
        require("lib/tr.php"); 
      elseif ($taraDili=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         

require 'database.php'; 
require("conf.php");	
		   
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	
/*
baglan2:
veritabaný baðlantýsý
*/
function baglan2()
{
	global  $_host;
	global  $_username;
	global  $_password;
    global  $_db;
    return 	@mysqli_connect($_host, $_username, $_password,$_db);
}

if(!baglan2())   
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();mysqli_set_charset($yol1, "utf8");

	if (!$yol1)
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href=install.php>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href=install.php>installing page</a>!<br/>
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
    $metin = str_replace("<", "‹", $metin);
    $metin = str_replace(">", "›", $metin);
    $metin = trim(htmlentities($metin));
    return $metin;
}

/*
cevapKontrol:
sayfanýn cevabýnýn kontrol edilmesi
*/
function cevapKontrol($cevap, $id){
	global $yol1;	
	global $metin;
	
	$olmasiGerekenDogruCevapSayisi = getCevapSay($id);
	
    $sql1 = "SELECT id FROM eo_5sayfa where cevap like '%$cevap%' and id='$id' limit 0,1"; 	

    $result1 = mysqli_query($yol1, $sql1); 

    if ($result1 && mysqli_num_rows($result1) == 1) {
	   $uyeDogruCevapSayisi = $_SESSION["cevaplar"][$id] + 1;
	   $_SESSION["cevaplar"][$id] = $uyeDogruCevapSayisi; 	//doðru sayýsýný 1 artýrdýk
	   $hataSayisi = $_SESSION["hataSay"][$id]; 			//kaç hata yapýldý
	   if($olmasiGerekenDogruCevapSayisi==$uyeDogruCevapSayisi && $hataSayisi==0) {
		   //eðer hatasýz olarak tüm cevaplar seçilmiþ ise, DOÐRU
	   		$sonuc = "<span><img src='img/tick_circle.png' border='0' style=\"vertical-align: middle;\" alt=\"ok\" /> $metin[348]</span>"; 
		   	$_SESSION["cevaplar"][$id] = "D";
			   }
		else {
			$sonuc = $uyeDogruCevapSayisi." $metin[453]";  
			if($hataSayisi>0) {
				 $sonuc .= $metin[454];
				}
		}
   
       return $sonuc;
    }else {
		//hatalý bir cevap verildi ise
	   $_SESSION["hataSay"][$id] += 1;
	   return "<span><img src='img/error.png' border='0' style=\"vertical-align: middle;\" alt=\"error\" /> $metin[349]</span>";
	}
}

/*main*/

 if(isset($_POST['cevap'])&& isset($_POST['id'])) {
	   echo cevapKontrol(temizle2($_POST['cevap']), temizle2($_POST['id']));
	   die();
 		} else
		echo "";
?>