<?php

/* 
 * 
 * This class is to operate the needs from user (login, register, unlogin)*
 * 
 * */
class User_Model {
	public $user_tel = '';
	
	public function __construct() {
		
	}
	public function login() {
		if(isset($_POST['action']) && $_POST['action']=="login")
		{
			$user_tel	=safe($_POST['user_tel']);
			$user_password	=safe($_POST['user_password']);
		
			$db = new myDB();
			$sql="select * from `user_key_info` where user_tel='".$user_tel."'";
			$result = $db->query($sql);
			$num = $result->rowCount();
			if ($num) {
				$row = $result->fetch(PDO::FETCH_ASSOC);
					
				if($row['user_password'] == $user_password)
				{
						
					$_SESSION['user_tel']	=$user_tel;
					$_SESSION['user_ID']	=$row['user_ID'];
					$_SESSION['user_type']	=$row['user_type'];
						
					if ($_SESSION['user_type'] == 0) {
						redirect("index.php","login successfully");
						exit();
							
					}
					if ($_SESSION['user_type'] > 0) {
						redirect("index.php?manage&type=sample_management","login successfully");
						exit();
		
					}
		
				}
				else 
					redirect("index.php?user&type=login","You entered a wrong password");
					exit();
						
		
			} else {
				redirect("index.php?user&type=register","Plz register");
				exit();
			}
		}
		else {
			redirect("index.php?user&type=login","You entered a wrong password");
					exit();}
	}
	
	public function register() {
		//accept the info from the register page
		$user_tel = $_POST['user_phone'];
		$user_password = $_POST['user_pass'];
		$user_type = $_POST['user_type'];
		
		
		// check if there has been a same user
		$db = new myDB();
		$sql = "SELECT `user_tel` FROM `user_key_info` WHERE user_tel = ".$user_tel;
		$result = $db->query($sql);
		$num = $result->rowCount();
		if ($num) {
			redirect("index.php?user&type=register","It is a existing user telephone number");
			exit();
		} else {
			//insert user info into database
		
			$sql = "INSERT INTO `user_key_info` (`user_tel`, `user_password`, `user_type`) VALUES (".$user_tel.", ".$user_password.", ".$user_type.")";
		
			$db->query($sql);
			//check the insection
			$sql = "SELECT * FROM `user_key_info` WHERE user_tel = ".$user_tel;
				
			$result = $db->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
		
			if($row['user_tel'] == $user_tel) {
		
				$_SESSION['user_tel']	= $row['user_tel'];
				$_SESSION['user_ID']	= $row['user_ID'];
				$_SESSION['user_type']	= $row['user_type'];
		
		
					
			} else {
				echo "failed";
			}
		
			//initialize all forms in the database
			$sql01 = "INSERT INTO `user_profile_for_research` (`user_ID`,`sample_code`,`user_physician_estimation_status`,`user_self_estimation_status`,`user_basic_info_status`,`user_health_info_status`,`user_diet_info_status`,`user_lifestyle_info_status`,`user_blood_status`,`user_urine_status`,`user_feces_status`,`user_to_physician`,`user_ibs_type`) VALUES ('".$_SESSION['user_ID']."','".$_SESSION['user_tel']."','0','0','0','0','0','0','0','0','0','Not specified yet','Not specified yet')";
			$sql02 = "INSERT INTO `user_basic_info` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql03 = "INSERT INTO `user_diet_info` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql04 = "INSERT INTO `user_health_info` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql05 = "INSERT INTO `user_lifestyle_info` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql06 = "INSERT INTO `user_physician_estimation` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql07 = "INSERT INTO `user_self_estimation` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
		
			$sql08 = "INSERT INTO `subform_physician_cmsymptom` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql09 = "INSERT INTO `subform_physician_hamd17` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql10 = "INSERT INTO `subform_physician_medicine` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql11 = "INSERT INTO `subform_physician_menopauseassessment` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql12 = "INSERT INTO `subform_physician_symptom` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql13 = "INSERT INTO `subform_selfe_anxiety` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql14 = "INSERT INTO `subform_selfe_depression` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql15 = "INSERT INTO `subform_selfe_feces` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
			$sql16 = "INSERT INTO `subform_selfe_lifequality` (`user_ID`) VALUES ('".$_SESSION['user_ID']."')";
		
		
			//echo $sql;
			$db->query($sql01);
			$db->query($sql02);
			$db->query($sql03);
			$db->query($sql04);
			$db->query($sql05);
			$db->query($sql06);
			$db->query($sql07);
			$db->query($sql08);
			$db->query($sql09);
			$db->query($sql10);
			$db->query($sql11);
			$db->query($sql12);
			$db->query($sql13);
			$db->query($sql14);
			$db->query($sql15);
			$db->query($sql16);
		
			redirect("index.php","You have now got registered successfully");
			exit();
		}
	}
	public function unlogin() {
		destroySession ();
	}
}
?>  