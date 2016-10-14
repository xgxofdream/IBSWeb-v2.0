<?php

/*
 * This class is to get data to support the survey data collecting*
 */
class Survey_Model {
	public $user_tel = '';
	public function __construct() {
		$this->user_tel = pageGuard ();
		// echo $this->user_tel;
	}
}
?>  