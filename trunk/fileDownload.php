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
include "conf.php";
	
    checkLoginLang(true,true,"fileDownload.php");
	if (!check_source()) die ("<font id='hata'>$metin[295]</font>"); 

	$dosya = RemoveXSS($_GET["file"]);
	$dosya = str_replace("..", "", $dosya);
	$dosya = str_replace("/", "", $dosya);

 $physicalFileName = $_uploadFolder.'/'.$dosya;
	// security check
	if (file_exists($physicalFileName)) {
		switch($_GET["islem"]){
			case "goster":				
                  $content = dosyaGoster($dosya); /* get the buffer */
				  if(file_ext($dosya)=="jpg")
	                  header("Content-Type: image/jpg");
				  elseif(file_ext($dosya)=="png")
	                  header("Content-Type: image/png");
				  elseif(file_ext($dosya)=="gif")
	                  header("Content-Type: image/gif");
				  elseif(file_ext($dosya)=="jpeg")
	                  header("Content-Type: image/jpeg");
                  echo $content;
				  downloadSayac(RemoveXSS($_GET["id"]));
                  die('');		 
			break;
			default:
					header('Content-Type: application/octet-stream');
					//header('Content-type: application/force-download');
					
					header('Content-Disposition: attachment; filename="'.$_GET['file'].'"');
					header('Content-Length: '.(string)filesize($physicalFileName));
					header('Cache-Control: no-store, no-cache, must-revalidate');
					header('Pragma: no-cache');
					header('Expires: 0');
					downloadSayac(RemoveXSS($_GET["id"]));
					readfile($physicalFileName);
					die();
		}
	}
?>