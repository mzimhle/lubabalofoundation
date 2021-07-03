<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');


if (isset($_GET['code']) && trim($_GET['code']) != '' && isset($_GET['camp']) && trim($_GET['camp']) != '') {
	
	/** Standard includes */
	require_once 'config/database.php';

	/* objects. */
	require_once 'class/participant.php';

	$participantObject 	= new class_participant();
	
	$code = trim($_GET['code']);
	$camp = trim($_GET['camp']);
	
	$participantData = $participantObject->getByCampaign($camp, $code);

	if($participantData) {
			
		/* Insert data. */
		$data = array();
		$data['participant_active']	= 0;
		
		$where	= $participantObject->getAdapter()->quoteInto('participant_code = ?', $participantData['participant_code']);		
		$success	= $participantObject->update($data, $where);	
		
	}
}

echo '<h3>You have been successfully unsubscribed.</h3>';

