<?php
namespace Adl\Config;

class JasperServer
{
	private $wsdl;
	private $username;
	private $password;
	private $pathToSave;
	
	public function __construct($config)
	{
		$this->loadConfig($config);
	}
	
	private function loadConfig($config)
	{
		$this->wsdl = $config['jasperserver']['wsdl'];
		$this->username = $config['jasperserver']['username'];
		$this->password = $config['jasperserver']['password'];
		$this->pathToSave = $config['jasperserver']['path_to_save'];		
	}
	
	
	public function getWsdl()
	{
		return $this->wsdl;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function getPathToSave()
	{
		return $this->pathToSave;
	}
	
	public function setWsdl($wsdl)
	{
		$this->wsdl = $wsdl;
		return $this;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}
	
	public function setPathToSave($pathToSave)
	{
		$this->pathToSave = $pathToSave;
		return $this;
	}
}

/*
Copyright (C) 2011 Adler Brediks Medrado

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/