<?php

require_once('functions.php');

$tablename = TABLE;
$data = opendir('./DATA');
if (!$data) die('DATA directory not found');
$output = array(array());
$x = 0;

while ( FALSE !== ($dataset_name = readdir($data) ) ) {
	
	if ( !preg_match('/\./', $dataset_name )  ) {
		//this tests for anything containing a full-stop, and should exclude both . and .. 
		//as well as actual files (such as listing.txt);
		$dataset = opendir('./DATA/'.$dataset_name );
		if (!$dataset) die('Problem accessing dataset '.$dataset_name);
		
		while ( FALSE !== ($filename = readdir($dataset) ) ) {
			if ( $filename != '.' && $filename != '..') {
				$path = './DATA/'.$dataset_name.'/'.$filename;
				$output[$x]['filename'] = $filename;
				$output[$x]['path'] = $path;
				$output[$x]['condition'] = $dataset_name;
				$x++;
			}
		}
		
	}
		
}

//randomize the order of the array
shuffle($output);

$num_records = count($output);

$sql = new SimpleSql("TRUNCATE TABLE $tablename");

$sql->query_switch("INSERT INTO $tablename VALUES (?, ?, ?, ?, NULL)");

$sql->stmt->bind_param('isss', $x, $filename, $path, $condition);

for ($x = 0; $x < $num_records; $x++) {
	$filename =	$output[$x]['filename'];
	$path =	$output[$x]['path'];
	$condition = $output[$x]['condition'];
	$sql->stmt->execute();
	if ( $sql->stmt->errno > 0 ) {
		echo 'Record for '.$output[$x]['path'].
		' could not be inserted due to '.$db->error.'<br/>';
	} else {
		echo 'Record '.$output[$x]['path'].' inserted succesfully<br />';
	}
}

?>