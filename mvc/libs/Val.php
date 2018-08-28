<?php

class Val{

  public function __construct(){
    $this->db = new Database();
  }

  public function minlength($data, $name, $arg){
    if( strlen($data) < $arg ){
      return "Your $name can only be min $arg characters long";
    }
  }

  public function maxlength($data, $name, $arg){
    if( strlen($data) > $arg ){
      return "Your $name can only be max $arg characters long";
    }
  }

  public function digit($data, $name){
    if( !ctype_digit($data) ){
      return "Your $name must be a digit";
    }
  }

  public function moreThan($data, $name, $arg){
    if( intval($data) < $arg ){
      return "Your $name must be greater than $arg";
    }
  }

  public function lessThan($data, $name, $arg){
    if( intval($data) > $arg ){
      return "Your $name must be less than $arg";
    }
  }

  public function unique($data, $name, $table, $col){
    $sth = $this->db->select("SELECT COUNT(*) as amount FROM $table WHERE $col = :data ", array(':data' => $data));
    if( $sth[0]['amount'] != 0 ){
      return "This $name is used";
    }
  }

  public function exists($data, $name, $table, $col){
    $sth = $this->db->select("SELECT COUNT(*) as amount FROM $table WHERE $col = :data ", array(':data' => $data));
    if( $sth[0]['amount'] <= 0 ){
      return "This $name is not exists";
    }
  }

  //public function isEqual($data, $name, $table, $col, $where)
  public function isEqual($data, $name, $table, $col, $where){
    if( $col == "password" ){
      $data = Hash::create('md5', $data);
    }

    $sth = $this->db->select("SELECT COUNT(*) as amount FROM $table WHERE $col = :data AND $where", array(':data' => $data));

    if( $sth[0]['amount'] <= 0 ){
      return "This $name is incorrect";
    }
  }

  public function valEqual($data, $name, $arg){
    if( $data != $arg ){
      return "Your $name must be equal $arg";
    }
  }

  public function valNotEqual($data, $name, $arg){
    if( $data == $arg ){
      return "Your $name can not be equal $arg";
    }
  }

  public function isInArray($item, $arr){
    foreach($arr as $row){
      if($row == $item){
        return true;
      }
    }
    return false;
  }

  public function extension($data, $name, $arg){
    $flag = true;

    foreach($data as $file){
      $exp = explode('.', $file);
      if( !$this->isInArray($exp[(count($exp)-1)], $arg )){
        $flag = false;
      }
    }

    if(!$flag){
      return "File: {$name} - invalid type of extension";
    }
  }

  public function pattern($data, $name, $arg){

    $ereg = '';
    switch( $arg ){
      case 'alphanumeric': $ereg = '/^([a-z|A-Z|0-9])+/'; break;
      case 'date': $ereg = '/^([1-2])([0-9])([0-9])([0-9])-([0-1])([0-9])-([0-1])([0-9])$/'; break;
      case 'email': $ereg = '/^([a-z|A-Z|0-9]{4,20})@([a-z|A-Z|0-9]{2,10})\\.([a-z|A-Z]{2,5})$/'; break;
      case 'name': $ereg = '/^([a-z|A-Z|ęóąśłżźćńĘÓĄŚŁŻŹĆŃ]{2,22})$/'; break;
      case 'phone': $ereg = '/[0-9]{9}$/'; break;
      case 'place': $ereg = '/^([a-z|A-Z|ęóąśłżźćńĘÓĄŚŁŻŹĆŃ]| |-){3,32}$/'; break;
      case 'postCode': $ereg = '/^([0-9]){1,3}-([0-9]){1,3}$/'; break;
      case 'street': $ereg = '/^([a-z|A-Z|ęóąśłżźćńĘÓĄŚŁŻŹĆŃ|0-9]| |-){1,32}$/'; break;
      case 'username': $ereg = '/^([a-z|A-Z|ęóąśłżźćńĘÓĄŚŁŻŹĆŃ|0-9]| |-){1,32}$/'; break;
      case 'password': $ereg = '/^([a-z|A-Z|ęóąśłżźćńĘÓĄŚŁŻŹĆŃ|0-9]| |-){1,32}$/'; break;
      default : return "$name: Unknown type of pattern";
    }

    if( !preg_match($ereg, $data) ){
      return "Your $name is not valid varchar";
    }
  }

  public function barcode($data, $name){
    if(!Barcode::makeCode($data)){
      return "Your barcode: $name is invalid";
    }
  }

  public function __call($name, $arguments){
    throw new Exception("$name does not exists inside of: ".__CLASS__);
  }


}





 ?>
