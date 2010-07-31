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
    session_start (); 
	  
	include "../../conf.php";
    checkLoginLang(true,true,"upload.php");
	if (!check_source()) die ("<font id='hata'>$metin[295]</font>"); 

$destination_path = getcwd().DIRECTORY_SEPARATOR."../../uploads/";

$result = 0;

 if(in_array(strtolower($_FILES['myfile']['name']),array(".htaccess")) or 
    file_exists($destination_path . basename( $_FILES['myfile']['name'])) or 
	$_FILES['myfile']['size']<2000 or
	strlen($_FILES['myfile']['name']>50) ) 
  { 
   $result = 0 ; 
   // unwanted file(s) or already exists or size 5M = 2000
   //file name can not be 50 chars
 }else{
	 try{
	$target_path = $destination_path . basename( $_FILES['myfile']['name']);
	dosyaKaydet($_FILES['myfile']['name'], getUserID2($_SESSION["usern"]));
	if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
	  $result = 1;
	}
	 }
	 catch (Exception $e) {
		echo "<script>alert('Hata : $e');</script>"; 
		$result = 0 ;
	}
 }
 
sleep(1); //?
?>
<script language="javascript" type="text/javascript">
  window.top.window.stopUpload(<?php echo $result; ?>);
</script>