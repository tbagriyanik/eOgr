<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-9" />
<title>Dosya Yükleme</title>
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
         result = '<span class="msg">Dosya Yüklendi...<\/span><br/><br/>';
      }
      else {
         result = '<span class="emsg">Dosya Yüklenirken Hata Oluþtu!<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<label>Dosya: <input name="myfile" type="file" size="30" /><\/label><label><input type="submit" name="submitBtn" class="sbtn" value="Yükle" /><\/label>';
      document.getElementById('f1_upload_form').style.visibility = 'visible';      
      return true;   
}
//-->
</script>
</head>

<body>
<div id="container">
  <div id="header">
    <div id="header_left"></div>
    <div id="header_main">AJAX Dosya  Yükleme</div>
    <div id="header_right"></div>
  </div>
  <div id="content">
    <form action="upload.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
      <p id="f1_upload_process">Yükleniyor...<br/>
        <img src="loader.gif" /><br/>
      </p>
      <p id="f1_upload_form" align="center"><br/>
        <label>Dosya:
          <input name="myfile" type="file" size="30" />
        </label>
        <label>
          <input type="submit" name="submitBtn" class="sbtn" value="Yükle" />
        </label>
      </p>
      <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
    </form>
  </div>
</div>
</body>
