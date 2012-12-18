<?php
	
	function locate( $lang=false )
	{
		if(!$lang){ $lang = _LANGUAGE; }
		
		setcookie('lang', $lang, time() + 3153600, '/');
							
	}
	
	function __( $txt, $lang=false )
	{
		
		if(!$txt){ return false; }
		
		if(!$_COOKIE['lang'])
		{
			$_COOKIE['lang'] = _LANGUAGE;
		}

		$t = new languages();
		$t->set('code', substr(fs($txt),0,240) );
				
		if( $t->exists() )
		{
			
			$r = $t->show();
			
			if( $r['content_'.$_COOKIE['lang']] )
			{
				$txt = $r['content_'.$_COOKIE['lang']];
			}
						
			return $txt;
		}
				
		$t->set('content_'.$_COOKIE['lang'], $txt);
		$t->save();
		
		return $txt;
		
		
	}

	// "fix" string - strip slashes, escape and convert new lines to \n
	function fs($str)
	{
		$str = stripslashes($str);
		$str = str_replace('"', '\"', $str);
		$str = str_replace("\n", '\n', $str);
		//$str = strtolower($str);
		//$str = str_replace(" ",'-',$str);
		
		$str = str_replace("  ",' ',$str);
		$str = str_replace("  ",' ',$str);
		$str = str_replace("  ",' ',$str);
		$str = str_replace("  ",' ',$str);
		$str = str_replace("  ",' ',$str);
		$str = str_replace("  ",' ',$str);
		$str = str_replace("  ",' ',$str);
		$str = str_replace("  ",' ',$str);
		$str = str_replace("  ",' ',$str);
		$str = str_replace("  ",' ',$str);
		
		$str = trim($str);
		
		return fs_clean( $str );
		
	}
	
	
	function fs_clean($text)
	{
		
			//Rememplazamos caracteres especiales latinos
			
			$find = array('&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;', '&ntilde;');
			
			$repl = array('a', 'e', 'i', 'o', 'u', 'n');
			
			$text = str_replace ($find, $repl, $text);
			
			// mas remplazos
			
			$a = array("á","é","í","ó","ú","à","è","ì","ò","ù","ä","ë","ï","ö","ü","â","ê","î","ô","û","ñ","ç");
			$b = array("a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","n","c");
			$text = str_replace($a, $b, $text);
			
			
			$a = array("�","�","�","�","�","�",'�');
			$b = array("a","e","i","o","u","n",'o');
			$text = str_replace($a, $b, $text);
			
			$text = str_replace("�", 'a', $text);
			
			$a = array('�','�','�','�','�','�');
			$b = array("a","e","i","o","u","n");
			$text = str_replace($a, $b, $text);
	
			
			$file = $text;
			
			//$file = str_replace(' ','-',$file);
			$file = str_replace("'","",$file);
            $file = str_replace("/","-",$file);
            $file = str_replace("]","",$file);
            $file = str_replace("[","",$file);
			$file = str_replace("ñ",'n',$file);
            $file = str_replace("Ñ",'n',$file);
            $file = str_replace("&ntilde;",'n',$file);
            $file = str_replace("&Ntilde;",'n',$file);
            $file = str_replace('"','',$file);
			$file = preg_replace('[·‡‚„™]','a',$file);
			$file = preg_replace('[¡¿¬√]','A',$file);
			$file = preg_replace('[ÕÃŒ]','I',$file);
			$file = preg_replace('[Ì�?Ó]','i',$file);
			$file = preg_replace('[ÈË�?]','e',$file);
			$file = preg_replace('[…» ]','E',$file);
			$file = preg_replace('[ÛÚÙı∫]','o',$file);
			$file = preg_replace('[�?“‘’]','O',$file);
			$file = preg_replace('[˙˘˚]','u',$file);
			$file = preg_replace('[�?�Ÿ€]','U',$file);
			$file = str_replace('�?','c',$file);
			$file = str_replace('«','C',$file);
			$file = preg_replace('[Ò]','n',$file);
			$file = preg_replace('[—]','N',$file);
			
            $file = htmlentities( strip_tags( $file) );
			
            $file = str_replace("%F1",'n',$file);
            $file = str_replace("%28",'(',$file);
            $file = str_replace("%29",')',$file);
			
			return $file;
			
	}
	
	

?>