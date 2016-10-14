<?php
/*
 * This class is for the operations regarding collecting survey data*
 */
class Survey_Controller {
	public $Body_basic_template = 'surveyPageBody_basic';
	public $Body_health_template = 'surveyPageBody_health';
	public $Body_diet_template = 'surveyPageBody_diet';
	public $Body_lifestyle_template = 'surveyPageBody_lifestyle';
	public $Body_self_estimation_template = 'surveyPageBody_self_estimation';
	public $Body_physician_estimation_template = 'surveyPageBody_physician_estimation';
	public $estimation_target_ID = '';
	public $pageBodyType = '';
	public function __construct() {
	}
	public function main(array $getVars) {
		if (empty ( $getVars )) {
			$this->pageBodyType = '';
		} else {
			$this->pageBodyType = $getVars ['type'];
			@$this->estimation_target_ID = $getVars ['estimation_target_ID'];
		}
		
		$surveyModel = new Survey_Model ();
		
		switch ($this->pageBodyType) {
			case 'basic_info' :
				
				$view = new View_Model ( $this->Body_basic_template );
				$view->assign ( 'user_tel', $surveyModel->user_tel );
				$view->display ();
				
				break;
			case 'health_info' :
				$view = new View_Model ( $this->Body_health_template );
				$view->assign ( 'user_tel', $surveyModel->user_tel );
				$view->display ();
				break;
			case 'diet_info' :
				$view = new View_Model ( $this->Body_diet_template );
				$view->assign ( 'user_tel', $surveyModel->user_tel );
				$view->display ();
				break;
			case 'lifestyle_info' :
				$view = new View_Model ( $this->Body_lifestyle_template );
				$view->assign ( 'user_tel', $surveyModel->user_tel );
				$view->display ();
				break;
			case 'self_estimation' :
				$view = new View_Model ( $this->Body_self_estimation_template );
				$view->assign ( 'user_tel', $surveyModel->user_tel );
				$view->display ();
				break;
			case 'physician_estimation' :
				$view = new View_Model ( $this->Body_physician_estimation_template );
				$view->assign ( 'user_tel', $surveyModel->user_tel );
				$view->assign ( 'estimation_target_ID', $this->estimation_target_ID );
				$view->display ();
				break;
			default :
				destroySession ();
				break;
		}
		
		include 'views/website_indexFoot.html';
	}
}
?>  