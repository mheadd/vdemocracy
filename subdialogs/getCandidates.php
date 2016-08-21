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

// Variable to hold output to be returned
$output1 = '';
$output2 = '';
$output3 = '';
$output4 = '';

try {

// Connect to database and execute query
$dsn = "$driver://$username:$password@$hostname/$database";
$dbConn = newADOConnection($dsn);
	
// Get a list of office names and numbers; used to tell voter what offices they can vote for
$sql = "SELECT DISTINCT off_name, off_num FROM `offices";
	
// Execute first query and populate array with results
$results = &$dbConn->GetArray($sql);
	
for ($i=0; $i<count($results); $i++) {
$output1 .= 'officeNumbers['.$i.'] = \''.$results[$i][1].'\';'."\n";
$output2 .= 'officeNames['.$i.'] = \''.$results[$i][0].'\';'."\n";
}

// Get a list of candidate names; used to confirm voter selections
$sql2 = "SELECT cand_num, cand_f_name, cand_l_name FROM offices";
	
// Execute second query and populate array with results
$results2 = &$dbConn->GetArray($sql2);
	
for ($i=0; $i<count($results2); $i++) {
$output3 .= 'candidates['.$results2[$i][0].'] = \''.$results2[$i][1].' '.$results2[$i][2].'\';'."\n";
}		
		
// Get a list of candidate names by office: used to list out selections to voter
$sql3 = "SELECT off_num, cand_f_name, cand_l_name FROM offices";
	
// Execute third query and populate array with results
$results3 = &$dbConn->GetArray($sql3);

$key = $results3[0][0];
$output4 = "officeList[$key] = new Array(";		
for ($i=0; $i<count($results3); $i++) {
if ($results3[$i][0] != $key) {
  $key = $results3[$i][0];
  $output4 .= ');'."\n";	
  $output4 .= "officeList[$key] = new Array(";
} 
elseif($i>0) {
  $output4 .= ", ";
}
  $output4 .= '\''.$results3[$i][1].' '.$results3[$i][2].'\'';
}
$output4 .= ');'."\n";	

$error = 0;
$dbConn->Close();
		
}


// If connection fails, return error
catch (Exception $e) {
	$error = 1;
}
	
header($vxml_content_type);
echo '<?xml version="1.0"?>';
?>

<vxml version = "2.0">
<var name="myError" expr="<?php echo $error; ?>"/>
<script>

var officeNumbers = new Array();
<?php echo $output1; ?>

var officeNames = new Array();
<?php echo $output2; ?>

var candidates = new Array();
<?php echo $output3; ?>

var officeList = new Array();
<?php echo $output4; ?>

</script>
<form id="first">
<block>
<return namelist="myError officeNames officeNumbers candidates officeList"/>
</block>
</form>
</vxml>
