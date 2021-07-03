<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'class/enquiry.php';
require_once 'class/_comms.php';

$enquiryObject = new class_enquiry();
 
/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	$areaByName	= NULL;
	
	if(isset($_POST['enquiry_name']) && trim($_POST['enquiry_name']) == '') {
		$errorArray['enquiry_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['enquiry_surname']) && trim($_POST['enquiry_surname']) == '') {
		$errorArray['enquiry_surname'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['enquiry_message']) && trim($_POST['enquiry_message']) == '') {
		$errorArray['enquiry_message'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['enquiry_email']) && trim($_POST['enquiry_email']) != '') {
		if($enquiryObject->validateEmail(trim($_POST['enquiry_email'])) == '') {
			$errorArray['enquiry_email'] = 'invalid email address';
			$formValid = false;	
		}
	} else {
		$errorArray['enquiry_email'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['enquiry_cellphone']) && trim($_POST['enquiry_cellphone']) != '') {
		if($enquiryObject->validateCell(trim($_POST['enquiry_cellphone'])) == '') {
			$errorArray['enquiry_cellphone'] = 'invalid cell number';
			$formValid = false;	
		}
	} else {
		$errorArray['enquiry_cellphone'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();				
		$data['enquiry_name']				= trim($_POST['enquiry_name']).' '.trim($_POST['enquiry_surname']);
		$data['enquiry_message']			= trim($_POST['enquiry_message']);		
		$data['enquiry_cellphone']			= $enquiryObject->validateCell(trim($_POST['enquiry_cellphone']));		
		$data['enquiry_email']				= $enquiryObject->validateEmail(trim($_POST['enquiry_email']));	

		$success = $enquiryObject->insert($data);
		
		if($success) {
			$_commsObject = new class_comms();

			$comm  = $_commsObject->sendEquiry($data);
			
			$idata = array();
			$idata['_comms_code'] = $comm;
			
			$where = $enquiryObject->getAdapter()->quoteInto('enquiry_code = ?', $success);
			$enquiryObject->update($idata, $where);		
			
			
			$smarty->assign('success', $success);
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

 /* Display the template */	
$smarty->display('contacts/default.tpl');

?>