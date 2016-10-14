<?php
/*
 * 这个文件处理文章的查询，并产生新闻文章*
 */
class Analyze_Controller {
	/**
	 * $template变量会保存与此控制器相关的"view(视图)"的文件名，不包括.php后缀
	 */

	public $pageBodyType = '';
	public function __construct() {
	}
	public function main(array $getVars) {
		if (empty ( $getVars )) {
			$this->pageBodyType = '';
		} else {
			$this->pageBodyType = $getVars ['type'];
		}
		
		switch ($this->pageBodyType) {
			
			case 'visulization' :
				redirect ( "dataworkbench/index.php", "You are logining the visulization workbench !" );
				break;
			default :
				destroySession ();
				break;
		}
	}
}
?>  