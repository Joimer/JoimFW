<?php

namespace Mail;

// TODO: Refactor
class Sender {
	public function send($mailSendTo, $title, $body, $replyTo='no-reply@example.com') {
		$noReplyMail = 'Website <no-reply@example.com>';
		$headers = "From: {$noReplyMail}\r\n". "Reply-to: {$replyTo}\r\n";
		$params = "-f {$noReplyMail}";
		$result = mail($mailSendTo, $title, $body, $headers, $params);
		$resultText = ($result)? 'success' : 'failure';
		return $result;
	}
}
