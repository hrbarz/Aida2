<?php

	function __autoload( $name ) 
	{
		$_PATH = dirname(__FILE__) . '/../../app/';
		
		if( substr($name,0,1) == '_' )
		{
			return false;
		}
		
		if( strpos($name, 'Query') !== false )
		{
			$name = str_replace('Query','',$name);
			require_once $_PATH . 'queries/' . $name . '.php';
			return true;
		}
		
		require_once $_PATH . 'models/'. $name . '.php';
		
		
	}
	
?>