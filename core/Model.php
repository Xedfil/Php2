<?php	
namespace core;

class Model 
{
	public static function template($filename, $vars = []){
		extract($vars); // создает переменные $key = $value
		
		ob_start(); // сохранить в буфер
		include "v/$filename.php";
		return ob_get_clean();
	}

	public static function checkController($controller) {
		return preg_match("/^[a-zA-Z0-9_]+$/", $controller); 
	}

	public function inArrayR($needle, $haystack, $strict = false) { //поиск в многомерном массиве
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->inArrayR($needle, $item, $strict))) {
				return true;
			}
		}

		return false;
	}
}