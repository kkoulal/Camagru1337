<?php
	class Pages extends Controller{
		public function __construct(){
		
      	$this->cameraModel = $this->model('camera');
			
		}

		
		public function index(){
			if(isset($_SESSION['user_id']))
          		redirect("pages/gallerie");
			$page = 0;
			if(isset($_POST["page"]))
			  {
				  $page= $_POST["page"];
				  $page= ($page*5)-5;
			  }
			  
			$images = $this->cameraModel->fetchall_pic($page);
			$data = [
			   'images' => $images
			   
			   ];
		   
			$this->view('pages/index',$data);
		}

		 public function camera(){
		 	$images = $this->cameraModel->fetchall_pic_1user();
		 	$data = [
				'images' => $images
				];
			if(!isset($_SESSION['user_id']))
          		redirect("pages/index");
          	if  (isset($_POST["img"]) && !empty($_POST["img"])) 
          	{
          		$img = $_POST['img'];
          		$img = str_replace('data:image/png;base64,', '', $img);
          		$data = base64_decode($img);
          		$file = APPROOT2.'/public/img/'.date("YmdHis"). rand().'.png';
          		file_put_contents($file, $data);
          		$file = str_replace(APPROOT2, "", $file);
              	$this->cameraModel->insertPhoto($file);
              	redirect('/pages/camera');
              	
              
			}
			if (isset($_GET["idlt"])){
				$idimg = $_GET["idlt"];
				$this->cameraModel->dltimg($idimg);
				redirect("pages/camera");
				
				
			}

		 	$this->view('pages/camera', $data);
		 }

		 public function likeAjax() {
			if(isset($_GET["id"]))
			{
			 $img_id = $_GET["id"];

			 if (!($this->cameraModel->isliked($img_id)))
			 {
				 $this->cameraModel->likes($img_id);
				 
				 echo 'https://www.pngix.com/pngfile/big/35-351395_pouce-bleu-youtube-png-pouce-lev-transparent-png.png,'.$this->cameraModel->nublikes($img_id);
			 }
			 else
			 {
				 $this->cameraModel->unliked($img_id);
				 echo 'https://www.sccpre.cat/png/big/1/13185_like-png.png,'.$this->cameraModel->nublikes($img_id);
			 }
		 }
		 }


		 public function gallerie(){
			if(!isset($_SESSION['user_id']))
				redirect("pages/index");

			if(isset($_GET["id"]) && !empty($_GET["id"]))
       		 {
				
				$img_id = $_GET["id"];
				
				  if(!($this->cameraModel->isliked($img_id))){
					  $this->cameraModel->likes($img_id);
					  redirect('pages/gallerie');
				  }else{
					 $this->cameraModel->unliked($img_id);
					 redirect('pages/gallerie');
				 }
				}
			 if (isset($_POST["ok"]) ){
				// var_dump($_POST);
				$comment = htmlspecialchars($_POST["comment"]);
				$img_id = $_POST["img_id"];
				$notif = $this->cameraModel->ischecked($img_id);
				 
				if ($notif->notif == 1)
				{

					if (!empty($comment)){
					$this->cameraModel->registercomment($comment, $img_id);
					//echo "notif equal to 1";
					 $to = $notif->email;
              		 $subject = 'Comment';
              		 $message = $_SESSION['user_username'] . " comments on your picture";
              		 $headers = 'From: noreply@Camagru.com';
					 mail($to, $subject, $message, $headers);
					 redirect('/pages/gallerie');
					}
				}else{
					if (!empty($comment)){
					$this->cameraModel->registercomment($comment, $img_id);
					redirect('/pages/gallerie');
					}
				}
				//redirect('/pages/gallerie');

			 }	

		 	$page = 0;
		 	if(isset($_POST["page"]))
       		{
           		$page= $_POST["page"];
           		$page= ($page*5)-5;
       		}
       		
		 	$images = $this->cameraModel->fetchall_pic($page);
		 	$data = [
				'images' => $images
				
				];
			

		 	$this->view('pages/gallerie', $data);
		 }


	}