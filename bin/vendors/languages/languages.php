<?php

	define('_DB_LANGAUGES_', 'aida_languages');

	class languages extends TModel
	{
		
		public function __construct()
		{
			$this->table = _DB_LANGAUGES_;
			$this->idb = 'local';
						
			parent::__construct();
			
		}
		
		public function run()
		{
			
			$this->create();
			
		}
		
		public function create()
		{
			
			$sql = "
					CREATE TABLE IF NOT EXISTS `". _DB_LANGAUGES_ ."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `code` varchar(250) NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `code` (`code`)
					) ENGINE=MyISAM  DEFAULT CHARSET= utf8 AUTO_INCREMENT=1 ;";
			
						
			$this->db('local')->query($sql);
			
			if(!$this->langs){ return false; }
			
			foreach($this->langs as $lang)
			{
				$this->db('local')->create_field( _DB_LANGAUGES_, 'content_'. $lang, 'ADD `content_'. $lang .'` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');		
			}
			
		}
		
	}

?>