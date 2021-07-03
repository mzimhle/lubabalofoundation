<?php/* Add this on all pages on top. */set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');/* Standard includes */require_once 'config/database.php';require_once 'config/smarty.php';/* Check for login */require_once 'administration/includes/auth.php';/* objects. */require_once 'class/ticket.php';require_once 'class/event.php';$ticketObject		= new class_ticket();$eventObject 	= new class_event();if (isset($_GET['code']) && trim($_GET['code']) != '') {		$code = trim($_GET['code']);		$ticketData = $ticketObject->getByCode($code);		if($ticketData) {		$smarty->assign('ticketData', $ticketData);	} else {		header('Location: /administration/tickets/');		exit;			}}$eventPairs = $eventObject->pairs();if($eventPairs) $smarty->assign('eventPairs', $eventPairs);/* Check posted data. */if(count($_POST) > 0) {	$errorArray		= array();	$data 				= array();	$formValid		= true;	$success			= NULL;	$areaByName	= NULL;		if(isset($_POST['event_code']) && trim($_POST['event_code']) == '') {		$errorArray['event_code'] = 'required';		$formValid = false;			}		if(isset($_POST['ticket_name']) && trim($_POST['ticket_name']) == '') {		$errorArray['ticket_name'] = 'required';		$formValid = false;			}		if(isset($_POST['ticket_price']) && (int)trim($_POST['ticket_price']) == 0) {		$errorArray['ticket_price'] = 'required and must only be a number';		$formValid = false;			}		if(isset($_POST['ticket_admit']) && trim($_POST['ticket_admit']) == '') {		$errorArray['ticket_admit'] = 'required';		$formValid = false;			}		if(count($errorArray) == 0 && $formValid == true) {				$data 	= array();						$data['ticket_name']	= trim($_POST['ticket_name']);				$data['event_code']	= trim($_POST['event_code']);				$data['ticket_price']	= trim($_POST['ticket_price']);		$data['ticket_admit']	= trim($_POST['ticket_admit']);				if(isset($ticketData)) {			$where		= $ticketObject->getAdapter()->quoteInto('ticket_code = ?', $ticketData['ticket_code']);			$success	= $ticketObject->update($data, $where);		} else {			$success = $ticketObject->insert($data);		}				if(count($errorArray) == 0) {			header('Location: /administration/tickets/');			exit;		}			}		/* if we are here there are errors. */	$smarty->assign('errorArray', $errorArray);	}$smarty->display('administration/tickets/details.tpl');?>