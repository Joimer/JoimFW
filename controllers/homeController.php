<?php
/**
 * @desc Home controller, example controller to show the home of an application
 * @author jmserrano
 * @since 2011-02-24
 */
class homeController extends joimFWController {
	
	/**
	 * @desc Shows the home index
	 * @return void
	 */
	public function index() {
		$view = new htmlHandler('home');
		$view->show();
	}
}
?>
