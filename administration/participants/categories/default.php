<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

error_reporting(!E_ALL);

/**
 * Check for login
 */
require_once 'administration/includes/auth.php';

require_once 'class/participantcategory.php';


$participantcategoryObject = new class_participantcategory();
 
/* Filter. */
$filter						= "participantcategory_deleted = 0";
$filter_fields				= "search_text~t"; // filter fields to remember
$filter_search_fields 	= "participantcategory_name~t"; // should be text only fields
$select_score 			= '';
$order_score 			= '';

require_once 'administration/includes/filter.php';
global $filter;

/* Setup Pagination. */
$participantcategoryData = $participantcategoryObject->getAll($filter,'participantcategory.participantcategory_added DESC');

if($participantcategoryData) $smarty->assign_by_ref('participantcategoryData', $participantcategoryData);

/* End Pagination Setup. */


$smarty->display('administration/participants/categories/default.tpl');

?>