<?php /* Smarty version 2.6.20, created on 2012-12-15 20:02:44
         compiled from /Users/rodrigoramirez/Sites/git/Aida2/bin/vendors/system/views/languages.html */ ?>
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
<title>LANGUAGES</title>
<body>

<?php $_from = $this->_tpl_vars['langs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['lang']):
?>

<input type="button" value="<?php echo $this->_tpl_vars['lang']['name']; ?>
" onclick="document.location.href='/@/languages&lang=<?php echo $this->_tpl_vars['lang']['name']; ?>
';" style="border:1px #999 solid; <?php if ($this->_tpl_vars['lang']['name'] == $this->_tpl_vars['lang_selected']): ?>background:#999;color:#FFF;<?php else: ?>background:#CCC;color:#666;<?php endif; ?>" />


<?php endforeach; endif; unset($_from); ?>


<input type="button" value="UPDATE" onclick="document.languages.submit();" style="border:1px #999 solid; color:#FFF; background:#000; float:right" />


<form method="post" name="languages">
<table width="100%">
	
	<tr class="table_head"> 
		<td width="%"> text </td>
		<td width="%"> translation </td>
	</tr>


<?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['r']):
?>

	<tr class="table_line" <?php if ($this->_tpl_vars['num']%2 == 0): ?> style="background:#f3f3f3" <?php endif; ?> > 
		
		<td width="%"> <?php echo $this->_tpl_vars['r']['code']; ?>
 </td>
		<td width="%"> <input type="text" name="txt_<?php echo $this->_tpl_vars['r']['id']; ?>
" value="<?php echo $this->_tpl_vars['r'][$this->_tpl_vars['lang_field']]; ?>
" style="width:99%" /> </td>
		
	</tr>


<?php endforeach; endif; unset($_from); ?>

</table>
</form>

</body>
</html>