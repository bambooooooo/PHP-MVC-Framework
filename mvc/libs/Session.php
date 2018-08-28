<?php

class Session{
  public static function init(){
    @session_start();
  }

  public static function set($key, $value){
    $_SESSION[$key] = $value;
  }

  public static function get($key){
    if( isset($_SESSION[$key]) ){
      return $_SESSION[$key];
    } else return false;
  }

  public static function destroy(){
    session_destroy();
  }

  public static function remove($key){
    if( isset($_SESSION[$key]) ){
      unset($_SESSION[$key]);
    }
  }

  public static function cut($key){
    if( isset($_SESSION[$key]) ){
      $temp = $_SESSION[$key];
      unset($_SESSION[$key]);
      return $temp;
    } else return false;
  }

  public static function push($key, $value){
    if( isset($_SESSION[$key]) && is_array($_SESSION[$key]) ){
      $_SESSION[$key] = array_splice($_SESSION[$key], $value);
    }
  }

  public static function redirectIfLogged(){
    if( Session::get('userSession') ){
      if( isset($_SERVER['HTTP_REFERER']) ){
        header('Location: '.$_SERVER['HTTP_REFERER']);
      }else{
        header('Location: '.URL);
      }

    }
  }

  public static function redirectIfNotLogged(){
    if( !Session::get('userSession') ){
        header('Location: '.URL);
    }
  }

}


 ?>
