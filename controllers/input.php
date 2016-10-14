<?php
/*
 * This class is for the operations regarding inserting data into database*
 */
class Input_Controller {

	public $pageBodyType = '';
	public $estimation_target_ID = '';
	
	public function __construct() {
	}
	public function main(array $getVars) {
		
		if (empty ( $getVars )) {
			$this->pageBodyType = '';
		} else {
			$this->pageBodyType = $getVars ['type'];
			@$this->estimation_target_ID = $getVars ['estimation_target_ID'];
		}
				
		switch ($this->pageBodyType) {
			case 'basic_info' :
				$db_table01_arr = array('user_basic_info','user_profile_for_research');
				$db_table02_arr = array('user_profile_for_research'=>'user_basic_info_status');
				$input = new Input_Model ();
				$input->assign($db_table01_arr, $db_table02_arr);
				$input->inputDada($_POST, $input->db_table01_arr, $input->db_table02_arr, $input->user_ID);
				break;
			case 'health_info' :
				$db_table01_arr = array('user_health_info','user_profile_for_research');
				$db_table02_arr = array('user_profile_for_research'=>'user_health_info_status');
				$input = new Input_Model ();
				$input->assign($db_table01_arr, $db_table02_arr);
				$input->inputDada($_POST, $input->db_table01_arr, $input->db_table02_arr, $input->user_ID);
				break;
			case 'diet_info' :
				$db_table01_arr = array('user_diet_info','user_profile_for_research');
				$db_table02_arr = array('user_profile_for_research'=>'user_diet_info_status');
				$input = new Input_Model ();
				$input->assign($db_table01_arr, $db_table02_arr);
				$input->inputDada($_POST, $input->db_table01_arr, $input->db_table02_arr, $input->user_ID);
				break;
			case 'lifestyle_info' :
				$db_table01_arr = array('user_lifestyle_info','user_profile_for_research');
				$db_table02_arr = array('user_profile_for_research'=>'user_lifestyle_info_status');
				$input = new Input_Model ();
				$input->assign($db_table01_arr, $db_table02_arr);
				$input->inputDada($_POST, $input->db_table01_arr, $input->db_table02_arr, $input->user_ID);
				break;
			case 'self_estimation' :
				$db_table01_arr = array('user_self_estimation','subform_selfe_depression','subform_selfe_anxiety','subform_selfe_lifequality','subform_selfe_feces','subform_selfe_ibslevel','user_profile_for_research');
				$db_table02_arr = array('user_profile_for_research'=>'user_self_estimation_status');
				$input = new Input_Model ();
				$input->assign($db_table01_arr, $db_table02_arr);
				$input->inputDada($_POST, $input->db_table01_arr, $input->db_table02_arr, $input->user_ID);
				break;
			case 'physician_estimation' :
				$db_table01_arr = array('subform_physician_cmsymptom', 'subform_physician_hamd17','subform_physician_medicine','subform_physician_menopauseassessment','subform_physician_symptom','user_physician_estimation','user_profile_for_research');
				$db_table02_arr = array('user_profile_for_research'=>'user_physician_estimation_status');
				$input = new Input_Model ();
				$input->assign($db_table01_arr, $db_table02_arr);
				$input->inputDada($_POST, $input->db_table01_arr, $input->db_table02_arr, $this->estimation_target_ID);
				break;
			default :
				destroySession ();
				break;
		}
		
	}
}
?>  