<?php

class View {
  public function render($source){
    require 'views/'.$source.'.php';
  }
}

 ?>
