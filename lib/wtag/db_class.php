<?php
class Sql {
          
var $conn; 
var $host;
var $user;
var $pass;
var $db;
var $result;
var $lastid;
        
        
	
// Constructor
function Sql($host, $user, $pass, $db) {
    
    $this->host=$host;
    $this->user=$user;
    $this->pass=$pass;
    $this->db=$db;
    $this->conn = @mysqli_connect($this->host, $this->user, $this->pass, $this->db );
	mysqli_set_charset($this -> conn, 'utf8'); 
    //@mysqli_select_db($this->db, $this->conn);
    
} 


// Perform query
function query($query) {
    
    if(!$this->result = @mysqli_query($this->conn,$query)) {
    return false;
    }
    
    else
    return true;
	
}


// Count rows
function count_rows($result) {
		
    return @mysqli_num_rows($this->result);
	
}


// Fetch row
function fetch_row() {
		
    return @mysqli_fetch_array($this->result, MYSQLI_ASSOC);
	
}
	
	
// Get the id for the last inserted row
function get_id() {
   
    $this->lastid = @mysqli_insert_id($this->conn);
    return  $this->lastid;
	
}

//End of the class
}
?>