<?php/* Add this on all pages on top. */set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');/* Standard includes */require_once 'config/database.php';require_once 'config/smarty.php';/* Check for login */require_once 'administration/includes/auth.php';/* objects. */require_once 'class/event.php';$eventObject 					= new class_event();if (isset($_GET['code']) && trim($_GET['code']) != '') {		$code = trim($_GET['code']);		$eventData = $eventObject->getByCode($code);		if($eventData) {		$smarty->assign('eventData', $eventData);	} else {		header('Location: /administration/events/');		exit;			}}/* Check posted data. */if(count($_POST) > 0) {	$errorArray		= array();	$data 				= array();	$formValid		= true;	$success			= NULL;	$areaByName	= NULL;		if(isset($_POST['area_code']) && trim($_POST['area_code']) == '') {		$errorArray['area_code'] = 'required';		$formValid = false;			}		if(isset($_POST['event_name']) && trim($_POST['event_name']) == '') {		$errorArray['event_name'] = 'required';		$formValid = false;			}		if(isset($_POST['event_description']) && trim($_POST['event_description']) == '') {		$errorArray['event_description'] = 'required';		$formValid = false;			}		if(isset($_POST['event_date']) && trim($_POST['event_date']) == '') {		$errorArray['event_date'] = 'required';		$formValid = false;			}		if(isset($_POST['event_address']) && trim($_POST['event_address']) == '') {		$errorArray['event_address'] = 'required';		$formValid = false;			}		if(count($errorArray) == 0 && $formValid == true) {				$data 	= array();						$data['area_code']				= trim($_POST['area_code']);				$data['event_name']			= trim($_POST['event_name']);				$data['event_description']	= trim($_POST['event_description']);		$data['event_address']	= trim($_POST['event_address']);		$data['event_date']			= trim($_POST['event_date']);						if(isset($eventData)) {					/*Update. */			$where		= $eventObject->getAdapter()->quoteInto('event_code = ?', $eventData['event_code']);			$success	= $eventObject->update($data, $where);											} else {			$success = $eventObject->insert($data);		}				if(count($errorArray) == 0) {			header('Location: /administration/events/');				exit;				}				}		/* if we are here there are errors. */	$smarty->assign('errorArray', $errorArray);	}$smarty->display('administration/events/details.tpl');?>