<?php

	function is_mobile( $v )
	{
		
		 $mobile[] = 'ipod';
		 $mobile[] = 'iphone';
		 $mobile[] = 'ipad';
		 $mobile[] = 'android';
		 $mobile[] = 'opera mini';
		 $mobile[] = 'blackberry';
		 $mobile[] = 'palm os';
		 $mobile[] = 'windows ce';
		 $mobile[] = 'Bada';
		 $mobile[] = 'Windows Phone';
		 $mobile[] = 'Symbian';
		 
		 $mobile = implode('|',$mobile);
		 
		 return eregi( $mobile, $_SERVER['HTTP_USER_AGENT'] );

		
	}

?>