<?php

namespace Joim;

/**
 * @desc Base model
 * @author jmserrano
 * @since 2013-06-29
 * @modified 2014-10-13
 */
class Model {

	protected $table = '';
	protected $columns = [];
	protected $data = [];

	public function __construct($id=0) {
		if ($table !== '') {
			// Populate columns data from the table from the DB
			if ($id) {
				// If an ID is given, populate the model data with that id
				/* TODO and TO IMPROVE
				$this->data = self::getInstance()
					->select()
					->from($this->table)
					->where('id = ?', $id)
					->query()
					->fetch();
				*/
			}
		}
	}

	public static function getAdapter() {
		return Db::getInstance();
	}
}
