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
	session_start();
	header("Content-Type: text/html; charset=iso-8859-9"); 
	
	require "conf.php";		
	checkLoginLang(true,true,"askForFriendship.php");
	check_source();
	
	$adi = RemoveXSS($_GET["adi"]);
	$id = RemoveXSS($_GET["id"]);	
?>
<h4><?php echo $metin[591]." : ".$adi;?></h4>
<div id="commAdderResult1" style="visibility:hidden;"> <?php echo $metin[602];?> </div>
<div id="commAdderResult2" style="visibility:hidden;"> <?php echo $metin[603];?> </div>
<div id="commAdder" style="visibility:visible;">
 <input type="button" name="gonder1" value="<?php echo $metin[600]?>" onclick="islemYap1();" />&nbsp;
 <input type="button" name="gonder2" value="<?php echo $metin[601]?>" onclick="islemYap2();" />
</div>
<script type="text/javascript">
/*
islemYap1: parametresiz, 
arkadas kabul edilmesi
*/
function islemYap1(){
	if(arkadasOnayla(<?php echo $id?>)!=""){		
		document.getElementById('commAdder').style.visibility = 'hidden' ;
		document.getElementById('commAdderResult1').style.visibility = 'visible' ;
	}
}            
/*
islemYap2: parametresiz, 
arkadas red edilmesi
*/
function islemYap2(){
	if(arkadasOnaylama(<?php echo $id?>)!=""){		
		document.getElementById('commAdder').style.visibility = 'hidden' ;
		document.getElementById('commAdderResult2').style.visibility = 'visible' ;
	}
}            
</script> 
