<?php/* Add this on all pages on top. */set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');/** * Standard includes */require_once 'config/database.php';require_once 'config/smarty.php';require_once 'class/administrator.php';//include the Zend class for Authentificationrequire_once 'Zend/Auth.php';require_once 'Zend/Auth/Adapter/DbTable.php';require_once 'Zend/Session.php';$zfsession = new Zend_Session_Namespace('BackendLogin');$zfsession->setExpirationSeconds(3600);// Get a reference to the singleton instance of Zend_Auth$auth = Zend_Auth::getInstance();// Set up the authentication adapter$authAdapter = new Zend_Auth_Adapter_DbTable($conn);//set default counter$countUser = 0;if ( !empty($_POST) && !is_null($_POST)) {	$username = (isset($_POST['email'])) ? $_POST['email'] : "-";	$password = (isset($_POST['password'])) ? $_POST['password'] : "-";	$user = new class_administrator();	$userData = $user->checkLogin($username, $password);			if ($userData) {			// Identity exists; store in session			$zfsession->identity	= $userData['administrator_code'];						//record last login for user			$data = array('administrator_last_login' => date('Y-m-d H:i:s'));			$where = $user->getAdapter()->quoteInto('administrator_email = ?', $username);			$user->update($data, $where);			//session_write_close();			header("Location: /administration/default.php");			exit;	}else{		$message = 'You are not a valid system user.';		$smarty->assign( 'message', $message);	}//end check for user}$smarty->display('administration/login.tpl');?>