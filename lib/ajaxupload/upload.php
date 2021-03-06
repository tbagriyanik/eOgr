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
    @session_start (); 
	ob_start();
	  
	include "../../conf.php";
    checkLoginLang(true,true,"upload.php");
	if (!check_source()) die ("<font id='hata'>$metin[295]</font>"); 

$destination_path = getcwd().DIRECTORY_SEPARATOR."../../".$_uploadFolder."/";
$target_path = $destination_path . basename( $_FILES['myfile']['name']);

$result = 0;

//http://www.mediawiki.org/wiki/Manual:$wgFileBlacklist
$wgFileBlacklist = array(
  # HTML may contain cookie-stealing JavaScript and web bugs
  'html', 'htm', 'js', 'jsb', 'mhtml', 'mht',
  # PHP scripts may execute arbitrary code on the server
  'php', 'phtml', 'php3', 'php4', 'php5', 'phps',
  # Other types that may be interpreted by some servers
  'shtml', 'jhtml', 'pl', 'py', 'cgi',
  # May contain harmful executables for Windows victims
  'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl' );
$wgMimeTypeBlacklist = array(
	# HTML may contain cookie-stealing JavaScript and web bugs
	'text/html', 'text/javascript', 'text/x-javascript',  'application/x-shellscript',
	# PHP scripts may execute arbitrary code on the server
	'application/x-php', 'text/x-php', 'application/x-httpd-php',
	# Other types that may be interpreted by some servers
	'text/x-python', 'text/x-perl', 'text/x-bash', 'text/x-sh', 'text/x-csh',
	# Client-side hazards on Internet Explorer
	'text/scriptlet', 'application/x-msdownload',
	# Windows metafile, client-side vulnerability on some systems
	'application/x-msmetafile',
	# A ZIP file may be a valid Java archive containing an applet which exploits the
	# same-origin policy to steal cookies
	'application/zip',
	# MS Office OpenXML and other Open Package Conventions files are zip files
	# and thus blacklisted just as other zip files
	'application/x-opc+zip',
);

$dBoyu = $_FILES['myfile']['size'];
$maxBoy = 1024*1024*$_fileMaxUploadSize; 

if((!empty($_FILES["myfile"])) && ($_FILES['myfile']['error'] == 0))
{

 if(in_array(strtolower($_FILES['myfile']['name']),array(".htaccess","index.php"))){ 
   $result = -1; 
	trackUser($currentFile,"fail,FileUp",$_SESSION["usern"]);
  }   
 else if(getUserType($_SESSION["usern"])==0 and file_ext($_FILES['myfile']['name'])!='rar'){
	   	$result = -8; //��rencilere sadece RAR uzant�s�
		trackUser($currentFile,"fail,FileUp",$_SESSION["usern"]);	 
	 } 
 else if ($dBoyu>$maxBoy or $dBoyu<0 ){
	 //maksimum dosya g�nderim s�n�r�
   $result = -3; 
	trackUser($currentFile,"fail,FileUp",$_SESSION["usern"]);
	 }   
 else if (!preg_match("/^[A-Za-z0-9_-]+.[A-Za-z0-9]{2,6}$/i", $_FILES['myfile']['name']) ){
   $result = -4; 
	trackUser($currentFile,"fail,FileUp",$_SESSION["usern"]);
	 }   
 else if (in_array(end(explode(".",strtolower($_FILES['myfile']['name']))),$wgFileBlacklist) ){
   $result = -5; 
	trackUser($currentFile,"fail,FileUp",$_SESSION["usern"]);
	 }   
 else if (in_array(strtolower($_FILES['myfile']['type']),$wgMimeTypeBlacklist)){
   $result = -7; 
	trackUser($currentFile,"fail,FileUp",$_SESSION["usern"]);
	 }   
 else if (strlen($_FILES['myfile']['name']>50)){
   $result = -6; 
	trackUser($currentFile,"fail,FileUp",$_SESSION["usern"]);
	 }   
 else{
	 try{
		$target_path = $destination_path . basename( strtolower($_FILES['myfile']['name']) );
		if (file_exists($target_path)){
		   $result = -2; 
			trackUser($currentFile,"fail,FileUp",$_SESSION["usern"]);
		} else if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
		  $result = 1;
		  dosyaKaydet(strtolower($_FILES['myfile']['name']), getUserID2($_SESSION["usern"]));
		  trackUser($currentFile,"success,FileUp",$_SESSION["usern"]);
		}else
		  $result = 0;		  
	 }
	 catch (Exception $e) {
		echo "<script>alert('Hata : $e');</script>"; 
		trackUser($currentFile,"fail,FileUp",$_SESSION["usern"]);
		$result = 0 ;
	}
 }
}
/*echo "<script>alert('$result - Hata : ".$_FILES['myfile']['name']."');</script>"; */
 
sleep(1); //?
?>
<script language="javascript" type="text/javascript">
  window.top.window.stopUpload(<?php echo $result; ?>);
</script>