<?php
namespace m;
use core\DBDriver;

class PostModel extends BaseModel
{
	public function __construct(DBDriver $db)
	{
		parent::__construct($db, 'posts');
	}

	public function addPost($title, $content, $user_id) 
	{	
		return $this->db->insert($this->table, ['title' => $title, 'content' => $content, 'user_id' => $user_id]);
	}

	public function editPost( $id, $title, $content) 
	{
		$where = 'id=:id'; // сразу с маской, как то это не уверсально чтоль
		$paramsForSet = ['title' => $title, 'content' => $content];
		$paramsForWhere = ['id'=> $id];
		return $this->db->update($this->table, $paramsForSet, $where, $paramsForWhere);	
	}

	public function veiwPost($id) 
	{
		$sql = sprintf(
		'SELECT title, content, date_c, login 
		FROM %s 
		INNER JOIN users 
		ON posts.user_id = users.id WHERE posts.id=:id',
		$this->table);

		return $this->db->select($sql, ['id' => $id], DBDriver::FETCH_ONE);
	}

	public function userPosts($user_id) 
	{
		$sql = sprintf('SELECT * FROM %s WHERE user_id =:u_id ORDER BY id DESC', $this->table);
		return $this->db->select($sql, ['u_id'=> $user_id]);
	}

	public function isTitleExist($title) 
	{	
		$sql = sprintf('SELECT title FROM %s', $this->table);
		return in_array($title, $this->db->select($sql));
	}

	public function deletePost($id)
	{
		$where = 'id=:id';
		$params = ['id' => $id];
		return $this->db->delete($this->table, $where, $params);
	}
}