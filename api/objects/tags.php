<?php
class tags{
	//Connection instance
	private $connection;
	
	//table name
	
	private $table_name = "tags";
	
	//table columns
	public $tag_id;
	public $tag_names;
	public $tag_type;
	
	public function __construct($connection){
		$this->connection = $connection;
	}
	
	//Connection
	public function create($tag, $tagType){
		$query = "INSERT INTO anderson_images.tags (tag_names, tag_type)
				VALUES (?,?)";
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam(1, $tag);
		$stmt->bindParam(2, $tagType);
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
		
		$query= "SELECT tag_id, tag_names, tag_type FROM anderson_images.tags order by tag_id";
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	
	//get tag by type
	public function get_tag_by_type($tagType){
		if($tagType!='year'){
			$query="SELECT tag_id, tag_names, tag_type FROM tags where tag_type = ? order by tag_names";
		}
		else{
			$query="SELECT tag_id, tag_names, tag_type FROM tags where NOT tag_id 9999 AND tag_type = ? order by tag_names DESC";
		}
		$stmt = $this->connection->prepare($query);
		$stmt->bindParam(1,$tagType);
		try{
			$stmt->execute();
		}
		catch(PDOException $e){
			echo $stmt . $e->getMessage();
		}
		return $stmt;
		
	}
	
	public function get_tag_no_type(){
		$query = "SELECT * FROM anderson_images.tags where tag_type != 'individual' and tag_type != 'holiday' and tag_type != 'event' and tag_type != 'year'";
		$stmt = $this->connection->prepare($query);
		try{
			$stmt->execute();
		}
		catch(PDOException $e){
			echo $stmt . $e->getMessage();
		}
		return $stmt;
		
	}
	
	
	
	//get tag by id
	public function get_tag($id){
		//select query
		$query = "SELECT tag_id, tag_names, tag_type
					FROM anderson_images.tags
					WHERE tag_id = ?
					ORDER BY tag_names";
		//prepare query statement
		$stmt = $this->connection->prepare($query);
		
		//bind variable values
		$stmt->bindParam(1,$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
				
	}
	
	//get tags by contains
	public function search_tags($keywords, $type){
		//select query
		$query = "SELECT tag_id, tag_names, tag_type
					FROM anderson_images.tags
					WHERE tag_names LIKE ?
					AND tag_type LIKE ?
					ORDER BY tag_id";
		//prepare query statement
		$stmt = $this->connection->prepare($query);
		//sanitize keywords
		$keywords=htmlspecialchars(strip_tags($keywords));
		$keywords = "%{$keywords}%";
		$type=htmlspecialchars(strip_tags($type));
		$type = "%{$type}%";
		
		//bind variable values
		$stmt->bindParam(1,$keywords);
		$stmt->bindParam(2,$type);
		$stmt->execute();
		return $stmt;
				
	}
	
	
	//U
	public function update($tag, $ntag, $ntagType){
		$query = "UPDATE anderson_images.tags
					SET tag_names = ?, tag_type = ?
					WHERE tag_id = ?";
		$stmt = $this->connection->prepare($query);
		//bind variable values
		$stmt->bindParam(1,$ntag);
		$stmt->bindParam(2,$ntagType);
		$stmt->bindParam(3,$tag, PDO::PARAM_INT);
		
		try{
		$stmt->execute();
		}
		catch(PDOException $e){
			echo $stmt . $e->getMessage();
		}
		return $stmt;
	}
	//D
	public function delete(){
		
	}
}
?>