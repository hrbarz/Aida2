<?php

	class paginator extends TGlobal
	{
	
		public $sql;		// consulta a paginar
		public $limit;		// resultados por pagina
		public $current;	// pagina actual
		public $pages;		// cantidad de paginas
		public $start;		// inicio consulta
		public $end;		// fin consulta
		public $total;		// cantidad de resultados
		public $url;		// url de paginacion
		public $idb;		// instancia de base de datos
	
	
		// constructor de la clase
		public function __construct( $sql=false, $limit=10, $pagina=0, $total=false, $label='local' )
		{
			parent::__construct();
			
			$this->idb		= $label;
			$this->total 	= $total;
			$this->sql		= $sql;
			$this->limit 	= $limit;
			$this->current	= $pagina;

			if($sql)
			{
				$this->run();
			}
			
		} 
		
		public function run()
		{
			
			# guardamos la cantidad de resultados si no esta seteado
			if( !$this->total )
			{ 
				$sql = $this->sql;
				$sql = explode('FROM', $sql);
			
				unset($sql[0]);
				$sql[1] = implode(' FROM ', $sql);
				
				$sql = explode('GROUP BY ', $sql[1]);
				
				
				$_GROUP = explode(' ',$sql[1]);
				$_GROUP = ($_GROUP[0]);
				
				$_SELECT = "COUNT(1)";
				
				if( strpos($_GROUP,'.') !== false )
				{
					$_SELECT = "COUNT( DISTINCT(". $_GROUP .") )";
				}
				
				$sql = "SELECT ". $_SELECT ." as cantidad FROM ". $sql[0]." LIMIT 1";
				$r = $this->db( $this->idb )->row( $sql );
				
				
				
				$this->total = $r['cantidad']; 
				
			}
			
			
			
			# calculo del numero de paginas
			$this->currents = ceil( $this->total / $this->limit);
		
			if($this->current <= 1)
			{
				$this->current  = 1;
				$this->start 	= 0;
				$this->end   	= $this->limit;
			}
	
			if($this->current != 1)
			{
				$lvl = $this->current - 1;
				$this->start	= ( $this->limit * $lvl );
				$this->end		= ( $this->limit * $this->current );
			}
			
			return $this->db( $this->idb )->fetch( $this->sql ." LIMIT ". $this->start . "," . $this->limit );
		
		}
		
		// pagina siguiente
		public  function get_next($url)
		{

			$i = $this->current + 1;
	
			if($this->current < $this->currents)
			{
				if( strpos($url, '#page#') !== false )
				{
						return str_replace('#page#',$i, $url);
				}
				else
				{
						return $url ."/".$i;
				}	
			}
				
			return false;

		}
		
		// pagina anterior
		public  function get_back($url)
		{

			$i = $this->current - 1;
	
			if($this->current > 1)
			{
				if( strpos($url, '#page#') !== false )
				{
						return str_replace('#page#',$i, $url);
				}
				else
				{
						return $url ."/".$i;
				}	
			}
				
			return false;

		}
		
		public function navigation( $url=false )
		{
			
			if($url){ $this->url = $url; }
	
			$paginador = array();
	
			/***************************************
			 ** Seteamos Botones de Navegacion
			 ***************************************/
	
			if($this->get_next(''))
			{
				$paginador['next_display']	= true;
			}
			else
			{
				$paginador['next_display']	= false;
			}
			
			if($this->get_back(''))
			{
				$paginador['back_display']	= true;
			}
			else
			{
				$paginador['back_display']	= false;
			}
	
			/***************************************
			 ** Seteamos Vareables de Paginacion
			 ***************************************/
	
			$paginador['current']		= $this->current;
			$paginador['pages']			= $this->currents;
			$paginador['limit']			= $this->limit;
			$paginador['total']			= $this->total;
			$paginador['next']			= $this->get_next( $this->url );
			$paginador['back']			= $this->get_back( $this->url );
			$paginador['numeric']		= $this->get_numeric( $this->url );
	
			$paginador['next_number']	= $this->current+1;
			$paginador['back_number']	= $this->current-1;
			
			$paginador['url']           = str_replace('#page#','',$this->url);

			
			$paginador['url_next']		= $paginador['url'] . $paginador['next_number'];
			$paginador['url_back'] 		= $paginador['url'] . $paginador['back_number'];
			
			$paginador['url_start']		= $paginador['url'] . '1';
			$paginador['url_end']		= $paginador['url'] . $paginador['pages'];
		
			$paginador['numeric']		= $this->get_numeric( $this->url );
			
			$paginador['start']  = ( ($paginador['current']-1) * $this->limit) +1;
			$paginador['end']   = ($paginador['current'] * $this->limit );
			
			if($paginador['end'] > $paginador['total'])
			{
				$paginador['end'] = $paginador['total'];
			}
			
			if($paginador['total'] == 0)
			{
				$paginador['start']  = 0;
				$paginador['end']   = 0;
			}
	
			return $paginador;

	}
	
		
		// listado numerico
		public  function get_numeric( $url )
		{
			
			$datos = array();
			
			if($this->currents > 0)
			{
				
				$cantidad = 4; // + 1
				
				$inicio = 0;
				$fin = 0;
				
				if( ( $this->current+$cantidad ) <= $this->currents ) 
				{
					$fin = $this->current+$cantidad;
					
					if( ( $this->current-$cantidad-1 ) > 0  )
					{
						$inicio = $this->current-$cantidad-1;
					}
					else
					{
						$inicio = 1;
						
						$diferencia = ( $cantidad+2 ) - $this->current;
						
						
						if( ($fin + $diferencia) > $this->currents )
						{
							$fin = $this->currents;
						}
						else
						{
							$fin = $fin + $diferencia;
						}
					}
					
				}
				else
				{
					$diferencia = ( $this->current+$cantidad ) - $this->currents;
					$fin = $this->current+$cantidad;
					$fin = $this->currents;
					
					if( ( $this->current-$cantidad-$diferencia-1 ) > 0  )
					{
						$inicio = $this->current-$cantidad-$diferencia-1;
					}
					else
					{
						$inicio = 1;
					}
					
					
				}
				
				if( $this->currents == 1  )
				{
					$inicio = 1;
					$fin = 1;
				}
				
				
	
				
				for($i=$inicio;$i <= $fin;$i++)
				{
					
					if( strpos($url, '#page#') !== false )
					{
						$datos[$i]['url'] = str_replace('#page#',$i, $url);
					}
					else
					{
						$datos[$i]['url'] = $url ."/".$i;
					}
					
					
					$datos[$i]['page'] = $i;
				
				}			
				
			}
			
			return $datos;
			
		}

		
	
	}

?>