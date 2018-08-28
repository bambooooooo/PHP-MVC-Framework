<?php

class Home extends Controller{
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->view->title = 'Home';

    $this->view->css = array('home');

    $this->view->render('header');
    $this->view->render('menu');
    $this->view->render('home/index');
    $this->view->render('footer');
  }
}

 ?>
