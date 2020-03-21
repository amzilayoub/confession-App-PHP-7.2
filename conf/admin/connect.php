<?php
	$dsn = "mysql:host=localhost;dbname=testt";
	try{
		$connect = new PDO($dsn,'root','');
	} catch (PDOException $e) {
		echo $e;
	}