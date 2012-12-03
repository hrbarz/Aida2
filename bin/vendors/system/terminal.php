<?php

	class _terminalController extends TController
	{
		
		public function run()
		{
	
			$this->file = dirname(__FILE__) . '/views/terminal.html';
			
			
			if($_GET['flush'])
			{
				$_SESSION['terminal'] = false;
				header('Location: /@/terminal');
			}
			
			if($_GET['sort'] == 2)
			{
				$_SESSION['terminal_sort'] = true;
			}
			
			if($_GET['sort'] == 1)
			{
				$_SESSION['terminal_sort'] = false;
			}
			
			
			$logs = $_SESSION['terminal'];
		
			if($_SESSION['terminal_sort'])
			{
				$logs = array_reverse($logs);
			}
			
			
			$this->tpl->set('logs', $logs);
						
		}
		
	}
	
	function terminal( $text, $debug=true, $flag=false )
	{
	
		if(!$debug){ return false; }
		
		if(is_array($text))
		{
			ob_start();
			echo '<br /><pre>';
			print_r($text);
			echo '</pre>';
			$text = ob_get_contents();
			ob_clean();
		}
			
		$log['time'] 		= date('H:i:s');
		$log['microtime'] 	= microtime(true);
		$log['lag'] 		= '0.00';
		
		if(!$flag)
		{
			$log['lag'] 	= number_format($log['microtime'] - $_SESSION['terminal_time'],2);
		}
		
		if( is_sql($text) )
		{
			$text = print_sql($text);
		}
		
		$log['text'] 		= $text;
		$log['flag'] 		= $flag;
		$log['url']	 		= $_SERVER['REQUEST_URI'];
		
		if( $log['lag'] >= 0.10 )
		{
			$log['error'] = true;
		}
		
		
		$_SESSION['terminal'][] = $log;
		$_SESSION['terminal_time'] = $log['microtime'];
		
		return $log['lag'];
	}
	
	
	function is_sql( $text )
	{
		$text = trim($text);

		if( substr($text, 0, 6) == "SELECT" )
		{
			return true;		
		}
		
		return false;
		
	}
	
	function print_sql( $text )
	{
		
		$keys = array('=',' ON ',' LIKE ',' DATE_FORMAT',' BY ',' ASC',' DESC',' < ',' > ','!=');
		
		foreach($keys as $key)
		{
			$text = str_replace($key, "<b style='color:yellow'>".$key."</b>", $text);
		}
		
		
		
		$keys = array('SELECT','WHERE','AND','JOIN','FROM','GROUP','ORDER','LIMIT','HAVING');
		
		foreach($keys as $key)
		{
			$text = str_ireplace($key, "<br />".$key, $text);
			$text = str_replace($key, "<b style='color:yellow'>".$key."</b>", $text);
		}
		
		
		return '<p style="color:#FFF;margin:20px">'.$text.'<p>';
	}
	
	

?>