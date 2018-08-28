<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?=URL;?>">MVC Framework</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?=URL;?>docs">Documentation<span class="sr-only">(current)</span></a>
      </li>
    </ul>

    <?php
    $userSession = Session::get('userSession');

    if($userSession){
      $name = '';
      if( strlen($userSession['first_name']) <= 0 ){
        $name = $userSession['nickname'];
      }else {
        $name = $userSession['first_name'].' '.$userSession['last_name'];
      }

     echo '<div class="dropdown">
             <div class="dropdown-toggle nav-user" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               logged as: <strong>'.$name.'</strong>
             </div>
             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
               <a class="dropdown-item" href="'.URL.'user/view/'.$userSession['nickname'].'">Profile</a>
               <a class="dropdown-item" href="#">Settings</a>
             </div>
           </div>
           <a href="'.URL.'user/logout" class="btn btn-success my-2 ml-2 my-sm-0">Log out</a>';
    } else {
     echo'<a href="'.URL.'user/signin" class="btn btn-success my-2 ml-2 my-sm-0">Sign In</a>
          <a href="'.URL.'user/login" class="btn btn-outline-success my-2 ml-2 my-sm-0">Log In</a>';
    }

   ?>


  </div>

</nav>
