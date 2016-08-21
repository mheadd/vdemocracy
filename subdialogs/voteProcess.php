<?php

/*
* Vocal Democracy is licensed under a Creative Commons License
* To review this license, go to http://creativecommons.org/licenses/by-nc-sa/2.5/
*/


include('../config.php');

// Check refering page against host
if ($check_host) {
	if($_SERVER['REMOTE_ADDR'] != $host) {
		die;
	}	
}

// Make sure you know where PHP is storing temporary upload files, see upload_tmp_dir in php.ini file

@ $pre = $_POST['prePend'];
@ $id = $_POST['call_id'];
@ $myFile = $_FILES['wavVote']['tmp_name'];

$fileName = $audioDest.$pre.'_'.$id.'.wav';

if(@move_uploaded_file($myFile, $fileName)) {
	$result=1;
}
else {	
	$result=2;
}

header('Content-type: text/xml');
echo '<?xml version = "1.0"?>';
?>
<vxml version = "2.0">
<var name="result" expr="<?php echo $result; ?>"/>
<form id="first">
<block>
<return namelist="result"/>
</block>
</form>

</vxml>