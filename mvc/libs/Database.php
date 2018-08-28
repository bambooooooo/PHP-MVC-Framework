<?php

class Database extends PDO{
  public function __construct(){
    try {
      parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
      $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

      if( MODE == "DEVELOP" ){
        $tables = $this->select("SELECT table_name FROM information_schema.tables where table_schema = :db ", array(
          ':db' => DB_NAME
        ));
        if(empty($tables)){
          $this->select("CREATE TABLE IF NOT EXISTS `provigle` (
                        `provigle_id` int(11) NOT NULL AUTO_INCREMENT,
                        `controller` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `method` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `public` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT NULL,
                        `user_group` enum('ALL','ADMIN') COLLATE utf8_unicode_ci DEFAULT NULL,
                        PRIMARY KEY (`provigle_id`)
                      ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
          $this->select("CREATE TABLE IF NOT EXISTS `user` (
                          `user_id` int(11) NOT NULL AUTO_INCREMENT,
                          `user_type` enum('ADMIN','USER','ROOT') COLLATE utf8_unicode_ci DEFAULT 'USER',
                          `nickname` varchar(32) COLLATE utf8_unicode_ci DEFAULT 'USER',
                          `email` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                          `password` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                          `first_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                          `last_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                          `date_join` datetime DEFAULT CURRENT_TIMESTAMP,
                          `SID` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                          `SIP` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
                          `confimed` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
                          `confirm_hash` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                          `avatar` varchar(40) COLLATE utf8_unicode_ci DEFAULT 'default.png',
                          PRIMARY KEY (`user_id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

            //insert tempuser with password zaq1@WSX
            $this->insert('user', array(
              'nickname' => 'tempuser',
              'user_type' => 1,
              'email' => 'tempuser@gmail.com',
              'nickname' => 'tempuser',
              'password' => '8caef63742361f3b57bf6a8b9112833c',
              'first_name' => 'Temp',
              'last_name' => 'User',
              'confirm_hash' => Hash::create('MD5', date('Y-m-d H:i:s')),
              'avatar' => 'default.png'
            ));


        }
      }

    } catch ( PDOEXception $error){
      if( MODE == "DEVELOP" ){
        echo 'Cannot connect with Database: '.$error;
      }

    }
  }


  public function select($sql, $array = array(), $debug = false, $fetchMode = PDO::FETCH_ASSOC){
    $sth = $this->prepare($sql);
    if( count($array) > 0 ){
      foreach($array as $key => $value){
        $sth->bindValue("$key", $value);
      }
    }

    if($debug){
      echo $sth->queryString;
    }

    $sth->execute();
    return $sth->fetchAll($fetchMode);
  }

  public function insert($table, $data, $debug = false){
    ksort($data);
    $fieldNames = implode(',', array_keys($data));
    $fieldValues = ' :'.implode(', :', array_keys($data));

    if($debug){
      echo "INSERT INTO $table ($fieldNames) VALUES ($fieldValues)";
    }else{
      $sth = $this->prepare("INSERT INTO $table ($fieldNames) VALUES ($fieldValues)");

      foreach($data as $key => $value){
        $sth->bindValue(":$key", $value);
      }

      if( $sth->execute() ){
        return true;
      } else {
        return false;
      }

    }

  }

  public function update($table, $data, $where, $debug = false){
    ksort($data);

    $fieldDetails = null;
    foreach($data as $key => $value){
      $fieldDetails .= "$key = :$key, ";
    }

    $fieldDetails = rtrim($fieldDetails, ', ');

    if($debug){
      echo"UPDATE $table SET $fieldDetails WHERE $where";
    }else{
      $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

      foreach($data as $key => $value){
        $sth->bindValue("$key", $value);
      }

      if( $sth->execute() ){
        return true;
      }else {
        echo'<pre>';
          print_r($sth->errorInfo());
        echo'</pre>';
        return false;
      }
    }
  }

  public function delete($table, $where, $debug = false){
    if( $debug ) {
      echo "DELETE FROM $table WHERE $where";
      return false;
    } else {
      if( $this->exec("DELETE FROM $table WHERE $where") ){
        return true;
      } else {
        echo'<pre>';
          print_r($sth->errorInfo());
        echo'</pre>';
        return false;
      }
    }
  }


}


 ?>
