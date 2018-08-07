<?php

namespace c;

/**
* 
*/
class ErrorController extends BaseController
{
	public function err404Action()
	{
		$this->title .= ' - ошибка 404';
		$this->content = $this->build(__DIR__ . '/../v/v_err404.php', []);
	}
}