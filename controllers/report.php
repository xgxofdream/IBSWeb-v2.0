<?php
/*
 * This class is for the operations regarding data display on individual basis*
 */
class Report_Controller {
	public $reportPage4all_template = 'reportPage4all';
	public $report_user_ID = '';
	public $pageBodyType = '';
	public function __construct() {
	}
	public function main(array $getVars) {
		if (empty ( $getVars )) {
			$this->pageBodyType = '';
		} else {
			$this->pageBodyType = $getVars ['type'];
			$this->report_user_ID = $getVars ['report_user_ID'];
		}
		
		$reportModel = new Report_Model ();
		$view = new View_Model ( $this->reportPage4all_template );
		
		$reportModel->reportData ( $this->pageBodyType, $this->report_user_ID );
		$view->assign ( 'user_tel', $reportModel->user_tel );
		$view->assign ( 'reportInfo', $reportModel->reportInfo );
		$view->display ();
	}
}
?>  