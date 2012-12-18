<?php /* Smarty version 2.6.20, created on 2012-12-15 20:06:16
         compiled from /Users/rodrigoramirez/Sites/git/Aida2/bin/vendors/system/views/terminal.html */ ?>
<?php echo '
<style>
body
{
	background: #f5f5f5;
	color:#666;
	font-size: 12px;
	margin: 0;
	padding: 20px;
	font-family: Arial;
}

hr { border: 1px #FFF solid; }

span { color: yellow; cursor: pointer; }

input { font-size: 12px; padding: 5px; }

.destacar { color: #000 !important; font-weight:bold; }


.error { color: red; }

.table_head { background:#999; }
.table_head td { color:#FFF }

.table_line td { border-bottom:1px #CCC solid; }

table tr td { padding:5px; font-size:12px; }

</style>
'; ?>


<html>
<title>TERMINAL</title>
<body>

<input type="button" value="ASC" onclick="document.location.href='/@/terminal&sort=1';" style="border:1px #999 solid; color:#666; background:#CCC;" />
<input type="button" value="DESC" onclick="document.location.href='/@/terminal&sort=2';" style="border:1px #999 solid; color:#666; background:#CCC;" />
<input type="button" value="FLUSH" onclick="document.location.href='/@/terminal&flush=true';" style="border:1px #999 solid; color:#666; background:#CCC;" />
<input type="button" value="RELOAD" onclick="document.location.href='/@/terminal';" style="border:1px #999 solid; color:#666; background:#CCC;" />

<table width="100%" style="margin-top:10px;">
	
	<tr class="table_head"> 
		<td width="1%"> time </td>
		<td width="1%"> diff </td>
		<td> log </td>
		<td> url </td>
	</tr>


<?php $_from = $this->_tpl_vars['logs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['log']):
?>

	<tr class="table_line <?php if ($this->_tpl_vars['log']['flag']): ?>destacar<?php endif; ?>" <?php if ($this->_tpl_vars['num']%2 == 0): ?> style="background:#f3f3f3" <?php endif; ?> > 
		<td> <?php echo $this->_tpl_vars['log']['time']; ?>
 </td>
		<td <?php if ($this->_tpl_vars['log']['error']): ?> class="error" <?php endif; ?> > <?php echo $this->_tpl_vars['log']['lag']; ?>
 </td>
		<td> <?php echo $this->_tpl_vars['log']['text']; ?>
 </td>
		<td> <?php echo $this->_tpl_vars['log']['url']; ?>
 </td>
	</tr>


<?php endforeach; endif; unset($_from); ?>

</table>

</body>
</html>