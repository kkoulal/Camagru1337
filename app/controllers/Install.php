<?php
class Install extends Controller {
  public function __construct()
  {
  }
  public function index(){
    redirect ('users/login');
  }
  public function setup()
  {
    if(require_once (''.APPROOT.'/config/setup.php'))
      redirect ('users/login');
    else
      echo "Something wrong";
  }
}