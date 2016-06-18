<?php
/*
+----------------------------------------------+
|                                              |
|       PHP MySQL Flood protection class       |
|                                              |
+----------------------------------------------+
| Filename   : flood-protection.php            |
| Created    : 19-Sep-05 3:48 GMT              |
| Created By : Sam Clarke                      |
| Email      : admin@free-webmaster-help.com   |
| Version    : 1.0                             |
|                                              |
|                                              |
| Modified   : 19-Sep-05 14:44 GMT             |
|         BY : Sam Clarke                      |
|                                              |
+----------------------------------------------+


+---------------------------------------+
|                                       |
|        MySQL sql to make tabke        |
|                                       |
+---------------------------------------+
|                                       |
| CREATE TABLE `floodprotection` (      |
|  `IP` char(32) NOT NULL default '',   |
|  `TIME` char(20) NOT NULL default '', |
|  PRIMARY KEY  (`IP`)                  |
| ) TYPE=MyISAM;                        |
|                                       |
+---------------------------------------+

LICENSE

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License (GPL)
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

To read the license please visit http://www.gnu.org/copyleft/gpl.html

*/

class flood_protection {

  var $secs = 1; // Number or secounds between a request
  
  var $keep_secs  = 600; // Number of secounds to keep the user registered

  // MySQL config
  var $host; // MySQl host
  var $password; // MySQL password
  var $username; // MySQL username
  var $db; // MySQL username
  var $link; // MySQl link

  // function to connect to MySQL
  function db_connect() {
    $this -> link = @mysqli_connect($this -> host, $this -> username, $this -> password, $this -> db); // connect to MySQL
    if(!$this -> link) { // test connection
      return false;
    }
    /* // select db and check it worked
    if(mysqli_select_db($this -> db)) {
      return true;
    } */
    return false;
  }

  // add user ip address to database
  function register_user($ip) {
    // insert ip and currnt time into database
    $result = mysqli_query($this -> link,'INSERT INTO `eo_floodprotection` (`IP`,`TIME`) VALUES(\' '. mysqli_real_escape_string( $ip, $this -> link ) . '\', \''. time() .'\') ');
    if(!$result) {
      return false;
    }
    return true;
  }

  // check to see if the user is flooding
  function check_request($ip) {
    if(!$this -> db_connect()) {
      return false; // if we cannot connect to db then return the user isnt flooding as we don't know
    }
    if($this -> user_in_db($ip)) { // find out if the user is in the db
      $return = $this -> user_flooding($ip); // if they are check if there flooding
      $this -> update_user($ip); // update there last request
      $this -> remove_old_users(); // remove the old users
      $this -> close_db(); // close db connection
      return $return; // return if there flooding or not
    } else {
      $this -> register_user($ip); // if there not in the db add them
      $this -> remove_old_users(); // remove the old users
      $this -> close_db(); // close db connection
      return false; // sonce there not in the db there not flooding so return false
    }
  }

  function user_in_db($ip) {
    // query db to see if there in
    $result = @mysqli_query($this -> link,'SELECT `TIME` FROM `eo_floodprotection` WHERE `IP` = \' '. mysqli_real_escape_string( $ip, $this -> link ) . '\' LIMIT 1');
    if(@mysqli_num_rows($result) > 0) { // if more than 0 records are returned there in
      return true;
    }
    return false; // other wise return false
  }

  function user_flooding($ip) {
    // query db to see if there flooding
    $result = @mysqli_query($this -> link,'SELECT `TIME` FROM `eo_floodprotection` WHERE `IP` = \' '. mysqli_real_escape_string( $ip, $this -> link ) . '\' AND `TIME` >= ' . (time() - $this ->  secs) . ' LIMIT 1');
    if(@mysqli_num_rows($result) > 0) { // if more than 0 records are returned there flooding
      return true;
    }
    return false; // other wise return false
  }

  function update_user($ip) {
    // query db to update the user last request
    $result = mysqli_query($this -> link,'UPDATE `eo_floodprotection` SET `TIME` = \'' . time() . '\' WHERE `IP` = \' '. mysqli_real_escape_string( $ip, $this -> link ) . '\'' );
  }
  
  function remove_old_users() {
    // Query db to remove all the old users
    mysqli_query($this -> link,'DELETE FROM `eo_floodprotection` WHERE `TIME` <= \'' . (time()- $this -> keep_secs) . '\'');
  }

  function close_db() {
    mysqli_close($this -> link);
  }
}

?>