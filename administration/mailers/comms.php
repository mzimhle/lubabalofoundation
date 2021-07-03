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
require_once 'class/_comms.php';

$mailerObject					= new class_mailer();
$_commsObject 				= new class_comms();		

if (!empty($_GET['code']) && $_GET['code'] != '') {

	$code = trim($_GET['code']);

	$mailerData = $mailerObject->getByCode($code);

	if($mailerData) {
		$smarty->assign('mailerData', $mailerData);
		
		$commData = $_commsObject->getByMailer($code);
		
		if($commData) {
			$smarty->assign('commData', $commData);
		}
		
	} else {
		header('Location: /administration/mailers/');
		exit;
	}
} else {
	header('Location: /administration/mailers/');
	exit;
}

 /* Display the template  */	
$smarty->display('administration/mailers/comms.tpl');
?>