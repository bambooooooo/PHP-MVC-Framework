<?php

class Docs extends Controller{
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->view->title = 'Docs';

    $this->view->render('header');
    $this->view->render('menu');
    $this->view->render('docs/index');
    $this->view->render('footer');
  }
}


 ?>
