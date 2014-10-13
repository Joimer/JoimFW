<?php
/**
 * @desc Handles the e-mail sending
 * @author jmserrano
 * @since 2011-10-05
 */
class Joim_Mail {
	public static function mail($mailSendTo, $title, $body, $replyTo='no-reply@example.com') {
		$noReplyMail = 'Website <no-reply@example.com>';
		$headers = "From: {$noReplyMail}\r\n". "Reply-to: {$replyTo}\r\n". 'X-Mailer: PHP/' . phpversion();
		$params = "-f {$noReplyMail}";
		$result = mail($mailSendTo, $title, $body, $headers, $params);
		$resultText = ($result)? 'success' : 'failure';
		logHandler::log(
			date('[Y-m-d H:i:s] ') 
			. "Sent mail to {$mailSendTo} [{$resultText}].\n"
			. "Subject: {$title}\n"
			. "Content:\n{$body}\n"
			. "----------------------------------------------------\n\n"
			, 'mail'
		);
		return $result;
	}
}