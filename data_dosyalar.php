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
	   
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */

require("conf.php");
	
  checkLoginLang(true,true,"data_dosyalar.php");	   
  
//  if (!check_source()) die ("<font id='hata'>$metin[295]</font>");	
  
	$aColumns = array( 'id', 'userID', 'fileName', 'downloadCount',' ');
	$aColumns2 = array( 'id', 'userID', 'fileName', 'downloadCount');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id";
	
	/* DB table to use */
	$sTable = "eo_files";
	
	/* Database connection information */
	$gaSql['user']       = $_username;
	$gaSql['password']   = $_password;
	$gaSql['db']         = $_db;
	$gaSql['server']     = $_host;
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
	$gaSql['link'] =  mysqli_connect( $gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db']) or
		die( 'Could not open connection to server' );
	
	//mysqli_select_db( $gaSql['db'], $gaSql['link'] ) or die( 'Could not select database '. $gaSql['db'] );
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) and $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($gaSql['link'], $_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string($gaSql['link'], $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = ""; 
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns2[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string($gaSql['link'], $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$tumDosyalar = ((isset($_SESSION["tumDosyalar"]))?"1":"0"); 
	 
	$sWhere = "";
	if (!empty($_GET['sSearch']) and  $_GET['sSearch'] != "" )
	{
		if($tumDosyalar!="1")
			$sWhere = "WHERE ((";
		 else
			$sWhere = "WHERE (";
		 		
		for ( $i=0 ; $i<count($aColumns)-1 ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';		
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns)-1 ; $i++ )
	{
		if (!empty($_GET['bSearchable_'.$i]) and !empty($_GET['sSearch_'.$i]) and $_GET['bSearchable_'.$i] == "true" and $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE (";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
		}
	}
	
		if($tumDosyalar!="1"){
			if(!empty($_GET['sSearch']))
					$sWhere .= " OR (SELECT userName FROM eo_users WHERE eo_users.id=eo_files.userID ) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%') AND fileName not REGEXP '^[0-9]{10,15}' ";		
				else
					$sWhere .= " WHERE fileName not REGEXP '^[0-9]{10,15}' ";
			}
		 else{
			if(!empty($_GET['sSearch']))
					$sWhere .= " OR (SELECT userName FROM eo_users WHERE eo_users.id=eo_files.userID ) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' ";	
				else 
					$sWhere .= "";
		 }
		 		

	

	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns2)).",
				(SELECT userName FROM eo_users WHERE 
					eo_users.id=eo_files.userID
					) as userName
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
	//echo $sQuery;
	$rResult = mysqli_query($gaSql['link'] ,$sQuery) or die(mysqli_error());
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysqli_query($gaSql['link'] ,$sQuery) or die(mysqli_error());
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
	";
	$rResultTotal = mysqli_query($gaSql['link'] ,$sQuery) or die(mysqli_error());
	$aResultTotal = mysqli_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$sOutput = '{';
	$sOutput .= '"sEcho": '.intval((isset($_GET['sEcho']))?$_GET['sEcho']:"").', ';
	$sOutput .= '"iTotalRecords": '.$iTotal.', ';
	$sOutput .= '"iTotalDisplayRecords": '.$iFilteredTotal.', ';
	$sOutput .= '"aaData": [ ';
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		$sOutput .= "[";
		$kayNo = $aRow[ $aColumns[0] ];
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{			
			if ( $aColumns[$i] == "fileName" )
			{
				/* Special output formatting */
				$sOutput .= '"<a href=\"fileDownload.php?id='.$aRow[ $aColumns[0] ].'&amp;file='.$aRow[ $aColumns[$i] ].'\" class=\"external\">'.$aRow[ $aColumns[$i] ].'</a> ';
				
			if(in_array(file_ext($aRow[ $aColumns[$i] ]),array("jpg","jpeg","png","gif"))) 
								$sOutput .=  ' <a href=\"fileDownload.php?id='.$aRow[ $aColumns[0] ].
								 '&amp;file='.$aRow[ $aColumns[$i] ].'&amp;islem=goster\" target=\"_blank\"><img src=\"img/preview.png\" border=\"0\" style=\"vertical-align:middle\" alt=\"207\"/></a> ';
			if(in_array(file_ext($aRow[ $aColumns[$i] ]),$_filesToPlay)) 
								$sOutput .=  ' <a href=\"fileDownload.php?id='.$aRow[ $aColumns[0] ].
								 '&amp;file='.$aRow[ $aColumns[$i] ].'&amp;islem=goster\" target=\"_blank\"><img src=\"img/preview.png\" border=\"0\" style=\"vertical-align:middle\" alt=\"??\"/></a> ';
							$sOutput .=  " <font size='-2'>".getSizeAsString(@filesize($_uploadFolder.'/'.$aRow[ $aColumns[$i] ]));
							$humanRelativeDate = new HumanRelativeDate();
							$sOutput .=  " ".($humanRelativeDate->getTextForSQLDate(date ("Y-m-d H:i:s",@filemtime($_uploadFolder.'/'.$aRow[ $aColumns[$i] ]) ))).'</font>",';

				
			}
			else if ( $aColumns[$i] == 'userID' )
			{
				$sOutput .= ' "'.($aRow[ 4 ]).'",';
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$sOutput .= '"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
			}
			else if ( $aColumns[$i] == ' ' )
			{
				/* Delete */
				if(($aRow[ 4 ]==$_SESSION["usern"] 
					or getUserType($_SESSION["usern"])=="2") 
					and (preg_match("/777/",decoct(@fileperms($_uploadFolder)))	 
					or preg_match("/766/",decoct(@fileperms($_uploadFolder))))) 				
				$sOutput .= '"<img src=\"img/cross.png\" alt=\"delete\" width=\"16\" height=\"16\" border=\"0\" style=\"vertical-align: middle;cursor:pointer;\"  onclick=\"javascript:delWithCon('.$kayNo.')\" title=\"'.$metin[102].'\"/>",';
				else
				$sOutput .= '"",';
			}
		}
		
		/*
		 * Optional Configuration:
		 * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
		 * database - you can do it here
		 */
		
		
		$sOutput = substr_replace( $sOutput, "", -1 );
		$sOutput .= "],";
	}
	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= '] }';
	
	echo $sOutput;
?>