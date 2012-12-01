<?php

	/************************************************************
	# Aida 12.12 - Autor: Rodrigo Ramirez - xpromx@gmail.com
	*************************************************************/
	
	/**
	* constants defined
	* paths, folders of the system.
	*/
	define('_CONFIG'		,'/config');
	define('_VENDORS'		,'/vendors');
	define('_PUBLIC'		,'/public');
	define('_TEMPLATE'		,'/views');
	define('_PAGES'			,'/pages');
	define('_CRON'			,'/cron');
	define('_AJAX'			,'/ajax');
	define('_CONTROLLERS'	,'/controllers');
	define('_SYSTEM'		,'/system');
	define('_LIBS'			,'/libs');
	
	/**	
	* global vars : databases, templates, pages, app, memcache, system
	* called in system/global.php
	*/
	$dbs  = array();
	$tpl  = false;
	$page = array();
	$app  = array();
	$memcache = false;
	$system = array();
	$links = array();
	
	/**
	* global includes
	* system/global.php first included, because everything is extended on TGloba
	*/
	require_once 'system/global.php';	


	/** 
	* Aida: main class.
	*/
	class Aida
	{
	
		// atributes
		public $settings	= array();
		public $config		= array();
		public $controller	= 'home';
		public $method		= 'index';
		public $app			= false;
		public $databases	= array();

		
		/**
		* files are included here, the settings of the project and the settings of the app is included  in the constructor class
		* smarty is instanced here as $tpl, and the session is initialized
		*/		
		public function __construct()
		{
			
			global $tpl, $app;
			
			// load files
			$this->library( dirname(__FILE__) .  _SYSTEM );
			$this->library( dirname(__FILE__) .  _LIBS );
			$this->plugins( dirname(__FILE__) .  _VENDORS );
			
			$this->config = $this->config( dirname(__FILE__) . '/..' . _CONFIG . '/settings.yml' );
			
			$this->app();
			
			// session
			session_name("Aida-". $this->settings['project']['name'] );
			session_start();
			
			// erros
			if( $this->settings['project']['error'] )
			{
				error_reporting(E_ALL & ~E_NOTICE);
				ini_set("display_errors", 1);
			}
			
			// instance of template
			$tpl = new template( _APP . _TEMPLATE . '/' );
			$this->tpl = $tpl;
			
			// routings
			$this->routing();
			
			// memcache
			$this->memcache_connect();
			
			// languages
			$this->languages();
			
			// exceptions
			$this->exceptions();
			
		}
		
		
		/**
		* this function run the app, paths and files are calling here.
		*/
		public function run()
		{
						
			$_VIEW = _APP . '/' . _TEMPLATE . '/';
			$_PATH =  _APP . '/' . _CONTROLLERS . '/';
			
			
			$method = $this->method;
			$controller = $this->controller . 'Controller';
			
			if( !file_exists( $_PATH .'/'. $this->controller . '.php'  )){ set_error_log("File don't exists : <strong> ". _PAGES .'/'. $this->controller .'.php' ." </strong>", 1); }
			require_once( $_PATH .'/'. $this->controller . '.php' );
			if( !class_exists( $controller ) ){ set_error_log("class don't exists : <strong> ". $controller ." </strong>", 1); }

						
			$c = new $controller();
			$c->$method();

			if( $c->file )
			{
				if( !file_exists( $_VIEW .'/'. $c->file ) ){ set_error_log("File don't exists : <strong> ". $c->file ." </strong>", 1); }

				$this->tpl->load( $c->file );
			}
			
		}
		
		/**
		* check the correct routing and complete the params
		*/
		public function routing()
		{
			global $page, $links;
			
			$_PAGE = explode('/', $_GET['p']);
			
			// lang detect
			if( $_PAGE[0] == 'lang'  )
			{

				if( in_array($_PAGE[1], $this->config['languages']['codes']) )
				{
					locate( $_PAGE[1] );
				}
				
				$_GET['p'] = str_replace( $_PAGE[0].'/'.$_PAGE[1],'', $_GET['p']);
				
				redirect( $_GET['p'] );
				
			}
			
			$links = $this->settings['routings'];
			
			foreach( $this->settings['routings'] as $k => $routing )
			{
								
				if( $this->routing_match( $_GET['p'], $routing ) )
				{
					
					$controller = explode(':', $routing['controller']);
					
					$page['_controller'] = $controller[0];
					$page['_method'] = $controller[1];
					
					$this->controller = $controller[0];
					$this->method = $controller[1];
					
				}
				
			}
			
		}
		
		/**
		* verific with routing match with the actual url
		* $url: string (url to extract)
		* $routing: string
		*/
		public function routing_match( $url, $routing )
		{
			$url = '/'.$url;
			$path = trim($routing['path']);
			$path_regex = $path;
							
			$params = $this->routing_regex( $path );
			
			if($params)
			{

				foreach($params as $param)
				{

					switch( $routing['security'][$param] )
					{
						case 'int':
							$r = '[\d]+';
							break;
							
						default:
							$r = '[\w]+';
							break;
					}
					
					$path_regex = str_ireplace('{'.$param.'}',$r,$path_regex);
				}			
			}
			
			$path_regex = str_replace('/','\\/', $path_regex);
			$regex = '#^'. $path_regex.'\/?$#i';

			if(preg_match( $regex, $url))
			{
				$this->routing_params( $regex, $url, $params );				
				return true;
			}
			
			return false;			
		}
		
		
		/**
		* extract the params of the routing and the actual url
		* $regex: string (regular expresión)
		* $url: string (url to extract)
		* $params: string (params to find)
		*/
		public function routing_params( $regex, $url, $params )
		{
			global $page;
			
			$regex = str_replace('[','([', $regex);
			$regex = str_replace(']+',']+)', $regex);
			
			preg_match_all($regex, $url, $partes);	
			
			foreach($params as $k=>$param)
			{
				$page[$param] =	$partes[1][$k];
			}		
						
		}
		
		/**
		* validating the routing
		* $path: string (example: /home/index )
		*/
		public function routing_regex( $path )
		{
			
			$regex = '/{(.*?)}/';
			preg_match_all($regex, $path, $partes);
	 
			return $partes[1];
			
		}
		
		/**
		* validating the routing
		*/
		public function app()
		{
		
			if(!$this->config){ return false; }
			
			foreach($this->config['apps'] as $app=>$config)		
			{
				if( $this->is_app( $config['domain'] , $_SERVER['SERVER_NAME'] ) )
				{
					$this->app = $config;
					
					$_PATH = dirname(__FILE__) . '/..' ._PUBLIC . '/'. $app.'/';
					
					define('_APP', $_PATH);
					define('_URL', $config['domain']);
					define('_ASSETS', 'http://' . $config['domain'] . '/' . $app . '/assets/' );
					
					$this->settings = $this->config( _APP . _CONFIG . '/settings.yml' );
					$this->settings['routings'] = $this->config( _APP . _CONFIG . '/routing.yml' );
					$this->databases = $this->config( dirname(__FILE__) . '/..' . _CONFIG . '/database.yml' );
					
					// database:connect default
					if( $this->settings['database'] )
					{
						foreach( $this->settings['database'] as $name=>$connect )
						{
							if($connect){ $this->database_connect($name); }
						}
					}
										
				}
			}
		}
		
		
		public function is_app( $app, $domain )
		{
			
			if( $app == $domain )
			{
				return true;
			}
			
			if( strpos($app, '*') !== false )
			{
				
				$app = str_replace('*.','', $app);
				
				$c = explode('.', $domain);
				$domain = str_replace($c[0].'.', '', $domain);
								
				if( $app == $domain )
				{
					return true;
				}
				
			}
			
			return false;
		}
		
		/**
		* included the folders in the path
		* $path: string (path to plugins folder)
		*/
		public function plugins( $path )
		{
			
			$dir = opendir( $path ); 
			while ($folder = readdir($dir))
			{
				
				if( strlen($folder) > 2 )
				{
					require_once $path .'/'. $folder .'/_main.php';
				}
				
			}
			
		}
		
		/**
		* included the files in the path
		* $path: string (path to library folder)
		*/
		public function library( $path )
		{
			
			$dir = opendir( $path ); 
			while ($file = readdir($dir))
			{
				
				if( strpos($file,'.php') !== false AND substr($file,0,1) != '.' )
				{
					require_once $path .'/'. $file;
				}
				
			}
			
		}
		
		
		/**
		* load the config files in yaml extension
		* $path: string (path to config file)
		*/
		public function config( $path )
		{

			$data = Spyc::YAMLLoad( $path );
			return $data;
			
		}
		
		
		/**
		* connection MEMCACHE
		*/
		public function memcache_connect()
		{
			global $memcache;
			
			if( !function_exists('memcache_connect') ){ return false; }
			
			if($this->settings['memcache'])
			{
				$memcache= new memcache();
				$memcache->connect( $this->settings['memcache']['host'] , $this->settings['memcache']['port']);
			}
			
		}
		
		
		/**
		* connection db
		* $name: string
		* $database: string (optional)
		*/
		public function database_connect( $name, $database=false )
		{
			global $dbs;
						
						
			$db = $this->databases[ $name ];
						 			
			// [ERROR] db no info 
			if( !is_array($db) )
			{
				set_error_log("database info don't exists : <strong> ". $name ." </strong>", 1); 
			}
			
			$dbs[ $name ] = new database();
			$dbs[ $name ]->project = $this->settings['project']['name'];
			$dbs[ $name ]->email = $this->settings['project']['email'];
			$dbs[ $name ]->databases = $this->databases;
			$dbs[ $name ]->security = $this->settings['project']['security'];
			$dbs[ $name ]->connect( $db['host'] , $db['user'] , $db['pass'] , ( $database ? $database : $db['name']) );
			
			
		}
		
		# get connection
		public function db( $name )
		{
			global $dbs;
				
			return $dbs[ $name ];
		}
		
		/**
		* languages: load
		**/
		public function languages()
		{
			if(!$this->config['languages']['codes']){ return false; }
			
			define('_LANGUAGE', $this->config['languages']['default']);
						
			$lang = new languages();
			$lang->langs = $this->config['languages']['codes'];
			$lang->run();
			
		}
		
		/**
		* exceptions : load
		**/
		public function exceptions()
		{
			$e = new exceptions();
		}
				
	}

?>