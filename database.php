<?php
	$GLOBALS["servername"] = "localhost";
	$GLOBALS["username"] = "username";
	$GLOBALS["password"] = "password";
	$GLOBALS["database"] = "bulletin_board";
	$GLOBALS["table"] = "notes";

	
	function GetPosts()
	{
		// Variables
		$servername = $GLOBALS["servername"];
		$username   = $GLOBALS["username"];
		$password   = $GLOBALS["password"];
		$database   = $GLOBALS["database"];
		$table      = $GLOBALS["table"];
		
		// Connect to the MySQL server
		$con = new mysqli($servername, $username, $password);
		if(mysqli_connect_errno())
		{
			die("MySQL connection failed!");
		}
		
		// Connect to the database if exists, else: create database & connect to it
		if(!$con->select_db($database))
		{
			$con->query("CREATE DATABASE $database");
			
			if(!$con->select_db($database))
				die("Unknown problem with the database.");
		}
		
		// Make sure the table exists, if not: make it
		$con->query("
	    	CREATE TABLE IF NOT EXISTS $table (
	        	id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   	     	msg VARCHAR(2000),
      	  	date TIMESTAMP
    		)
		");
	
		// Finishing up
		$result = $con->query("SELECT * FROM $table");
		$con->close();
		return $result;
	}
	
	
	function WritePost($msg)
	{
		// Variables
		$servername = $GLOBALS["servername"];
		$username   = $GLOBALS["username"];
		$password   = $GLOBALS["password"];
		$database   = $GLOBALS["database"];
		$table      = $GLOBALS["table"];
		
		// Connect to the MySQL server
		$con = new mysqli($servername, $username, $password);
		if(mysqli_connect_errno())
		{
			die("MySQL connection failed!");
		}
		
		// Connect to the database if exists, else: create database & connect to it
		if(!$con->select_db($database))
		{
			$con->query("CREATE DATABASE $database");
			
			if(!$con->select_db($database))
				die("Unknown problem with the database.");
		}
		
		// Make sure the table exists, if not: make it
		$con->query("
	    	CREATE TABLE IF NOT EXISTS $table (
	        	id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   	     	msg VARCHAR(2000),
      	  	date TIMESTAMP
    		)
		");
		
		// Making sure no MySQL injection happens & send command
		$cmdo = $con->prepare("INSERT INTO $table (msg) VALUES(?)");
		$cmdo->bind_param('s', $msg);
		$cmdo->execute();
		
		// Finishing up
		$con->close();
	}
?>
