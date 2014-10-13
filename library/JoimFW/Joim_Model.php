<?php
/**
 * @desc Base model
 * @author jmserrano
 * @since 2013-06-29
 */
class Joim_Model {

	protected $table = '';
	protected $columns = array();
	protected $data = array();

	public function __construct($id=0) {
		if ($table !== '') {
			// Populate columns data from the table from the DB
			if ($id) {
				// If an ID is given, populate the model data with that id
				$this->data = self::getInstance()
					->select()
					->from($this->table)
					->where('id = ?', $id)
					->query()
					->fetch();
			}
		}
	}

	public static function getAdapter() {
		return Joim_Db::getInstance();
	}
}