<?php

namespace c;

use m\UserModel;
use m\PostModel;
use core\DB;
use core\Model;
use core\DBDriver;

class PostController extends BaseController
{
	public function homeAction()
	{
		$this->title .= ' - главная';
		$userObj = new UserModel(new DBDriver(DB::connect()));
		$mPost = new PostModel(new DBDriver(DB::connect()));	
		$hidden = !$userObj->isAuth(); // если не авторизирован скрыть edit, add, logout; Сделать видимым авторизацию.
		$all_posts = $mPost->getAll();
		$user_posts = $mPost->userPosts($this->request->session('user_id'));

		$this->content = $this->build(
				__DIR__ . '/../v/v_home.php',
				[
					'user_posts'=> $user_posts,
					'list' => $all_posts,
					'hidden' => $hidden,
				]
			);	
	}

	public function veiwAction()
	{
		$userObj = new UserModel(new DBDriver(DB::connect())); // сколько раз подключаеться?
		$mPost = new PostModel(new DBDriver(DB::connect()));
		$id = $this->request->get('id');
		$content = false; 
		if ($mPost->checkId($id)) {
			$content = $mPost->veiwPost($id);
		} 
		if($content){
			$this->content = $this->build(
				__DIR__ . '/../v/v_post.php',
				[
					'content' => $content
				]
			);
			$this->title .= ' - '. $content['title'];
		} else {
			$this->err404 = true;
		}
	}

	public function addAction()
	{
		$this->title .= ' - добавить';
		$userObj = new UserModel(new DBDriver(DB::connect())); // сколько раз подключаеться?
		$mPost = new PostModel(new DBDriver(DB::connect()));
		
		if(!$userObj->isAuth()) {
			header('location: index.php?c=login');
			exit();
		}	

		if($this->request->isPost()){
			$title = $this->request->post('title');
			$content = $this->request->post('content');
			
			if($title == '' || $content == ''){
				$msg = 'Заполните все поля';
			} elseif ($mPost->isTitleExist($title)) {
				$msg = 'имя занято, пожалуйста выберите другое';
			} else{
				$user_id = $this->request->session('user_id');
				$id = $mPost->addPost($title, $content, $user_id);
				header("Location: " . ROOT . "post/veiw?id=$id");
				exit();
			}
		}
		
		$this->content = $this->build(
				__DIR__ . '/../v/v_add.php',
				[
					'msg' => $msg,
					'content' => $content
				]
			);	
	}

	public function editAction()
	{
		$this->title .= ' - редактировать';
		$userObj = new UserModel(new DBDriver(DB::connect())); // сколько раз подключаеться? сделал синглтон но..
		$mPost = new PostModel(new DBDriver(DB::connect()));
		$config = new Model;

		if(!$userObj->isAuth()) {
			header('location: index.php?c=login');
			exit();
		}	

		$id = $this->request->get('id'); // не стал проверять, вроде в препаре защита есть так что покс
		$msg = '';	// сообщение об ошибке по умолчанию пусто
		$user_id = $this->request->session('user_id');
		$list_user = $mPost->userPosts($user_id);

		if($config->inArrayR($id, $list_user)){ // in_array_r в ооп
			$old_content = $mPost->veiwPost($id);

			if(!$old_content){
				$this->err404 = true;
			} else {
				$content = trim(htmlspecialchars($old_content['content']));
				$title = trim(htmlspecialchars($old_content['title']));
						
				if ($this->request->isPost()) {
					$title = $this->request->post('title');
					$content = $this->request->post('content');
					
					if($title == '' || $content == ''){
						$msg =  "Заполните все поля"; 
					} elseif ($old_content['title'] != $title ) {
						if ($mPost->isTitleExist($title)) {
							$msg = 'имя занято, пожалуйста выберите другое';
						}
					} 
					if($msg == '') {
						if ($this->request->Post('delete')) {
							$mPost->deletePost($id);
							header("Location: ". ROOT );
							exit();
						}

						$mPost->editPost($id, $title, $content);
						header("Location: ". ROOT . "post/veiw?id=$id");
						exit();
					}						
				}	
			}
		} else {
			$this->err404 = true;
		}

		$this->content = $this->build(
				__DIR__ . '/../v/v_edit.php',
				[
					'msg' => $msg,
					'title' => $title,
					'content' => $content
				]
			);	
		}
}