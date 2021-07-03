<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/42729/calendarattend.php';

$calendarattendObject	= new class_calendarattend();

$array = explode('/',$_SERVER['REQUEST_URI']);

if ((isset($array[4]) && trim($array[4]) != '') && (isset($array[5]) && trim($array[5]) != '')) {

	$reference = trim($array[5]);

	$attendeeData = $calendarattendObject->getByHashCode($reference);
	
	if($attendeeData) {
		$smarty->assign('attendeeData', $attendeeData);
	} else {
		header('Location: http://'.$_SERVER['HTTP_HOST']);
		exit;
	}
} else {
	header('Location: http://'.$_SERVER['HTTP_HOST']);
	exit;
}

$data = array();
$data['calendarattend_response'] = (int)trim($array[4]) == 1 ? 'accepted' : 'declined';

$where = array();
$where[] = $calendarattendObject->getAdapter()->quoteInto('calendar_code = ?', $attendeeData['calendar_code']);
$where[] = $calendarattendObject->getAdapter()->quoteInto('calendarattend_hascode = ?', $attendeeData['calendarattend_hascode']);
$success = $calendarattendObject->update($data, $where);
	
if((int)trim($array[4]) == 0) {
	$message = '<span style="color: red;">We are sorry to hear that you will not be joining us for the <b>'.$attendeeData['calendar_name'].'</b> event/meeting.</span>';
} else {
	$message = '<span style="color: green;">We are happy to hear that you will be joining us for the <b>'.$attendeeData['calendar_name'].'</b> event/meeting.</span>';
}

$smarty->assign('message', $message);

$display = $smarty->fetch(ltrim($zfsession->domainData['campaign_directory'], '/').'/templates/emails/response.html');

echo $display; exit;

?>