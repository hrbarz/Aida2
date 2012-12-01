<?php

	class blogController extends TController
	{
		
		public function show()
		{
			echo 'show:' . $this->page['id'];
			
			$post = new post( $this->page['id'] );
			$r = $post->show();
			
			print_p($r);
			
		}
		
		public function fetch()
		{
			echo 'hola';
		}
		
	}

?>