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

	include "conf.php";	

    checkLoginLang(false,true,"fileDownload.php");

	//if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	

	if(!isset($_GET["file"]) or !isset($_GET["id"]))
		die("no file to download or view");		

	if(isset($_GET["id"]) and idtoDosyaAdi($_GET["id"])!=$_GET["file"])	
		die(RemoveXSS($_GET["id"])." and ".RemoveXSS($_GET["file"])." are not matching");	

	$dosya = RemoveXSS($_GET["file"]);
	$dosya = str_replace("..", "", $dosya);
	$dosya = str_replace("/", "", $dosya);

	$physicalFileName = $_uploadFolder.'/'.$dosya;
	// security check	

	if (file_exists($physicalFileName)) {
 		if(isset($_GET["islem"]) and $_GET["islem"]=="goster"){	
			if(in_array(file_ext($dosya),$_filesToPlay)){			

				$oyna = "<iframe src=\"$_source1/player.php?id=".RemoveXSS($_GET["id"])."\" frameborder=\"0\" scrolling=\"no\" width=\"470\" height=\"320\" align=\"middle\" marginheight=\"0\" allowtransparency=\"false\" style=\"background-color: white\"></iframe>";

				echo $oyna;

				echo "<p style='font-family:tahoma; font-size:12px;color:#f00;'>$metin[676] <br/><textarea cols=80 rows=4  style='font-family:tahoma; font-size:12px;color:#222;border:1px solid #555;'>$oyna</textarea></p>";															

				die();

			}				

                  $content = dosyaGoster($dosya); /* get the buffer */				  
				  ob_clean();//2-3 saatim gitti bu sayede dosya icleri baklava olmadi

				  if(file_ext($dosya)=="jpg")
	                  header("Content-Type: image/jpg");

				  elseif(file_ext($dosya)=="png")
	                  header("Content-Type: image/png");

				  elseif(file_ext($dosya)=="gif")
	                  header("Content-Type: image/gif");

				  elseif(file_ext($dosya)=="jpeg")
	                  header("Content-Type: image/jpeg");

                  echo $content;

				  if(isset($_GET["id"]))
				  	downloadSayac(RemoveXSS($_GET["id"]));

                  die('');		 

			}else {
				ob_clean();
				 
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'. $dosya .'"');
				header('Content-Transfer-Encoding: binary');
				header('Connection: Keep-Alive');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($physicalFileName));

				// read file
				readfile($physicalFileName);		

					if(isset($_GET["id"]))
						downloadSayac(RemoveXSS($_GET["id"]));
					
				die("");
		}
	}else
	echo "$physicalFileName :  no such file ! ";
?>