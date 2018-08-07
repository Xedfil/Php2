<?php

namespace c;

use core\Request;

class BaseController
{
	protected $title;
	protected $content;
	protected $err404;
	protected $request;

	public function __construct(Request $request)
	{
		$this->title = 'Php2';
		$this->content = '';
		$this->err404 = false;
		$this->request = $request;
	}

	public function render()
	{
		echo $this->build(
				__DIR__ . '/../v/v_main.php',
				[
					'title' => $this->title,
					'content' => $this->content
				]
			 );
	}

	protected function build($template, array $params = [])
	{
		ob_start();
		extract($params);
		include_once $template;

		return ob_get_clean();
	}

	public function checkError()
	{
		if ($this->err404 == true) {
			return true;
		} 
		return false;
	}
}