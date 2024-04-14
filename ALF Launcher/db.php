<?php
define('DB_SERVER', '213.246.45.224:3306');
define('DB_USERNAME', 'paneladmin');
define('DB_PASSWORD', 'Ls8Vy8R4Ahm7');
define('DB_DATABASE', 'armalife');

class DB_con {
	public $connection;
	function __construct(){
		$this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		
		if ($this->connection->connect_error) die('Database error -> ' . $this->connection->connect_error);
		
	}
	
	function ret_obj(){
		return $this->connection;
	}

}
