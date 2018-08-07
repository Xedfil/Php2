<?php

namespace m;
use core\DBDriver;

class UserModel extends BaseModel
{
	public function __construct(DBDriver $db)
	{
		parent::__construct($db, 'users');
	}

	public function isAuth()
	{
		$isAuth = false;
	
		if(isset($_SESSION['is_auth']) && $_SESSION['is_auth']){
			$isAuth = true;
		}
		elseif(isset($_COOKIE['login']) && isset($_COOKIE['password'])){
			$user = $this->getUserByLogin($_COOKIE['login']);
			if($user && $_COOKIE['password'] == hash('sha256', $user['password'])){
				$_SESSION['is_auth'] = true; // изменяем сессию что бы проверки были короче.
				$_SESSION['user_id'] = $user['id'] ;	
				$_SESSION['username'] = $user['login'] ;
				$isAuth = true;
			}
		}
			return $isAuth;
	}

	public function getUserByLogin($login) 
	{
		$sql = sprintf('SELECT * FROM %s WHERE login=:l', $this->table);
		return $this->db->select($sql, ['l'=> $login], DBDriver::FETCH_ONE);
	}

	public function userAdd($login, $password)
	{
		return $this->db->insert($this->table, ['login' => $login,'password' => $password]);
	}	
}