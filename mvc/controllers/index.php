<?php

class Index extends Controller {
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    header('Location: '.URL.'home');
    //echo'We are in the index page';
  }
}

 ?>
