<?php

class database
{

	// settings
	public $link;
	public $pageError;
	public $security;
	public $db;
	public $Aida;
	
	
	# constructor class
	public function __construct( $Aida=false, $pageError = 'errorConnect.php' )
	{
		$this->pageError = $pageError;
		$this->Aida = $Aida;
	}
	
	
	# connecting to server
	public function connect( $host , $user , $pass , $db )
	{
		global $dbs;
		$this->db = $db;
		
		$this->link = mysql_connect( $host , $user , $pass , true) or set_error_log("can't connect to server",1);
		    
		mysql_select_db( $db , $this->link ) or set_error_log("can't access to database :<strong>". $host ."</strong>",1);
		
		if( $this->security )
		{
			// security dabase query
			$security = new security( $this->link, $db );
			$security->cookie = $this->name;
			$security->emails = $this->email;
			$security->db_main = $this->databases['local']['name'];
			$security->run();
		}
		
		return $this->link;
	}
	
	
	# query results
	public function query( $sql, $id = false, $debug = false )
	{
		global $Aida;
		
		$consulta  = mysql_query( $sql , $this->link );
		
		$error = mysql_error( $this->link );
		
		// muestra el error si hay
		if($error)
		{
			
			$txt[] = $sql;
			$txt[] = $error;
			
			set_error_log( $txt , 2);
			
		}
		
		// muestra la consulta ejecutada
		if($debug)
		{
			
			$txt[] = $sql;

			set_error_log( $txt , 3);
			
		}
		
		// retorna el id, si se pidio
		if( $id )
		{
			return mysql_insert_id( $this->link );
		}
		else
		{
            return $consulta;
		}
		
	}
	
	# fetch row
	public function row( $sql, $debug=false )
	{
		if($debug)
		{
			terminal( $sql );
		}
		
		$consulta = $this->query( $sql );
		$resultados = mysql_fetch_array( $consulta , MYSQL_ASSOC );
		return $resultados;
		
	}
	
	# fetch array
	public function fetch( $sql, $debug=false )
	{
	
		if($debug)
		{
			terminal( $sql );
		}
		
		$data = array();
		$consulta = $this->query( $sql );
		
		while($resultados = mysql_fetch_array( $consulta , MYSQL_ASSOC ))
		{
			$data[] = $resultados;
		}
		
		return $data;
	}
	
	# count query
	public function count( $sql, $debug=false )
	{
		
		if($debug)
		{
			terminal( $sql );
		}
		
		$consulta = $this->query( $sql );
		return mysql_num_rows( $consulta );
	}
	
	# index exists
	public function index_exists( $table, $index )
	{
		
		$index = $this->count("SHOW INDEX FROM ". $table ." WHERE Key_name LIKE '". $index ."' ");

		if( $index )
		{
			return true;
		}
		
		return false;
		
	}
	
	# field exists
	public function field_exists( $table, $field )
	{
		
		$exists = $this->count("SHOW COLUMNS FROM ". $table ." WHERE Field = '". $field ."'");
		
		if( $exists )
		{
			return true;
		}
		
		return false;
		
	}
	
	# table exists
	public function table_exists( $table )
	{
	
		$exists = $this->count(" SHOW TABLES LIKE '". $table ."' ");
		
		if($exists)
		{
			return true;
		}
	
		return false;
	
	}

	# create tabla
	public function create_table( $table, $sql )
	{
		
		if( !$this->table_exists( $table ) )
		{
			
			$this->query( $sql );
			
			return true;
			
		}	
		
		return false;	
		
	}
	
	# create index
	public function create_index( $table, $index, $sql )
	{
		
		if( !$this->index_exists( $table, $index ) )
		{
			
			$this->query( $sql );
			
			return true;
			
		}	
		
		return false;
		
	}
	
	# create field
	public function create_field( $table, $field, $sql )
	{
		
		if( !$this->field_exists( $table, $field ) )
		{
			
			$this->query( " ALTER TABLE ".$table." ". $sql. " " );
			
			return true;
			
		}	
		
		return false;
		
	}
	

}

?>