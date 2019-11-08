<?php
class setup extends Database {
    private $db;
public function __construct()
    {
       try{
            $this->db= new PDO('mysql:host=' . DB_HOST, 'root', 'test');
            }catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        $this->db->exec("CREATE DATABASE IF NOT EXISTS camagru;
                use camagru;

                CREATE table users(
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                Username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                is_verified int(11) NOT NULL DEFAULT '0',
                token VARCHAR(255) NOT NULL DEFAULT '0',
                created_at datetime DEFAULT CURRENT_TIMESTAMP,
                ntoken VARCHAR(255) NOT NULL DEFAULT '0',
                notif int(11) NOT NULL DEFAULT '1');


                CREATE table camera(
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                user_id int(11) NOT NULL,
                url VARCHAR(255) NOT NULL,
                created_at datetime DEFAULT CURRENT_TIMESTAMP);


                CREATE table likes(
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                img_id int(11) NOT NULL,
                user_id int(11) NOT NULL);
                


                CREATE table comment(
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                user_id int(11) NOT NULL,
                img_id int(11) NOT NULL,
                comment text NOT NULL,
                created_at datetime DEFAULT CURRENT_TIMESTAMP);
");
        
    }
 }
$install = new setup;