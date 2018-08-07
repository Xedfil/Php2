<?php 

namespace core;

class Request
{
	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';

	private $get;
	private $post;
	private $server;
	private $cookie;
	private $file;
	private $session;

	public function __construct($get, $post, $server, $cookie, $file, $session)
	{
		$this->get = $get;
		$this->post = $post;
		$this->server = $server;
		$this->cookie = $cookie;
		$this->file = $file;
		$this->session = $session;
	}

	private function getValueFrom($array, $key = null)
	{
		if (!$key) {
			return $array;
		}

		if (isset($array[$key])) {
			return $array[$key];
		}

		return null;
	}

	public function get($key = null)
	{
		$array = $this->get;
		return trim($this->getValueFrom($array, $key));
	}

	public function post($key = null)
	{
		$array = $this->post;
		return trim(htmlspecialchars($this->getValueFrom($array, $key)));
	}

	public function isPost()
	{
		return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
	}

	public function isGet()
	{
		return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
	}

	public function session($key = null)
	{
		return $this->getValueFrom($this->session, $key);
	}

	public function FunctionName($array, $key = null)
	{
		return isset($array[$key]); // сча понял кароч что можно просто обращаться к массиву с [] и все, но выходит длинее
	}

}