<?php

/*
* Vocal Democracy is licensed under a Creative Commons License
* To review this license, go to http://creativecommons.org/licenses/by-nc-sa/2.5/
*/


// Include database connection classes and credentials
include('../config.php');
include('../adodb/adodb.inc.php');
include("../adodb/adodb-exceptions.inc.php");

// Check refering page against host
if ($check_host) {
	if($_SERVER['REMOTE_ADDR'] != $host) {
		die;
	}	
}


// Catch and scrub variables submitted with subdialog request
@ $session = sessionCheck($_GET['session_id']);
@ $cutoff = check($_GET['cutoff']);
@ $status = check($_GET['status']);
@ $ed = check($_GET['ed']);
@ $rd = check($_GET['rd']);
@ $sd = check($_GET['sd']);
@ $error = check($_GET['theError']);
@ $noinput = check($_GET['numNoInput']);
@ $nomatch = check($_GET['numNoMatch']);
@ $length = check($_GET['callLength']);

try {

// Don't log the call is a session ID not provided 
if (strlen($session)==0) {
	throw new Exception("Invalid Call ID submitted"); 
}

	// Connect to database
	$dsn = "$driver://$username:$password@$hostname/$database";
	$db_Conn = newADOConnection($dsn);
	
	// Build SQL query for voters table
	$sql =  "INSERT INTO call_logs (log_time,session_id,cutoff,status,ed,rd,sd,error,noinput,nomatch,call_length) 
	   		 VALUES (NOW(),".'\''."$session".'\''.",$cutoff,$status,$ed,$rd,$sd,$error,$noinput,$nomatch,$length)";
	
	// Execute query
	$db_Conn->Execute($sql);

	$error = 0;
	
	// Close connection
	$db_Conn->Close();

}

// Catch any exception in connecting to DB or executing queries
catch (Exception $e) {
 	$error = 1;
}

header($vxml_content_type);
echo '<?xml version="1.0"?>';
?>

<vxml version = "2.0">
<var name="myError" expr="<?php echo $error;  ?>"/>
<form id="first">
<block>
<if cond="myError==1">
<log>*** An error occured while writing the call record for: <?php echo $session ?>. ***</log>
<else/>
<log>*** Call logging compelte. ***</log>
</if>
<exit/>
</block>
</form>
</vxml>
