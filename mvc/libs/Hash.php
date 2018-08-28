<?php
class Hash{

  public static function create($algo, $data){
    $context = hash_init( $algo, HASH_HMAC, HASH_KEY );
    hash_update( $context, trim($data) );

    return hash_final($context);
  }

}

?>
