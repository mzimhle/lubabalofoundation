<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'class/tenderinstitute.php';

$tenderinstituteObject	= new class_tenderinstitute();

$results 				= array();
$list						= array();	

if(isset($_REQUEST['term'])) {
	
	$tenderinstituteData	= $tenderinstituteObject->getAll("tenderinstitute.tenderinstitute_name != ''", "tenderinstitute_added DESC");
	$q						= trim($_REQUEST['term']); 
	
	if(count($tenderinstituteData) > 0) {
		for($i = 0; $i < count($tenderinstituteData); $i++) {
			$list[] = array(
				"id" 		=> $tenderinstituteData[$i]["tenderinstitute_code"],
				"label" 	=> $tenderinstituteData[$i]['tenderinstitute_name'],
				"value" 	=> $tenderinstituteData[$i]['tenderinstitute_name']
			);			
		}
		
		foreach ($list as $details) {
			if (strpos(strtolower($details["value"]), $q) !== false) {
				$results[] = $details;
			}
		}		
	}
}

if(count($results) > 0) {
	echo json_encode($results); 
	exit;
} else {
	echo json_encode(array('id' => '', 'label' => 'no results')); 
	exit;
}
exit;

?>