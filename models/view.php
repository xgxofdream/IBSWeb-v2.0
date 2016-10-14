<?php
/*
 *
 * This class is to prepare UI display and values*
 *
 */
class View_Model {
	private $data = array (); // store the values that will display in UI
	private $render = FALSE; // the path of template file
	                         
	// Load a template
	public function __construct($template) {
		// 构成完整文件路径
		$file = SERVER_ROOT . '/views/' . strtolower ( $template ) . '.html';
		
		if (file_exists ( $file )) {
			
			$this->render = $file;
		}
	}
	
	// Get value from the outside of the Class 'View_Model'
	public function assign($variable, $value) {
		$this->data [$variable] = $value;
	}
	// Display the UI combining the data
	public function display() {
		$data = $this->data; // this piece of code must be with the next piece of code.
		include ($this->render);
	}
	public function __destruct() {
	}
}
?>
