<?php

	class _logsController extends TController
	{
		
		public function run()
		{
	
			$this->file = dirname(__FILE__) . '/views/logs.html';
			
			if($_GET['flush'])
			{
				$this->db('local')->query("DELETE FROM aida_logs");
			}
			
			$logs = $this->db('local')->fetch("SELECT * FROM aida_logs ORDER BY id DESC LIMIT 100");
									
			$this->tpl->set('logs', $logs);
						
		}
		
	}

?>