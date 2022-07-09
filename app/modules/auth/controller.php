<?php
namespace modules\auth;
class controller extends \Controller {

	function get() {
		echo $this->render('index');
	}

    function post() {
        $auth = $this->model('Auth');
        $errors = $auth->attempt_login($_POST['user'], $_POST['password']);

        if(empty($errors)) {
            $this->f3->reroute('/');
        } else {
            $this->f3->set('site_error', $errors);
        }

        $this->get();
    }

    function logout() {
        $_SESSION = [];
        $this->f3->reroute('/');
    }

    function register() {

        if($this->f3->VERB == "POST") {

            if($_POST['password'] == $_POST['password_verify']) {
                $auth = $this->model('Auth');
                $errors = $auth->create_account($_POST['display_name'], $_POST['email'], $_POST['password']);

                if(empty($errors)) {
                    $this->f3->reroute('/');
                } else {
                    $this->f3->set('site_error', $errors);
                }

            } else {
                $this->f3->set('site_error', 'The passwords that you entered did not match.');
            }

		}

        echo $this->render('register');
    }

}
