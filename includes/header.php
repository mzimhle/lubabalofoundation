<?php
/**
 * Standard includes
 */
global $smarty;


//used for selected menu items
$page = explode('/',$_SERVER['REQUEST_URI']);
$currentPage = isset($page[1]) && trim($page[1]) != '' ? trim($page[1]) : '';

$smarty->assign('currentPage', $currentPage);

 /* Display the template
 */	
$smarty->display('includes/header.tpl');
?>