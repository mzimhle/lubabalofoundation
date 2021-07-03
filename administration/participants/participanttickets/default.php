<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Other resources. */
require_once 'administration/includes/auth.php';

require_once 'class/participant.php';
require_once 'class/participantticket.php';
require_once 'class/File.php';

$participantObject			= new class_participant();
$participantticketObject	= new class_participantticket();
$fileObject 				= new File();

 /* Competition mail */
if(isset($_GET['sendticket'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	
	if (isset($_GET['sendticket']) && trim($_GET['sendticket']) != '') {
		
		$code = trim($_GET['sendticket']);
		
		$participantticketData = $participantticketObject->getByCode($code);
		
		if(!$participantticketData) {
			$errorArray['error']	= 'Item does not exist.';
			$errorArray['result']	= 1;	
		}
	} else {
		$errorArray['error']	= 'Item does not exist.';
		$errorArray['result']	= 1;		
	}
	
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$_commsObject = new class_comms();			
		$participantticketData['category'] = 'send_sale_ticket';
		$success = $_commsObject->sendEmailComm('templates/tickets/2014.html', $participantticketData, 'Lubabalo Foundation - Ticket Sale Confirmation', array('email' => 'info@lubabalofoundation.co.za', 'name' => 'Lubabalo Foundation'));	
		
		if($success) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;		

			$data = array();
			$data['participantticket_notify'] = date('Y-m-d h:i:s');
			
			$where	= array();
			$where[]	= $participantticketObject->getAdapter()->quoteInto('participant_code = ?',  $participantticketData['participant_code']);
			$where[]	= $participantticketObject->getAdapter()->quoteInto('participantticket_code = ?',  $participantticketData['participantticket_code']);
			$success	= $participantticketObject->update($data, $where);					
		} else {
			$errorArray['error']	= 'Could not send email, please try again.';
			$errorArray['result']	= 0;					
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(isset($_GET['deleteitem'])) {

	$errorArray				= array();
	$errorArray['message']	= '';
	$error					= array();
	$errorArray['result']	= 0;
	$data 					= array();
	$formValid				= true;
	$success				= NULL;
	
	if(isset($_REQUEST['deleteitem']) && trim($_REQUEST['deleteitem']) == '') {
		$error[] = 'Please select item to delete';
		$formValid = false;		
	}	
	
	if($formValid && count($error)  == 0 ) {
	
		$data = array();
		$data['participantticket_deleted'] = 1;
		
		$where	= array();
		$where		= $participantticketObject->getAdapter()->quoteInto('participantticket_code = ?',  trim($_REQUEST['deleteitem']));
		$success	= $participantticketObject->update($data, $where);					
	}
	
	if($success) {		
		$errorArray['message']	= '';
		$errorArray['result']	= 1;				
	} else {
		$errorArray['message']	= 'Could not update, please try again: '.implode(", ", $error);
		$errorArray['result']	= 0;				
	}	
	
	echo json_encode($errorArray);
	exit;
	
}

$participantticketData	= $participantticketObject->getAll();
if($participantticketData) $smarty->assign('participantticketData', $participantticketData);

 /* Display the template  */	
$smarty->display('administration/participants/participanttickets/default.tpl');
?>