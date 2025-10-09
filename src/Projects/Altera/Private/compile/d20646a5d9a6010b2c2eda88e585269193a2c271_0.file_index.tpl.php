<?php
/* Smarty version 5.6.0, created on 2025-10-09 16:41:53
  from 'file:index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68e7c9b1da0019_64586160',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd20646a5d9a6010b2c2eda88e585269193a2c271' => 
    array (
      0 => 'index.tpl',
      1 => 1760020912,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:components/card_student.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68e7c9b1da0019_64586160 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/app/Projects/Altera/Views';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
<h1>Bonjour <?php echo substr((string) $_smarty_tpl->getValue('name'), (int) 0, (int) 2);?>
... !!</h1>

<?php if ($_smarty_tpl->getValue('name') == 'damien') {?>
    Est Admin
<?php } else {
}?>

<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('students'), 'student', false, 'i');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('i')->value => $_smarty_tpl->getVariable('student')->value) {
$foreach0DoElse = false;
?>
    <?php $_smarty_tpl->renderSubTemplate("file:components/card_student.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('number'=>$_smarty_tpl->getValue('i'),'name'=>$_smarty_tpl->getValue('student')['name']), (int) 0, $_smarty_current_dir);
}
if ($foreach0DoElse) {
?>
    Aucun student
<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
$_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
