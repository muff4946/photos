<?php
class images{
	//Connection instance
	private $connection;
	
	//table name
	
	private $table_name = "imagesTest";
	
	//table columns
	public $image_id;
	public $image_hash;
	public $image_path;
	public $image_file;
	
	public function __construct($connection){
		$this->connection = $connection;
	}
	
	//Connection
	public function create(){
	}
	
	//R
	public function read(){
		$query= "SELECT image_id, image_hash, image_file,image_path 
				FROM anderson_images.images order by image_path";
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	//U
	public function update(){
	}
	//D
	public function delete(){
	}
	//searches by the image name given in the bar
	public function search_by_name($keywords){
		//select all query
		$query= "SELECT image_id, image_hash, image_file, image_path 
				FROM anderson_images.images 
				WHERE image_path LIKE ?
				ORDER BY image_path";
		//prepare query statement
		$stmt = $this->connection->prepare($query);
		//sanitize
		$keywords=htmlspecialchars(strip_tags($keywords));
		$keywords = "%{$keywords}%";
		
		//bind
		$stmt->bindParam(2, $keywords, $keywords);
		
		//execute query
		$stmt->execute();
		
		return $stmt;
	}


//read products with pagination
	public function readPaging($from_record_num, $records_per_page, $keywords){
		//select query
		$query = "SELECT image_id, image_hash, image_file,image_path 
					FROM anderson_images.images  
					WHERE image_file LIKE ?
					ORDER BY image_path, image_file
					LIMIT ?,?";
		//prepare query statement
		$stmt = $this->connection->prepare($query);
		
		//sanitize keywords
		$keywords=htmlspecialchars(strip_tags($keywords));
		$keywords = "%{$keywords}%";
		
		//bind variable values
		$stmt->bindParam(1,$keywords);
		$stmt->bindParam(2,$from_record_num,PDO::PARAM_INT);
		$stmt->bindParam(3,$records_per_page,PDO::PARAM_INT);
		
		//execute query
		$stmt->execute();
		
		//return values from database
		return $stmt;
	}

	//get image using id
	public function getImageById($id){
		//select query
		$query = "SELECT image_id, image_hash, image_file, image_path
					FROM anderson_images.images
					WHERE image_id = ?";
		//prepare query statement
		$stmt = $this->connection->prepare($query);
		
		//bind variable values
		$stmt->bindParam(1, $id);
		//execute query
		$stmt->execute();
		//return values from database
		return $stmt;
	}
	
	
	//used for paging products
	public function count($keywords){
		$query = "SELECT COUNT(*) as total_rows FROM images WHERE image_file LIKE ? COLLATE utf8_general_ci";
		$stmt = $this->connection->prepare( $query );
		
		$keywords=htmlspecialchars(strip_tags($keywords));
		$keywords = "%{$keywords}%";
		
		$stmt->bindParam(1, $keywords);
		
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//var_dump($row['total rows']);
		return $row['total_rows'];
		
	}
	
	
	
	
}

?>
