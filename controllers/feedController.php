<?php
/**
 * @desc ATOM RSS Feed controller
 * @author jmserrano
 * @since 2012-02-28
 */
class feedController extends joimFWController {
	/**
	 * @desc RSS feed. Takes web entries and shows them in an RSS feed.
	 * This example would feed news, if there were any.
	 */
	public function index() {
		header('Content-Type: application/rss+xml');
		$document = htmlHandler::get('rss', 'rss');
		//$news = homeModel::getNews();
		$items = '';
		$itemHtml = htmlHandler::get('item', 'rss');
		/* News do not exist
		foreach ($news as $new) {
			$items .= htmlHandler::parseInto($memeHtml, $new);
		}
		*/
		$document = htmlHandler::parseInto($document, array('items' => $items));
		die($document);
	}
}
?>
