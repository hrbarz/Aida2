<?php

class template extends Smarty
{
	// settings
	public $settings = array();
	public $path;
	public $folders = array();
	public $system	= array();
	public $template;
	
	# constructor de la clase
	public function __construct( $path )
	{		
		$this->template 	= $path;
		$this->caching 		= false;
		$this->path			= $this->template;
		$this->compile_dir	= $this->template .'../assets/compile/';
		$this->cache_dir	= $this->template .'../assets/cache/';
		$this->template_dir = $this->path;
		
		$this->getFolders();
		
	}
	
	# load tempalte folders
	public function getFolders()
	{

		$dir = opendir( $this->template . '../../assets/' ); 
		
		while ($file = readdir($dir))
		{
			if( strpos($file,'.') === false )
			{
				$this->folders[] = $file."/";
			}
		}
		
		
		closedir($dir);
	}

	# reload config
	public function reload( $path )
	{
		$this->path			= $path;
		$this->template		= $path;
		$this->template_dir = $this->path;
		$this->compile_dir	= $this->template .'/compile/';
		$this->cache_dir	= $this->template .'/cache/';
	}
	
    # set folders
    public function setFolder( $folder )
    {
        $this->folders[] = $folder;
    }
	
	# set vareables
	public function set($nombre, $valor)
	{
		$this->assign($nombre, $valor);
	}
	
	# cargar plantilla
	public function load( $file )
	{
	
		$html  = $this->fetch( $this->template . $file );
		
		// file no exists
		if( strpos( strip_tags( $html ), 'Smarty error: unable to read resource') !== false )
		{
			set_error_log("File don't exists : <strong> ". $file ." </strong>", 1);
			$html = '';
		}
		
		
		echo $this->parser($html);
	}
	
	# remplazar rutas
	public function parser( $html )
	{
		
		$path = _ASSETS;

		foreach( $this->folders as $folder )
		{
			$html = str_ireplace( '"'. $folder	, '"'.$path.$folder	, $html );
			$html = str_ireplace( "'". $folder	, "'".$path.$folder	, $html );
		}
		
		
		foreach( $this->system as $folder )
		{
			$html = str_ireplace( '"'. $folder	, '"'. $path.$folder	, $html );
			$html = str_ireplace( "'". $folder	, "'". $path.$folder	, $html );
		}		
		
		
		return $html;
		
	}
	
	      	


}

?>