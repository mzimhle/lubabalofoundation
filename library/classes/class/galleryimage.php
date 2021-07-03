<?php

//custom account item class as account table abstraction
class class_galleryimage extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'galleryimage';
	protected $_primary 		= 'galleryimage_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data)
    {
        // add a timestamp
        $data['galleryimage_added'] = date('Y-m-d H:i:s');        

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
        $data['galleryimage_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job galleryimage Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {	
		$select = $this->_db->select()	
					->from(array('galleryimage' => 'galleryimage'))	
					->joinLeft(array('gallery' => 'gallery'), 'gallery.gallery_code = galleryimage.gallery_code')	
					->where('galleryimage_deleted = 0')
					->where('galleryimage_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	
		
	public function getAll($where = NULL, $order = NULL){
		
		$select = $this->_db->select()	
					->from(array('galleryimage' => 'galleryimage'))	
					->joinLeft(array('gallery' => 'gallery'), 'gallery.gallery_code = galleryimage.gallery_code')
					->where('galleryimage_deleted = 0')					
					->where($where)
					->order($order);						
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	
	public function getByGallery($gallerycode)
	{
		
		$select = $this->_db->select()	
					->from(array('galleryimage' => 'galleryimage'))	
					->joinLeft(array('gallery' => 'gallery'), 'gallery.gallery_code = galleryimage.gallery_code')	
					->where('galleryimage.gallery_code = ?', $gallerycode)
					->where('galleryimage_deleted = 0')
					->order('galleryimage_added DESC');					

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function getPrimaryByGallery($code) {
	
		global $zfsession;
		
		$select = $this->_db->select()	
					->from(array('galleryimage' => 'galleryimage'))	
					->joinLeft(array('gallery' => 'gallery'), 'gallery.gallery_code = galleryimage.gallery_code')	
					->where('galleryimage.gallery_code = ?', $code)
					->where('galleryimage_deleted = 0')
					->where('galleryimage_primary = 1')
					->order('galleryimage_added DESC')
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;	
	}
	
	public function updatePrimaryByGallery($code, $gallerycode) {
		
		$item = $this->getPrimaryByGallery($gallerycode);
		
		if($item) {
			$data = array();
			$where = null;
			$data['galleryimage_primary'] = 0;
			
			$where		= $this->getAdapter()->quoteInto('galleryimage_code = ?', $item['galleryimage_code']);
			$success	= $this->update($data, $where);				
		}

		$data = array();
		$data['galleryimage_primary'] = 1;
			
		$where		= $this->getAdapter()->quoteInto('galleryimage_code = ?', $code);
		$success	= $this->update($data, $where);
		
		return $success;
	}	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select()	
					->from(array('galleryimage' => 'galleryimage'))	
					   ->where('galleryimage_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<12;$i++){
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