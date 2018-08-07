<?php

namespace m;
use core\DB;
use core\DBDriver;

abstract class BaseModel
{
	protected $db;
	protected $table;

	public function __construct(DBDriver $db, $table)
	{
		$this->db = $db;
		$this->table = $table;
	}

	public function getAll()
	{
		$sql = sprintf('SELECT * FROM %s ORDER BY id DESC', $this->table);
		return $this->db->select($sql);
	}

	public function getById($id)
	{
		$sql = sprintf('SELECT * FROM %s WHERE id = :id', $this->table);
		return $this->db->select($sql, ['id' => $id], DBDriver::FETCH_ONE);
	}

	public static function checkId($id) 
	{
		return preg_match("/^[0-9]+$/", $id); 
	}
}