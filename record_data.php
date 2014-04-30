<?php

require_once('functions.php');

$tablename = TABLE;

//get needed data from POST
$ajax_cat = $_POST['category'];
$cat = preg_replace('/\w+(\d)/', '$1', $ajax_cat);
$path = $_POST['currentCell'];

$response = new Response();

//validate $cat
if (!$cat = intval($cat)) {
	$response->msg = 'Bad query sent, data not recognized';
} else if ($cat > 3 || $cat < 1) {
	$response->msg = 'Bad query sent, category must be between 0 and 4';
} else {	

	//data validated.
	//send it to the database
	
	$sql = new SimpleSql("UPDATE $tablename SET result = ? WHERE path = ?");
	$sql->stmt->bind_param('is', $cat, $path);
	$sql->stmt->execute();

	if ($sql->db->errno > 0) {
		$response->msg = 'Query could not be executed. See server log';
	} else {
		$sql->query_switch("SELECT MIN(ID), path FROM $tablename WHERE result IS NULL");
		if ($sql->num_rows > 0){
			$response->new = $sql->resultset[0]['path'];
		} else {
			$response->msg = 'end';
		}
	}
	
}

$response_str = json_encode($response);

echo $response_str;

?>