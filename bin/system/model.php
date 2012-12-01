<?php

	
	class TModel extends TGlobal
	{
	
		# atributes		
		public $fields 	= array(); 
		public $data 	= array();
		public $query   = array();
		public $id		= false;
		public $table	= false;
		public $key		= 'id';
		public $where	= false;
		public $idb  = 'local';
		
		# constructor de la clase
		public function __construct( $id=false, $idb=false )
		{
			$this->id = $id;
			
			parent::__construct();
			
			if($idb){ $this->idb = $idb; }
			$this->saveFields();
			
			$this->data = $fields;
			
		}
		
		public function show( $type=false )
		{ 
		
			if($this->data){ return $this->data; }

			$r = $this->db( $this->idb )->row("SELECT * FROM ". $this->table . " WHERE id = '". $this->id ."'" );
			$this->data = $r;
			
			return $this->data; 
		}
		
				
		# fields
		public function saveFields()
		{

			if(!$this->table){ return false; }
			
			$r = $this->db( $this->idb )->fetch(" SHOW FIELDS FROM " . $this->table );
			
			foreach( $r as $f )
			{
				$this->fields[ $f['Field'] ] = $f['Field'];
			}
						
			
		}
		
		# set campos
		public function set( $field, $value )
		{
			
			if( $this->fields[ $field ] )
			{
				$this->query[ $field ] = $value;
				
				if($field == 'id')
				{
					$this->id = $value;
				}
				
			}
			
		}
		
		# get campos
		public function get( $field )
		{
			
			return $this->query[ $field ];
			
		}

		
		# loop fields
		public function fields( $union = ',' )
		{
			
			$array = array();
			$sql = "";
			
			if( is_array( $this->query ) )
			{
				
				foreach( $this->query as $key=>$value )
				{
					
					if( $key != $this->key )
					{
						$array[] = $key."='". mysql_real_escape_string($value) ."'";
					}
					
				}
				
				$sql = implode($union, $array);
			}
			
			return $sql;
		}

		
		# save user
		public function save()
		{
			if(!$this->table){ return false; }
			
			$sql = " INSERT IGNORE INTO ". $this->table ."
			SET ". $this->fields() ."
			";
			
			$id = $this->db( $this->idb )->query( $sql , true);
			
			if(!$id)
			{
				return false;
			}
				
			$this->set('id', $id);	
						
			return $id;
			
		}
		
		# update user
		public function update()
		{
			
			if(!$this->table){ return false; }
			
			$sql_where = $this->key . " = '". $this->query[ $this->key ]."' ";
			if($this->where){ $sql_where = $this->where; }
			
			if( $this->query[ $this->key ] || $this->where )
			{
				$sql = " UPDATE IGNORE ". $this->table ."
				SET ". $this->fields() ."
				WHERE ". $sql_where;
				
				$this->db( $this->idb )->query( $sql );
			}
		}
		
		
		# update user
		public function delete()
		{
			
			if(!$this->table){ return false; }
			
			$sql_where = $this->key . " = '". $this->query[ $this->key ]."' ";
			if($this->where){ $sql_where = $this->where; }
			
			if( $this->query[ $this->key ] || $this->where )
			{
				$sql = " DELETE FROM ". $this->table ."
				WHERE ". $sql_where;
				
				$this->db( $this->idb )->query( $sql );
			}
			
		}
		
		# get key id
		public function get_id( $key )
		{
			
			$r = $this->db( $this->idb )->query("SELECT id FROM ". $this->table . " 
												 WHERE ". $this->key . " = '". $this->query[ $this->key ] ."' ");
			
			if($r['id'])
			{
				return $r['id'];
			}
			
			return false;
			
		}
		
		public function exists()
		{
			
			$r = $this->db( $this->idb )->row("SELECT id FROM ". $this->table . " 
												 WHERE ". $this->fields('AND') ."
												");
			if($r['id'])
			{
				$this->set('id', $r['id']);
				return $r['id'];
			}
			
			return false;
		}
		
	}

?>