<?php 
/*
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
*/
   header("Content-Type: text/html; charset=iso-8859-9"); 
   
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }
require("conf.php");  	

     $taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) 
    $taraDili="EN";
   dilCevir($taraDili);
   
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	   
/*
anaMetniOku:
yardım bilgisinin ana metnini getirir
*/
function anaMetniOku($konu)
{	
	global $metin;	
 	
	switch ($konu){
	 
	 case 1:
	  return "<h4>$metin[261]</h4>".$metin[266];
	  break;
	 case 2:
	  return "<h4>$metin[262]</h4>".$metin[267];
	  break;
	 case 3:
	  return "<h4>$metin[263]</h4>".$metin[268];
	  break;
	 case 4:
	  return "<h4>$metin[264]</h4>".$metin[269];
	  break;
	 case 5:
	  return "<h4>$metin[265]</h4>".$metin[270];
	  break;
	 case 6:
	  return "<h4>$metin[421]</h4>".$metin[432];
	  break;
	 case 7:
	  return "<h4>$metin[422]</h4>".$metin[433];
	  break;
	 case 8:
	  return "<h4>$metin[423]</h4>".$metin[434];
	  break;
	 case 9:
	  return "<h4>$metin[424]</h4>".$metin[435];
	  break;
	 case 10:
	  return "<h4>$metin[425]</h4>".$metin[436];
	  break;
	 case 11:
	  return "<h4>$metin[426]</h4>".$metin[437];
	  break;
	 case 12:
	  return "<h4>$metin[427]</h4>".$metin[438];
	  break;
	 case 13:
	  return "<h4>$metin[428]</h4>".$metin[439];
	  break;
	 case 14:
	  return "<h4>$metin[429]</h4>".$metin[440];
	  break;
	 case 15:
	  return "<h4>$metin[430]</h4>".$metin[441];
	  break;
	 case 16:
	  return "<h4>$metin[431]</h4>".$metin[442];
	  break;
	
	}
	
	return "";
}
	

if (isset($_GET['konu'])){
	  if(!empty($_GET['konu'])){
			echo anaMetniOku(temizle($_GET['konu']));
	  }
   }else
   echo "";

?>