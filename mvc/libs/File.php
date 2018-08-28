<?php

class File{
  private $_currentFile;
  private $_destPath;
  private $_error;
  private $_allowedExtension;
  private $_maxFileSize;
  private $_destName;
  private $_size;
  private $_formName;

  public function __construct($name = 'default'){
    $this->_formName = Form::sanitize($name);
  }

  public function setFormFile($field){
    if( isset($_FILES[$field]) ){
      $this->_currentFile = $field;
      $exp = explode('.', $_FILES[$field]['name']);
      $this->_extension = $exp[count($exp)-1];
      $this->_size = $_FILES[$field]['size'];
    } else {
      $this->_error[] = "field <strong>".$field.'</strong> does not exist<br>';
    }
  }

  public function setType($ext){
    if( is_array($ext) ){
      $this->_allowedExtension = $ext;
    }else{
      switch($ext){
        case 'image': $this->_allowedExtension = array('png', 'jpg', 'jpeg', 'svg'); break;
        case 'text': $this->_allowedExtension = array('txt', 'csv'); break;
        default: $this->_errors[] = 'Unknown type of extension';
      }
    }
  }

  public function submit(){
    if(empty($this->_error)) {
      return true;
    } else {
      Session::push($this->_formName, $this->_error);
      return false;
    }
  }

  public function setDestPath($dir){
    $this->_destPath = $dir;
    if( !file_exists($dir) ){
      mkdir($dir, 0777);
    }
  }

  public function setDestFilename($name){
    $this->_destName = $name;
  }

  public function setMaxSize($MB = 1){
    $this->_maxFileSize = $MB * 1048576;
  }

  public function validateFile(){
    //extension
    if( !in_array($this->_extension, $this->_allowedExtension) ){
      $this->_error[] = "Invalid type of extension";
    }

    //size
    if( $this->_size > $this->_maxFileSize ){
      $this->_error[] = "Too large file";
    }
  }

  public function uploadFile(){
    $this->validateFile();

    if( !empty($this->_error) ){
      return false;
    }
    if( !is_uploaded_file($_FILES[$this->_currentFile]['tmp_name']) ){
      $this->_error[] = 'file '.$this->_currentFile.' upload failed';
    }else {
      move_uploaded_file($_FILES[$this->_currentFile]['tmp_name'], $this->_destPath.$this->_destName);
    }
  }

  public function getExtension(){
    return $this->_extension;
  }

  public function getError(){
    return $this->_error();
  }

}





class FileGroup{

}

 ?>
