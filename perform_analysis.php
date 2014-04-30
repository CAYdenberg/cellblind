<?php
/*
Set up a new analysis (usr, analysis name, data_dir)
	- randomize the order of the filenames
	- create a database with unique id (random) filenames, results, datasets + metadata

Perform the analysis sequentially
	- pull record from the database sequentially, user assigns a category to each image, return the category via AJAX and put into the database
	- upon successful AJAX call, pull the next record

View the results
	- read in dataset names and categories, calc % of cells in each category, 
	display as a chart
*/


require_once('functions.php');

$tablename = TABLE;

$sql = new SimpleSql("SELECT MIN(ID), path FROM $tablename WHERE result IS NULL");

$image = $sql->resultset[0]['path'];

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="Double-blind system for qualitative cell biological phenotypes">
  <meta name="author" content="Casey A. Ydenberg">
  <link href = "css/normalize.css" rel = "stylesheet" type = "text/css">
  <link href = "css/main.css" rel = "stylesheet" type = "text/css">
  <script src = "js/jquery.js" type = "text/javascript"></script>
  <!--replace line above with CDN upon shipping-->
  <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
  <script src = "js/scripts.js" type = "text/javascript"></script>
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
<div id = "container">
	<div class = "cell">
		<img src = "<?php echo $image; ?>" id = "currentCell" />
	</div>
	
	<div id = "choose">
		<form action = "index.php" id = "recordCat" />
			<input id = "btnCat1" class = "btnCat" type = "radio" name = "category" value = "class1" />
			<img src = "./img/cat1.jpg" id = "imgCat1" class = "imgCat" />	
	
			<input id = "btnCat2" class = "btnCat" type = "radio" name = "category" value = "class2" />
			<img src = "./img/cat2.jpg" id = "imgCat2" class = "imgCat" />
			
			<input id = "btnCat3" class = "btnCat" type = "radio" name = "category" value = "class3" />
			<img src = "./img/cat3.jpg" id = "imgCat3" class = "imgCat" />
	
			<input type = "submit" value = "Submit" id = "catSubmit" disabled = "disabled" />
		</form>
	</div>
	
</div>

</body>