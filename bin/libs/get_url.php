<?php

		// get url transform
		function get_url( $content )
		{
			$url = $content;
			// Tranformamos todo a minusculas
			$url = strtolower($url);
			$new = '';
			$i=0;
			
			while( strlen($url) != $i )
			{
				$letra = substr($url,$i,1);
				
				$i++;
				
				switch( ord($letra) )
				{
					case 192: case 193: case 194: case 195: case 196: case 197:
					case 224: case 225: case 226: case 227: case 228: case 229:
						$new .="a"; 
						break;
						
						
					case 200: case 201: case 202: case 203: case 232: case 233: 
					case 234: case 235:
						$new .="e"; 
						break;
						
					case 204: case 205: case 206: case 207: case 236: case 237:
					case 238: case 239:
						$new .="i"; 
						break;	
						
					case 217: case 218: case 219: case 220: case 249: case 250:
					case 251: case 252:
						$new .="u"; 
						break;	
						
					case 210: case 211:	case 212: case 213: case 214: case 215: case 216: 
					case 242: case 243: case 244: case 245: case 246: case 248:
						$new .="o"; 
						break;
						
					case 255:
						$new .="y";
						break;
						
					case 209: case 241:
						$new .="n";
						break;
						
					default:
						$new .= $letra;
				}
				
			}
			
			$url = $new;
			
			
			//Rememplazamos caracteres especiales latinos
			
			$find = array('&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;', '&ntilde;');
			
			$repl = array('a', 'e', 'i', 'o', 'u', 'n');
			
			$url = str_replace ($find, $repl, $url);
			
			// mas remplazos
			
			$a = array("√°","√©","√≠","√≥","√∫","√†","√®","√¨","√≤","√π","√§","√´","√Ø","√∂","√º","√¢","√™","√Æ","√¥","√ª","√±","√ß"," ");
			$b = array("a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","n","c","-");
			$url = str_replace($a, $b, $url);
			
			// A√±aadimos los guiones
			
			$find = array(' ', '&', '\r\n', '\n', '+'); 
			$url = str_replace ($find, '-', $url);
			
			// Eliminamos y Reemplazamos dem√°s caracteres especiales
			
			$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
			
			$repl = array('', '-', '');
			
			$url = preg_replace ($find, $repl, $url);
			
			
			$file = $url;
			
			$file = str_replace(' ','-',$file);
			$file = str_replace("'","",$file);
            $file = str_replace("/","-",$file);
            $file = str_replace("]","",$file);
            $file = str_replace("[","",$file);
			$file = str_replace("√±",'n',$file);
            $file = str_replace("√ë",'n',$file);
            $file = str_replace("&ntilde;",'n',$file);
            $file = str_replace("&Ntilde;",'n',$file);
            $file = str_replace('"','',$file);
			$file = preg_replace('[¬∑‚Ä°‚Äö‚Äû‚Ñ¢]','a',$file);
			$file = preg_replace('[¬°¬ø¬¨‚àö]','A',$file);
			$file = preg_replace('[√ï√É≈í]','I',$file);
			$file = preg_replace('[√å√?√ì]','i',$file);
			$file = preg_replace('[√à√ã√?]','e',$file);
			$file = preg_replace('[‚Ä¶¬ª¬†]','E',$file);
			$file = preg_replace('[√õ√ö√ôƒ±‚à´]','o',$file);
			$file = preg_replace('[‚Ä?‚Äú‚Äò‚Äô]','O',$file);
			$file = preg_replace('[ÀôÀòÀö]','u',$file);
			$file = preg_replace('[‚?Ñ≈∏‚Ç¨]','U',$file);
			$file = str_replace('√?','c',$file);
			$file = str_replace('¬´','C',$file);
			$file = preg_replace('[√í]','n',$file);
			$file = preg_replace('[‚Äî]','N',$file);
			
            $file = urlencode($file);
			
            $file = str_replace("%F1",'n',$file);
            $file = str_replace("%28",'(',$file);
            $file = str_replace("%29",')',$file);
			
			return $file;
			
		}
		


?>