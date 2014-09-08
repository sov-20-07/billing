<?
class PrepareController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			View::plugin('index');
		}
	}
	function run(){
		DB::escapePost();
		Prepare::run();
		$this->redirect('/prepare/');
	}
}
?>