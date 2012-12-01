<?php

	class postController extends TController
	{
		
		public function fetch()
		{
			$this->file = 'post_fetch.html';
			
			$query = new postQuery();
			$query->limit = 10;
			$r = $query->run();
									
			$this->tpl->set('results', $r);
			$this->tpl->set('paginator', $query->nav);
				
		}
		
		public function edit()
		{
			$this->file = 'post.html';	
		}
		
		public function create()
		{
			/*
			$post = new post();
			$post->set('title', 'The standard Lorem Ipsum passage, used since the 1500s');
			$post->set('content', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
			$post->save();
			*/
			
			$post = new post(4);
			$r = $post->show();
			
			print_r($r);
			
			//echo 'post-created:'. $post->get('id');
		}
		
	}

?>