<?php
// ////////////////////////////////////////////////////////////
// ���ݿ����ó���� //
// Author��Jie LIU //
// Data��Jul 2016 //
// All Rights Reserved By Jie LIU //
// ////////////////////////////////////////////////////////////

// ###############################################
// ### �������ݿ������� ####
// ###############################################
function connectMysql() {
	$servername = "localhost";
	$database = "ibsproject";
	$username = "root";
	$password = "123456";
	
	try {
		$db = new PDO ( "mysql:host=$servername;dbname=$database", $username, $password );
		// echo "successful connection";
	} catch ( PDOException $e ) {
		echo $e->getMessage ();
	}
	
	$db->query ( 'set names utf8' );
	return $db;
}

$servername = "localhost";
$database = "ibsproject";
$username = "root";
$password = "123456";

try {
	$db = new PDO ( "mysql:host=$servername;dbname=$database", $username, $password );
	// echo "successful connection";
} catch ( PDOException $e ) {
	echo $e->getMessage ();
}

$db->query ( 'set names utf8' );
class myDB extends PDO {
	public $servername = "localhost";
	public $database = "ibsproject";
	public $username = "root";
	public $password = "123456";
	public function __construct() {
		try {
			parent::__construct ( "mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password );
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
		$this->query ( 'set names utf8' );
	}
}

?>

