<?php

	class loginController extends TController
	{
		
		public function index()
		{
			$this->file = 'login.html';
			
			if( $_POST )
			{
				$this->connect();
			}
		}
		
		public function connect()
		{
			if(  $_POST['user'] == 'admin' )
			{
				redirect('/home');
				return true;
			}
			
			return false;
		}
		
	}

?>