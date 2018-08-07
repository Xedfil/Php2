<?php

namespace core;

class DB
{
	private static $instance;

	public static function connect()
	{
		if (self::$instance === null) {
			self::$instance = self::getPDO();
			self::$instance->exec('SET NAMES UTF8');
		}

		return self::$instance;
	}

	public static function CheckError($query) 
	{
		$info = $query->errorInfo();

		if ($info[0] != \PDO::ERR_NONE) {
			exit($info[2]);
		}
	}

	public function getPDO()
	{
		$dsn = sprintf('%s:host=%s;dbname=%s', 'mysql', 'localhost', 'blog5');
		return new \PDO($dsn, 'Viktori', '89233172383'); // слэш у пдо для пространства имен
	}
}
