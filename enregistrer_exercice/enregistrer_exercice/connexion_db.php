<?php
	function connectToDatabase() {
		require('config.php');
		
		try {
			$connection = new PDO("mysql:host=" . $server . ";dbname=" . $dbName, $user, $pass);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			die('Error: ' . $e->getMessage());
		}
		
		return $connection;
	}
?>
