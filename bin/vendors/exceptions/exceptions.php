<?php


	class exceptions extends TModel
	{
		public $table = 'aida_logs';
		
		public function __construct()
		{
			$this->create();
			
			parent::__construct();
		}
		
		
		public function create()
		{
			
			$sql = "
					CREATE TABLE IF NOT EXISTS `". $this->table."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `domain` varchar(100) NOT NULL,
					  `url` varchar(250) NOT NULL,
					  `code` varchar(100) NOT NULL,
					  `content` text NOT NULL,
					  `registered` datetime NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
					";
			
						
			$this->db('local')->query($sql);
			
			
		}
		
	}
	
	
	
	function _error_log_( $code='sql', $txt )
	{
		
		$e = new exceptions();
		$e->set('domain', $_SERVER['SERVER_NAME']);
		$e->set('url', $_GET['p']);
		$e->set('code', $code);
		$e->set('content', $txt);
		$e->set('registered', date('Y-m-d H:i:s'));
		$e->save();
		
	}
	

?>