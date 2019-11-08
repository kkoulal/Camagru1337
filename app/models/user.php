<?php
  class User {
    private $db;
    public function __construct(){
      $this->db = new Database;
    }
    //Register user
    public function register($data){
      $this->db->query('INSERT INTO users (Username, email, password, token) VALUES(:Username, :email, :password, :token)');
      $this->db->bind(':Username', $data['Username']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);
       $this->db->bind(':token', $data['token']);
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }
      public function registerntoken($data){
      $this->db->query('UPDATE users set ntoken = :ntoken WHERE email = :email');
       $this->db->bind(':ntoken', $data['ntoken']);
       $this->db->bind(':email', $data['email']);
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }
    public function UploadEmail($data){
        $this->db->query('UPDATE users set email = :email  WHERE Username =:Username');
        $this->db->bind(':email', $data['Email']);
        $this->db->bind(':Username', $_SESSION['user_username']);
        if($this->db->execute()){
        return true;
        }else{
        return false;
        }
    }
    //Login User
    public function login($Username, $password){
      $this->db->query('Select * FROM users WHERE Username = :Username');
      $this->db->bind(':Username', $Username);
      $row = $this->db->single();
      $hashed_password = $row->password;
      if(password_verify($password, $hashed_password)){
          return $row;
      }else{
          return false;
      }
    }

    public function deleteprofile(){
      $this->db->query('DELETE FROM users WHERE email = :email');
      $this->db->bind(':email', $_SESSION['user_email']);
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }

      public function deleteimg(){
      
      $this->db->query('DELETE FROM camera WHERE user_id = :user_id');
      $this->db->bind(':user_id', $_SESSION['user_id']);
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }


    public function is_verified($Username){
      $this->db->query('SELECT is_verified FROM users WHERE Username = :Username');
      $this->db->bind(':Username', $Username);
     $row = $this->db->single();
     return $row;
    }
    // Find user by email
    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);
      $row = $this->db->single();
 
      // Check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }
    public function findUserByUsername($Username){
      $this->db->query('SELECT * FROM users WHERE Username = :Username');
      $this->db->bind(':Username', $Username);
      $row = $this->db->single();
 
      // Check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }
      public function UploadUsername($data){
        $this->db->query('UPDATE users set Username = :Username  WHERE email =:email');
        $this->db->bind(':Username', $data['Username']);
        $this->db->bind(':email', $_SESSION['user_email']);
        if($this->db->execute()){
        return true;
        }else{
        return false;
        }
      }
    
      public function ChangePassProfile($data){
        $this->db->query('UPDATE users set password = :password  WHERE email =:email');
        $this->db->bind(':email', $_SESSION['user_email']);
        $this->db->bind(':password', $data['password']);
      if($this->db->execute()){
        return true;
      }else{
        return false;
    }
  }
    public function confirm($data){
      
      $this->db->query('UPDATE users set is_verified = 1  WHERE token =:token');
      $this->db->bind(':token', $data);
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }

    public function nomoretoken($data){
      $this->db->query('UPDATE users set token = 0  WHERE token =:token');
      $this->db->bind(':token', $data);
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }

    public function nomorentoken(){
      $this->db->query('UPDATE users set ntoken = 0  WHERE ntoken =:ntoken');
      $this->db->bind(':ntoken', $_SESSION['ntoken']);
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }

    public function selecttoken($data){
      $this->db->query('SELECT token FROM users WHERE token =:token');
      $this->db->bind(':token', $data);
     $row = $this->db->single();
    
     return $row;
     
    }

    public function selecnttoken($data){
      $this->db->query('SELECT ntoken FROM users WHERE ntoken =:ntoken');
      $this->db->bind(':ntoken', $data['ntoken']);
     $row = $this->db->single();
     return $row;
    }





    public function UploadPassword($data){
        $this->db->query('UPDATE users set password = :password  WHERE ntoken =:ntoken');
        $this->db->bind(':ntoken', $data['ntoken']);
        $this->db->bind(':password', $data['password']);
      if($this->db->execute()){
        return true;
      }else{
        return false;
    }
  }


	public function setone(){
    $this->db->query("UPDATE users set notif = 1 WHERE id = :id ");
    $this->db->bind(':id', $_SESSION['user_id']);
    if($this->db->execute()){
      return true;
    }else{
      return false;
    }
  }


  public function ischecked(){
    $this->db->query("SELECT notif FROM users WHERE id = :id");
    $this->db->bind(':id', $_SESSION['user_id']);
    $row = $this->db->single();
    return $row;
  }



  public function deletealllikes(){
    $this->db->query("DELETE FROM likes WHERE user_id = :id");
    $this->db->bind(':id', $_SESSION['user_id']);
    if($this->db->execute()){
      return true;
    } else {
      return false;
    }
  }
  public function deleteallcomments(){
    $this->db->query("DELETE FROM comment WHERE user_id = :id");
    $this->db->bind(':id', $_SESSION['user_id']);
    if($this->db->execute()){
      return true;
    } else {
      return false;
    }
  }





  public function setzero(){
    $this->db->query("UPDATE users set notif = 0 WHERE id = :id ");
    $this->db->bind(':id', $_SESSION['user_id']);
    if($this->db->execute()){
      return true;
    }else{
      return false;
    }
  }
  
}