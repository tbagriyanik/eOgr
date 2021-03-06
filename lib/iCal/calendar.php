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
	ob_start();
    @session_start (); 
	require("../../conf.php");	
	checkLoginLang(true,true,"calendar.php");	

$month	=(isset($_REQUEST['month']))?RemoveXSS($_REQUEST['month']):date('m');
$year	=(isset($_REQUEST['year']))?RemoveXSS($_REQUEST['year']):date('Y');

$get_date	=mktime(0, 0, 0, $month, 1, $year );
$next_month	=mktime(0, 0, 0, $month+1, 1, $year );
$prev_month	=mktime(0, 0, 0, $month-1, 1, $year );

$next_m=date('m', $next_month);
$next_y=date('Y', $next_month);

$myEkle="&my=0";
if(isset($_GET["my"]))
 if($_GET["my"]=="1")
  $myEkle="&my=1";
  
if($taraDili=="EN")
	$next_month="<a href=\"calendar.php?month=$next_m&year=$next_y$myEkle\" class=\"date_selector\" target=\"_self\">". date('F', $next_month) . " &raquo;</a>";
 else
	$next_month="<a href=\"calendar.php?month=$next_m&year=$next_y$myEkle\" class=\"date_selector\" target=\"_self\">". ayTr(date('m', $next_month)) . " &raquo;</a>";
	

$prev_m=date('m', $prev_month);
$prev_y=date('Y', $prev_month);
if($taraDili=="EN")
	$prev_month="<a href=\"calendar.php?month=$prev_m&year=$prev_y$myEkle\" class=\"date_selector\" target=\"_self\">&laquo; ". date('F', $prev_month) . "</a>";
	else
	$prev_month="<a href=\"calendar.php?month=$prev_m&year=$prev_y$myEkle\" class=\"date_selector\" target=\"_self\">&laquo; ". ayTr(date('m', $prev_month)) . "</a>";
	
function last_day( $month, $year ) {
return mktime( 23, 59, 59, $month + 1, 0, $year );
}

function print_calendar( $month, $year, $weekdaytostart = 0 ) {
	global $taraDili,$get_date,$myEkle;
	$last = idate( 'd', last_day( $month, $year ) );
	$firstdaystamp = mktime( 0, 0, 0, $month, 1, $year );
	$firstwday = idate( 'w', $firstdaystamp );
	$name = date( 'F', $firstdaystamp );
	$weekorder = array();
	for ( $wo = $weekdaytostart; $wo < $weekdaytostart + 7; $wo++ ) {
		$weekorder[] = $wo % 7;
	}
	

	// GET LAST FRIDAY
	$numDays=date('t', $get_date);
	$last_day_name=mktime(0, 0, 0, $month, $numDays, $year );
	$last_day_name=date('D', $last_day_name);
	if ($last_day_name=='Sat') { $last_day=$numDays-1; }
	if ($last_day_name=='Sun') { $last_day=$numDays-2; }
	if ($last_day_name=='Mon') { $last_day=$numDays-3; }
	if ($last_day_name=='Tue') { $last_day=$numDays-4; }
	if ($last_day_name=='Wed') { $last_day=$numDays-5; }
	if ($last_day_name=='Thu') { $last_day=$numDays-6; }
	
	echo "<table cellspacing=\"0\">\n";
	
	// SET UP DAYS
	echo '<thead><tr>';
	foreach ( $weekorder as $w ) {
		$dayname = date( 'D',
		mktime( 0, 0, 0, $month, 1 - $firstwday + $w, $year ) );
		if($taraDili=="EN")
			echo "<th>{$dayname}</th>";
		else	
			echo "<th>".gunTr($dayname)."</th>";
	}
	echo "</tr></thead>\n";

	$onday = 0;
	$started = false;
	while ( $onday <= $last ) {
		echo '<tbody><tr>';
		
		foreach ( $weekorder as $d ) {
			if ( !( $started ) ) {
				if ( $d == $firstwday ) {
					$started = true;
					$onday++;
				}
			}
			if ( ( $onday == 0 ) || ( $onday > $last ) ) {
				echo "<td class=\"padding\">&nbsp;</td>";
			} else {
				$olayVar = buTarihtekiOlayListesi($onday,$month,$year,$myEkle);
				if ($onday==date('d') && $month==date('m') && empty($olayVar) ) {
					//bugünü işaretle
					echo "<td class=\"today\">{$onday}</td>";
				} elseif ($onday==date('d') && $month==date('m') && !empty($olayVar) ) {
					//bugünü ve olay var ise işaretle
					echo "<td class=\"date_has_event today\">{$onday}
					<div class=\"events\">
						<ul>
							$olayVar
						</ul>
					</div>					
					</td>";
				} elseif (!empty($olayVar)) {
					//bu günde olaylar varsa
					echo "<td class=\"date_has_event\">{$onday}
					<div class=\"events\">
						<ul>
							$olayVar
						</ul>
					</div>
					</td>";
				} else {
					//boş bir gün
					echo "<td>{$onday}</td>";
				}
				$onday++;
			}
		}
		echo "</tr></tbody>\n";
	}
	
	// SET UP DAYS
	echo '<tfoot><tr>';
	foreach ( $weekorder as $w ) {
		$dayname = date( 'D',
		mktime( 0, 0, 0, $month, 1 - $firstwday + $w, $year ) );
		if($taraDili=="EN")
			echo "<th>{$dayname}</th>";
		else	
			echo "<th>".gunTr($dayname)."</th>";
	}
	echo "</tr></tfoot>\n";
	
	echo '</table>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
        <head>
        <title>Calendar</title>
        <link rel="stylesheet" href="master.css" type="text/css" media="screen" charset="utf-8" />
        <script src="../jquery-1.9.1.min.js" type="text/javascript"> </script>
        <script src="coda.js" type="text/javascript"> </script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        </head>
        <body>
<div style="margin:0 auto;">
          <div align="center"> <?php echo $prev_month; ?> <strong><?php 
		  if($taraDili=="EN")
			  echo (date("F",$get_date))." ".date('Y', $get_date); 
			 else 
			  echo ayTr(date("m",$get_date))." ".date('Y', $get_date); 
		  ?></strong> <?php echo $next_month; ?> </div>
        </div>
<div style="clear:both;">
          <?php
        	print_calendar($month,$year, 1);
        ?>
        </div>
</body>
</html>