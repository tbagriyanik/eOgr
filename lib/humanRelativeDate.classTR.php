<?php

/*

Human Friendly dates by Invent Partners
We hope you enjoy using this free class.
Remember us next time you need some software expertise!
http://www.inventpartners.com

*/

class HumanRelativeDate{

	private $current_timestamp;
	private $current_timestamp_day;
	private $event_timestamp;
	private $event_timestamp_day;
	private $calc_time = false;   // Are we going to do times, or just dates?
	private $string = 'now';
	
	private $magic_5_mins = 300;
	private $magic_15_mins = 900;
	private $magic_30_mins = 1800;
	private $magic_1_hour = 3600;
	private $magic_1_day = 86400;
	private $magic_1_week = 604800;
	
	public function __construct(){
	
		$this->current_timestamp = time();
		$this->current_timestamp_day = mktime(0,  0 ,  0 , $month = date("n") , $day = date("j") , date("Y"));
	
	}
	
	public function getTextForSQLDate($sql_date){
		
		// Split SQL date into date / time
		@list($date , $time) = explode(' ' , $sql_date);
		// Split date in Y,m,d
		@list($Y,$m,$d) = explode('-' , $date);
		// Check that this is actually a valid date!
		if(@checkdate($m , $d , $Y)){
			// If we have a time, then we can show relative time calcs!
			if(isset($time) && $time){
				$this->calc_time = true;
				// Split tim in H,i,s
				@list($H,$i,$s) = explode(':' , $time);
			} else {
				$this->calc_time = false;
				$H=12;
				$i=0;
				$s=0;
			}
			// Set the event timestamp
			$this->event_timestamp = mktime($H, $i , $s , $m , $d , $Y);
			$this->event_timestamp_day = mktime(0 , 0 , 0 , $m , $d , $Y);
			
			//Get the string
			$this->getString();
		} else {
			$this->string = 'geçersiz tarih';
		}
		
		return $this->string;
		
	}
	
	public function getString(){
		
		// Is this today
		if($this->event_timestamp_day == $this->current_timestamp_day){
			if($this->calc_time){
				$this->calcTimeDiffString();
				return true;
			} else {
				$this->string = 'bugün';
				return true;
			}
		} else {
			$this->calcDateDiffString();
			return true;
		}
	
	}

	protected function calcTimeDiffString(){
	
		$diff = $this->event_timestamp - $this->current_timestamp;
	
		// Future events
		if($diff > 0){
			if($diff < $this->magic_5_mins){
				$this->string = 'þimdi';
			} else if ($diff < $this->magic_15_mins){
				$this->string = 'birkaç dakika içinde';
			} else if ($diff < $this->magic_30_mins){
				$this->string = 'yarým saat içinde';
			} else if ($diff < $this->magic_1_hour){
				$this->string = 'sonraki saat içinde';
			} else {
				$this->string = 'bugün saat ' . date('H:i' , $this->event_timestamp);
			}
		}
		// Past Events
		else {
			$diff = abs($diff);
			if($diff < $this->magic_5_mins){
				$this->string = 'henüz þimdi';
			} else if ($diff < $this->magic_15_mins){
				$this->string = 'birkaç dakika önce';
			} else if ($diff < $this->magic_30_mins){
				$this->string = 'yarým saat içinde';
			} else if ($diff < $this->magic_1_hour){
				$this->string = 'bir saat içinde';
			} else  if ($diff < ($this->magic_1_hour * 2)){
				$this->string = 'bir saat önce';
			} else {
				$this->string = floor($diff / $this->magic_1_hour) . ' saat önce';
				//$this->string = 'today at ' . date('H:i' , $this->event_timestamp);
			}
		
		}
	
	}
	
	protected function trGun($gelen){
				switch ($gelen){
				 case 'Monday':
					return 'pazartesi' ;
					break;
				 case 'Tuesday':
					return 'salý' ;
					break;
				 case 'Wednesday':
					return 'çarþamba' ;
					break;
				 case 'Thursday':
					return 'perþembe' ;
					break;
				 case 'Friday':
					return 'cuma' ;
					break;
				 case 'Saturday':
					return 'cumartesi' ;
					break;
				 case 'Sunday':
					return 'pazar' ;
					break;					
				}		
	}
	
	protected function calcDateDiffString(){
	
		$diff = $this->event_timestamp_day - $this->current_timestamp_day;
	
		// Future events
		if($diff > 0){
			//Tomorrow
			if($diff >= $this->magic_1_day && $diff < ($this->magic_1_day * 2)){
				$this->string = 'yarýn'; 
				return true;
			} else if($diff <= $this->magic_1_week){
				// Find out if this date is this week or next!
				$current_day = date('w' , $this->current_timestamp_day);
				if($current_day == 0){
					$current_day = 7;
				}
				$event_day = date('w' , $this->event_timestamp_day);
				if($event_day == 0){
					$event_day = 7;
				}
				if($event_day > $current_day){
					$this->string = 'bu ' . $this->trGun(date('l' , $this->event_timestamp_day));
				} else {
					$this->string = 'gelecek ' . $this->trGun(date('l' , $this->event_timestamp_day));
				}
			} else if($diff <= ($this->magic_1_week * 2) ) {
				$this->string = 'gelecek hafta içinde ' . $this->trGun(date('l' , $this->event_timestamp_day));
			} else {
				$month_diff = $this->calcMonthDiff();
				if($month_diff == 0){
					$this->string = 'bu ay sonunda';
				} else if($month_diff == 1){
					$this->string = 'gelecek ay';
				} else {
					$this->string = ' ' . $month_diff . ' ay içinde';
				}
			}
		} 
		// Historical events
		else {
			$diff = abs($diff);
			//Tomorrow
			if($diff >= $this->magic_1_day && $diff < ($this->magic_1_day * 2)){
				$this->string = 'dün'; 
				return true;
			} else if($diff <= $this->magic_1_week){
				$this->string = 'geçen '.$this->trGun(date('l' , $this->event_timestamp_day)) ;
			} else if($diff <= ($this->magic_1_week * 2) ) {
				$this->string = 'bir hafta önce ';
			} else {
				$month_diff = $this->calcMonthDiff();
				if($month_diff == 0){
					$this->string = 'bu ay içinde';
				} else if($month_diff == 1){
					$this->string = 'geçen ay';
				} else {
					if($month_diff > 12){
						$this->string = 'bir yýldan önce';
					} else {
						$this->string = $month_diff . ' ay önce';
					}
				}
			}
			
		}
	
	}
	
	protected function calcMonthDiff(){
		
		$event_month = intval( (date('Y' , $this->event_timestamp_day) * 12) + date('m' , $this->event_timestamp_day));
		$current_month = intval( (date('Y' , $this->current_timestamp_day) * 12) + date('m' , $this->current_timestamp_day));
		$month_diff = abs($event_month - $current_month);
		return $month_diff;
	
	}

}

?>