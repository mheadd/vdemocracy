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
@ $id = check(substr($_GET['id'],0,9));
@ $areaCode = check(substr($_GET['ani'],0,3));
@ $number = check(substr($_GET['ani'],3,7));
@ $ani = $areaCode.$number;


try {

	// Connect to database
	$dsn = "$driver://$username:$password@$hostname/$database";
	$db_Conn = newADOConnection($dsn);
	
	// Build SQL query for voters table
	$sql1 = "SELECT * FROM voters WHERE id = MD5($id) AND ani = $ani AND status = 0";
	
	// Execute first query and populate array with results
	$results = &$db_Conn->GetArray($sql1);
	$count = count($results);
	
 switch ($count) {

 	// No records found
	case 0:	
	 $error = 2;
	 $nm = 0;
	 $ed = '';
	 $rd = '';
	 $sd = '';
	break;
	
	// One record found for the voter, this is good!	
	case 1:
	 $error = 0;
	 $nm = $results[0][0];
	 $ed = $results[0][5];
	 $rd = $results[0][6];
	 $sd = $results[0][7];
	break;
	
	// Multiple records found, this is not good!	
	default:
	 $error = 3;
	 $nm = 0;
	 $ed = '';
	 $rd = '';
	 $sd = '';
 }
	
	// Build SQL query to update vote_history table
	$sql2 = "UPDATE vote_history SET attempts = attempts+1, vote_try = NOW() WHERE number = $nm";
	
	// Execute second query
	$db_Conn->Execute($sql2);
	
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
<var name="myError" expr="<?php echo $error; ?>"/>
<var name="myED" expr="<?php echo $ed; ?>"/>
<var name="myRD" expr="<?php echo $rd; ?>"/>
<var name="mySD" expr="<?php echo $sd; ?>"/>
<form id="first">
<block>
<return namelist="myError myED myRD mySD"/>
</block>
</form>
</vxml>
