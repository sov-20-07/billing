<?
class FeedbackController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$list=Feedback::getList();
			View::plugin('index',array('list'=>$list));
		}elseif(Funcs::$uri[2]=='history'){
			$list=Feedback::getList('history');
			View::plugin('index',array('list'=>$list));
		}
	}
	function done(){
		DB::escapePost();
		if($_POST){
			Feedback::done();
			$this->redirect('/feedback/');
		}
	}
}
?>