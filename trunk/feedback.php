<?php
 $adi	=temizle(substr($_SESSION["usern"],0,15));
 $par	=temizle($_SESSION["userp"]);
 if(!($adi=="" or $par=="")) {
?>
<div id="containerFB">
<div class="panelFB">
  <h3>Hata Bildirimi</h3>
  <p>Ekranda gördüðünüz bir uyarý veya hata mesajýný <strong>"yöneticiye"</strong> bildirebilirsiniz.</p>
  <p>Mesajýnýza hatanýn oluþtuðu sayfa adýný ve kendi isminizi eklemeyi unutmayýnýz.</p>
  <p>Yeni fikir ve önerilerinizi göndermek isterseniz <br/>
<br/>
<a href="mail.php?to=-1" title="feedback" target="_blank" class="external" style="text-decoration:none;">týklatýnýz&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
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