<?php

//custom account item class as account table abstraction
class class_gallery extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'gallery';
	protected $_primary		= 'gallery_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['gallery_added'] = date('Y-m-d H:i:s');
		$data['gallery_code']		= $this->createReference();
        
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
        $data['gallery_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	public function remove($code) {
		return $this->delete('gallery_code = ?', $code);		
	}
	
	/**
	 * get job by job gallery Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		
		$select = $this->_db->select()	
					->from(array('gallery' => 'gallery'))
					->where('gallery_deleted = 0')
					->where('gallery_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}
	
	public function getAll($where = 'gallery_deleted = 0', $order = 'gallery_name desc') {
		
		$select = $this->_db->select()	
					->from(array('gallery' => 'gallery'))
					->joinLeft(array('galleryimage' => 'galleryimage'), 'galleryimage.gallery_code = gallery.gallery_code and galleryimage_primary = 1')	
					->where('gallery_deleted = 0')
					->where($where)
					->order($order);
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code) {
		$select = $this->_db->select()	
					->from(array('gallery' => 'gallery'))	
					   ->where('gallery_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createReference() {
		/* New code. */
		$code = "";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createReference();
		} else {
			return $code;
		}
	}		
}
?>