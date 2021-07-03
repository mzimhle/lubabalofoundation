<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'administration/includes/auth.php';

/* objects. */
require_once 'class/gallery.php';
require_once 'class/galleryimage.php';
require_once 'class/File.php';

$galleryObject			= new class_gallery();
$galleryimageObject 	= new class_galleryimage();
$fileObject 				= new File(array('gif', 'png', 'jpg', 'jpeg', 'gif'));

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
	header('Location: /administration/gallery/');
	exit;	
}

/* Check posted data. */
if(isset($_GET['galleryimage_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['galleryimage_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['galleryimage_deleted'] = 1;
		
		$where		= array();
		$where[]	= $galleryimageObject->getAdapter()->quoteInto('galleryimage_code = ?', $itemcode);
		$where[]	= $galleryimageObject->getAdapter()->quoteInto('gallery_code = ?', $galleryData['gallery_code']);
		
		$success	= $galleryimageObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {		
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not delete, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(isset($_GET['galleryimage_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['galleryimage_code_update']);
	
	if(isset($_GET['galleryimage_description']) && trim($_GET['galleryimage_description']) == '') {
		$errorArray['error'] = 'description required.';	
	}

	if($errorArray['error']  == '') {

		if(isset($_GET['galleryimage_primary']) && trim($_GET['galleryimage_primary']) == $itemcode) {			
			$galleryimageObject->updatePrimaryByGallery(trim($_GET['galleryimage_primary']), $galleryData['gallery_code']);			
		}
		
		$data 	= array();		
		$data['galleryimage_description'] 			= trim($_GET['galleryimage_description']);			
		$data['galleryimage_active'] 				= isset($_GET['galleryimage_active']) && (int)trim($_GET['galleryimage_active']) == 1 ? 1 : 0;	
		
		$where		= array();
		$where[]	= $galleryimageObject->getAdapter()->quoteInto('galleryimage_code = ?', $itemcode);
		$where[]	= $galleryimageObject->getAdapter()->quoteInto('gallery_code = ?', $galleryData['gallery_code']);
		$success	= $galleryimageObject->update($data, $where);	

		if(is_numeric($success)) {		
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not update, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;
	
	if(isset($_FILES['imagefile'])) { 
		/* Check validity of the CV. */
		if((int)$_FILES['imagefile']['size'] == 0) {
			/* Check if its the right file. */
			$errorArray['imagefile'] = 'Please try to upload again, its size is empty.';
			$formValid = false;	
		} else {
			$ext = array_search($_FILES['imagefile']['type'], $fileObject->mime_types); 
			
			if($ext != '') {
				if(!$fileObject->valideExt($ext)) { 
					$errorArray['imagefile'] = 'Invalid file type';
					$formValid = false;						
				}
			} else {
				$errorArray['imagefile'] = 'Invalid file type';
				$formValid = false;									
			}
		}
	}
	
	if(isset($_POST['galleryimage_description']) && trim($_POST['galleryimage_description']) == '') {
		$errorArray['galleryimage_description'] = 'required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['galleryimage_description']	= trim($_POST['galleryimage_description']);
		$data['galleryimage_code']				= $galleryimageObject->createReference();		
		$data['gallery_code']						= $galleryData['gallery_code'];
			
		$ext 			= strtolower($fileObject->file_extention($_FILES['imagefile']['name']));					
		$filename	= $data['galleryimage_code'].'.'.$ext;
		$directory	= $_SERVER['DOCUMENT_ROOT'].'/media/gallery/'.$galleryData['gallery_code'].'/'.$data['galleryimage_code'];
		$file			= $directory.'/'.$filename;	
		
		if(!is_dir($directory)) mkdir($directory, 0777, true);

		/* Create files for this product type. */
		foreach($zfsession->items['images'] as $image) {
		
			$newfilename = str_replace($filename, $image['code'].$filename, $file);

			/* Create new file and rename it. */
			$uploadObject	= PhpThumbFactory::create($_FILES['imagefile']['tmp_name']);
			$uploadObject->adaptiveResize($image['width'], $image['height']);
			$uploadObject->save($newfilename);
		
		}

		$data['galleryimage_path']		= $zfsession->link.'/media/gallery/'.$galleryData['gallery_code'].'/'.$data['galleryimage_code'];
		$data['galleryimage_filename']	= trim($_FILES['imagefile']['name']);
		$data['galleryimage_extension']	= '.'.$ext ;
		
		/* Check for other images. */
		$primary = $galleryimageObject->getPrimaryByGallery($galleryData['gallery_code']);		
		
		if($primary) {
			$data['galleryimage_primary']	= 0;
		} else {
			$data['galleryimage_primary']	= 1;
		}

		$success	= $galleryimageObject->insert($data);	

		if(is_numeric($success)) {
			header('Location: /administration/gallery/image.php?code='.$galleryData['gallery_code']);
			exit;
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

/* Display the template */	
$smarty->display('administration/gallery/image.tpl');

?>