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
	header("Content-Type: text/html; charset=utf-8");
	
	require("conf.php");
	
  	checkLoginLang(false,true,"dataFill.php");	   
  	
	if(isset($_GET["okul"])) {
		echo sinifAdlari($_GET["okul"]);
	}elseif(isset($_GET["sinif"]) and isset($_GET["okuldan"]) and $_GET["okuldan"]=="1") {
		echo dersAdlari($_GET["sinif"],1);	//1=okuldan parametresi
	}elseif(isset($_GET["sinif"])) {
		echo dersAdlari($_GET["sinif"],0);	//0=t�m s�n�flar
	}elseif(isset($_GET["ders"]) and isset($_GET["okuldan"]) and  $_GET["okuldan"]=="2") {
		echo konuAdlari($_GET["ders"],2); 	//2=okuldan 
	}elseif(isset($_GET["ders"]) and isset($_GET["siniftan"]) and  $_GET["siniftan"]=="1") {
		echo konuAdlari($_GET["ders"],1); 	//1=s�n�ftan 
	}elseif(isset($_GET["ders"])) {
		echo konuAdlari($_GET["ders"],0);	//0=t�m konular
	}
	
?>