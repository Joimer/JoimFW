<?php
/**
 * @desc Handles logs
 * @author jmserrano
 * @since 2012-02-10
 */
class Joim_Log {
	public static function log($message, $section='php') {
		switch ($section) {
			case 'mail':
				$file = 'mail.log';
				break;
			case 'mysql':
				$file = 'mysql.log';
				break;
			case 'cron':
				$file = 'cron.log';
				break;
			case 'php':
			default:
				$file = 'php.log';
				break;
		}
		file_put_contents(DOC_ROOT . '/logs/' . $file, $message, FILE_APPEND);
	}
}