<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'includes/auth.php';

$array = explode('/',$_SERVER['REQUEST_URI']);

if (isset($array[4]) && trim($array[4]) != '') {

	/* objects. */
	require_once 'class/42729/_comm.php';

	$commObject	= new class_comm();
	
	$tracking = trim($array[4]);
	
	$commData = $commObject->getByCode($tracking);

	if($commData) {
		
		require_once 'class/42729/_tracker.php';
		
		$trackerObject = new class_tracker();
			
		/* Insert data. */
		$data = array();
		$data['_comm_code']	= $commData['_comm_code'];
		
		$trackerObject->insert($data);
		
	}
}

