<?php

	
	class TQuery extends TGlobal
	{
	
		# atributes 
		public $search		= false;
		public $key			= 'id';
		public $order		= 'id DESC';
		public $limit		= 10;
		public $start		= 0;
		public $current		= 0;
		public $total		= 0;
		public $url			= false;
		public $where		= false;
		public $model		= false;
		public $group		= 'id';
		public $select		= false;
		public $table		= false;
		public $idb			= 'local';
		public $nav			= false;
		public $data		= false;
		public $sql_extra   = false;
		public $sql_join	= false;
		public $ids			= array();
		public $join		= array();
		public $join_table	= array();
		
		# constructor de la clase
		public function __construct()
		{			
			
			$model = new $this->model();
			$this->idb = $model->idb;
			$this->table = $model->table;
						
			parent::__construct();			
		}	
		
		public function join_define( $table, $sql )
		{
			$this->join_table[ $table ] = $sql;
		}
		
		public function join( $table )
		{
			$this->join[ $table ] = true;
		}
		
		public function join_sql( $table )
		{
			
			if(!$this->join){ return false; }
			
			foreach($this->join as $table=>$value)
			{
					
				$this->sql_join .= $this->join_table[ $table ];	
					
			}
						
		}
		
		# run query
		public function run( $return = false )
		{
						
			// init query vars
			$this->sql_extra	= "";
			$this->sql_join	= "";
			
			$this->extra();
					
			// group by / order by
			if($this->group)
			{
				$this->sql_extra .= " GROUP BY ". $this->group;
			}
			
			if($this->order)
			{
				$this->sql_extra .= " ORDER BY ". $this->order;
			}

			$this->join_sql();
			
			
			
			// final query
			$sql = "
			SELECT ". $this->key ." as id ". ($this->fields ? ',' . $this->fields : '' ) ."
			
			FROM ". $this->table ."
			". $this->sql_join ."	
					
			WHERE 1=1
			". $this->where ."
			". $this->sql_extra ."
			";
			
			
			$this->sql = $sql;
			
			
			if($return)
			{
				return $this->sql;
			}
			
			if(!$this->limit)
			{
				$r = $this->db( $this->idb )->fetch( $this->sql );
				$this->compile( $r, $this->type );
				
				return $this->data;
			}
			
			// instanciamos paginador
			$paginador = new paginator();
			$paginador->sql = $sql;
			$paginador->limit = $this->limit;
			$paginador->current = ( $this->current ? $this->current : $_GET['page'] );
			$paginador->start = $this->start;
			$paginador->total = $this->total;
			$paginador->idb = $this->idb;
			
			
			$results = $paginador->run();
			
					
			$this->nav	 = $paginador->navigation( $this->url );
			$this->data	 = $this->compile( $results, $this->type );
			
			return $this->data;
			
		}
		
		# filtros extra
		public function extra()
		{
			
		}
		
		# compile results
		public function compile( $results, $type )
		{
			
			if(!$this->model){ return false; }
			
			$data = array();
			
	        if( is_array( $results ) )
	        {
				$i=0;
	            foreach( $results as $r )
	            {

					$this->ids[$i] = $r['id'];
	                
					$fields = $r;
					unset($fields['id']);
	                
	                if(count($fields) > 0){ $fields['_id'] = $r['id']; }
	                
	                $model = new $this->model( $r['id'], $this->idb );
	                $data[] = $model->show( $this->type );
					$i++;
	            }
				
	        }
			
			$this->ids = implode(',', $this->ids);
			
	        return $data;
			
		}
		
		
		public function get_ids()
		{
			$this->ids = array();
			
			$r = $this->db( $this->idb )->fetch( $this->sql );
			
			if($r)
			{
				foreach($r as $item)
				{
					$this->ids[] = $item['id'];
				}
			}
			
			$this->ids = implode(',', $this->ids);
			
			return $this->ids;
			
		}
		
		
	}

?>