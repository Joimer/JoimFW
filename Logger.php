<?php

namespace Application;

class Logger {
	public static function log($message, $section='php') {
		if (!in_array($section, ['mail', 'mysql', 'cron', 'php'])) {
			$section = 'php';
		}
		$file = $section . '.log';
		file_put_contents(DOC_ROOT . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $file, $message, FILE_APPEND);
	}	
}
