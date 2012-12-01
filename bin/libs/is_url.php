<?php
	
	function is_url($url)
	{
		//TIPO DE CONEXIîN
		$urlregex = "^(https?|ftp)\:\/\/";
		
		//USUARIO Y CONTRASE„A (opcional)
		$urlregex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
		
		//EL NOMBRE DE LA WEB O LA IP
		$urlregex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*"; // http://x = allowed (ejemplo. http://localhost, http://routerlogin)
		//$urlregex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)+"; // http://x.x = minimum
		//$urlregex .= "([a-z0-9+\$_-]+\.)*[a-z0-9+\$_-]{2,3}"; // http://x.xx(x) = minimum
		
		//PUERTO (opcional)
		$urlregex .= "(\:[0-9]{2,5})?";
		
		//RUTA (opcional)
		$urlregex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
		
		//GET de la ruta (opcional)
		$urlregex .= "(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?";
		
		//ANCLA de la ruta (opcional)
		$urlregex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
		
		//COMPROBAMOS
		return eregi($urlregex, $url);
	}
	
?>
