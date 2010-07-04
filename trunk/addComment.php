<?php
	header("Content-Type: text/html; charset=iso-8859-9"); 
	
	$taraDili=$_COOKIE["lng"];    
   if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili="EN";
      if ($taraDili=="TR")
        require("lib/tr.php"); 
      elseif ($taraDili=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         
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
