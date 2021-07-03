<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'class/profile.php';

$profileObject = new class_profile();

$profileData = $profileObject->getAll();
if($profileData) $smarty->assign('profileData', $profileData);
 
 /* Display the template */	
$smarty->display('profiles/default.tpl');

?>