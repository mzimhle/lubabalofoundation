<?php

/**
 * This class uses the Zend Framework :
 * @package    Zend_Db
 * This class is used for all standard administrators functions, both singleton and collection
 * Created: 05 May 2009
 * Author: Rafeeqah Mollagee
 */

//custom enquiry item class as enquiry table abstraction
class class_event extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'event';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data) {
        // add a timestamp
        $data['event_added']	= date('Y-m-d H:i:s');
		$data['event_code']	= $this->createReference();		   
		
		return parent::insert($data);		
    }
	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where){
        // add a timestamp
        $data['event_updated']	= date('Y-m-d H:i:s');
		
        return parent::update($data, $where);
    }
	
	public function getAll($where = 'event_deleted = 0', $order = 'event_added desc') {
	
			$select = $this->_db->select() 
					   ->from(array('event' => 'event'))
					   ->joinLeft('area', 'area.area_code = event.area_code')
					   ->where('event_deleted = 0')
					   ->where($where)
					   ->order($order);
	
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	 public function pairs() {
		$select = $this->select()
					   ->from(array('event' => 'event'), array('event.event_code', 'event.event_name'))
					   ->where('event_deleted = 0')
					   ->order('event_name ASC');

	   $result = $this->_db->fetchPairs($select);	
       return ($result == false) ? false : $result = $result;			
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
						->from(array('event' => 'event'))	
						->joinLeft('area', 'area.area_code = event.area_code')
					   ->where('event_code = ?', $code)
					   ->where('event_deleted = 0')
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
						->from(array('event' => 'event'))	
					   ->where('event_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		//$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = '123456789';
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
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