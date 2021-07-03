<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'class/gallery.php';

$galleryObject = new class_gallery();

$galleryData = $galleryObject->getAll();
if($galleryData) $smarty->assign('galleryData', $galleryData);

 /* Display the template */	
$smarty->display('galleries/default.tpl');

?>