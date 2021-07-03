<?php

ini_set('max_execution_time', 2100); //300 seconds = 5 minutes

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Other resources. */
require_once 'administration/includes/auth.php';

require_once 'class/mailer.php';
require_once 'class/participantcategory.php';
require_once 'class/participant.php';
require_once 'class/_comms.php';

$mailerObject					= new class_mailer();
$participantcategoryObject	= new class_participantcategory();
$participantObject				= new class_participant();
$_commsObject 				= new class_comms();		

if (!empty($_GET['code']) && $_GET['code'] != '') {

	$reference = trim($_GET['code']);

	$mailerData = $mailerObject->getByCode($reference);

	if($mailerData) {
		$smarty->assign('mailerData', $mailerData);
		
	} else {
		header('Location: /administration/mailers/');
		exit;
	}
} else {
	header('Location: /administration/mailers/');
	exit;
}


$participantcategoryPairs = $participantcategoryObject->pairs();
if($participantcategoryPairs) $smarty->assign('participantcategoryPairs', $participantcategoryPairs);

 /* Competition mail */
if(isset($_GET['category'])) {
	
	$errorArray				= array();
	$errorArray['message']	= '';
	$errorArray['result']	= 1;	
	$errorArray['data']	= array();	
	
	if (isset($_GET['category']) && trim($_GET['category']) != '') {
		
		$code = trim($_GET['category']);
		
		$participantData = $participantObject->getByCategory($code);
		
		if(!$participantData) {
			$errorArray['message']	= 'No participants in this category.';
			$errorArray['result']	= 0;	
		} else {
			$errorArray['data']	= $participantData;	
		}
	} else {
		$errorArray['message']	= 'Please select category.';
		$errorArray['result']	= 0;		
	}
	
	echo json_encode($errorArray);
	exit;
}

 /* Competition mail */
if(count($_POST) > 0 && !isset($_GET['category'])) {

	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['participant_code']) && count($_POST['participant_code']) == 0) {
		$errorArray['participant_code'] = 'Please select participants to send an email to.';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {		
		
		for($i = 0; $i < count($_POST['participant_code']); $i++) {
		
			$participantData = false; $participantData = $participantObject->getByCode($_POST['participant_code'][$i]);
			
			if($participantData) {
				$participantData['category'] = 'mailer_send';		

				$success = $_commsObject->sendMailer($participantData, $mailerData);	
			}
		}
		
		header('Location: /administration/mailers/comms.php?code='.$mailerData['mailer_code']);	
		exit;		
				
	}
}


 /* Display the template  */	
$smarty->display('administration/mailers/mail.tpl');
?>