<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
	ob_start();
	@session_start();
	
	include "conf.php";
	
    checkLoginLang(false,true,"fileDownload.php");
	//if (!check_source()) die ("<font id='hata'>$metin[295]</font>"); 

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
			}else {
					header('Content-Type: application/octet-stream');
					//header('Content-type: application/force-download');
					
					header('Content-Disposition: attachment; filename="'.$dosya.'"');
					header('Content-Length: '.(string)filesize($physicalFileName));
					header('Cache-Control: no-store, no-cache, must-revalidate');
					header('Pragma: no-cache');
					header('Expires: 0');
					downloadSayac(RemoveXSS($_GET["id"]));
					//readfile($physicalFileName);
	   
					flush();
					$download_rate = 1;// set the download rate limit (=> 1024 kb/s)
					$file = fopen($physicalFileName, "r");
					while (!feof($file)) {
						print fread($file, round($download_rate * 1024));
						//flush();
						//sleep(1);
					}
				 	flush();
					// close file stream
					fclose($file);					
					
					die("");
		}
	}else
	echo "$physicalFileName :  no such file ! ";
?>
