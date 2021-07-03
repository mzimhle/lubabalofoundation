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
require_once 'class/ticket.php';
require_once 'class/File.php';

$participantObject			= new class_participant();
$participantticketObject	= new class_participantticket();
$ticketObject					= new class_ticket();
$fileObject 					= new File();

if (!empty($_GET['code']) && $_GET['code'] != '') {

	$reference = trim($_GET['code']);

	$participantData = $participantObject->getByCode($reference);
	
	if($participantData) {
		$smarty->assign('participantData', $participantData);
		
		$participantticketData = $participantticketObject->getByParticipant($reference);
		
		if($participantticketData) {
			$smarty->assign('participantticketData', $participantticketData);
		}
		
	} else {
		header('Location: /administration/participants/');
		exit;
	}
} else {
	header('Location: /administration/participants/');
	exit;
}

$ticketPairs = $ticketObject->pairs();
if($ticketPairs) $smarty->assign('ticketPairs', $ticketPairs);

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
			$where[]	= $participantticketObject->getAdapter()->quoteInto('participant_code = ?',  $participantData['participant_code']);
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
if(isset($_GET['deleteitem']) && isset($participantData)) {

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
		$where[]	= $participantticketObject->getAdapter()->quoteInto('participant_code = ?',  $participantData['participant_code']);
		$where[]	= $participantticketObject->getAdapter()->quoteInto('participantticket_code = ?',  trim($_REQUEST['deleteitem']));
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

if(count($_POST) > 0 && !isset($_GET['deleteitem']) && isset($participantData)) {

	$errorArray		= array();
	$data 			= array();
	$formValid		= true;
	$success		= NULL;
	
	if(isset($_POST['participantticket_reference']) && trim($_POST['participantticket_reference']) == '') {
		$errorArray['participantticket_reference'] = 'required date value';
		$formValid = false;		
	}
	
	if(isset($_POST['ticket_code']) && trim($_POST['ticket_code']) == '') {
		$errorArray['ticket_code'] = 'required';
		$formValid = false;		
	} else {
		
		$ticketData = $ticketObject->getByCode(trim($_POST['ticket_code']));
		
		if($ticketData) {				
					
			$smarty->assign('ticketData', $ticketData);
			$message = $smarty->fetch('templates/tickets/2014.html');
			
			$data['participantticket_html'] = $message;
			
		} else {
			$errorArray['ticket_code'] = 'Ticket does not exists.';
			$formValid = false;						
		}
	}
	
	if(isset($_POST['participantticket_date']) && trim($_POST['participantticket_date']) == '') {
		$errorArray['participantticket_date'] = 'required date value';
		$formValid = false;		
	}
	
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		/* required. */
		$data['participantticket_reference'] 	= trim($_POST['participantticket_reference']);								
		$data['ticket_code'] 						= trim($_POST['ticket_code']);	
		$data['participantticket_date'] 		= trim($_POST['participantticket_date']);
		$data['participant_code'] 				= $participantData['participant_code'];
				
		/* Check if there is an uploaded file. */
		if(isset($_FILES['participantticket_file'])) {
			/* Check validity of the CV. */
			if((int)$_FILES['participantticket_file']['size'] != 0 && trim($_FILES['participantticket_file']['name']) != '') {
			
				$reference	= $participantticketObject->createFile();
				$ext 				= $fileObject->file_extention($_FILES['participantticket_file']['name']);				
				$filename		= $reference.'.'.$ext;			
				
				/* Create folder in /media/document/ using reference. */					
				$directory		= $_SERVER['DOCUMENT_ROOT']."/media/participanttickets/".$participantData['participant_code'];
				$file				= $_SERVER['DOCUMENT_ROOT']."/media/participanttickets/".$participantData['participant_code'].'/'.$filename;
				$tempPath		= "/media/participanttickets/".$participantData['participant_code'].'/'.$filename;
					
				/* Create directory. */
				if(!is_dir($directory)) mkdir($directory, 0777, true);
					
				/* Now lets upload to this directory. */
				if(move_uploaded_file($_FILES['participantticket_file']['tmp_name'], $file)) {
					$data['participantticket_filename']	= $_FILES['participantticket_file']['name'];
					$data['participantticket_filepath']		= $tempPath;
				} else {
					$errorArray['participantticket_file'] = 'could not upload file, please try again';
					$formValid = false;					
				}			
			}
		}
		
		if(count($errorArray) == 0 && $formValid == true) {
			/* Insert. */
			$success = $participantticketObject->insert($data);
								
			if($success) {
				header('Location: /administration/participants/view/tickets.php?code='.$participantData['participant_code']);
				exit;	
			}
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

 /* Display the template  */	
$smarty->display('administration/participants/view/tickets.tpl');
?>