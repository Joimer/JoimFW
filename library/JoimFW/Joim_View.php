<?php
/**
 * @desc The HTML handler, treats HTML to parse the templates and show the user the final result
 * @author jmserrano
 * @since 2011-02-24
 */
class Joim_View {
	
	/**
	 * @desc Template to use
	 * @var string
	 */
	protected $page;
	/**
	 * @desc Template section
	 * @var string
	 */
	protected $section;
	/**
	 * @desc Data to parse
	 * @var array
	 */
	protected $data = array();
	/**
	 * @desc Master template to use (base.phtml by default)
	 * @var array
	 */
	protected $masterTemplate;
	
	/**
	 * @desc Use the main template
	 */
	protected $useMain = true;

	/**
	 * @desc JS files to add to the template
	 */
	protected $jsFiles = array();
	
	/**
	 * @desc Class constructor
	 * @param string $page
	 * @param string $section
	 * @return void
	 */
	public function __construct($page='', $section='main') {
		$this->page = $page;
		$this->section = $section;
		$this->masterTemplate = 'base';
		$this->data = array();
	}
	
	/**
	 * @desc Chooses template to use
	 * @param string $page
	 * @return void
	 */
	public function setPage($page) {
		$this->page = $page;
		return $this;
	}
	
	/**
	 * @desc Adds data to the template
	 * @param array $data
	 * @return void
	 */
	public function addData($data=array()) {
		if (is_array($data)) $this->data = array_merge($this->data, $data);
		return $this;
	}
	
	public function useMain($bool=true) {
		$this->useMain = $bool;
	}

	/**
	 * @desc Adds a JS file or a series of JS files.
	 * @param mixed $file String or Array
	 */
	public function addJs($file) {
		if (is_string($file)) {
			$this->_addJs($file);
		} else if (is_array($file)) {
			foreach ($file as $js) {
				$this->_addJs($js);
			}
		}
		return $this;
	}

	private function _addJs($file) {
		if (is_string($file)) {
			$file = trim(preg_replace('/[^A-z]\-/', '', $file));
			if ($file) $this->jsFiles[] = $file;
		}
	}
	
	/**
	 * @desc Shows final HTML
	 * @return void
	 */
	public function show($data=array()) {
		$this->addData($data);
		$template = self::get($this->page, $this->section);
		$this->parse($template, $this->data);
		if ($this->useMain) {
			$section = (Joim_Session::isLoggedIn())? 'main' : 'public';
			$master = self::get($this->masterTemplate, $section);
			$header = self::get('header', 'main');
			$footer = self::get('footer', 'main');
			// Add the JS files to the head
			$jsBuffer = array();
			foreach ($this->jsFiles as $js) {
				$jsBuffer[] = "<script type='text/javascript' src='/front/js/{$js}.js'></script>";
			}
			$jsBuffer = implode("\n", $jsBuffer);
			$this->parse($header, array('js' => $jsBuffer));
			// Parse HTMLs on the master template
			$this->parse($master, array('content' => $template, 'head' => $header, 'foot' => $footer));
			// Halt script with final html to be thrown to the output buffer.
			die($master);
		} else {
			die($template);
		}
	}

	public function appendInto(htmlHandler &$view, $name) {
		$template = self::get($this->page, $this->section);
		$this->parse($template, $this->data);
		$view->addData(array($name => $template));
	}
	
	/**
	 * @desc Takes a template's HTML
	 * @param string $pagename
	 * @return string $html
	 */
	public static function get($pagename, $section='main') {
		return file_get_contents("templates/{$section}/{$pagename}.phtml");
	}

	/**
	 * @desc Parses data to HMTL, access from $this context
	 * @param string &$html
	 * @param array $data
	 */
	protected function parse(&$html, $data=array()) {
		$html = self::parseProcess($html, $data);
	}

	/**
	 * @desc Internal parse function
	 * @param string $html
	 * @param array $data
	 */
	protected static function parseProcess($html, $data=array()) {
		foreach ($data as $tag=>$value) {
			if (!is_scalar($value)) {
				if (is_array($value)) {
					foreach ($value as $inner_tag=>$inner_value) {
						if (is_scalar($inner_value)) {
							$html = str_replace("{{$tag}_{$inner_tag}}", $inner_value, $html);
						}
					}
				} else {
					throw new ErrorException(
						'Expecting string or mapable array, obtained this instead:<br />'
						. print_r($value, true) . '<br />Current data:<br />' 
						. print_r($data, true), 
						0, E_USER_ERROR, __FILE__, __LINE__
					);
				}
			} else {
				$html = str_replace("{{$tag}}", $value, $html);
			}
		}

		return $html;
	}
	

	/**
	 * @desc Public static access parse function
	 * @param string $html
	 * @param array $data
	 */
	public static function parseInto($html, $data=array()) {
		return self::parseProcess($html, $data);
	}
	
	public static function makeList($array) {
		$list = '<ul>';
		foreach ($array as $value) {
			$list .= "<li>{$value}</li>";
		}
		$list .= '</ul>';
		return $list;
	}

	public static function deaccent(&$string) {
		// Declare values to seek
		$a_min = array('á', 'à', 'ä', 'â', 'å', 'ã', 'ą');
		$a_mayus = array('Á', 'À', 'Ä', 'Â', 'Å', 'Ą');
		$e_min = array('é', 'è', 'ë', 'ê', 'ę');
		$e_mayus = array('É', 'È', 'Ë', 'Ê', 'Ę');
		$i_min = array('í', 'ì', 'ï', 'î');
		$i_mayus = array('Í', 'Ì', 'Ï', 'Î');
		$o_min = array('ó', 'ò', 'ö', 'ô', 'ø');
		$o_mayus = array('Ó', 'Ò', 'Ö', 'Ô', 'Ø');
		$u_min = array('ú', 'ù', 'ü', 'û');
		$u_mayus = array('Ú', 'Ù', 'Ü', 'Û');
		$consonantes_find = array('ñ', 'ç', 'ł', 'ß', 'Ñ', 'Ç', 'Ł');
		$consonantes_replace = array('ny', 's', 'w', 'ss', 'NY', 'S', 'W');

		// Replace
		$string = str_replace($a_min, 'a', $string);
		$string = str_replace($a_mayus, 'A', $string);
		$string = str_replace($e_min, 'e', $string);
		$string = str_replace($e_mayus, 'E', $string);
		$string = str_replace($i_min, 'i', $string);
		$string = str_replace($i_mayus, 'I', $string);
		$string = str_replace($o_min, 'o', $string);
		$string = str_replace($o_mayus, 'O', $string);
		$string = str_replace($u_min, 'u', $string);
		$string = str_replace($u_mayus, 'U', $string);
		$string = str_replace($consonantes_find, $consonantes_replace, $string);
	}

	public static function exists($pagename, $section='main') {
		return file_exists("templates/{$section}/{$pagename}.phtml");
	}
}