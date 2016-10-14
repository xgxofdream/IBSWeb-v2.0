<?php
/*
 * This class is for the operations in Index page*
 */
class Index_Controller {
	public $Head_offLogin_template = 'website_indexHead_offLogin';
	public $Head_onLogin_template = 'website_indexHead_onLogin';
	public $Body_offLogin_template = 'website_indexBody_offLogin';
	public $Body_onLogin_template = 'website_indexBody_onLogin';
	public $Body_onLogin4researcher_template = 'website_indexBody_onLogin4researcher';
	public $pageBodyType = '';
	// Construct function
	public function __construct() {
	}
	// Main function
	public function main(array $getVars) {
		
		// Get the GET variables and values
		if (empty ( $getVars )) {
			$this->pageBodyType = '';
		} else {
			$this->pageBodyType = $getVars ['purposeTo'];
		}
		
		// Instantiate the class 'Index_Model' to get data from database
		$indexModel = new Index_Model ();
		
		switch ($indexModel->loginStatus) {
			case 0 :
				// Instantiate the class 'View_Model' to get UI display
				$view = new View_Model ( $this->Head_offLogin_template );
				$view->display ();
				break;
			case 1 :
				// Instantiate the class 'View_Model' to get UI display
				$view = new View_Model ( $this->Head_onLogin_template );
				// Get data from 'Index_Model' instantiation
				$view->assign ( 'user_tel', $indexModel->user_tel );
				// Display UI
				$view->display ();
				break;
			case 2 :
				$view = new View_Model ( $this->Head_onLogin_template );
				$view->assign ( 'user_tel', $indexModel->user_tel );
				$view->display ();
				break;
			default :
				session_destroy ();
				redirect ( "login.php", "You are not properly logining!" );
				break;
		}
		
		switch ($indexModel->loginStatus) {
			case 0 :
				include 'views/website_indexBody_offLogin.html';
				break;
			case 1 :
				if ($this->pageBodyType == 'report_physician_estimation') {
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/samplePageUI.css\"/>";
					include 'views/reportPageBody_physician_estimation.html';
					break;
				}
				if ($this->pageBodyType == '') {
					$view = new View_Model ( $this->Body_onLogin_template );
					$view->assign ( 'basic_info_completion', $indexModel->basic_info_completion );
					$view->assign ( 'health_info_completion', $indexModel->health_info_completion );
					$view->assign ( 'diet_info_completion', $indexModel->diet_info_completion );
					$view->assign ( 'lifestyle_info_completion', $indexModel->lifestyle_info_completion );
					$view->assign ( 'self_estimation_completion', $indexModel->self_estimation_completion );
					$view->assign ( 'physician_estimation_completion', $indexModel->physician_estimation_completion );
					
					$view->display ();
					
					break;
				}
			
			case 2 :
				include 'views/website_indexBody_onLogin4researcher.html';
				break;
			default :
				$_SESSION = array ();
				if (isset ( $_COOKIE [session_name ()] )) {
					setcookie ( session_name (), '', time () - 42000, '/' );
				}
				session_destroy ();
				redirect ( "login.php", "You are not properly logining!" );
				break;
		}
		
		include 'views/website_indexFoot.html';
	}
}
?>  