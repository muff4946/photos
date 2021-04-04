<?php
class DBClass { 

	private $db_host = 'localhost';
	private $db_user = 'images';
	private $db_pwd = 'F0t0b0mb';
	private $db_name = 'anderson_images';

	public $conn;
	
	public function getConnection(){
		
		$this->connection = null;
		try{
			$this->connection = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_pwd);
			$this->connection->exec("set names utf8");
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
		}
		
		return $this->connection;
	}
}	

?>