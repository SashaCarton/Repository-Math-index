<?php
	# Function to connect to the database
	function connectToDatabase() {
		// Include the configuration file
		require('config.php');
		
		// Attempt to connect to the MySQL database
		try {
			// Create a PDO connection string
			$connection = new PDO("mysql:host=" . $server . ";dbname=" . $dbName, $user, $pass);
			
			// Set PDO error mode to exception
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			// Set default fetch mode to associative array
			$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			// Handle connection errors
			die('Error: ' . $e->getMessage());
		}
		
		return $connection;
	}
?>