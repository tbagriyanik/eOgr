<?php
/*
the returned xml has the following structure
<results>
	<rs>foo</rs>
	<rs>bar</rs>
</results>
*/
@session_start();

include ("conf.php");

$aUsers =array();
$aID 	=array();
$aInfo	=array();

	$result = mysql_query("select konuAdi from eo_4konu order by id");
	for($i = 0; $sonuc = mysql_fetch_assoc($result); $i++) 
	{
		$aUsers[$i] =iconv( "ISO-8859-9","UTF-8",temizle(htmlspecialchars($sonuc ["konuAdi"]))); 
	};
	
	$result = mysql_query("select id from eo_4konu order by id");
	for($i = 0; $sonuc = mysql_fetch_assoc($result); $i++) 
	{
		$aID[$i] = iconv( "ISO-8859-9","UTF-8",temizle(htmlspecialchars($sonuc ["id"])));
	};

	$result = mysql_query("select eo_3ders.dersAdi as dersAdi from eo_3ders,eo_4konu where eo_4konu.dersID=eo_3ders.id order by eo_4konu.id");
	for($i = 0; $sonuc = mysql_fetch_assoc($result); $i++) 
	{
		$aInfo[$i] = iconv( "ISO-8859-9","UTF-8",temizle(htmlspecialchars($sonuc ["dersAdi"])));
	};
	
	if(!empty($_GET['input']))
		$input = strtolower($_GET['input']);
	else	
		$input = "";
																					
	$len = strlen($input);
	$limit = 5;
	
	
	$aResults = array();
	$count = 0;
	
	if ($len)
	{
		for ($i=0;$i<count($aUsers);$i++)
		{
			// had to use utf_decode, here
			// not necessary if the results are coming from mysql
			//

			if (strtolower(substr(utf8_decode($aUsers[$i]),0,$len)) == $input || strpos( strtolower($aUsers[$i]),$input) > 0 )
			{
				$count++;
				$aResults[] = array( "id"=> $aID[$i] ,"value"=>$aUsers[$i], "info"=>$aInfo[$i] );
			}
			
			if ($limit && $count==$limit)
				break;
		}
	}
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"".$aResults[$i]['info']."\" }";
		}
		echo implode(", ", $arr);
		echo "]}";
?>