<?php

	
	class TGlobal
	{
		
		public $tpl;
		public $dbs;
		public $app;
		public $params;
		
		public function __construct()
		{
			global $dbs, $tpl, $app, $page, $Aida, $memcache, $lang;
			
			$this->tpl  = $tpl;
			$this->dbs  = $dbs;
			$this->app  = $app;
			$this->page = $page;
			$this->memcache = $memcache;
			$this->lang = $lang;
						
		}
		
		public function __reload()
		{
			global $dbs, $tpl, $app, $page, $Aida, $memcache, $lang;
			
			$this->tpl  = $tpl;
			$this->dbs  = $dbs;
			$this->app  = $app;
			$this->page = $page;
			$this->memcache = $memcache;
			$this->lang = $lang;
		}
		
		public function db( $name )
		{
			
			global $dbs;
				
			$this->dbs = $dbs;
			
			return $this->dbs[ $name ];
			
		}
		
		
	}

?>