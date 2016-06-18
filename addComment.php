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
	header("Content-Type: text/html; charset=utf-8"); 
	
	require "conf.php";		
	checkLoginLang(true,true,"addComment.php");
	check_source();
?>

<h2><?php echo $metin[290];?></h2>
<div id="commAdderResult" style="visibility:hidden;"> <?php echo $metin[293];?> </div>
<div id="commAdder" style="visibility:visible;">
  <textarea cols="50" rows="3" name="acomment" id="acomment" ></textarea>
  <input type="button" name="gonder" value="<?php echo $metin[30]?>"
 onclick="islemYap();" />
</div>
<script type="text/javascript">
/*
islemYap: parametresiz, 
yorum girildiðini kontrol eder
*/
function islemYap(){
    if (document.getElementById('acomment').value!="") {
			yorumGonder(<?php echo $_GET['konu3']?>  , document.getElementById('acomment').value);	
 			document.getElementById('commAdder').style.visibility = 'hidden' ;
 			document.getElementById('commAdderResult').style.visibility = 'visible' ;
       }else
	   alert("?");
}            
</script> 
