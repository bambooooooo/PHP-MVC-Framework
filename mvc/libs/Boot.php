<?php

class Boot {

	function __construct() {

		Session::init();

		$userData = Session::get('userSession');

		if( !$userData ){
			if( isset($_COOKIE['SID']) ){
				$this->setLoggedUserData($_COOKIE['SID'], Form::sanitize($_SERVER['REMOTE_ADDR']));
			}
		}

		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);

		$error = '';

		if (empty($url[0])) {
			require 'controllers/index.php';
			$controller = new Index();
			$controller->index();
			return false;
		}

		$file = 'controllers/' . $url[0] . '.php';
		if (file_exists($file)) {
			require $file;
		} else {
			$this->error('controller does not exists');
			return false;
		}

		$controller = new $url[0];
		if(!$controller->loadModel($url[0])){
			$this->error('model does not exists');
			return false;
		}

		//checking provigles

		if(!$this->getMethodData($url)){
			$this->error('access denided');
			return false;
		}

		// calling methods
		if( count($url) == 1 ) {
			if( method_exists($controller, 'index') ){
				$controller->index();
			}else{
				$this->error("unknown method <strong>index</strong> in $url[0] controller");
			}
		}else{
			$arg = '';

			for($i=2; $i<count($url); $i++){
				if( $i == (count($url) - 1) ){
					$arg .= $url[$i];
				}else {
					$arg .= $url[$i].', ';
				}
			}
			if( method_exists($controller, $url[1]) ){
				$controller->{$url[1]}($arg);
			}else{
				$this->error("unknown method <strong>$url[1]</strong> in <strong>$url[0]</strong> controller");
			}
		}


	}

	public function setLoggedUserData($SID, $SIP){
		$db = new Database();

    $data = $db->select("SELECT nickname, user_id, user_type, email, first_name, last_name, SID, SIP FROM user WHERE SID = :sid AND SIP = :sip", array(
      ':sid' => $SID,
      ':sip' => $SIP
    ));

    if(empty($data)){
      return false;
    }else{
      Session::set('userSession', array(
        'email' => $data[0]['email'],
				'nickname' => $data[0]['nickname'],
				'user_id' => $data[0]['user_id'],
        'first_name' => $data[0]['first_name'],
        'last_name' => $data[0]['last_name'],
        'user_type' => $data[0]['user_type'],
        'SID' => $data[0]['SID'],
        'SIP' => $data[0]['SIP']
      ));

      return true;
    }

		$db = null;
  }

	public function getMethodData($url){
		if( !isset($url[0]) ){
			return true;
		}

		$db = new Database();

		$method = 'index';
		if( isset($url[1]) ){
			$method = $url[1];
		}

		$data = $db->select("SELECT * FROM provigle WHERE controller = :controller AND method = :method", array(
			':controller' => $url[0],
			':method' => $method
		));


		if( empty($data) ){
			if( MODE == 'DEVELOP' ){
				//insert public method into database
				$db->insert('provigle', array(
					'controller' => $url[0],
					'method' => $method,
					'public' => 'Y',
					'user_group' => 'ALL'
				));
			}

			return true;
		}else{
			if( $data[0]['public'] == 'Y' ){
				return true;
			} else {
				$us = Session::get('userSession');
				if( $us ){
					if( $us['user_type'] == 'ROOT' || $us['user_type'] == 'ADMIN' || $data[0]['user_group'] == 'ALL' ){
						return true;
					} else {
						if( $us['user_type'] == 'USER' && $data[0]['user_group'] == 'ADMIN' ){
							return false;
						}
					}
				} else {
					return false;
				}
			}
		}

		$db = null;
	}

	function error($error = null) {
		require 'controllers/error.php';
		$controller = new Error();
		$controller->index($error);
		return false;
	}

}
