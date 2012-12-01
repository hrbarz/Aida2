<?php

	function _link( $code, $data=false )
	{
		
		global $links;
		
		$routing = $links[ $code ];
		
		if(!$routing){ return false; }
		
		if($data)
		{
			foreach( $data as $key=>$value )
			{
				$routing['path'] = str_replace('{'. $key .'}', $value, $routing['path']);
			}
		}
		
		if( strpos($routing['path'],'{') !== false ){ return '/home'; }
		
		return $routing['path'];
		
	}

?>