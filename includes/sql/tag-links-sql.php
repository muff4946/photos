<?php
class tag_links{
	//Connection instance
	private $connection;
	
	//table name
	
	private $table_name = "tag_links";
	
	//table columns
	public $link_id;
	public $image_id;
	public $tag_id;
	
	
	//Connection
	public function __construct($connection){
		$this->connection = $connection;
	}
	
	
	public function create($tag, $image){
		$query = "INSERT INTO anderson_images.tag_links (image_id, tag_id)
				VALUES (?,?)";
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam(1, $image);
		$stmt->bindParam(2, $tag);
		try{
			$stmt->execute();
		}
		catch(PDOException $e){
			echo $stmt . $e->getMessage();
		}
		return $stmt;
	}
	
	//R
	public function read(){
		//ask dad about table name and order
		$query= "SELECT link_id, image_id, tag_ids FROM anderson_images.tag_links order by link_id";
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	
	//get tags by image (filtering out 9999 for viewing)
	public function tagsByImage4View($image){
		$query = "SELECT link_id, image_id, tag_id
					FROM anderson_images.tag_links
					WHERE image_id LIKE ?
					AND NOT tag_id = 9999
					ORDER BY tag_id";
		
		$stmt = $this->connection->prepare($query);
		
		$stmt->bindParam(1,$image);
		$stmt->execute();
		
		return $stmt;
	}
	
	//get tags by image (leaving in 9999 for editing)
	public function tagsByImage4Edit($image){
		$query = "SELECT link_id, image_id, tag_id
					FROM anderson_images.tag_links
					WHERE image_id LIKE ?
					ORDER BY tag_id";
		
		$stmt = $this->connection->prepare($query);
		
		$stmt->bindParam(1,$image);
		$stmt->execute();
		
		return $stmt;
	}
	
	//get images by tag
	public function imagesByTag($tag){
		$query = "SELECT link_id, image_id, tag_id
					FROM anderson_images.tag_links
					WHERE tag_id LIKE ?
					ORDER BY image_id";
		
		$stmt = $this->connection->prepare($query);
		
		$stmt->bindParam(1,$tag,PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt;
	}
	
	//U
	public function update(){
	}
	
	//D
	public function deleteIt($tag, $image){
		$query = "DELETE FROM anderson_images.tag_links 
					WHERE tag_id= ? AND image_id = ?";
		$stmt = $this->connection->prepare($query);
		
		$stmt->bindParam(1,$tag,PDO::PARAM_INT);
		$stmt->bindParam(2,$image);
		try{
			$stmt->execute();
		}
		catch(PDOException $e){
			echo $stmt . $e->getMessage();
		}
		return $stmt;
		
	}
}
?>