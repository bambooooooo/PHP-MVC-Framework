<form class="form-signin" action="<?=URL?>user/doSignIn" method="POST">
  <div class="text-center mb-4">
    <a href="<?=URL?>home"><img class="mb-4" src="<?=URL;?>public/images/logo.svg" alt="" width="250"></a>
    <h1 class="h3 mb-3 font-weight-normal">register into MVC</h1>
    <p>PHP MVC framework powered by <a href="https://github.com/bambooooooo">bamboo</a></p>
  </div>
  <div class="form-label-group">
    <input type="email" id="inputEmail" name="email" class="form-control"
      value="<?=(isset($this->formValues['email'])) ? $this->formValues['email'] : '' ?>" placeholder="Email address" required="" autofocus="">
    <label for="inputEmail">Email address</label>
  </div>
  <div class="form-label-group">
    <input type="text" id="inputNickname" name="nickname"
    value="<?=(isset($this->formValues['nickname'])) ? $this->formValues['nickname'] : '' ?>"
     class="form-control" placeholder="nickname" required="" autofocus="">
    <label for="inputNickname">Nickname</label>
  </div>
  <div class="form-label-group">
    <input type="password" name="password" id="inputPassword" class="form-control" required="">
    <label for="inputPassword">Password</label>
  </div>
  <div class="form-label-group">
    <input type="password" name="passwordRepeated" id="inputPasswordRepeated" class="form-control"  required="">
    <label for="inputPasswordRepeated">Repeat password</label>
  </div>
  <div class="login-error">
    <?php
      if( isset($this->formError) && !empty($this->formError) ){
        foreach ($this->formError as $key => $value) {
          echo'<strong>'.$key.'</strong>: '.$value.'<br>';
        }
      }
     ?>
  </div>
  <div class="checkbox mb-3" style="height:auto; overflow:auto">
    <div style="float:left">
      <input type="checkbox" name="rules" <?=(isset($this->formValues['rules'])) ? 'checked' : '' ?>>
      Accept terms of use
    </div>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
  <p class="mt-5 mb-3 text-muted text-center">© 2017-2018</p>
  <input type="hidden" name="formName" value="register">
</form>
