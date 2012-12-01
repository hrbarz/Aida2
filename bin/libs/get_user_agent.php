<?php

	function get_user_agent()
	{
	
		$browser = false;
		
		// determina que explorador usan
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';  
		$user_agent = strtolower($user_agent);
		
		
		// NAVEGADORES DE VERDAD
		if (strpos($user_agent, 'opera') !== false) 
		{  
		   $browser = 'opera';  
		}
		elseif (strpos($user_agent, 'firefox') !== false)
		{  
		   $browser = 'firefox';  
		} 
		elseif (strpos($user_agent, 'safari') !== false) 
		{  
		   $browser = 'safari';  
		} 
		elseif (strpos($user_agent, 'apple') !== false) 
		{  
		   $browser = 'safari'; 
		} 
		elseif (strpos($user_agent, 'msie') !== false) 
		{  
		   $browser = 'explorer';
		} 
		
		// MOBILE
		if (strpos($user_agent, 'blackberry') !== false)
		{  
		   $browser = 'mobile';  
		} 
		elseif (strpos($user_agent, 'java') !== false)
		{  
		   $browser = 'mobile';  
		}
		elseif (strpos($user_agent, 'mobile') !== false)
		{  
		   $browser = 'mobile';  
		}
		elseif (strpos($user_agent, 'iphone') !== false)
		{  
		   $browser = 'mobile';  
		}
		elseif (strpos($user_agent, 'ipad') !== false)
		{  
		   $browser = 'mobile';  
		} 

		
		// parches mobile
		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i',strtolower($_SERVER['HTTP_USER_AGENT']))){
		   $browser = 'mobile';
		}
		
		if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or
		    ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))){
		   $browser = 'mobile';
		}
		
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
		$mobile_agents = array(
		    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
		    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		    'wapr','webc','winw','winw','xda','xda-');
		
		//buscar agentes en el array de agentes
		if(in_array($mobile_ua,$mobile_agents)){
		   $browser = 'mobile';
		}
		
		if(strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) {
		   $browser = 'mobile';
		}



		
		
		// BOTS
		if (strpos($user_agent, 'butterfly') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'abby') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'page_prefetcher') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'ia_archiver') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'perl') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'catchbot') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'eventalyzer') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'phpsessid') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'siteserver') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'wget') !== false)
		{  
		   $browser = false;  
		}
		elseif (strpos($user_agent, 'proximic') !== false)
		{  
		   $browser = false;  
		}  
		elseif (strpos($user_agent, 'wisponbot') !== false)
		{  
		   $browser = false;  
		}  
		elseif (strpos($user_agent, 'wordpress') !== false)
		{  
		   $browser = false;  
		}
		elseif (strpos($user_agent, 'feedhub') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'google') !== false)
		{  
		   $browser = false;  
		}
		elseif (strpos($user_agent, 'microsoft') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'utmz') !== false)
		{  
		   $browser = false;  
		} 
		elseif (strpos($user_agent, 'python') !== false)
		{  
		   $browser = false;  
		}
		elseif (strpos($user_agent, 'snapbot') !== false)
		{  
		   $browser = false;  
		}
		elseif (strpos($user_agent, 'googlebot') !== false) 
		{  
		   $browser = false;
		} 
		elseif (strpos($user_agent, 'bonecho') !== false) 
		{  
		   $browser = false;
		} 
		elseif (strpos($user_agent, 'slurp') !== false) 
		{  
		   $browser = false;
		} 
		elseif (strpos($user_agent, 'msnbot') !== false) 
		{  
		   $browser = false;
		} 
		elseif (strpos($user_agent, 'sitemaps') !== false) 
		{  
		   $browser = false;
		} 
		elseif (strpos($user_agent, 'lotus-notes') !== false) 
		{  
		   $browser = false;
		} 
		elseif (strpos($user_agent, 'curl') !== false) 
		{  
		   $browser = false;
		} 	
		elseif (strpos($user_agent, 'bot') !== false) 
		{  
		   $browser = false;
		} 		
		elseif (strpos($user_agent, 'metauri') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'rank') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'ning') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'hit') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'voyager') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'js-kit') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'oneriot') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'mozilla/4.0 (compatible; msie 7.0; windows nt 6.0)') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'crawler') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, '@') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'ru; rv:1.9') !== false) 
		{  
		   $browser = false;
		}
		elseif (strpos($user_agent, 'rv:1.8.1') !== false) 
		{  
		   $browser = false;
		}
		elseif(strpos($user_agent, '1.6.0_24') !== false)
		{
			$browser = false;
		}
		
		
		
		
		if( $browser == 'mobile' AND strlen($_SERVER['HTTP_ACCEPT']) < 5 )
		{
			 $browser = false;
		}

		
		return $browser;

	}


?>