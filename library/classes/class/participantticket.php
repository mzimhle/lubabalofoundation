<?php

//custom enquiry item class as enquiry table abstraction
class class_participantticket extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'participantticket';
	protected $_primary = 'participantticket_code';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data) {
        // add a timestamp
        $data['participantticket_code'] = $this->createReference();
        $data['participantticket_added'] = date('Y-m-d H:i:s');
        		        
		return parent::insert($data);
		
    }

	
    public function update(array $data, $where)
    {
        // add a timestamp
        $data['participantticket_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	public function remove($code) {
		return parent::delete("participantticket_code = '$code'");		
	}
	
	public function deleteByParticipant($code) {
		
		$participanttickets = $this->getByParticipant($code);
		
		if($participanttickets) {
			for($i = 0; $i < count($participanttickets); $i++) {
				if($participanttickets[$i]['participantticket_code'] != '') {
					$this->remove($participanttickets[$i]['participantticket_code']);
				}
			}
		}
	}
	
	/**
	 * get participantticket by participantticket Account Id
 	 * @param string participantticket id
     * @return object
	 */
	public function getAll($where = 'participantticket_deleted != \'\'', $order = 'participantticket_name desc')
	{
		$select = $this->_db->select() 
					   ->from(array('participantticket' => 'participantticket'))
					   ->joinLeft('participant', 'participant.participant_code = participantticket.participant_code and participant_deleted = 0')
					   ->joinLeft('ticket', 'ticket.ticket_code = participantticket.ticket_code and ticket_deleted = 0')
					   ->joinLeft('event', 'event.event_code = ticket.event_code and event_deleted = 0')
					   ->where('participant_deleted = 0 and event_deleted = 0')
					   ->where('participantticket_deleted = 0');
					   
	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;

	}
	
	/**
	 * get participantticket by participantticket Account Id
 	 * @param string participantticket id
     * @return object
	 */
	public function getByCode($reference) {
		$select = $this->_db->select() 
					   ->from(array('participantticket' => 'participantticket'))
					   ->joinLeft('participant', 'participant.participant_code = participantticket.participant_code and participant_deleted = 0')
					   ->joinLeft('ticket', 'ticket.ticket_code = participantticket.ticket_code and ticket_deleted = 0')
					   ->joinLeft('event', 'event.event_code = ticket.event_code and event_deleted = 0')
					   ->where('participantticket_deleted = 0')
					   ->where('participant_deleted = 0 and event_deleted = 0')
					   ->where('participantticket_code = ?', $reference)
					   ->limit(1);
					   
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;

	}
	
	public function getByParticipant($code) {
		$select = $this->_db->select() 
					   ->from(array('participantticket' => 'participantticket'))
					   ->joinLeft('participant', 'participant.participant_code = participantticket.participant_code and participant_deleted = 0')
					   ->joinLeft('ticket', 'ticket.ticket_code = participantticket.ticket_code and ticket_deleted = 0')
					   ->joinLeft('event', 'event.event_code = ticket.event_code and event_deleted = 0')
					   ->where('participantticket_deleted = 0')
					   ->where('participant_deleted = 0 and event_deleted = 0')
					   ->where('participantticket.participant_code = ?', $code)
					   ->order('participantticket_date');
					   
	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;	
	
	}
	
	/**
	 * get participantticket by participantticket Account Id
 	 * @param string participantticket id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select() 
					   ->from(array('participantticket' => 'participantticket'))
					   ->where('participantticket_code = ?', $reference)
					   ->limit(1);
					   
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	function createFile() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet .= "123456789";
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i = 0; $i < 12; $i++) {
			$reference .= $codeAlphabet[rand(1,$count)];
		}

		return $reference;
		
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		// $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = "123456789";
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i = 0; $i < 10; $i++) {
			$reference .= $codeAlphabet[rand(1,$count)];
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