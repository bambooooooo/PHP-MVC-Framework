<?php

class Form {
  private $_callback;
  private $_name;
  private $_mode;

  private $_handle;
  private $_oldData;

  private $_currentItem = null;
  private $_postData = array();
  private $_val = array();
  private $_error = array();

  public function __construct(){
    if( !isset($_POST['formName']) ){
      if( MODE == 'DEVELOP' ){
        echo'Form name is not defined<br>';
      }

      return false;
    }
    $this->_name = mysql_real_escape_string(strip_tags($_POST['formName']));
    $this->_val = new Val();
  }

  public function post($field){
    if( !isset($_POST[$field]) ){
      if( MODE == 'DEVELOP' ){
        echo 'unknown form field: <strong>'.$field.'</strong><br>';

      }
      return false;
    }

    if( $_POST[$field] == $this->_oldData[$field] ){
      $this->_currentItem = null;
      return true;
    }

    if(is_array($_POST[$field])){
      foreach ($_POST[$field] as $item) {
        $item = mysql_real_escape_string(strip_tags($item));
      }
      $this->_postData[$field] = $_POST[$field];
    }else{
      $this->_postData[$field] = mysql_real_escape_string(strip_tags($_POST[$field]));
    }

    $this->_currentItem = $field;
  }

  public function check($field){

    if(!isset($_POST[$field])){
      $this->_postData[$field] = null;
    }else{
      if( is_array($_POST[$field]) ){
        foreach ($_POST[$field] as $item) {
          $item = mysql_real_escape_string($item);
        }
        $this->_postData[$field] = $_POST[$field];
      }else{
        $this->_postData[$field] = mysql_real_escape_string(strip_tags($_POST[$field]));
      }

    }

    $this->_currentItem = $field;
  }

  public static function sanitize($value){
    return mysql_real_escape_string(strip_tags($value));
  }

  public function getFormName(){
    return $this->_name;
  }

  public function setMode($mode = 'CREATE'){
    switch($mode){
      case 'CREATE': $this->_mode = 'CREATE'; break;
      case 'EDIT': $this->_mode = 'EDIT'; break;
      default: {
        if(MODE == 'DEVELOP'){
          echo'unknown type of work mode';
          break;
        }
      }
    }
  }

  public function setHandle($table, $key, $value){
    $this->_handle = array('table' => $table, 'key' => $key, 'value' => $value);
    if(!isset($this->_val->db)){
      return false;
    }
    $res =  $this->_val->db->select("SELECT * FROM ".$this->_handle['table']." WHERE ".$this->_handle['key']." = :value", array(
      ':value' => $this->_handle['value']
    ));
    if(!empty($res)){
      $this->_oldData = $res[0];
    }
  }

  public function getHandle(){
    return $this->_handle;
  }

  public function getError(){
    if( empty($this->_error) ){
      return false;
    } else return $this->_error;
  }

  public function submit(){
    if(empty($this->_error)){
      Session::remove($this->_name);
      Session::remove($this->_name.'Data');
      return true;
    }else{
      Session::set($this->_name, $this->getError());
      Session::set($this->_name.'Data', $this->fetch());
      return false;
    }
  }

  public function fetch($fieldName = false){
    if( $fieldName ){
      if( isset( $this->_postData[$fieldName] ) ){
        return $this->_postData[$fieldName];
      }else{
        return false;
      }
    }else{
      return $this->_postData;
    }
  }

  public function val($typeOfValidator, $arg=null, $arg2=null, $arg3=null){

    if( $this->_currentItem == null ){
      return false;
    }

    if( $arg==null ){
      $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem], $this->_currentItem);
    }else if( $arg2==null ){
      $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem], $this->_currentItem, $arg);
    }else if( $arg3==null ){
      $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem], $this->_currentItem, $arg, $arg2);
    }else{
      $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem], $this->_currentItem, $arg, $arg2, $arg3);
    }

    if( $error ){
      $this->_error[$this->_currentItem] = $error;
    }
  }

  public function identity($data = array()){
    if( $this->_currentItem == null ){
      return false;
    }
    for($i=0; $i<count($data); $i++){
      if( $this->_postData[$data[$i]] != $this->_postData[$data[0]] ){
        $string = implode($data, ', ');
        $this->_error[$data[0]] = "Field ".$string." are not equal";
        return false;
      }
    }
  }

  public function checked($label, $check = true){
    if( !isset($this->_postData[$this->_currentItem]) || !$this->_postData[$this->_currentItem] ){
      $this->_error[$this->_currentItem] = '<strong>'.$label.'</strong>: must be checked';
    }
  }
}


 ?>
