<?php
/*
 * This class is for the operations regarding user*
 */
class User_Controller {
	public $Login_template = 'login';
	public $Register_template = 'register';
	public $pageBodyType = '';
	public function __construct() {
	}
	public function main(array $getVars) {
		if (empty ( $getVars )) {
		} else {
			$this->pageBodyType = $getVars ['type'];
		}
		
		switch ($this->pageBodyType) {
			case 'prepareLogin' :
				$view = new View_Model ( $this->Login_template );
				$view->display ();
				break;
			
			case 'login' :
				$userModel = new User_Model ();
				$userModel->login ();
				break;
			case 'unlogin' :
				$userModel = new User_Model ();
				$userModel->unlogin ();
				break;
			case 'prepareReg' :
				$view = new View_Model ( $this->Register_template );
				$view->display ();
				break;
			case 'register' :
				$userModel = new User_Model ();
				$userModel->register ();
				break;
			
			default :
				destroySession ();
				break;
		}
	}
}
?>  