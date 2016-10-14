<?php

/*
 * This class is for the operations regarding sample management*
 */
class Manage_Controller {

	public $Body_management_template = 'samplePageBody_management';
	public $Body_profile_template = 'samplePageBody_profile';
	public $Body_biochemistry_template = 'samplePageBody_biochemistry';
	public $pageBodyType = '';
	public function __construct() {
	}
	public function main(array $getVars) {
		if (empty ( $getVars )) {
			$this->pageBodyType = 'sample_management';
		} else {
			$this->pageBodyType = $getVars ['type'];
		}
		
		switch ($this->pageBodyType) {
			
			case 'sample_management' :
				$manage = new Manage_Model ();
				$manage->fectchData01 ( $this->pageBodyType );
				$view = new View_Model ( $this->Body_management_template );
				$view->assign ( 'user_tel', $manage->user_tel );
				$view->assign ( 'sampleInfo', $manage->sampleInfo );
				$view->display ();
				break;
			
			case 'sample_profile' :
				$manage = new Manage_Model ();
				$manage->fectchData02 ( $this->pageBodyType );
				$view = new View_Model ( $this->Body_profile_template );
				$view->assign ( 'user_tel', $manage->user_tel );
				$view->assign ( 'sampleInfo', $manage->sampleInfo );
				$view->display ();
				break;
			
			case 'sample_biochemistry' :
				$manage = new Manage_Model ();
				$view = new View_Model ( $this->Body_biochemistry_template );
				$view->assign ( 'user_tel', $manage->user_tel );				
				$view->display ();
				break;
			case 'search_managmentInfo' :
				$manage = new Manage_Model ();
				$manage->fectchData01 ( $this->pageBodyType );
				$view = new View_Model ( $this->Body_management_template );
				$view->assign ( 'user_tel', $manage->user_tel );
				$view->assign ( 'sampleInfo', $manage->sampleInfo );
				$view->display ();
				break;
			case 'search_sampleProfile' :
				$manage = new Manage_Model ();
				$manage->fectchData02 ( $this->pageBodyType );
				$view = new View_Model ( $this->Body_profile_template );
				$view->assign ( 'user_tel', $manage->user_tel );
				$view->assign ( 'sampleInfo', $manage->sampleInfo );
				$view->display ();
				break;
			
			default :
				destroySession ();
				break;
		}
		
		include 'views/samplePageFoot.html';
	}
}
?>  