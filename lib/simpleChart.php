<?php
/**
*       (c) www.sourceworkshop.com
*       @project: simpleChart.php
*	@version: 1.0
*	@author: Konstantin Atanasov
*
*
*
*    CSS classes:    chartTable 
*                    emptyCell - emty table cell
*                    dataCell  - bar cell
*                    vPoint    - vertical point
*                    barLabel  - bar label style
*                    chartTitle  -title style
*/
/*
NO WARRANTY
11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW. EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU. SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING, REPAIR OR CORRECTION.
*/

class simpleChart {
    var    
        $data,              // chart data array
        $labels,            // horizontal labels 
        $verticalPoints,    // number of vertical axix point
        $maxValue,          // max value
        $title,             // chart title
        $barColors,         // color for every bar in chart
        $cellWidth = "14",
        $cellHeight = "10", 
        $scale;             // scale value 
        
        
    /**
    *    constructor
    *
    */
	
    function simpleChart($dataArray = null,$labelArray = null) {
		$newData = array();
		$newLabel = array();
		
		$baslangic = (int)$labelArray[0];
		$icIndex = 0;
 	    $newLabel[$icIndex] = $labelArray[0];
		$newData[$icIndex] = $dataArray[0];
 	    $icIndex++;	  
		
		for($i=1;$i<sizeof($dataArray);$i++) //kaç eleman var ise dön
		 {
		 	if ( (int)($labelArray[$i]) - $baslangic> 1) //en az 2 gün fark
			  {
				   for($j=0;$j<((int)($labelArray[$i]) - $baslangic - 1 );$j++){
					  if($j + 1 + (int)($baslangic)<10)  
					   $newLabel[$icIndex] = "0". ($j + 1 + (int)($baslangic));
					  else
					   $newLabel[$icIndex] = $j + 1 + (int)($baslangic);
					   
					   $newData[$icIndex] = 0;
					   $icIndex++;	  
				   }
				   
			   $newLabel[$icIndex] = $labelArray[$i];
			   $newData[$icIndex] = $dataArray[$i];
			   $icIndex++;	  
				   
			  }
			  elseif ( (int)($labelArray[$i]) - $baslangic == 1) {//1 gün fark varmýþ yani normal
			   $newLabel[$icIndex] = $labelArray[$i];
			   $newData[$icIndex] = $dataArray[$i];
			   $icIndex++;	  
			  } else { //negatif yani 2 - 31 gibi
	
    $last_month=date('m')-1;$year=date('Y');
	$timestamp = strtotime("$year-$last_month-01");    $number_of_days = date('t',$timestamp);
	
			    for($j=$baslangic;$j<$number_of_days;$j++){
					   $newLabel[$icIndex] = $j + 1 ;					   
					   $newData[$icIndex] = 0;
					   $icIndex++;	  					
				}
			    for($j=1;$j<(int)($labelArray[$i]);$j++){
					  if($j<10)  
					   $newLabel[$icIndex] = "0". ($j);
					  else
					   $newLabel[$icIndex] = $j ;					   
					   $newData[$icIndex] = 0;
					   $icIndex++;	  					
				}
				
			   $newLabel[$icIndex] = $labelArray[$i];
			   $newData[$icIndex] = $dataArray[$i];
			   $icIndex++;	  
				   
			  }
			
			$baslangic = (int)$labelArray[$i];
		 }
		 
        $this->data = ($newData);
        $this->labels = ($newLabel);
        $this->verticalPoints = sizeof($dataArray);
        return this;
    }            
   
    /**
    *    set data array
    *
    */    
    function setData($data) {
        $this->data = $data;
        $this->verticalPoints = sizeof($data);
    }
    
    /**
    *    set bar colors array
    *
    */
    function setBarColors($data) {
        $this->barColors = $data;
    }
   
    
    /**
    *    set chart title
    *
    */
    function setTitle($title) {
        $this->title = $title;
    }
        
    /**
    *    set max value of bars
    *
    */
    function setMaxValue($max) {
        $this->maxValue = $max;
        $this->scale =  ($this->maxValue / $this->verticalPoints);
    }
    
    /**
    *    retrun html chart title
    *
    */    
    function getTitleHtml($title) {
        return "<CAPTION class='chartTitle'>$title</CAPTION>";
    }
    
    /**
    *    return html chart$chart->verticalPoints = 10;
    *         
    *
    */
    function showChart() {
        $html = "<center><TABLE class=chartTable cellspacing=0 cellpadding=1  >";
        $html = $html . $this->getTitleHtml($this->title);
        // rows
        for($row = $this->verticalPoints;$row > 0;$row=$row -    1) {
            $html = $html . $this->getChartRow($row);
        }
        $html = $html . $this->showLabels();
        $html = $html . "</TABLE></center>";
        return $html;
    }
    
    /**
    *    return html with chart label
    *
    */
    function showLabels() {
        $html = "<TR><td>&nbsp;</td><TD>&nbsp;</TD>";
        for($i = 0;$i <= sizeof($this->data);$i++) {
          if (isset($this->labels[$i])) {
              $val = $this->labels[$i];
          } else {
              $val = $this->data[$i];
          }
          $html = $html . "<TD class=barLabel>$val</TD>";
        } 
        $html = $html . "</TR>";
        return $html;
    }
    
    /**
    *
    *
    */ 
    function showVerticalPointValue($value) {
		if($this->cellWidht > 0)		
        	return "<td>&nbsp;</td><TD class='vPoint' width=" . $this->cellWidht . ">$value</TD>";
			else
        	return "<td>&nbsp;</td><TD class='vPoint'>$value</TD>";
    }
    
    /**
    *    return html of chart row
    *
    */   
    function getChartRow($index) {
        $html = "<TR>";
        $verticalPointValue = round($index * $this->scale,1);
        $html = $html . $this->showVerticalPointValue($verticalPointValue);
        for($i = 0;$i <= sizeof($this->data);$i++) {
            $val = $this->data[$i];
            if ($val >= $verticalPointValue) {
                $html = $html . $this->showCell($i,'full');       
            } else {
                $html = $html . $this->showCell($i,'empty');       
            }
        }
        $html = $html . "</TR>";
        return $html;
    }    
   
    /**
    *    return html with  chart cell
    *
    */        
    function showCell($index,$type = 'empty',$val = "") {
        if ($index % 3 == 0) 
            $barColor = "brown";
		elseif ($index % 3 == 1) 
            $barColor = "maroon";
        else
            $barColor = "#440000";
		
        switch ($type) {
            case 'empty': { 
                    return "<TD class=emptyCell >&nbsp;</TD>";
            }
            case 'full' : { return "<TD class=dataCell style='background-color:$barColor;'>&nbsp;</TD>";
            }
        }
    }    
      
    
      
} // end class

    
      
      
?>