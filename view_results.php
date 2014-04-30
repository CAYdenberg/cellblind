<?php

require_once('functions.php');

$tablename = TABLE;

$results = array();

if (!$directory = opendir('./DATA')) die('Data not found');

$num = 0;

$x = 1;

$sql = new SimpleSql("SELECT ID FROM $tablename WHERE `condition` = ? AND result = ?");
$sql->stmt->bind_param('si', $dataset_name, $x);

while (FALSE !== ($dataset_name = readdir($directory))){
	if ( !preg_match('/\./', $dataset_name )  ) {
		$results[$dataset_name] = array();
		for ($x = 1; $x <= 3; $x++) {
			$sql->stmt->execute();
			$result = $sql->stmt->get_result();
			$num = $result->num_rows;
			$results[$dataset_name][$x] = $num;
		}
	}
}

$fh = fopen(FILE, 'w');

fwrite($fh, "Condition\tRobust cables\tFewer or thinner cables\tDisorganized cables".PHP_EOL);

foreach ($results as $dataset_name => $result) {
	fwrite($fh, $dataset_name);
	for ($x = 1; $x <= 3; $x++) {
		fwrite($fh, "\t".$result[$x]);
	}
	fwrite($fh, PHP_EOL);
}

fclose($fh);

echo "Results succesfully written to ".FILE;

?>