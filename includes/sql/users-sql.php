<?php
class users{
	//Connection instance
	private $connection;
	
	//table name
	
	private $table_name = "users";
	
	//table columns
	public $user_id;
	public $user_name;
	public $image_number;
	
	public function __construct($connection){
		$this->connection = $connection;
	}
	
	//add username with photo number
	public function createWithNumber($name, $image){
		$query = "INSERT INTO anderson_images.users (user_name, image_number)
				VALUES (?,?)";
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam(1, $name);
		$stmt->bindParam(2, $image);
		try{
			$stmt->execute();
		}
		catch(PDOException $e){
			echo $stmt . $e->getMessage();
		}
		return $stmt;
	}
	
	//assign photo number to username
	public function setImage($name, $image){
		$query = "UPDATE anderson_images.users
					SET image_number = ?
					WHERE user_name = ?";
		$stmt = $this->connection->prepare($query);
		//bind variable values
		$stmt->bindParam(1,$image);
		$stmt->bindParam(2,$name);
		
		try{
		$stmt->execute();
		}
		catch(PDOException $e){
			echo $stmt . $e->getMessage();
		}
		return $stmt;
	}
	
	
	//retrieve photo number for username
	public function getImage($name){
		$query = "SELECT image_number, user_id, user_name
					FROM anderson_images.users
					WHERE user_name = ?";
		
		$stmt = $this->connection->prepare($query);
		
		$stmt->bindParam(1,$name);
		$stmt->execute();
		
		return $stmt;
	}
}

?>