<?php
 $adi	=temizle(substr($_SESSION["usern"],0,15));
 $par	=temizle($_SESSION["userp"]);
 if(!($adi=="" or $par=="")) {
?>
<div id="containerFB">
<div class="panelFB">
  <h3>Hata Bildirimi</h3>
  <p>Ekranda g�rd���n�z bir uyar� veya hata mesaj�n� <strong>"y�neticiye"</strong> bildirebilirsiniz.</p>
  <p>Mesaj�n�za hatan�n olu�tu�u sayfa ad�n� ve kendi isminizi eklemeyi unutmay�n�z.</p>
  <p>Yeni fikir ve �nerilerinizi g�ndermek isterseniz <br/>
<br/>
<a href="mail.php?to=-1" title="feedback" target="_blank" class="external" style="text-decoration:none;">t�klat�n�z&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
  <div style="clear:both;"></div>  
</div>
</div>
<a class="triggerFB" href="#">&nbsp;</a> 
<script type="text/javascript">
    $(document).ready(function($) { 
	$(".triggerFB").click(function(){
		$(".panelFB").toggle("fast");
		$(this).toggleClass("active");
		return false;
	});
  });
</script>
<?php
 }
?>