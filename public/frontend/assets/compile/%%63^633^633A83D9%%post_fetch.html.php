<?php /* Smarty version 2.6.20, created on 2012-12-02 11:12:23
         compiled from /Users/rodrigoramirez/Sites/git/Aida2/bin/../public/frontend//views/post_fetch.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', '/Users/rodrigoramirez/Sites/git/Aida2/bin/../public/frontend//views/post_fetch.html', 36, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		
		<div class="row-fluid">
			<div class="span12 page-header">
				<div class="pull-left">
					<h1>Contenidos</h1>
				</div>
				<a class="btn btn-primary btn-large pull-right">Nuevo contenido</a>
			</div>
			<form>
				<input type="text" placeholder="Buscar..."/>
				<select>
				    <option value="volvo">Todas las categor&iacute;as</option>
				    <option value="">Categor&iacute;a 1</option>
				    <option value="">Categor&iacute;a 2</option>
				    <option value="">Categor&iacute;a 3</option>
				</select>
				<input type="submit" value="Buscar" class="btn" style="margin-bottom:10px" />		
			</form>
        </div>
		<div class="row-fluid">
			<div class="span12">
				<table class="table table-hover">
					
					<tr>
						<th> Titulo</th>
						<th> Contenido</th>
						<th> FEcha</th>
                        <th></th>
                        <th></th>
					</tr>
					
					<?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['data']['title']; ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['content'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?>
</td>
						<td><?php echo $this->_tpl_vars['data']['registered']; ?>
</td>
                        <td><a class="btn btn-mini btn-danger" href="#">Eliminar</a></td>
                        <td><a class="btn btn-mini btn-primary" href="#">Editar</a></td>
					</tr>
					<?php endforeach; endif; unset($_from); ?>
					
				</table>
				
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/pagination.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			</div>
		</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>