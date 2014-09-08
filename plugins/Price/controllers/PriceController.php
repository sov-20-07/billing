<?
require_once $_SERVER['DOCUMENT_ROOT'].'/'.ONESSA_DIR.'/lib/Excel/PHPExcel.php';
class PriceController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			View::plugin('index');
		}
		
	}
	function import(){
		DB::escapePost();
		Price::import();
		$this->redirect('/price/');
	}
	function recalculate(){
		DB::escapePost();
		Price::recalculatePrice();
		$this->redirect('/price/');
	}
}
?>