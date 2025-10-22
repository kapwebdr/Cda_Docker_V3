<?php
/* Smarty version 5.6.0, created on 2025-10-22 11:58:03
  from 'file:upload.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f8aaab2a1453_75413798',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f3dc9cacb500cf193b17bebafb7c6870d5a742f9' => 
    array (
      0 => 'upload.tpl',
      1 => 1761127082,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68f8aaab2a1453_75413798 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/app/Projects/Altera/Views';
?><!DOCTYPE html>
<form action="/upload" 
    method="post" 
    enctype="multipart/form-data"
>
    <input type="file" multiple name="fichiers[]"/>
    <input type="text" name="nom"/>
    <input type="submit" name="Uploader"/>

</form><?php }
}
