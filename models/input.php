<?php

/*
 * This class is to get data for inserting data into database*
 */
class Input_Model {
	// System initialization
	public $user_ID = '';
	public $estimation_target_ID = '';
	public $db_table01_arr = array ();
	public $db_table02_arr = array ();
	public function __construct() {
		$this->user_ID = $_SESSION ['user_ID'];
		$this->user_tel = pageGuard ();
	}
	public function assign($table01, $table02) {
		$this->db_table01_arr = $table01;
		$this->db_table02_arr = $table02;
	}
	public function inputDada($data, $db_table01_arr, $db_table02_arr, $user_ID) {
		$pageform_completion = 0;
		receiveAndAddDataToMysql ( $data, $db_table01_arr, $db_table02_arr, $user_ID );
		redirect ( "index.php", "You have added data successfully" );
	}
}
?>  