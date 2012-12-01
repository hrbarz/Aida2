<?php

	class homeController extends TController
	{
		public function index()
		{
			$this->file = 'home.html';
						
			$this->tpl->set('name', $this->page['name']);						
		}
		
		public function redirect()
		{
			$data['name'] = rand(1,200);
			$url = _link( 'hola_mundo',  $data );
			
			redirect( $url );
		}
		
	}

?>