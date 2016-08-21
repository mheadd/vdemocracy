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
@ $votes = explode("|",$_GET['voteString']);


try {

	// Connect to database
	$dsn = "$driver://$username:$password@$hostname/$database";
	$db_Conn = newADOConnection($dsn);
	
	for($i=0; $i<count($votes); $i++) {
		$temp = check($votes[$i]);
		
		// Build SQL query for offices table
		$sql = "UPDATE offices SET vote_total = vote_total+1 WHERE cand_num = $temp";
		$db_Conn->Execute($sql);
	}
	
	// Build SQL query to update vote_history table
	$sql2 = "UPDATE vote_history SET vote_finish = NOW() WHERE number IN (SELECT number FROM voters WHERE id = MD5($id) AND ani = $ani AND status = 0)";
	$db_Conn->Execute($sql2);
	
	// Build SQL query for voters table
	$sql3 = "UPDATE voters SET status = 1 WHERE id = MD5($id) AND ani = $ani AND status = 0";
	$db_Conn->Execute($sql3);
	
	$error = 0;
	$db_Conn->Close();

}

// Catch any exception in connecting to DB or executing query
catch (Exception $e) {
 	$error = 1;
}

header($vxml_content_type);
echo '<?xml version="1.0"?>';
?>

<vxml version = "2.0">
<var name="myError" expr="<?php echo $error; ?>"/>
<form id="first">
<block>
<return namelist="myError"/>
</block>
</form>
</vxml>
