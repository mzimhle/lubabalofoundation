<?php

//custom account item class as account table abstraction
class class_administrator extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'administrator';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        if (empty($data['administrator_added'])) {
            $data['administrator_added'] = date('Y-m-d H:i:s');
        }

		return parent::insert($data);
		
    }

	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where)
    {
        // add a timestamp
        if (empty($data['administrator_updated'])) {
            $data['administrator_updated'] = date('Y-m-d H:i:s');
        }
        return parent::update($data, $where);
    }
	
	public function remove($code) {
		return $this->delete('administrator_code = ?', $code);		
	}
	
	/**
	 * get job by job administrator Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('administrator' => 'administrator'))
					->where('administrator_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	
	
	public function getAll($where = NULL, $order = NULL)
	{
		$select = $this->_db->select()	
						->from(array('administrator' => 'administrator'))					
						->where($where)
						->order($order);						
		
		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get all administrators ordered by column name
	 * example: $collection->getAlladministrators('administrator_title');
	 * @param string $order
     * @return object
	 */
	public function checkLogin($username = '', $password= '')
	{
		$select = $this->select()
					   ->where('administrator_email = ?', $username)
					   ->where('administrator_active = 1')
					   ->where('administrator_deleted = 0')
					   ->where('administrator_password = ?', $password);
		
        $result = $this->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select()	
						->from(array('administrator' => 'administrator'))	
					   ->where('administrator_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "0123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<8;$i++){
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

	function createPassword() {
		/* New reference. */
		$password = "";
		$codeAlphabet = "abcdefghigklmnopqrstuvwxyz";
		$codeAlphabet .= "0123456789";
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<6;$i++){
			$password .= $codeAlphabet[rand(0,$count)];
		}
		
		return $password;

	}	
}
?>