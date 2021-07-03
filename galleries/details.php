<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'class/gallery.php';
require_once 'class/galleryimage.php';

$galleryObject			= new class_gallery();
$galleryimageObject = new class_galleryimage();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$galleryData = $galleryObject->getByCode($code);

	if($galleryData) {
		$smarty->assign('galleryData', $galleryData);
		
		$galleryimageData = $galleryimageObject->getByGallery($galleryData['gallery_code']);

		if($galleryimageData) {
			$smarty->assign('galleryimageData', $galleryimageData);
		}	
	} else {
		header('Location: /administration/gallery/');
		exit;	
	}
} else {
	header('Location: /galleries/');
	exit;	
}
 
 /* Display the template */	
$smarty->display('galleries/details.tpl');

?>