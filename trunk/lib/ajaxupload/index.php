<?
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>Dosya Y�kleme</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
<!--
function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success){
      var result = '';
      if (success == 1){
         result = '<span class="msg">Dosya Y�klendi...<\/span><br/><br/>';
      }
      else {
         result = '<span class="emsg">Dosya Y�klenirken Hata Olu�tu!<\/span><br/>';
		 switch(success){
			 case -1:
			    result += "�stenmeyen Dosya G�nderimi<br/><br/>";					
			 	break;
			 case -2:
			    result += "Varolan Bir Dosya G�nderimi<br/><br/>";					
			 	break;
			 case -3:
			    result += "Boyutu Fazla Olan Dosya G�nderimi<br/><br/>";					
			 	break;
			 case -4:
			    result += "Dosya Ad�nda �stenmeyen Karakter Olan Dosya G�nderimi<br/><br/>";					
			 	break;
			 case -5:
			    result += "�stenmeyen Dosya T�r�nde G�nderim<br/><br/>";					
			 	break;
			 case -6:
			    result += "Dosya �smi �ok Uzun Olan Dosya G�nderimi<br/><br/>";					
			 	break;
			 default:
			    result += "Bilinmeyen Hata<br/><br/>";					
		 }
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<label>Dosya: <input name="myfile" type="file" size="30" /><\/label><label><input type="submit" name="submitBtn" class="sbtn" value="Y�kle" /><\/label>';
      document.getElementById('f1_upload_form').style.visibility = 'visible';      
      return true;   
}
//-->
</script>
<style type="text/css">
body {
	margin-left: 5px;
	margin-top: 1px;
	margin-right: 1px;
	margin-bottom: 1px;
}
</style>
</head>

<body>
<div id="container">
  <div id="header">
    <div id="header_left"></div>
    <div id="header_main">eOgr - Dosya Y�kleme</div>
    <div id="header_right">
      <input type="image" name="closeBtn" src="../../img/close.gif" value="Kapat"  onclick="window.close();" style="left:-10px;"/>
    </div>
  </div>
  <?php
	include "../../conf.php";
    checkLoginLang(true,true,"index.php");
  ?>
  <div id="content">
    <form action="upload.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
      <INPUT TYPE="hidden" NAME="MAX_FILE_SIZE" VALUE="5242880">
      <p id="f1_upload_process">Y�kleniyor...<br/>
        <img src="loader.gif" /><br/>
      </p>
      <p id="f1_upload_form" align="center"><br/>
        <label>Dosya:
          <input name="myfile" type="file" size="30"/>
        </label>
        <input type="submit" name="submitBtn" class="sbtn" value="Y�kle" />
      </p>
      <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
    </form>
    <ul>
      <li>Dosya ad� 50 karakteri ge�memelidir. </li>
      <li>Dosya ad�nda T�rk�e karakter ve bo�luk olmamal�d�r.</li>
      <li>Dosya boyutu en fazla 5 MB olabilir.</li>
      <li>Var olan bir dosya tekrar g�nderilemez.</li>
    </ul>
  </div>
</div>
</body>
