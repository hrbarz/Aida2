<?php

	set_error_handler('errorHandler');

	# capturar errores php
	function errorHandler( $errno, $errstr, $errfile, $errline, $errcontext)
	{
		/*
		echo 'Into '.__FUNCTION__.'() at line '.__LINE__.
		"\n\n---ERRNO---\n". print_r( $errno, true).
		"\n\n---ERRSTR---\n". print_r( $errstr, true).
		"\n\n---ERRFILE---\n". print_r( $errfile, true).
		"\n\n---ERRLINE---\n". print_r( $errline, true).
		"\n\n---ERRCONTEXT---\n".print_r( $errcontext, true).
		"\n\nBacktrace of errorHandler()\n".
		
		
		print_r( debug_backtrace(), true);
		*/
		
	   switch ($errno)
	   {
	      case E_USER_WARNING:
	      case E_USER_NOTICE:
	      case E_WARNING:
	      case E_NOTICE:
	      case E_CORE_WARNING:
	      case E_COMPILE_WARNING:
	         break;
	      case E_USER_ERROR:
	      case E_ERROR:
	      case E_PARSE:
	      case E_CORE_ERROR:
	      case E_COMPILE_ERROR:
	      
			
					$txt  = "  Fatal error on line ". $errline. " in file ". $errfile;
					$txt .= "<br /> ". $errstr;
	       			$txt .= "<br /> PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
					set_error_log( $txt ,1);
					break;
			
		}

		
		
		
	}


	# get error controller
	function get_error_log()
	{
		if( error_get_last() )
		{
			print_r(error_get_last());
		}
	}
	
	
	# set error controller
	function set_error_log( $e, $level=false ) 
	{ 
		$error = $e;
		if( is_array($e) ){ $error = ''; foreach($e as $txt){ $error .= $txt . '</br>';  } }
		
		switch ($level) 
		{ 
				
			case 1: 
				
				get_error_template('Fatal Error', $error);
				
				exit(1); 
				break; 
				
			case 2: 
				
				get_error_template('Warning', $error);
				
				break; 
				
			case 3: 
				
				get_error_template('Notice', $error);
				
				break; 
				
			case 4: 
				
				get_error_template('Fatal Error', $error); 
				break; 
				
			default: 
				
				get_error_template('Unknown Error', $error);
				
				break; 
				
		} 
		
		
		return true; 
		
	}
	
	
	function get_error_template( $title, $message )
	{
		

		$html = file_get_contents( dirname(__FILE__) . '/error.html' );
		
		$html = str_replace('#title#', $title, $html);
		$html = str_replace('#message#', $message, $html);
		$html = str_replace('#Time#', date('Y/m/d H:i:s'), $html);
		$html = str_replace('#Version#', '' , $html);
		
		if(_LOCAL)
		{
			echo $html;
		}
		
	}
	
	
?>