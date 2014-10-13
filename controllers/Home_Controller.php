<?php
/**
 * @desc Index controller. Controls actions at root and decides where to go.
 * @author jmserrano
 * @since 2013-05-05
 */
class Home_Controller extends Joim_Controller {

	/**
	 * @desc Controller construct, chooses the main template and its section.
	 */
	public function _init() {
		$this->template_section = 'public';
		$this->template = 'login';
	}

	/**
	 * @desc Shows the main home page where you can login.
	 * @return void
	 */
	public function indexAction() {
		$this->view()->addJs('login')->show($this->args);
	}
}
