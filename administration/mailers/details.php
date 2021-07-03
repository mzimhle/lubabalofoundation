<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Check for login */
require_once 'administration/includes/auth.php';

/* objects. */
require_once 'class/mailer.php';

$mailerObject 					= new class_mailer();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$mailerData = $mailerObject->getByCode($code);
	
	if($mailerData) {
		$smarty->assign('mailerData', $mailerData);
	} else {
		header('Location: /administration/mailers/');
		exit;		
	}
}

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['mailer_title']) && trim($_POST['mailer_title']) == '') {
		$errorArray['mailer_title'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['mailer_content']) && trim($_POST['mailer_content']) == '') {
		$errorArray['mailer_content'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
	
		$data 	= array();				
		$data['mailer_title']		= trim($_POST['mailer_title']);		
		$data['mailer_content']	= trim($_POST['mailer_content']);			
		
		$smarty->assign('mailerData', $data);		
		
		$message = $smarty->fetch('templates/mailers/mailer.html');

		$data['mailer_page']	= $message;	
		
		if(isset($mailerData)) {
			$where		= $mailerObject->getAdapter()->quoteInto('mailer_code = ?', $mailerData['mailer_code']);
			$success	= $mailerObject->update($data, $where);			
			$success 	= $mailerData['mailer_code'];
		} else {
			$success = $mailerObject->insert($data);
		}
		
		if(count($errorArray) == 0) {
			header('Location: /administration/mailers/mail.php?code='.$success);	
			exit;		
		}
		
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('administration/mailers/details.tpl');

?>