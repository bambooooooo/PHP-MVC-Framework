<?php

class User_Model extends Model{
  public function __construct(){
    parent::__construct();
  }

  public function loginUser($data){
    //print_r($data);

    $res = $this->db->select("SELECT user_id, nickname, email, user_type, first_name, last_name FROM user WHERE email = :email AND password = :pass", array(
      ':email' => $data['email'],
      ':pass' => Hash::create('MD5', $data['password'] )
    ));

    if(empty($res)){
      Session::set('loginError', 'invalid login or password');

      return false;
    }

    $userData = $res[0];

    $SID = Hash::create('MD5', time());
    $SIP = Form::sanitize($_SERVER['REMOTE_ADDR']);

    $ses = $this->db->update('user', array(
      'SID' => $SID,
      'SIP' => $SIP
    ), 'user_id = '.$userData['user_id']);

    Session::set('userSession', array(
      'email' => $userData['email'],
      'user_id' => $userData['user_id'],
      'nickname' => $userData['nickname'],
      'first_name' => $userData['first_name'],
      'last_name' => $userData['last_name'],
      'user_type' => $userData['user_type'],
      'SID' => $SID,
      'SIP' => $SIP
    ));


    if( $data['remember'] == 'on' ){
      setcookie('SID', $SID, time()+60*60*24*30, "/");
    }else{
      setcookie('SID', $SID, 0, "/");
    }

    return true;
  }

  public function getLoggedUserData(){
    $session = Session::get('userSession');
    $res = $this->db->select("SELECT * FROM user WHERE email = :email", array(
      ':email' => $session['email']
    ));
    return $res[0];
  }

  public function getUserDataByNickname($nick){
    $res = $this->db->select("SELECT * FROM user WHERE nickname = :nick", array(
      ':nick' => $nick
    ));
    if( !empty($res) ){
      return $res[0];
    }else {
      return false;
    }

  }

  public function logout(){
    Session::remove('userSession');
    setcookie('SID', '', -1, "/");
    header('Location: '.URL);
  }

  public function getAllUserData(){
    return $this->db->select("SELECT * FROM user ORDER BY nickname");
  }

  public function createNewUser($data){
    $confirmHash = Hash::create('MD5', date('Y-m-d H:i:s'));

    $this->db->insert('user', array(
      'email' => $data['email'],
      'nickname' => $data['nickname'],
      'password' => Hash::create('MD5', $data['password']),
      'confirm_hash' => $confirmHash
    ));

    //Email::send('MVC APP', $data['email'], 'Confirm your email adress', 'http://'.URL.'user/confirm/'.$data['email'].'/'.$confirmHash);

    Session::set('confirmAlert', 'To complete register you have to confirm your email adress');
  }

  public function updateUserData($handle, $data){
    if(!empty($data)){
      $this->db->update($handle['table'], $data, $handle['key'].'='.$handle['value']);
    }
  }

  public function changeUserAvatar($data){
    echo'av: '.$data.'<br>';
    $us = Session::get('userSession');
    $uid = $us['user_id'];
    $res = $this->db->update('user', array(
      'avatar' => $data
    ), 'user_id = '.$uid);
    if( $res ) return true;
    return false;
  }

}

 ?>
