<?php

/*
 * This class is to get data for Index page from database*
 */
class Index_Model {
	public $report_user_ID = '';
	public $reportInfo = '';
	public $user_tel = '';
	public $loginStatus = '';
	public $basic_info_completion = '';
	public $health_info_completion = '';
	public $diet_info_completion = '';
	public $lifestyle_info_completion = '';
	public $self_estimation_completion = '';
	public $physician_estimation_completion = '';
	public function __construct() {
		if (isset ( $_SESSION ['user_tel'] )) {
			
			if ($_SESSION ['user_type'] > 0) {
				$this->user_tel = $_SESSION ['user_tel'];
				$this->loginStatus = 2;
			}
			if ($_SESSION ['user_type'] == 0) {
				$this->user_tel = $_SESSION ['user_tel'];
				$this->report_user_ID = $_SESSION ['user_ID'];
				$this->loginStatus = 1;
				
				$db = new myDB ();
				$sql01 = "select * from `user_profile_for_research` where user_ID='" . $_SESSION ['user_ID'] . "'";
				
				$result = $db->query ( $sql01 );
				$row = $result->fetch ( PDO::FETCH_ASSOC );
				
				$this->basic_info_completion = $row ['user_basic_info_status'] . "%";
				$this->health_info_completion = $row ['user_health_info_status'] . "%";
				$this->diet_info_completion = $row ['user_diet_info_status'] . "%";
				$this->lifestyle_info_completion = $row ['user_lifestyle_info_status'] . "%";
				$this->self_estimation_completion = $row ['user_self_estimation_status'] . "%";
				$this->physician_estimation_completion = $row ['user_physician_estimation_status'] . "%";
				
				// fetch data
				$sql02 = "SELECT * FROM `user_physician_estimation` LEFT JOIN `subform_physician_symptom` ON (user_physician_estimation.user_ID=subform_physician_symptom.user_ID) LEFT JOIN `subform_physician_cmsymptom` ON (subform_physician_symptom.user_ID=subform_physician_cmsymptom.user_ID) LEFT JOIN `subform_physician_medicine` ON (subform_physician_cmsymptom.user_ID=subform_physician_medicine.user_ID) LEFT JOIN `subform_physician_hamd17` ON (subform_physician_medicine.user_ID=subform_physician_hamd17.user_ID) LEFT JOIN `subform_physician_menopauseassessment` ON (subform_physician_hamd17.user_ID=subform_physician_menopauseassessment.user_ID) WHERE user_physician_estimation.user_ID='" . $this->report_user_ID . "'";
				
				$result = $db->query ( $sql02 );
				$row = $result->fetch ( PDO::FETCH_ASSOC );
				
				// print data
				$reportInfo = '';
				$name = $GLOBALS ['database_column_translation'];
				$content = $row;
				
				$array = translateDatabaseColumnName ( $name, $content );
				
				foreach ( $array as $key => $value ) {
					$reportInfo .= "<tr>" . 

					"<td>" . $key . "</td>" . "<td>" . $value . "</td>" . 

					"</tr>";
				}
				
				$this->reportInfo = $reportInfo;
			}
		} else {
			$this->loginStatus = 0;
		}
	}
}
?>  