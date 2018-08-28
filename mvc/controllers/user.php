<?php


class User extends Controller {
  public function __construct(){
    parent::__construct();

  }

  public function index(){
    //echo'We are in the index page';
  }

  public function login(){
    Session::redirectIfLogged();

    $this->view->loginError = Session::get('loginError');
    Session::remove('loginError');

    $this->view->title = 'Log In';
    $this->view->css = array('login');

    $this->view->render('header');
    $this->view->render('user/login');
    $this->view->render('footer');
  }

  public function logout(){
    $this->model->logout();
  }

  public function signin(){
    Session::redirectIfLogged();

    $this->view->title = 'Sign In';
    $this->view->css = array('login');

    $this->view->formError = Session::cut('register');
    $this->view->formValues = Session::cut('registerData');

    $this->view->render('header');
    $this->view->render('user/signin');
    $this->view->render('footer');
  }

  public function doSignIn(){
    Session::redirectIfLogged();

    $form = new Form();

    $form->post('email');
    $form->val('pattern', 'email');
    $form->post('nickname');
    $form->val('pattern', 'alphanumeric');
    $form->val('unique', 'user', 'nickname');
    $form->val('minlength', 1);
    $form->val('maxlength', 32);
    $form->post('password');
    $form->val('pattern', 'password');
    $form->post('passwordRepeated');
    $form->val('pattern', 'password');
    $form->identity(array('password', 'passwordRepeated'));
    $form->check('rules');
    $form->checked('terms of use');


    if( $form->submit() ){
      $this->model->createNewUser($form->fetch());
      header('Location: '.URL);
      exit();
    }else{
      header('Location: '.URL.'user/signin');
      exit();
    }
  }

  public function getLoggedUserData($SID, $SIP){
    $this->model->getLoggedUserData($SID, $SIP);
  }

  public function tryLogin(){
    Session::redirectIfLogged();

    $form = new Form();
    $form->post('email');
    $form->val('pattern', 'email');
    $form->post('password');
    $form->val('pattern', 'password');
    $form->check('remember');


    if( empty($form->getError()) ){
      $data = $form->fetch();
      if( $this->model->loginUser($data) ){
        header('Location: '.URL);
      }else{
        header('Location: '.URL.'user/login');
      }
    }else{
      header('Location: '.URL.'user/login');
    }


  }

  public function view($nickname = ''){
    $nickname = Form::sanitize($nickname);

    $this->view->title = $nickname;
    $this->view->userData = $this->model->getUserDataByNickname($nickname);

    $this->view->render('header');
    $this->view->render('menu');
    $this->view->render('user/view');
    $this->view->render('footer');
  }

  public function getAllUserData(){
    $this->view->title = "All users";

    $this->view->usersData = $this->model->getAllUserData();

    $this->view->render('header');
    $this->view->render('menu');
    $this->view->render('user/allUserList');
    $this->view->render('footer');
  }

  public function edit(){
    $this->view->title = "Edit profile";

    $this->view->uploadError = Session::cut('avatar');
    $this->view->userData = $this->model->getLoggedUserData();

    $this->view->render('header');
    $this->view->render('menu');
    $this->view->render('user/edit');
    $this->view->render('footer');
  }

  public function editDo(){
    Session::redirectIfNotLogged();
    $ses = Session::get('userSession');

    $form = new Form();

    $form->setMode('EDIT');
    $form->setHandle('user', 'user_id', $ses['user_id']);
    $form->post('first_name');
    $form->val('pattern', 'name');
    $form->post('last_name');
    $form->val('pattern', 'name');
    if( $form->submit() ){
      $this->model->updateUserData($form->getHandle(), $form->fetch());
      header('Location: '.URL.'user/view/'.$ses['nickname']);
    }else{
      header('Location: '.URL.'user/edit');
    }
  }

  public function changeAvatar(){
    $file = new File('avatar');

    $file->setFormFile('avatar');
    $file->setType('image');
    $file->setMaxSize(1);

    $ext = $file->getExtension();
    $destName = Hash::create('MD5', time()).'.'.$ext;

    $file->setDestPath('public/images/avatar/');
    $file->setDestFilename($destName);
    $file->uploadFile();


    if( $file->submit() ){
      //echo'file uploaded';
      $this->model->changeUserAvatar($destName);
      header('Location: '.URL.'user/edit');
    }else{
      //echo'upload failed';
      header('Location: '.URL.'user/edit');
    }
  }

}

 ?>
