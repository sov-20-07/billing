<?
class ImpexpController extends Site{
	function __construct(){
		$this->checkRights();
	}
	function export(){
		Impexp::export();
	}
	function import(){
		Impexp::import();
		$this->redirect('/work/'.Funcs::$uri[3].'/');
	}
}
?>