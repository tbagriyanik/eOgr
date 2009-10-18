<?php header("Content-Type: text/html; charset=iso-8859-9"); ?>
<?php 
require("conf.php");  	
    if ( !isset( $_SESSION ['ready'] ) ) 
     { 
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
     }

     $taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) 
    $taraDili="EN";
   dilCevir($taraDili);
   
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	   
   
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