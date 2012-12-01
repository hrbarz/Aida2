<?php /* Smarty version 2.6.20, created on 2012-12-01 15:38:58
         compiled from /home/rodrigo/www/aida/Aida2/bin/../public/frontend//views/home.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'translate', '/home/rodrigo/www/aida/Aida2/bin/../public/frontend//views/home.html', 1, false),)), $this); ?>
<h1><?php $this->_tag_stack[] = array('translate', array()); $_block_repeat=true;smarty_block_translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Hola<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> <?php echo $this->_tpl_vars['name']; ?>
</h1>