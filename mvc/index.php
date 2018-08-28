<?php

foreach(scandir('./libs') as $lib){
  if($lib != '.' && $lib != '..'){ require '/libs/'.$lib; }
}

$app = new Boot();


 ?>
