<?php

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
@ $ed = check(substr($_GET['ed'],0,3));
@ $offnum = check(substr($_GET['offnum'],0,3));

// If bad data passed, halt execution - this will cause a bad fetch error in the main dialog
if (!$ed || !$offnum) {
die;
}

// Variable to store grammar rules
$output = '';

try {

	// Connect to database and execute query
	$dsn = "$driver://$username:$password@$hostname/$database";
	$dbConn = newADOConnection($dsn);
	
	// Build SQL query
	$sql = "SELECT * FROM offices WHERE ed = $ed AND off_num = $offnum";
	
	// Execute first query and populate array with results
	$results = &$dbConn->GetArray($sql);
	
	for ($i=0; $i<count($results); $i++) {
	
		$output .= '<item>';
		$output .= $results[$i][4].' '.$results[$i][5];
		$output .= '<tag> <![CDATA[ <getVote "';
		$output .= $results[$i][2];
		$output .= '"> ]]> </tag>';
		$output .= '</item>'."\n";
		$output .= '<item>';
		$output .= $results[$i][5];
		$output .= '<tag> <![CDATA[ <getVote "';
		$output .= $results[$i][2];
		$output .= '"> ]]> </tag>';
		$output .= '</item>'."\n";
		
	$dbConn->Close();

}

}

// If connection fails, halt execution - this will cause a bad fetch error in the main dialog
catch (Exception $e) {
	die;
}
//header("Cache-Control: no-cache, must-revalidate");	
header($gram_content_type);
echo '<?xml version="1.0"?>';
?>
<grammar version="1.0" xml:lang="es-US" xmlns="http://www.w3.org/2001/06/grammar" root="primary">
<rule id="primary" scope="public">
<one-of>
<?php echo $output; ?>
<item>List<tag> <![CDATA[ <getVote "list"> ]]> </tag></item>
<item>Republican<tag> <![CDATA[ <getVote "inv"> ]]> </tag></item>
<item>Democrat<tag> <![CDATA[ <getVote "inv"> ]]> </tag></item>
<item>Democratic<tag> <![CDATA[ <getVote "inv"> ]]> </tag></item>
<item>Independent<tag> <![CDATA[ <getVote "inv"> ]]> </tag></item>
</one-of>
</rule>

</grammar> 
