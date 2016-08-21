<?php

/*
* Vocal Democracy is licensed under a Creative Commons License
* To review this license, go to http://creativecommons.org/licenses/by-nc-sa/2.5/
*/


/****************************************************************
* Type of database driver used
* see http://phplens.com/adodb/index.html for more information
* Example: $driver = 'postgres';
****************************************************************/
$driver = 'mysql';


/**************************************************************** 
* Database connection credentials
****************************************************************/
$username = '';
$password = '';


/****************************************************************
* Host name and DB name
****************************************************************/
$hostname = '';
$database ='voice_vote';


/****************************************************************
* Set to true to check IP address of referring page
****************************************************************/
$check_host = false;


/****************************************************************
* IP address of the VoiceXML platform that will access PHP scripts
* Example: $host = '132.4.15.1';
****************************************************************/
$host = $_SERVER['SERVER_ADDR'];


/****************************************************************
* Location to store audio files; store outside of web diretory
* where PHP scripts can not be executed
* Example: '/my/safe/dir/audio'
****************************************************************/
$audioDest = '../utterances/';


/****************************************************************
* MIME type for VoiceXML content
****************************************************************/
$vxml_content_type = 'Content-type: application/voicexml+xml';
//$vxml_content_type = 'Content-type: text/xml';


/****************************************************************
* MIME type for GRXML content
****************************************************************/
$gram_content_type = 'Content-type: application/grammar+xml';
//$gram_content_type = 'Content-type: text/xml';


/****************************************************************
* Function to filter input; just convert to an integer ;-)
****************************************************************/
function check($a) {
  return (int) $a; 
}


/****************************************************************
* Function to filter session_id in logCall subdialog
* Modify as needed to conform to the database type being used
* or roll your own custom filter
****************************************************************/
function sessionCheck($sess) {

  //return pg_escape_string($sess);
  return mysql_escape_string($sess);

}

?>
