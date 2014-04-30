<?php

require_once('config.php');

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
class SimpleSql(string $query)
$query is an Sql query, either basic or prepared statement.

If the query contains a '?', the constructor will not execute the query
(even in cases where ? is quoted).

Parameters can then be bound and the query executed by the encapsulating code.
Properties:
$db - the database (mysqli)
$stmt - the statement (mysqli::statement)
$resultset - An array of SQL rows, represented as an associative array.

The database is simply closed in the destructor.
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
class SimpleSql {
	public $db, $stmt, $resultset, $num_rows, $affected_rows;
	function __construct($query) {
		//Create $db property
		$this->db = new mysqli(HOST, USR, PWD, DB);
		if ( $this->db->connect_errno > 0 ){
			throw new Exception("Problem connecting to database: ". $this->db->connect_error);
		}
		//Create $stmt property
		if (!$this->stmt = $this->db->prepare($query)) {
			throw new Exception('Query not validated. MySQL error '.$this->db->error);
		}
		//Create resultset
		return $this->retrieve($query);
	}
	
	function __destruct() {
		$this->stmt->close();
		$this->db->close();
	}
	
	//this method is used to switch queries without closing
	//and reopening the database
	function query_switch($query) {
		$this->stmt->close();
		if (!$this->stmt = $this->db->prepare($query)) {
			throw new Exception('Query not validated. MySQL error '.$db->error);
		}
		return $this->retrieve($query);
	}
	
	//if this is a prepared statement, perform no query and return FALSE
	//if it is not a prepared statement, execute the query. Further if results
	//are returned by the query, store results in a 2-dimensional array
	function retrieve($query) {
		//Check if this is a prepared statement
		if (strpos($query, '?') === FALSE){		
			if (!$this->stmt->execute()){
				throw new Exception('Query not executed. MySQL error '.$this->db->error);
			}
			//if get_result works (ie, this is a retrieve statement),
			//then go ahead and create the $resultset property
			if ($result = $this->stmt->get_result()) {	
				$this->num_rows = $result->num_rows;		
				while ($row = $result->fetch_assoc()) {
					$this->resultset[] = $row;
				}
			} else {
				$affect_rows = $this->stmt->affected_rows;
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

//simple object to store information to be sent back to Javascript
class Response {
	public $msg, $new;
	function __construct() {
		$this->msg = '';
	}
}
?>