<?php/* Add this on all pages on top. */set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');/*** Standard includes */require_once 'config/database.php';require_once 'config/smarty.php';/*** Check for login */require_once 'administration/includes/auth.php';/* objects. */require_once 'class/profile.php';require_once 'class/File.php';$profileObject	= new class_profile();$fileObject 		= new File(array('gif', 'png', 'jpg', 'jpeg', 'gif'));if (isset($_GET['code']) && trim($_GET['code']) != '') {		$code = trim($_GET['code']);		$profileData = $profileObject->getByCode($code);		if($profileData) {		$smarty->assign('profileData', $profileData);	} else {		header('Location: /administration/profiles/');		exit;			}}/* Check posted data. */if(count($_POST) > 0) {	$errorArray		= array();	$data 				= array();	$formValid		= true;	$success			= NULL;		if(isset($_POST['profile_name']) && trim($_POST['profile_name']) == '') {		$errorArray['profile_name'] = 'required';		$formValid = false;			}		if(isset($_POST['profile_surname']) && trim($_POST['profile_surname']) == '') {		$errorArray['profile_surname'] = 'required';		$formValid = false;			}		if(isset($_POST['profile_birthday']) && trim($_POST['profile_birthday']) == '') {		$errorArray['profile_birthday'] = 'required';		$formValid = false;			}		if(isset($_POST['profile_player']) && trim($_POST['profile_player']) == '') {		$errorArray['profile_player'] = 'required';		$formValid = false;			}		if(isset($_POST['profile_description']) && trim($_POST['profile_description']) == '') {		$errorArray['profile_description'] = 'required';		$formValid = false;			}		if(isset($_POST['profile_email']) && trim($_POST['profile_email']) != '') {		if($profileObject->validateEmail(trim($_POST['profile_email'])) == '') {			$errorArray['profile_email'] = 'Needs to be an email address';			$formValid = false;			} else {						$username = isset($profileData) ? $profileData['profile_code'] : null;						$emailData = $profileObject->getByEmail(trim($_POST['profile_email']), $username);						if($emailData) {				$errorArray['profile_email'] = 'Email already exists';				$formValid = false;							}		}	}		if(isset($_POST['profile_cellphone']) && trim($_POST['profile_cellphone']) != '') {		if($profileObject->validateCell(trim($_POST['profile_cellphone'])) == '') {			$errorArray['profile_cellphone'] = 'Needs to be a valid cell number';			$formValid = false;			} else {						$username = isset($profileData) ? $profileData['profile_code'] : null;						$emailData = $profileObject->getByCell(trim($_POST['profile_cellphone']), $username);						if($emailData) {				$errorArray['profile_cellphone'] = 'Cell already exists';				$formValid = false;							}		}	}		if(isset($_FILES['profile_image'])) {		/* Check validity of the CV. */		if((int)$_FILES['profile_image']['size'] != 0 && trim($_FILES['profile_image']['name']) != '') {			/* Check if its the right file. */			$ext = array_search($_FILES['profile_image']['type'], $fileObject->mime_types); 						if($ext != '') {				if(!$fileObject->valideExt($ext)) { 					$errorArray['profile_image'] = 'Invalid file type';					$formValid = false;										}			} else {				$errorArray['profile_image'] = 'Invalid file type';				$formValid = false;												}		}	}				if(count($errorArray) == 0 && $formValid == true) {				$data 	= array();						$data['profile_name']				= trim($_POST['profile_name']);				$data['profile_surname']			= trim($_POST['profile_surname']);				$data['profile_cellphone']		= $profileObject->validateCell(trim($_POST['profile_cellphone']));				$data['profile_email']				= $profileObject->validateEmail(trim($_POST['profile_email']));			$data['profile_birthday']			= trim($_POST['profile_birthday']);		$data['profile_school']			= trim($_POST['profile_school']);				$data['profile_grade']				= trim($_POST['profile_grade']);				$data['profile_player']			= trim($_POST['profile_player']);				$data['profile_description']		= trim($_POST['profile_description']);				$data['profile_address']			= trim($_POST['profile_address']);						if(isset($profileData)) {					/*Update. */			$where		= $profileObject->getAdapter()->quoteInto('profile_code = ?', $profileData['profile_code']);			$success	= $profileObject->update($data, $where);									$success 	= $profileData['profile_code'];		} else {			$success = $profileObject->insert($data);		}				/* Upload image if its added. */		if((int)$_FILES['profile_image']['size'] != 0 && trim($_FILES['profile_image']['name']) != '') {						$image = array();			$image['profile_image_name']	= $profileObject->createFilename();			$image['profile_image_path']		= '';			$image['profile_image_ext']		= '';						$ext 						= strtolower($fileObject->file_extention($_FILES['profile_image']['name']));								$filename				= $image['profile_image_name'].'.'.$ext;						$directory				= $_SERVER['DOCUMENT_ROOT'].'/media/profile/'.$success.'/';			$file						= $directory.'/'.$filename;							if(!is_dir($directory)) mkdir($directory, 0777, true);			/* Create files for this product type. */			foreach($fileObject->image as $item) {								$newfilename = str_replace($filename, $item['code'].$filename, $file);								/* Create new file and rename it. */				$uploadObject	= PhpThumbFactory::create($_FILES['profile_image']['tmp_name']);				$uploadObject->resize($item['width'], $item['height']);				$uploadObject->save($newfilename);						}			$image['profile_image_path']	= '/media/profile/'.$success.'/';			$image['profile_image_ext']	= '.'.$ext;			$where = $profileObject->getAdapter()->quoteInto('profile_code = ?', $success);			$profileObject->update($image, $where);							}						if(count($errorArray) == 0) {			header('Location: /administration/profiles/');				exit;				}					}		/* if we are here there are errors. */	$smarty->assign('errorArray', $errorArray);	}$smarty->display('administration/profiles/details.tpl');?>