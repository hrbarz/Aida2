<?php

	
	# global vars
	define('_PATH', dirname(__FILE__));
	
	# parche favicon
 	if(strpos($_SERVER['REQUEST_URI'],'favicon.ico') !== false){ die(); }
 	
 	# framework include	
	include '../bin/core.php';
	$Aida = new Aida();
	$Aida->run();
	
?>