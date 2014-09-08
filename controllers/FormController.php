<?
class FormController extends Site{
	function __construct(){
		DB::escapePost();
		DB::escapeGet();
		$model=new Form;
		$model->send();
		if($_POST['redirect'])$_POST['redirect']=$_POST['redirect'].'/';
		$this->redirect($_SERVER['HTTP_REFERER'].$_POST['redirect']);
	}
}
?>