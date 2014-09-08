<?
class TranslatorController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$data=array();
			View::plugin('list',array('list'=>Translator::getList()));
		}
		
	}
	function add(){
		if($_POST){
			DB::escapePost();
			Translator::add();
			$this->redirect('/translator/');
		}else{
			View::plugin('add');
		}
	}
	function edit(){
		if($_POST){
			DB::escapePost();
			Translator::edit();
			$this->redirect('/translator/');
		}else{
			View::plugin('add',array('list'=>Translator::getOne(Funcs::$uri[3])));
		}
	}
	function del(){
		DB::escapePost();
		Translator::del();
		$this->redirect('/translator/');
	}
}
?>