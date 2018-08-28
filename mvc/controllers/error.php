<?php

class Error extends Controller{
  public function __construct($error = null){
    parent::__construct();
  }

  public function index($error = null){
    if( $error ){
      echo'<center>'.$error.'</center>';
      return true;
    }
  }
}

 ?>
