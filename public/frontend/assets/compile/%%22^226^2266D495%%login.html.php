<?php /* Smarty version 2.6.20, created on 2012-11-28 16:41:38
         compiled from /home/rodrigo/www/aida/Aida2/bin/../public/frontend//views//pages/login.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pages/inc/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		
		<div style="width:350px; margin:auto; margin-top:80px;">
			<h1>Inicio de sesi&oacute;n</h1>
            <hr/>
		</div>
        <div class="well well-large" style="width:300px; margin:auto; margin-bottom:80px;">
            <form style="margin:0px;">
                <label>Nombre de usuario</label>
                <input type="text" style="width:285px" />
                <label>Contrase&ntilde;a</label>
                <input type="password" style="width:285px"/>
                <input type="submit" value="Iniciar sesi&oacute;n" class="pull-right btn btn-success btn-large" style="margin-top:20px;"/>
                <div style="clear:both"></div>
            </form>
         </div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pages/inc/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>