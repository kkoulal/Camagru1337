<?php
  class Users extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
    }
    public function register(){

        if(isset($_SESSION['user_id']))
          redirect("pages/index");
      // print_r ($_SESSION['user_id']);
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Username']) && isset($_POST['confirm_password']) && isset($_POST['password']) && isset($_POST['email'])){
        // Process form
  
        // Sanitize POST data
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $token = 'fg7khhzxvlloulaldl';
         $token = str_shuffle($token);
         $token = substr($token , 0, 10);
        // Init data
        $data =[
          'Username' => trim($_POST['Username']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'Username_err' => '',
          'email_err' => '',
          'password_err' => '',
          'token' => $token,
          'confirm_password_err' => ''
        ];
        // Validate Email
         if(empty($data['email'])){
          $data['email_err'] = 'Please enter email';
        } else{
          if ($this->userModel->findUserByEmail($data['email'])){
              $data['email_err'] = 'email is already taken';
          }else{
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
              $data['email_err'] = 'Please enter a valid email';
            }
          }
        }
        // Validate UserName
        if(empty($data['Username'])){
          $data['Username_err'] = 'Please enter Username';
          //aydhaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        } else{
          if ($this->userModel->findUserByUsername($data['Username'])){
              $data['Username_err'] = 'Username is already taken';
          }elseif(!preg_match( "/^(?=.{5,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/", $data['Username'])){
            $data['Username_err'] = 'Please enter a valid Username';
          }
        }
        // Validate Password
        if(empty($data['password'])){
          $data['password_err'] = 'Please enter password';
        } elseif(!preg_match( "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $data['password'])){
          $data['password_err'] = 'At least one uppercase letter, one lowercase letter, one number and eight characters';
        }
        // if (!preg_match( "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $email)){
        //     $data['email_err'] = 'At least one uppercase letter, one lowercase letter and one number';
        //   }
        // }
        // Validate Confirm Password
        if(empty($data['confirm_password'])){
          $data['confirm_password_err'] = 'Please confirm password';
        } else {
          if($data['password'] != $data['confirm_password']){
            $data['confirm_password_err'] = 'Passwords do not match';
          }
        }
        // Make sure errors are empty
        if(empty($data['email_err']) && empty($data['Username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
          // Validated
            $to = $data['email'];
            $subject = 'Please verify your Email';
            $message = "In order to validate your account, please click on the link below\n\nhttp://localhost:8001/camagru/users/confirm?token=$token";
            $headers = 'From: noreply@Camagru.com';
            //$secure_check = sanitize_my_email($to_email);
              /* if ($secure_check == false) {
                 echo "Invalid input";
              } else { *///send email 
              mail($to, $subject, $message, $headers);
              
          
          //Hash password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
          // Register User
          if ($this->userModel->register($data)){
            flash('register_success' , 'Please verify your email');
            redirect('users/login');
          }else{
          }
        } else {
          // Load view with errors
          $this->view('users/register', $data);
        }
      } else {
        // Init data
        $data =[
          'Username' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'Username_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];
        // Load view
        $this->view('users/register', $data);
      }
    }
    public function login(){
        if(isset($_SESSION['user_id']) )
          redirect("pages/index");
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Username']) && isset($_POST['password'])){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Init data
        $data =[
          'Username' => trim($_POST['Username']),
          'password' => trim($_POST['password']),
          'Username_err' => '',
          'password_err' => ''      
        ];
        // Validate Username
        if(empty($data['Username'])){
          $data['Username_err'] = 'Please enter Username';
        }
        // Validate Password
        if(empty($data['password'])){
          $data['password_err'] = 'Please enter password';
        }
        //check for user/email
        if ($this->userModel->findUserByUsername($data['Username'])){
          //User found
        }else{
          $data['Username_err'] = 'No Username found';
        }
        // Make sure errors are empty
        if(empty($data['Username_err']) && empty($data['password_err'])){
          // Validated
          //check and set logged in user
          
          $loggedInUser = $this->userModel->login($data['Username'], $data['password']);
          if($loggedInUser){
            
             $res = $this->userModel->is_verified($data['Username']);
             if($res->is_verified == '0'){
                $data['Username_err'] = 'Please Verify your email';
              }
            //Create Session
              if ($res->is_verified == '1'){
               $this->createUserSession($loggedInUser);
             }else{
                 // echo "Please Verify your email";
                    redirect('users/emailver');
              // $this->view('users/login', $data);
             }
           
          }else{
            $data['password_err'] = 'Password incorrect';
            $this->view('users/login', $data);
          }
        } else {
          // Load view with errors
          $this->view('users/login', $data);
        }
      } else {
        // Init data
        $data =[    
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',        
        ];
        // Load view
        $this->view('users/login', $data);
      }
    }

  
  public function createUserSession($user){
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email; 
    $_SESSION['user_username'] = $user->Username;
    redirect('pages/gallerie');
    }
    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_username']);
      session_destroy();
      redirect('users/login');
    }
    public function isLoggedIn(){
      if (isset($_SESSION['user_id'])){
        return true;
      }else{
        return false;
      }
    }
    public function forgot_password(){

        if(isset($_SESSION['user_id']))
          redirect("pages/index");
        $ntoken = 'fg7khhzxvlloulaldl';
        $ntoken = str_shuffle($ntoken);
        $ntoken = substr($ntoken , 0, 10);
      $data =[
          'email' => '',
          'email_err' => '',
          'ntoken' => $ntoken,
          'sent' => 'Email has been sent'      
        ];
        
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      
      
        // Init data
        $data =[
          'email' => trim($_POST['email']),
          'ntoken' => $ntoken,
          'email_err' => '',
          'sent' => 'Email has been sent'     
        ];
         if(empty($data['email'])){
           $data['email_err'] = 'Please enter email';
        }else{
           if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
              $data['email_err'] = 'Please enter a valid email';
        }else{
            if (!($this->userModel->findUserByEmail($data['email']))){
              $data['email_err'] = 'Email does not exist';
            }   
          }
        }
        if(empty($data['email_err'])){       
              $to = $data['email'];
              $subject = 'Please verify your Email';
              $message = "In order to reset your password , please click on the link below\n\nhttp://localhost:8001/camagru/users/redirect_forgot_password?ntoken=".$ntoken;
              $headers = 'From: noreply@Camagru.com';
              mail($to, $subject, $message, $headers);
              
              $this->userModel->registerntoken($data);
              redirect('users/emailsent');
        }
          
      }
      $this->view('users/forgot_password', $data);
    }
     public function emailsent(){
      if(isset($_SESSION['user_id']))
        redirect("pages/index");
       $this->view('users/emailsent');
    }
    public function profile(){
      if(!isset($_SESSION['user_id']))
          redirect("");
       $checked = $this->userModel->ischecked();
      //&& ($checked->notif == 1)
      
       if(isset($_POST['check'])) { 
          $check = $this->userModel->ischecked();
          if ($check->notif == 1){
            $this->userModel->setzero();
            redirect('users/profile');
        }else{
            $this->userModel->setone();
            redirect('users/profile');
      }
    }
      $this->view('users/profile');
    }


 
    public function emailver(){
      if(isset($_SESSION['user_id']))
          redirect("pages/index");
       $this->view('users/emailver');
    }


    public function redirect_forgot_password(){ 
      if(isset($_SESSION['user_id']))
          redirect("pages/index");
      if (isset($_GET['ntoken'])){
          $_SESSION['ntoken'] = $_GET['ntoken'];          
      }
         
            $data =[
              'password' => '',
              'repassword' => '',
              'password_err' => '',
              'repassword_err' => '',
              'ntoken' => $_SESSION['ntoken']    
            ];
            if($_SERVER['REQUEST_METHOD'] == 'GET')
            {
              
               $nttoken = $this->userModel->selecnttoken($data);
                
               if ($nttoken === false){
                  redirect('users/index');
                }
            }
            
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
            $data =[
                'password' => trim($_POST['password']),
                'repassword' => trim($_POST['repassword']),
                'ntoken' => $_SESSION['ntoken'],
                'password_err' => '',
                'repassword_err' => ''      
            ];
        
            if(empty($data['password'])){
              $data['password_err'] = 'Please enter password';
              }elseif(!preg_match( "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $data['password'])){
                $data['password_err'] = 'At least one uppercase letter, one lowercase letter, one number and eight characters';
              }
               // Validate Confirm Password
            if(empty($data['repassword'])){
              $data['repassword_err'] = 'Please confirm password';
            }else{
              if($data['password'] != $data['repassword']){
                $data['repassword_err'] = 'Passwords do not match';
                
              }
            }
      //       // print_r($data);
           if(empty($data['password_err']) && empty($data['repassword_err'])){
              $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
              
              $nttoken = $this->userModel->selecnttoken($data);

             if ($this->userModel->UploadPassword($data)){ 
                $this->userModel->nomorentoken($data);
                flash('Password_Updated' , 'Password updated');
                redirect('users/login');
            }
           
           }

     
           $this->view('users/redirect_forgot_password', $data);
       }else{
        $data =[
          'password' => '',
          'repassword' => '',
          'password_err' => '',
          'repassword_err' => ''      
        ];
        $this->view('users/redirect_forgot_password', $data);
       }
      
}
    public function index(){

       redirect('pages/gallerie');
      $this->view('pages/index');
    }
    public function profile_Email(){
      if(!isset($_SESSION['user_id']))
          redirect("");

       $data=[
        'Email' => '',
        'Email_err' => ''
        ];
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          $data=[
            'Email' => trim($_POST['Email']),
            'Email_err' => ''
            ];
          if(empty($data['Email'])){
              $data['Email_err'] = 'Please enter email';
              $this->view('users/profile_Email', $data);
          } else {
              if($this->userModel->findUserByEmail($data['Email'])){
                  $data['Email_err'] = 'Email is already taken';
              }
          }
          if (!filter_var($data['Email'], FILTER_VALIDATE_EMAIL)){
            $data['Email_err'] = 'Please enter a valid email';
            $this->view('users/profile_Email', $data);
          }
          if(empty($data['Email_err'])){
              if($this->userModel->UploadEmail($data)){
                  flash('register_success', 'Your email has been changed');
                  $_SESSION['user_email'] = $data['Email'];
                  redirect('users/index');
              } 
              
          } else {
              $this->view('users/profile_Email', $data);
          }
      } else {
          $data = [
              'Email' => '',
              'Email_err' => ''
          ];
          $this->view('users/profile_Email', $data);
      }
  
  }
    public function profile_Username(){
      if(!isset($_SESSION['user_id']))
      redirect("");
       $data=[
        'Username' => '',
        'Username_err' => ''
        ];
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data=[
        'Username' => trim($_POST['Username']),
        'Username_err' => ''
        ];
        if(empty($data['Username'])){
          $data['Username_err'] = 'Please enter a new Username';
          $this->view('users/profile_Username',$data);
          
        }else
        {if($this->userModel->findUserByUsername($data['Username'])){
              $data['Username_err'] = 'Username is already taken';
          }
        }
        if(empty($data['Username_err'])){
          if ($this->userModel->UploadUsername($data)){
             //change session id
            $_SESSION['user_username'] = $data['Username'];
            flash('Passwor_Updated' , 'Username updated');
            redirect('pages/index');
            
          }
        }else{
          $this->view('users/profile_Username',$data);
        }
      }else{
        $data=[
          'Username' => '',
          'Username_err' => ''
          ];
        $this->view('users/profile_Username',$data);
      }
    }

    public function dltlpics(){
      if(!isset($_SESSION['user_id']))
      redirect("");
    $this->view('users/dltlpics');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
     if($this->userModel->deleteimg()){
      redirect('users/login');
      
    }
    }
    }

    public function dltcomments(){
      if(!isset($_SESSION['user_id']))
      redirect("");
    $this->view('users/dltcomments');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
     if($this->userModel->deleteallcomments()){
      redirect('users/login');
      flash('deleted_success' , 'Your Account Has Been Deleted');
    }
  }
    }

    public function dltlikes(){
      if(!isset($_SESSION['user_id']))
          redirect("");
        $this->view('users/dltlikes');

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         if($this->userModel->deletealllikes()){
          redirect('users/login');
          flash('deleted_success' , 'Your Account Has Been Deleted');
        }
      }
    }

    public function deleteaccount(){
        if(!isset($_SESSION['user_id']))
          redirect("");
        $this->view('users/deleteaccount');
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->userModel->deleteprofile()){
          $this->userModel->deleteimg();
          $this->userModel->deletealllikes();
          $this->userModel->deleteallcomments();

          unset($_SESSION['user_id']);
          unset($_SESSION['user_email']);
          unset($_SESSION['user_username']);
          session_destroy();

          redirect('users/login');
          flash('deleted_success' , 'Your Account Has Been Deleted');
        }
      }

      
    }
    public function profile_password(){
      if(!isset($_SESSION['user_id']))
        redirect("");
          $data =[
            'password' => '',
            'repassword' => '',
            'password_err' => '',
            'repassword_err' => ''      
          ];
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          $data =[
            'password' => trim($_POST['password']),
            'repassword' => trim($_POST['repassword']),
            'password_err' => '',
            'repassword_err' => ''      
          ];
        
          if(empty($data['password'])){
            $data['password_err'] = 'Please enter password';
            }elseif(!preg_match( "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $data['password'])){
              $data['password_err'] = 'At least one uppercase letter, one lowercase letter, one number and eight characters';
            }
             // Validate Confirm Password
          if(empty($data['repassword'])){
            $data['repassword_err'] = 'Please confirm password';
          }else{
            if($data['password'] != $data['repassword']){
              $data['repassword_err'] = 'Passwords do not match';
            }
          }
          if(empty($data['password_err']) && empty($data['repassword_err'])){
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
              //send pass to mode
             if ($this->userModel->ChangePassProfile($data)){
                flash('Password_Updated' , 'Password updated');
                redirect('pages/index');
            }
          }
          $this->view('users/profile_password',$data);
        }else{
          $data =[
            'password' => '',
            'repassword' => '',
            'password_err' => '',
            'repassword_err' => ''      
          ];
          $this->view('users/profile_password',$data);
        }
    }
    public function confirm(){
   
      if (isset($_GET['token']))
      {
        $data = $_GET['token'];
        
          $ttoken = $this->userModel->selecttoken($data);
          
          //  var_dump($data);
          if ($ttoken === false){
              redirect("users/index");
          }
         if($this->userModel->confirm($data)){
          $this->userModel->nomoretoken($data);
          $this->view('users/confirm');
        }

        $this->view('users/confirm');
      }
       
       $this->view('users/confirm');
    }
    
  }