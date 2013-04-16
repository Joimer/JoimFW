<?php

namespace Joim;

/**
 * @desc Handles logs
 * @author jmserrano
 * @since 2012-02-10
 * @modified 2014-10-13
 * @modified 2016-02-09
 */
class Log {
	public static function log($message, $section='php') {
		if (!in_array($section, ['mail', 'mysql', 'cron', 'php'])) {
			$section = 'php';
		}
		$file = $section . '.log';
		file_put_contents(DOC_ROOT . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $file, $message, FILE_APPEND);
	}
}
