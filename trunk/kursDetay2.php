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
    header("Expires: Sun, 1 Jan 2000 12:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
	
      session_start (); 
      $_SESSION ['ready'] = TRUE; 
	require("conf.php");	
	$time = getmicrotime();  
	checkLoginLang(false,true,"kursDetay2.php");	
	//check_source();
	$seciliTema=temaBilgisi();	
ob_start (); // Buffer output
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>eOgr -<?php echo $metin[461]?>
<!--TITLE-->
</title>
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.css" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" href="theme/<?php echo $seciliTema?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="javascript" type="text/javascript" src="lib/jquery-1.4.3.min.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery-print.js"></script>
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<link rel="stylesheet" type="text/css" href="lib/shadowbox/shadowbox.css" />
<script type="text/javascript" src="lib/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init({
    handleOversize: "drag",
    modal: true
});
</script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        
      }) 
    })
    jQuery(document).ready(function($) {
      // Hook up the print link.
				$( ".yazdir" )
					.attr( "href", "javascript:void(0)" )
					.click(
						function(){
							// Print the DIV.
							$( ".printMe" ).print(); 
							// Cancel click event.
							return( false );
						}); 
    })
</script>
</head>
<body>
<div class="PageBackgroundGradient"></div>
<div class="Main">
  <div class="Sheet">
    <div class="Sheet-tl"></div>
    <div class="Sheet-tr">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-bl">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-br">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-tc">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-bc">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-cl">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-cr">
      <div>&nbsp;</div>
    </div>
    <div class="Sheet-cc"></div>
    <div class="Sheet-body">
      <div class="Header">
        <div class="Header-png"></div>
        <div class="Header-jpeg"></div>
        <div class="logo">
          <h1 id="name-text" class="logo-name"><a href="index.php"><?php echo ayarGetir("okulGenelAdi")?></a></h1>
          <div id="slogan-text" class="logo-text"> <?php echo $metin[286]?> </div>
        </div>
      </div>
      <div class="nav">
        <?php
				 require("menu.php");
                ?>
        <div class="l"> </div>
        <div class="r">
          <div>&nbsp;</div>
        </div>
      </div>
      <div class="contentLayout">
        <div class="content">
          <div class="Post">
            <div class="Post-tl"></div>
            <div class="Post-tr">
              <div>&nbsp;</div>
            </div>
            <div class="Post-bl">
              <div>&nbsp;</div>
            </div>
            <div class="Post-br">
              <div>&nbsp;</div>
            </div>
            <div class="Post-tc">
              <div>&nbsp;</div>
            </div>
            <div class="Post-bc">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cl">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cr">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cc"></div>
            <div class="Post-body">
              <div class="Post-inner">
                <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[461]?> </span> </h2>
                <div class="PostContent">
                 <p><?php echo $metin[629];?></p>
                  <?php
				  
	$uID = temizle($_GET["kisi"]);
	if($uID!="") $_SESSION["kursUser2"]=$uID;
		 
?>
                  <div class="aramaDiv2">
                    <p> <?php echo $metin[29]?> :
                      <input name="searchterm2" type="text" id="searchterm2" size="30" maxlength="50" title="<?php echo $metin[590]?>"/>
                      <img src="img/view.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[590]?>" title="<?php echo $metin[590]?>"/> </p>
                  </div>
                  <script type="text/javascript">
                        var options = {
                            script:"lib/as/test2.php?",
                            varname:"input",
                            json:true,
                            shownoresults:false,
                            maxresults:3,
                            callback: function (obj) {								
								location.href = "kursDetay2.php?kisi="+obj.id;
							}
                        };
                        var as_json = new bsn.AutoSuggest('searchterm2', options);                                                
</script> 
				<?php if($uID!="") {?>
                  <div class="tekKolon"> <h4><?php echo $metin[584]?> :</h4>
                    <?php				    
				    echo "<p><span style='text-transform: capitalize;'>".strtolower(kullGercekAdi($uID))."</span></strong></p>";
					if(strlen(getStats(19,$uID))==0)					
						echo "<font id='uyari'>$metin[586]</font>";
					else					
						echo getStats(19,$uID);
                  ?>
                  </div>
                  <?php
                  }
				  ?>
                </div>
                <div class="cleared" ></div>
              </div>
            </div>
          </div>
          <?php
					$dersID = temizle($_GET["kurs"]);
					$uID = temizle($_GET["kisi"]);
			if(! empty($dersID) ) {
          ?>
          <div class="Post">
            <div class="Post-tl"></div>
            <div class="Post-tr">
              <div>&nbsp;</div>
            </div>
            <div class="Post-bl">
              <div>&nbsp;</div>
            </div>
            <div class="Post-br">
              <div>&nbsp;</div>
            </div>
            <div class="Post-tc">
              <div>&nbsp;</div>
            </div>
            <div class="Post-bc">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cl">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cr">
              <div>&nbsp;</div>
            </div>
            <div class="Post-cc"></div>
            <div class="Post-body">
              <div class="Post-inner">
                <div class="PostContent">
                  <div class='printMe' style="margin:3px;">
                    <?php
	 				echo "<h4 align='center'>$metin[363] : ".
							getDersAdi($dersID)." (".getDerstekiKonuSay($dersID).")</h4>";
	 				echo "<h5>$metin[17] : ".getUserName($uID)."</h5>";
					echo getKursTablo($dersID,$uID);
					?>
                  </div>
                  <hr noshade="noshade">
                  <p> <a href="#" class="yazdir external" style="background-color:white"><?php echo $metin[462]?></a> </p>
                </div>
                <div class="cleared"></div>
              </div>
            </div>
          </div>
          <?php
			}
			
		if(isset($_GET["kurs"])){			
			$pageContents = ob_get_contents (); // Get all the page's HTML into a string
			ob_end_clean (); // Wipe the buffer
			echo str_replace ('<!--TITLE-->', " - ".dersAdiGetir($_GET["kurs"]), $pageContents);	   			
		}	   else{
			$pageContents = ob_get_contents (); // Get all the page's HTML into a string
			ob_end_clean (); // Wipe the buffer
			echo str_replace ('<!--TITLE-->', "", $pageContents);	   
	   }			
          ?>
        </div>
        <div class="cleared"></div>
        <div class="Footer">
          <div class="Footer-inner">
            <?php  						
						 require "footer.php";
                        ?>
          </div>
          <div class="Footer-background"></div>
        </div>
      </div>
    </div>
    <div class="cleared"></div>
  </div>
</div>
<?php  						
 require "feedback.php";
?>
</body>
</html>
