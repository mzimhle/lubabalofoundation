<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

//custom account item class as account table abstraction
class class_comms extends Zend_Db_Table_Abstract {
   
   //declare table variables
    protected $_name 		= '_comms';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['_comms_added'] = date('Y-m-d H:i:s');

		return parent::insert($data);
		
    }
	
	/**
	 * get job by job _comms Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		
		$select = $this->_db->select()	
					->from(array('_comms' => '_comms'))								
					->where('_comms_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}
	
	
	public function getAll($where = NULL, $order = NULL)
	{		
		$select = $this->_db->select()	
					->from(array('_comms' => '_comms'))	
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = _comms.participant_code')	
					->where($where)
					->order($order);	
					
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function sendEmailComm($template, $userData, $subject, $from) {
		
		require_once 'config/smarty.php';
		
		global $smarty; 
		
		require_once('Zend/Mail.php');
		
		$mail = new Zend_Mail();
		
		$data								= array();
		$data['_comms_code']		= $this->createReference();
		
		$smarty->assign('userData', $userData);	
		$smarty->assign('tracking', $data['_comms_code']);
		$smarty->assign('host', $_SERVER['HTTP_HOST']);
		
		$message = $smarty->fetch($template);

		$mail->setFrom($from['email'], $from['name']); //EDIT!!											
		$mail->addTo($userData['participant_email']);
		$mail->addTo('info@lubabalofoundation.co.za');
		$mail->setSubject($subject);
		$mail->setBodyHtml($message);			

		/* Save data to the comms table. */
		$data['participant_code']	= $userData['participant_code'];
		$data['_comms_type']			= 'email';
		$data['_comms_email']		= trim($userData['participant_email']);
		$data['_comms_output']		= '';
		$data['_comms_category']	= isset($userData['category']) ? $userData['category'] : null;
		$data['_comms_sent']			= null;
		$data['_comms_html']			= str_replace($data['_comms_code'], '', $message);
		$data['_comms_name']		= $subject;
		
		$this->insert($data);
		$return = false;
		try {
		
			$mail->send();
			$data['_comms_sent']	= 1;	
			$return = $data['_comms_code'];
			$data['_comms_output']	= 'Email Sent!';
			
		} catch (Exception $e) {
			$data['_comms_sent']	= 0;	
			$return = false;
			$data['_comms_output']	= $e->getMessage();
		}
		
		$where = $this->getAdapter()->quoteInto('_comms_code = ?', $data['_comms_code']);
		$success = $this->update($data, $where);
		
		return $return;
	}
	
	public function sendMailer($userData, $mailerData) {
		
		require_once('Zend/Mail.php');
		
		$mail = null; unset($mail);
		$mail = new Zend_Mail();
		
		$data								= array();
		$data['_comms_code']		= $this->createReference();
		
		$message = $mailerData['mailer_page'];
		
		$message = str_replace('[fullname]', $userData['participant_name'].' '.$userData['participant_surname'], $message);
		$message = str_replace('[name]', $userData['participant_name'], $message);
		$message = str_replace('[surname]', $userData['participant_surname'], $message);
		$message = str_replace('[cellphone]', $userData['participant_cellphone'], $message);
		$message = str_replace('[email]', $userData['participant_email'], $message);
		$message = str_replace('[area]', $userData['area_shortPath'], $message);
		$message = str_replace('[tracker]', $data['_comms_code'], $message);

		$mail->setFrom('info@lubabalofoundation.co.za', 'Lubabalo Foundation'); //EDIT!!
		$mail->addTo($userData['participant_email']);
		$mail->setSubject($mailerData['mailer_title']);
		$mail->setBodyHtml($message);			

		/* Save data to the comms table. */
		$data['participant_code']	= $userData['participant_code'];
		$data['_comms_type']		= 'email';
		$data['_comms_email']		= trim($userData['participant_email']);
		$data['_comms_output']		= '';
		$data['mailer_code']			= $mailerData['mailer_code'];
		$data['_comms_category']	= isset($userData['category']) ? $userData['category'] : null;
		$data['_comms_sent']		= null;
		$data['_comms_html']		= str_replace($data['_comms_code'], '', $message);
		$data['_comms_name']		= $mailerData['mailer_title'];
		
		$this->insert($data);
		$return = false;
		try {
		
			$mail->send();
			$data['_comms_sent']	= 1;
			$return = $data['_comms_code'];
			$data['_comms_output']	= 'Email Sent!';
			
		} catch (Exception $e) {
			$data['_comms_sent']	= 0;	
			$return = 0;
			$data['_comms_output']	= $e->getMessage();
		}
		
		$where = $this->getAdapter()->quoteInto('_comms_code = ?', $data['_comms_code']);
		$success = $this->update($data, $where);
		
		return $return;
	}
	
	public function sendEquiry($enquiryData) {
		
		require_once 'config/smarty.php';
		
		global $smarty; 
		
		require_once('Zend/Mail.php');
		
		$mail = new Zend_Mail();
		
		$data								= array();
		$data['_comms_code']		= $this->createReference();
		
		$smarty->assign('enquiryData', $enquiryData);	
		$smarty->assign('tracking', $data['_comms_code']);
		$smarty->assign('host', $_SERVER['HTTP_HOST']);
		
		$message = $smarty->fetch('templates/mailers/contact.html');

		$mail->setFrom('info@lubabalofoundation.co.za', 'Lubabalo Foundation'); //EDIT!!											
		$mail->addTo($enquiryData['enquiry_email']);
		$mail->addTo('info@lubabalofoundation.co.za');
		$mail->setSubject('Online Enquiry');
		$mail->setBodyHtml($message);			

		/* Save data to the comms table. */
		$data['_comms_type']		= 'email';
		$data['_comms_email']		= trim($enquiryData['enquiry_email']);
		$data['_comms_output']		= '';
		$data['_comms_category']	= 'enquiry';
		$data['_comms_sent']		= null;
		$data['_comms_html']		= str_replace($data['_comms_code'], '', $message);
		$data['_comms_name']		= 'Lubabalo Foundation Online Enquiry';
		
		$this->insert($data);
		$return = false;
		
		try {
		
			$mail->send();
			$data['_comms_sent']	= 1;	
			$return = $data['_comms_code'];
			$data['_comms_output']	= 'Email Sent!';
			
		} catch (Exception $e) {
			$data['_comms_sent']	= 0;	
			$return = false;
			$data['_comms_output']	= $e->getMessage();
		}
		
		$where = $this->getAdapter()->quoteInto('_comms_code = ?', $data['_comms_code']);
		$success = $this->update($data, $where);
		
		return $data['_comms_code'];
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
						->from(array('_comms' => '_comms'))		
					   ->where('_comms_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;				   		
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByMailer($code) {
		$select = $this->_db->select()	
						->from(array('_comms' => '_comms'))	
						->joinLeft(array('participant' => 'participant'), 'participant.participant_code = _comms.participant_code and participant_deleted = 0')						
						->joinLeft('area', 'area.area_code = participant.area_code')
						->where('_comms.mailer_code = ?', $code);

	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;				   		
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<13;$i++) {
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createReference();
		} else {
			return $reference;
		}
	}		
}
?>