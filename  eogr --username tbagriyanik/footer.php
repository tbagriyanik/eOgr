<?php
$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
if($seceneklerimiz[0]=="1") {
?>            
 <a href="rss.php" class="rss-tag-icon" title="RSS"></a>
<?php
}
?>  
 <div class="Footer-text">
                       <form method="get" action="" name="themeSelect">
 <?php
	$currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1];
?> 
  <script type="text/javascript">
if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
if (document.getElementById("uyari")!=null) fadeUp(document.getElementById("uyari"),0,0,255,0,0,150);
if (document.getElementById("tamam")!=null) fadeUp(document.getElementById("tamam"),0,255,0,0,150,0);  
  </script>
<?php
if($seceneklerimiz[1]=="1") {
?>
                       <label for="theme"><?php echo $metin[154]?> : </label>
                        <select name="theme" id="theme" onchange="document.themeSelect.submit();">
                        <option value="0" <?php if (!(strcmp("0", temizle($_COOKIE['theme'])))) {echo "selected=\"selected\"";} ?>>
                         <?php echo $metin[159]?>
                        </option>
                        <option value="1" <?php if (!(strcmp("1", temizle($_COOKIE['theme'])))) {echo "selected=\"selected\"";} ?>>
                         <?php echo $metin[160]?>
                        </option>
                        <option value="2" <?php if (!(strcmp("2", temizle($_COOKIE['theme'])))) {echo "selected=\"selected\"";} ?>>
                         <?php echo $metin[161]?>
                        </option>
                        </select>
<?php
}

if($seceneklerimiz[2]=="1") {
?>
  <a href='index.php?lng=<?php echo $taraDili?>&amp;oldPath=<?php echo $currentFile?>' title='Dil se&ccedil;iniz Choose a language'>
  <?php echo ($taraDili=="TR")?"<img src='img/turkish.png' border='0' alt='Dil' style='vertical-align: middle;' />":"<img src='img/english.png' border='0' alt='Language' style='vertical-align: middle;'/>"?></a>
<?php
}
?>  
  
						<?php
						
if($seceneklerimiz[3]=="1") 
echo ("&nbsp;<font size='-3'>".$metin[155]." ".round(getmicrotime() - $time,3)."s</font>");
if($seceneklerimiz[4]=="1") 
echo ("&nbsp;<font size='-3'>".$metin[217]." ".date("d-m-Y", filemtime($currentFile))."</font>");

?> 
                        </form>

</div>
<?php
 mysql_close($yol);
 mysql_close($yol1);
?>