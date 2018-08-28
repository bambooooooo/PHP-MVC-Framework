<form class="form-signin" action="<?=URL?>user/tryLogin" method="POST">
  <div class="text-center mb-4">
    <a href="<?=URL?>home"><img class="mb-4" src="<?=URL;?>public/images/logo.svg" alt="" width="250"></a>
    <h1 class="h3 mb-3 font-weight-normal">log into MVC</h1>
    <p>PHP MVC framework powered by <a href="https://github.com/bambooooooo">bamboo</a></p>
  </div>
  <div class="form-label-group">
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
    <label for="inputEmail">Email address</label>
  </div>

  <div class="form-label-group">
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="">
    <label for="inputPassword">Password</label>
  </div>
  <div class="login-error">
    <?=(isset($this->loginError)) ? $this->loginError : '' ?>
  </div>
  <div class="checkbox mb-3" style="height:auto; overflow:auto">
    <div style="float:left"><input type="checkbox" name="remember">Remember me</div>
    <div style="float:right;" class="text-right"><a href="">Forgotten password?</a></div>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
  <p class="mt-5 mb-3 text-muted text-center">© 2017-2018</p>
  <input type="hidden" name="formName" value="login">
</form>
