<?php

/*
 * This class is to get data for management data from database*
 */
class Manage_Model {
	public $user_tel = '';
	public $user_type = '';
	public $sampleInfo = '';
	public function __construct() {
		$this->user_tel = pageGuard ();
		$this->user_type = $_SESSION['user_type'];
		if ($this->user_type < 1) {
		destroySession();
		}else {}
		
	}
	public function fectchData01($type) {
		$sql = '';
		switch ($type) {
			case 'search_managmentInfo' :
				$sql = searchSql01 ( $type );
				break;
			case 'sample_management' :
				$sql = "SELECT * FROM `user_basic_info` LEFT JOIN `user_profile_for_research` ON (user_basic_info.user_ID=user_profile_for_research.user_ID) LEFT JOIN `user_key_info` ON (user_profile_for_research.user_ID=user_key_info.user_ID) WHERE user_key_info.user_type = 0 ORDER BY user_key_info.user_ID DESC";
				break;
			default :
				destroySession ();
				break;
		}
		
		$db = new myDB ();
		$result = $db->query ( $sql );
		while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
			$this->sampleInfo .= "<tr>" . 

			"<td>" . $row ['basic_name'] . "</td>" . "<td>" . $row ['basic_gender'] . "</td>" . "<td>" . $row ['basic_age'] . "</td>" . "<td>" . $row ['user_blood_status'] . "%</td>" . "<td>" . $row ['user_urine_status'] . "%</td>" . "<td>" . $row ['user_feces_status'] . "%</td>" . "<td>
            <li>" . $row ['user_to_physician'] . "</li>
            <li>
            <a href='index.php?survey&type=physician_estimation&estimation_target_ID=" . $row ['user_ID'] . "'>写/修诊断</a>
			
            </li>
            </td>" . "<td><a href='index.php?report&type=report_physician_estimation&report_user_ID=" . $row ['user_ID'] . "'>" . $row ['user_physician_estimation_status'] . "%</a></td>" . "<td><a href='index.php?report&type=report_self_estimation&report_user_ID=" . $row ['user_ID'] . "'>" . $row ['user_self_estimation_status'] . "%</a></td>" . "<td><a href='index.php?report&type=report_basic&report_user_ID=" . $row ['user_ID'] . "'>" . $row ['user_basic_info_status'] . "%</a></td>" . "<td><a href='index.php?report&type=report_health&report_user_ID=" . $row ['user_ID'] . "'>" . $row ['user_health_info_status'] . "%</a></td>" . "<td><a href='index.php?report&type=report_diet&report_user_ID=" . $row ['user_ID'] . "'>" . $row ['user_diet_info_status'] . "%</a></td>" . "<td><a href='index.php?report&type=report_lifestyle&report_user_ID=" . $row ['user_ID'] . "'>" . $row ['user_lifestyle_info_status'] . "%</a></td>" . "<td>" . $row ['user_tel'] . "</td>" . "<td>" . $row ['user_ID'] . "</td>" . "</tr>";
		}
	}
	public function fectchData02($type) {
		$sql = '';
		switch ($type) {
			case 'search_sampleProfile' :
				$sql = searchSql02 ( $type );
				break;
			case 'sample_profile' :
				$sql = "SELECT * FROM `user_basic_info` LEFT JOIN `user_health_info` ON (user_basic_info.user_ID=user_health_info.user_ID) LEFT JOIN `user_physician_estimation` ON (user_health_info.user_ID=user_physician_estimation.user_ID)  LEFT JOIN `user_key_info` ON (user_physician_estimation.user_ID=user_key_info.user_ID) WHERE user_key_info.user_type = 0 ORDER BY user_key_info.user_ID DESC";
				break;
			default :
				destroySession ();
				break;
		}
		
		$db = new myDB ();
		$result = $db->query ( $sql );
		while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
			$this->sampleInfo .= "<tr>" . 

			"<td>" . $row ['basic_name'] . "</td>" . "<td>" . $row ['basic_gender'] . "</td>" . "<td>" . $row ['basic_age'] . "</td>" . "<td>" . $row ['health_period_condition'] . "</td>" . "<td>" . $row ['health_gastrointestinal_surgery_YorN'] . "</td>" . "<td>" . $row ['health_gastrointestinal_disease_YorN'] . "</td>" . "<td>" . $row ['health_other_disease_YorN'] . "</td>" . "<td>" . $row ['health_mental_disease_YorN'] . "</td>" . "<td>" . $row ['health_infection_YorN'] . "</td>" . "<td>" . $row ['health_drug_allergy_YorN'] . "</td>" . "<td>" . $row ['health_food_allergy_YorN'] . "</td>" . "<td>" . $row ['user_symptom_stage'] . "</td>" . "<td>" . $row ['user_IBStype_byROME'] . "</td>" . "<td>" . $row ['user_ID'] . "</td>" . "</tr>";
		}
	}
}
?>  