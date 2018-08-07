<?php
	define('ROOT', '/d6/blog/');
	use core\DB;
	use m\PostModel;
	use core\Model;
	use m\UserModel;
	

	spl_autoload_register(function ($classname) {
		require_once __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
	});
	
	session_start();

	$params = explode('/', $_GET['php1chpu']); // ЧПУ Параметры,  
	$end = count($params) - 1;
	
	// if($params[$end] === ''){ // Убераем последний параметр если, он после слэша пустой. зачем?
	// 	unset($params[$end]);
	// 	$end--;
	// }

	$controller = trim(isset($params[0]) && $params[0] !== '' ? $params[0] : 'post');
	
	switch ($controller) {
	case 'post':
		$controller = 'Post';
		break;
	case 'user':
		$controller = 'User';
		break;
	
	default:
		$controller = 'Error';
		$params[1] = 'err404';
		break;
	}	

	$action = isset($params[1]) && $params[1] !== '' && !is_numeric($params[1]) ? $params[1] : 'home';
	$action = sprintf('%sAction', $action);

	// здесь есть ошибка если ввести левый актион крашиться
	// var_dump($params);
	// echo $action;
	// die;
	$request = new core\Request($_GET, $_POST, $_SERVER, $_COOKIE, $_FILES, $_SESSION); 

	$controller = sprintf('c\%sController', $controller);
	$controller = new $controller($request);
	$controller->$action();
	if ($controller->checkError()) {
		$controller = new c\ErrorController($request); 
		$controller->err404Action();
	}
	$controller->render();
