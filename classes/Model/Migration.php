<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Migration extends ORM {

	protected $_table_columns = array(
		'id'         => array('type' => 'int'),
		'hash'       => array('type' => 'string'),
		'name'       => array('type' => 'string'),
		'updated_at' => array('type' => 'datetime'),
		'created_at' => array('type' => 'datetime'),
	);

	public function is_installed() {
		try {
      $this->count_all();
    } catch (Database_Exception $a) {
      return false;
    }
    return true;
	}

	public function fetch_migrations() {
		try {
  	  $this->find_all();
    } catch (Database_Exception $a) {
      if ($a->getCode() == 1146) { //Tabla no existe
        echo kohana::debug($a->getMessage());
    	}
	  }
	}

}
