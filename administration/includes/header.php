<?php
/**
 * Standard includes
 */
global $smarty;


//used for selected menu items
$page = explode('/',$_SERVER['REQUEST_URI']);
$currentPage = isset($page[2]) && trim($page[2]) != '' ? trim($page[2]) : '';

$smarty->assign('page', $currentPage);

 /* Display the template
 */	
$smarty->display('administration/includes/header.tpl');
?>