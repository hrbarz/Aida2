<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of securityclass
 *
 * @author rodrigoramirez
 */
class security
{

	public $db;
	public $cookie = 'security';
	public $emails = 'xpromx@gmail.com';
	public $redirect = 'http://google.com';
	public $db_main = 'aida';
	
   # constructor de la clase
   public function __construct( $link, $name ) 
   {

		$this->link = $link;
		$this->db_name = $name;		
   }

   public function run()
   {
	   // aca hay que chekear si viene el post de otra url, bloquearla.
	   
	   //$_SESSION           = $this->parser( $_SESSION );
	   $_POST              = $this->parser( $_POST );
	   $_GET               = $this->parser( $_GET );
		
	   
	   if( $this->db_name == $this->db_main )
	   {
		   // CONTROL
		   $this->create();
		   $this->check_cookie();
	   	   $this->check_ips();
		   //$this->check_vals( $_SERVER );
	   }
		
   }

	public function create()
	{
		
		$sql = "
				CREATE TABLE IF NOT EXISTS `aida_security` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `ip` varchar(200) NOT NULL,
				  `fecha` datetime NOT NULL,
				  `content` text NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `ip` (`ip`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		
		mysql_query($sql, $this->link);
		
		$sql = "
				CREATE TABLE IF NOT EXISTS `aida_security_rules` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(250) NOT NULL,
				  `value` text NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `name` (`name`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
			   ";
		mysql_query($sql, $this->link);
	}

   public function parser( $array )
   {

        if( $array )
        {

            foreach ($array as $key=>$value)
            {


                $array[$key] = $this->safe($value);


            }

        }

        return $array;

   }


   public function safe( $content )
   {

	   global $Aida;
		
	   $cantidad = strlen($content);
	   $original = $content;
	   
	   if( strlen($content) < 500 )
	   { 
			$content = str_replace('/*', '', $content); 
			$content = str_replace('*/', '', $content); 
	   }
	   
	   
	   $inyect =  array(
			'concat(',
			'exists(SELECT',
			'UNION+SELECT',
			'UNION SELECT',
			'Length((SELECT',
			'(SELECT',
			'::int=1',
			'if (1=1)',
			'"x"="x',
			'"x"="y',
			'and(select 1',
			'Union Select',
			'ascii(',
			'UNION ALL SELECT',
			'UTL_INADDR.GET_HOST_ADDRE',
			'0x6d65676133164756d706572',			
			'UNION+ALL+SELECT'); 
	   
		foreach($inyect as $in)
		{
			if(strpos($content,$in) || strpos(strtolower($content), strtolower($in)) )
			{
				$this->insert_ip();
				header('Location: '. $this->redirect); die();

			}
			
			$content = str_replace($in, 'BLABLABLABLA', $content); 
		}
	   
	   
	   if(!$_SESSION['_system_'][$this->db_name]['tables'])
	   {
		   $r = mysql_query("SHOW TABLES" , $this->link );
		   while($resultados = mysql_fetch_array( $r , MYSQL_ASSOC ))
		   {
			   $data[] = $resultados;
		   }
		   
		   $_SESSION['_system_'][$this->db_name]['tables'] = $data;
	   }
	   
	   
	   if($_SESSION['_system_'][$this->db_name]['tables'])
	   {
		   foreach( $_SESSION['_system_'][$this->db_name]['tables'] as $table )
		   {
		   
			   $value = $table['Tables_in_'. $this->db_name ];
			   			   
			   $strings = array(
									'DELETE FROM '.$value,
									'INSERT INTO '.$value,
									'UPDATE '.$value,
									'DROP '. $this->db_name,
									'DROP TABLE '.$value
	
								);
	
				$content = str_ireplace($strings, "-", $content);
		   
		   
		   }
	   }
	   	   
		return $content;

   }
   
   
   public function get_ip()
   {
  	
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
		
  }
  
  
  public function check_cookie()
  {
   
  		if(isset($_COOKIE[ $this->cookie ]) && ($_COOKIE[ $this->cookie ] == 'on'))
  		{
		
			if(!$this->ip_exists())
			{
				$this->insert_ip();
			}

			header('Location: '. $this->redirect); die();
		}
		
   }
   
   public function check_vals($arrs)
   {
				
		$ru = $this->get_rules();
		
		if(count($arrs) > 0)
		{
		
			foreach($arrs as $i => $val)
			{
				
				if(isset($ru[$i]) &&  $ru[$i]!='')
				{
					$rr = explode('||',$ru[$i]);
					
					foreach($rr as $r)
					{
						if( strpos( $val , $r ) !== false )
						{
							$this->insert_ip();
							header('Location: '. $this->redirect); die();
						}
					}
				}
			}
		}
		
   }
   
   	
   public function get_rules()
   {
		
		$arr = array();
		
		$q = mysql_query('SELECT * FROM aida_security_rules ',$this->link);
	 	while ($r = mysql_fetch_array($q, MYSQL_ASSOC)) 
	 	{
			$arr[$r['name']] = $r['value'];
		}
		
		return $arr;
		
	}
   
   public function check_ips()
   {
   		
   		if(empty($_SERVER['HTTP_USER_AGENT']))
   		{
   			header('Location: '. $this->redirect); die();
   		}
   		
		
		if( $this->ip_exists() )
		{
			header('Location: '. $this->redirect); die();
		}
		
		if(strpos($_SERVER['HTTP_USER_AGENT'],'Havij') !== false  || strpos($_SERVER['HTTP_USER_AGENT'],'sqlmap') !== false || strpos($_SERVER['HTTP_USER_AGENT'],'libwww-perl') !== false )
		{
			$this->insert_ip();
			die();
		}
		
		if($_SERVER['HTTP_USER_AGENT'] == 'Mozilla/5.0 (X11; U; Linux i686; es-AR; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.04 (lucid) Firefox/3.6.13' || $_SERVER['HTTP_USER_AGENT'] == 'libwww-perl/5.805')
		{
			die();
		}
	
   }
   
   public function ip_exists()
   {
	
		$q = mysql_query('SELECT ip FROM aida_security WHERE DATE_ADD(now(), INTERVAL -1 DAY) < registered AND ip = "'.$this->get_ip().'"  ',$this->link);
	 	
		if(mysql_num_rows($q) > 0)
		{
			return true;
		}
		
		return false;
		
	}

   public function insert_ip()
   {
		$ip = $this->get_ip();
		
		ob_start();
		print_r($_SERVER);
		print_r($_POST);
		print_r($_SESSION);
		$s = ob_get_contents();
		ob_end_clean();
		
		setcookie( $this->cookie , 'on' , time()+36000000000,'/');
		
		mysql_query('INSERT INTO aida_security ( ip , registered , content ) VALUES ( "'.$ip.'", NOW() , "'. mysql_real_escape_string($s) .'") ',$this->link);
				
		$s = str_replace("\n",'<br>',$s);
		
		$header = 'From: SocialHint <soporte@powersite.com.ar>' . "\n";
		$header  .= 'MIME-Version: 1.0' . "\n";
		$header .= 'Content-type: text/html' . "\n";
		$subjet	= '[alert] attack detected from: '. $ip.' ';
		
		unset($_SESSION);
		
		$body = '<h1>Details</h1>'.$s;
		mail($this->emails,$subjet,$body,$header);
				
	}

	
}
	
?>