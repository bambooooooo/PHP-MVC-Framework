<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?=URL;?>public/css/bootstrap.css">
    <?php
      if(isset($this->css)){
        foreach($this->css as $css){
          echo '<link rel="stylesheet" href="'.URL.'public/css/'.$css.'.css">';
        }
      }
    ?>
    <link rel="stylesheet" href="<?=URL;?>public/css/main.css">
    <link rel="icon" href="<?=URL;?>public/images/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?=URL;?>public/images/favicon.png" type="image/x-icon"/>
    <script type="text/javascript" src="<?=URL;?>public/js/jquery.js"></script>
    <script type="text/javascript" src="<?=URL;?>public/js/popper.js"></script>
    <script type="text/javascript" src="<?=URL;?>public/js/bootstrap.js"></script>
    <title><?=$this->title;?></title>
  </head>
  <body>
