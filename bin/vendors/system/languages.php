<?php

	class _languagesController extends TController
	{
		
		public function run()
		{
	
			$this->file = dirname(__FILE__) . '/views/languages.html';
			
			if($_GET['lang'])
			{
				$this->lang = $_GET['lang'];
			}
						
			$langs = $this->languages();
			$this->tpl->set('langs', $langs);
			
			if($_POST)
			{
				$this->update();
			}
			
			$r = $this->db('local')->fetch("SELECT * FROM aida_languages ORDER BY id DESC");
			$this->tpl->set('results', $r);
			
			$this->tpl->set('lang_field', 'content_'. $this->lang);
			$this->tpl->set('lang_selected', $this->lang);

						
		}
		
		public function update()
		{
			
			$r = $this->db('local')->fetch("SELECT * FROM aida_languages ORDER BY id DESC");
			
			foreach($r as $item)
			{
				
				$this->db('local')->query("UPDATE aida_languages SET content_". $this->lang ." = '". mysql_real_escape_string( $_POST['txt_'.$item['id']] ) ."' WHERE id = '". $item['id'] ."' ");
				
			}

			
		}
		
		public function languages()
		{
			$data = array();
			$r = $this->db('local')->row("SELECT * FROM aida_languages ORDER BY id DESC LIMIT 1");
			
			foreach($r as $key=>$value)
			{
			
				if( strpos($key,'content_') !== false )
				{
					$lang['name'] = str_replace('content_','', $key);
					$data[] = $lang;
				}
			}
			
			if( !$this->lang )
			{
				$this->lang = $data[0]['name'];
			}
						
			return $data;
		}
		
	}

?>