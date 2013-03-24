<?php
require_once("db_class.php");
require_once("../../database.php");

#------ Database connection details -------------------------------------------#
$dbhost = $_host; // Most likely 'localhost', so you don't need to change this in most of cases
$dbuser = $_username; // Your MySQL username
$dbpass = $_password; // Your MySQL password
$dbname = $_db; // Your MySQL database name


#------ Create an instance of Sql class ---------------------------------------#
$sql = new Sql($dbhost, $dbuser, $dbpass, $dbname);

function temizle($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("'", "`", $metin);
    //$metin = str_replace('"', '¨', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "‹", $metin);
    $metin = str_replace(">", "›", $metin);
    $metin = trim(htmlentities($metin));
    return $metin;
}

?>