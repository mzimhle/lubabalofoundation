<?php

//error_reporting(!E_DEPRECATED);

//standard config include.
require_once 'config/database.php';
require_once 'config/smarty.php';

//include the Zend class for Authentification
require_once 'Zend/Session.php';

// Set up the namespace
$zfsession = new Zend_Session_Namespace('BackendLogin');

// Check if logged in, otherwise redirect
if (!isset($zfsession->identity) || is_null($zfsession->identity) || $zfsession->identity == '') {
	header('Location: /administration/login.php');
	exit();
} else {
	//instantiate the users class
	require_once 'class/administrator.php';
	$users = new class_administrator();
	
	//get user details by username
	$usersData = $users->getByCode($zfsession->identity);
	
	$smarty->assign('admin', $usersData);
	
	$zfsession->items['images']	= array(
											'min'			=> array('width' => '50', 	'height' 	=> '50', 	'percentage' => '15',  	'code' => 'min_'),
											'tiny'			=> array('width' => '120', 'height'	=> '120', 	'percentage' => '30', 		'code' => 'tny_'),
											'thumb'		=> array('width' => '300', 'height' 	=> '200', 	'percentage' => '45', 		'code' => 'tmb_'),
											'medium'	=> array('width' => '570', 'height' 	=> '320', 	'percentage' => '70',		'code' => 'mdm_'),
											'big'			=> array('width' => '536', 'height' 	=> '480', 	'percentage' => '100', 	'code' => 'big_'),
											'profile'		=> array('width' => '208', 'height' => '208', 	'percentage' => '100',	'code' => 'prof_'),
											'gallery'		=> array('width' => '208', 'height' => '260', 	'percentage' => '100',	'code' => 'gal_')											
										);	

}

?>