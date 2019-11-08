<?php
  class camera {
    private $db;
    public function __construct(){
      $this->db = new Database;
    }

    //function to link database

    public function insertPhoto($file){
    	if(isset($_SESSION['user_id']))
		  $this->db->query('INSERT INTO camera (user_id,url) VALUES(:user_id, :url)');
	      $this->db->bind(':user_id', $_SESSION['user_id'] );
	      $this->db->bind(':url', $file);
	      if($this->db->execute()){
   	     	return true;
   	     }else{
   	     	return false;
   	   }
   	 }

   	public function fetchall_pic_1user(){
   		$this->db->query('SELECT * FROM camera WHERE user_id = :User_id order by created_at DESC');
   		$this->db->bind(':User_id', $_SESSION['user_id']);
		$results = $this->db->resultSet();
    	return $results;
   	}


   	   	public function fetchall_pic($page){
   		$this->db->query('SELECT * FROM camera order by created_at DESC limit :page,5');
   		$this->db->bind(':page', $page);
		$results = $this->db->resultSet();
    	return $results;
   	}

   	public function postcount(){
   		$this->db->query('SELECT * FROM camera');
   		$row = $this->db->single();
   		$results = $this->db->rowCount();
   		return $results;
		 }

	// public function get_img_id(){
	// 	$this->db->query('SELECT id FROM camera');
	// }



	public function likes($img_id){
		$this->db->query('INSERT INTO likes (img_id, user_id) VALUES(:img_id, :session)');
		$this->db->bind(':img_id', $img_id);
		$this->db->bind(':session', $_SESSION['user_id']);
		if($this->db->execute()){
		  return true;
		}else{
		  return false;
		}
	  }

	public function isliked($img_id){
	  	$this->db->query("SELECT * FROM likes WHERE user_id = :session AND img_id = :img_id");
		$this->db->bind(':img_id', $img_id);
		$this->db->bind(':session', $_SESSION['user_id']);
		$res = $this->db->single();
		if($this->db->rowCount() > 0){
		  return true;
		} else {
			return false;
		}
	}

	public function unliked($img_id){
		$this->db->query("DELETE FROM likes WHERE user_id = :session AND img_id = :img_id");
		$this->db->bind(':img_id', $img_id);
		$this->db->bind(':session', $_SESSION['user_id']);
		if($this->db->execute()){
		  return true;
		} else {
		return false;
		}
	}

	public function nublikes($img_id){
		$this->db->query("SELECT * FROM likes WHERE img_id = :img_id");
		$this->db->bind(':img_id', $img_id);
		$row = $this->db->single();
   	$results = $this->db->rowCount();
   	return $results;

	 }


	public function registercomment($comment,$img_id){
		$this->db->query('INSERT INTO comment (user_id, img_id, comment) VALUES(:user_id, :img_id, :comment)');
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$this->db->bind(':img_id', $img_id);
		$this->db->bind(':comment', $comment);
		if($this->db->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function dltimg($idimg){
      
		$this->db->query('DELETE FROM camera WHERE id = :id');
		$this->db->bind(':id', $idimg);
		if($this->db->execute()){
			return true;
		}else{
			return false;
		}
	}


	public function fetchall_comments($img_id){
		$this->db->query('SELECT comment, Username FROM comment left join users on users.id = comment.user_id WHERE img_id = :img_id order by comment.created_at desc');
		$this->db->bind(':img_id', $img_id);
 		$results = $this->db->resultSet();
	 	return $results;
	}

	
  public function ischecked($img_id){
    $this->db->query("SELECT notif,email FROM users left join camera ON users.id = camera.user_id WHERE camera.id = :img_id");
    $this->db->bind(':img_id', $img_id);
    $row = $this->db->single();
    return $row;
  }

}
