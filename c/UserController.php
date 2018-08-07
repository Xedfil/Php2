<?php

namespace c;
use m\UserModel;
use m\PostModel;
use core\DB;
use core\DBDriver;


class UserController extends BaseController
{
	public function loginAction()
	{	
		$this->title .= ' - login';
		$userObj = new UserModel(new DBDriver(DB::connect()));
		$mPost = new PostModel(new DBDriver(DB::connect()));

		if(isset($_SESSION['is_auth'])) {
			unset($_SESSION['is_auth']);
			unset($_SESSION['user_id']);
		}

		if(isset($_COOKIE['login'])) {
			setcookie('login','', time() - 100, '/');
			setcookie('password','', time() - 100, '/');
		}

		if($this->request->isPost()){
			$login = $this->request->post('login');
			$password = $this->request->post('password');
			$user = $userObj->getUserByLogin($login);

			if (!$user) {
				$msg = 'Такого пользователя не существует';
			} elseif ($user['password'] == $password) { // сделать так что бы был хешированый пароль в бд
				
				$_SESSION['is_auth'] = true;
				$_SESSION['user_id'] = $user['id'] ;	
				$_SESSION['username'] = $user['login'] ;

				if ($_POST['remember']) {
					setcookie("login", $user['login'], time() + 3600 * 24 * 7, '/');
					setcookie('password', hash('sha256', $user['password']), time() + 3600 * 24 * 7, '/');
				}
				
				header("location: ".ROOT."index.php");
				exit();
			} else {
				$msg = 'Неверный пароль';
			}
		}

		$this->content = $this->build(
				__DIR__ . '/../v/v_login.php',
				[
					'msg'=> $msg,
					'login'=> $login
				]
			);	

	}

	public function registrationAction()
	{	
		$this->title .= ' - registration';
		$userObj = new UserModel(new DBDriver(DB::connect()));
		$mPost = new PostModel(new DBDriver(DB::connect()));

		if($this->request->isPost()){
			$login = $this->request->post('login');
			$password = $this->request->post('password');
			$user = $userObj->getUserByLogin($login);

			if (!preg_match("/^[a-zA-Z0-9_-]{4,32}$/", $login) || !preg_match('/^[a-zA-Z0-9_-]{4,32}$/', $password)) {
				$msg = 'Введите минимум 4 символа в строку, строка может содержать латинские символы и цифры так же - и _';
			} elseif ($user) {
				$msg = 'Такой пользователь уже существует, сорян';
			} else {
				$userObj->userAdd($login, $password);
				$user = $userObj->getUserByLogin($login);
				$_SESSION['is_auth'] = true;
				$_SESSION['user_id'] = $user['id'] ;	
				$_SESSION['username'] = $user['login'] ;
				header("location: ".ROOT."index.php");
				exit();
			}

		}

		$this->content = $this->build(
				__DIR__ . '/../v/v_registration.php',
				[
					'msg'=> $msg,
				]
			);	

	}
}