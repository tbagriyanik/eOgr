<?php

$siteLink = "";

class RSS
{
	public function RSS()
	{
		require 'database.php';
	DEFINE ('DB_USER', $_username);
	DEFINE ('DB_PASSWORD', $_password);
	DEFINE ('DB_HOST', $_host);
	DEFINE ('DB_NAME', $_db);

// Make the connnection and then select the database.
$dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL: ' . mysql_error() );
mysql_select_db (DB_NAME) OR die ('Could not select the database: ' . mysql_error() );

	}
	
	public function GetFeed()
	{
		return $this->getDetails() . $this->getItems();
	}
	
	private function dbConnect()
	{
		DEFINE ('LINK', mysql_connect (DB_HOST, DB_USER, DB_PASSWORD));
	}
	
	private function smileAdd($gelen){

	$icos = array(":)",":(",";)",":-P","S-)","](",":*)","O:]",":-X","8-)","=/","=O","QQ",":-D");
	$smileImg = array(
					  "<img src='lib/wtag/smileys/smile.gif' width='15' height='15' alt=':)' title=':)' />",
					  "<img src='lib/wtag/smileys/sad.gif' width='15' height='15' alt=':(' title=':(' />",
					  "<img src='lib/wtag/smileys/wink.gif' width='15' height='15' alt=';)' title=';)' />",
					  "<img src='lib/wtag/smileys/tongue.gif' width='15' height='15' alt=':-P' title=':-P' />",
					  "<img src='lib/wtag/smileys/rolleyes.gif' width='15' height='15' alt='S-)' title='S-)' />",
					  "<img src='lib/wtag/smileys/angry.gif' width='15' height='15' alt='](' title='](' />",
					  "<img src='lib/wtag/smileys/embarassed.gif' width='15' height='15' alt=':*)' title=':*)' />",
					  "<img src='lib/wtag/smileys/angel.gif' width='15' height='15' alt='O:]' title='O:]' />",
					  "<img src='lib/wtag/smileys/sealedlips.gif' width='15' height='15' alt=':-X' title=':-X' />",
					  "<img src='lib/wtag/smileys/cool.gif' width='15' height='15' alt='8-)' title='8-)' />",
					  "<img src='lib/wtag/smileys/undecided.gif' width='15' height='15' alt='=/' title='=/' />",
					  "<img src='lib/wtag/smileys/shocked.gif' width='15' height='15' alt='=O' title='=O' />",
					  "<img src='lib/wtag/smileys/cry.gif' width='15' height='15' alt='QQ' title='QQ' />",
					  "<img src='lib/wtag/smileys/grin.gif' width='15' height='15' alt=':-D' title=':-D' />"
		);

	$sonuc = str_replace($icos, $smileImg, $gelen);
 	return $sonuc;	
	}

	
	private function getDetails()
	{
		global $siteLink;
		$detailsTable = "eo_webref_rss_details";
		$this->dbConnect($detailsTable);
		$query = "SELECT * FROM ". $detailsTable;
		$result = mysql_db_query (DB_NAME, $query, LINK);
		
		while($row = mysql_fetch_array($result))
		{
			$details = '<?xml version="1.0" encoding="ISO-8859-9" ?>
					<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
						<channel>
							<title>'. $row['title'] .'</title>
							<link>'. $row['link'] .'</link>
							<description>'. ($row['description']) .'</description>
							<language>'. $row['language'] .'</language>							
							<atom:link href="'.$row['link'].'/rss.php" rel="self" type="application/rss+xml" />
';
			$siteLink = $row['link'];
		}
		return $details;
	}
	
	private function getItems()
	{
		global $siteLink;
		$itemsTable = "eo_webref_rss_items";
		$this->dbConnect($itemsTable);
		$query = "SELECT * FROM ". $itemsTable;
		$result = mysql_db_query (DB_NAME, $query, LINK);
		$items = '';
		$i = 0;
		while($row = mysql_fetch_array($result))
		{
			$items .= '<item>
						 <title><![CDATA['. $row["title"] .']]></title>
						 <link>'. ((!empty($row["link"]))?$siteLink.'/'.$row["link"]:$siteLink) .'</link>
						 <guid isPermaLink="false">'. $row["title"] .'</guid>
						 <description><![CDATA['. $this->smileAdd($row["description"]) .']]></description>
						 <pubDate>'. date("D, d M Y H:i:s O", strtotime($row["pubDate"])) .'</pubDate>
					 </item>';
			$i++;		 
		}
		$items .= '</channel>
				 </rss>';
		return $items;
	}

}

?>