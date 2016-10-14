<?php

/*
 * This class is to get data from database*
 */
class Report_Model {
	public $user_tel = '';
	public $reportInfo = '';
	public function __construct() {
		$this->user_tel = pageGuard ();
		$this->user_type = $_SESSION['user_type'];
		if ($this->user_type < 1) {
		destroySession();
		}else {}
	}
	public function reportData($type, $report_user_ID) {
		$sql = '';
		switch ($type) {
			case 'default' :
				redirect ( "index.php?manage&type=sample_management", "You are going back to Sample Management Page!" );
				break;
			case 'report_basic' :
				$sql = "SELECT * FROM `user_basic_info` WHERE `user_ID`='" . $report_user_ID . "'";
				break;
			
			case 'report_health' :
				// include 'html_pages/msg.html';break;
				$sql = "SELECT * FROM `user_health_info` WHERE `user_ID`='" . $report_user_ID . "'";
				break;
			
			case 'report_diet' :
				// include 'html_pages/msg.html';break;
				$sql = "SELECT * FROM `user_diet_info` WHERE `user_ID`='" . $report_user_ID . "'";
				break;
			
			case 'report_lifestyle' :
				// include 'html_pages/msg.html';break;
				$sql = "SELECT * FROM `user_lifestyle_info` WHERE `user_ID`='" . $report_user_ID . "'";
				break;
			
			case 'report_self_estimation' :
				$sql = "SELECT * FROM `user_self_estimation` LEFT JOIN `subform_selfe_depression` ON (user_self_estimation.user_ID=subform_selfe_depression.user_ID) LEFT JOIN `subform_selfe_anxiety` ON (subform_selfe_depression.user_ID=subform_selfe_anxiety.user_ID) LEFT JOIN `subform_selfe_lifequality` ON (subform_selfe_anxiety.user_ID=subform_selfe_lifequality.user_ID) LEFT JOIN `subform_selfe_feces` ON (subform_selfe_lifequality.user_ID=subform_selfe_feces.user_ID) LEFT JOIN `subform_selfe_ibslevel` ON (subform_selfe_feces.user_ID=subform_selfe_ibslevel.user_ID)  WHERE user_self_estimation.user_ID='" . $report_user_ID . "'";
				break;
			case 'report_physician_estimation' :
				
				$sql = "SELECT * FROM `user_physician_estimation` LEFT JOIN `subform_physician_symptom` ON (user_physician_estimation.user_ID=subform_physician_symptom.user_ID) LEFT JOIN `subform_physician_cmsymptom` ON (subform_physician_symptom.user_ID=subform_physician_cmsymptom.user_ID) LEFT JOIN `subform_physician_medicine` ON (subform_physician_cmsymptom.user_ID=subform_physician_medicine.user_ID) LEFT JOIN `subform_physician_hamd17` ON (subform_physician_medicine.user_ID=subform_physician_hamd17.user_ID) LEFT JOIN `subform_physician_menopauseassessment` ON (subform_physician_hamd17.user_ID=subform_physician_menopauseassessment.user_ID) WHERE user_physician_estimation.user_ID='" . $report_user_ID . "'";
				break;
			
			default :
				destroySession ();
		}
		
		$db = new myDB ();
		$result = $db->query ( $sql );
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
}

?>  