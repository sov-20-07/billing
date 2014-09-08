<?
class ConfirmController extends Site{
	function __construct(){
		if(News::tryDelSubscribers()){
			News::delSubscribers();
			View::$layout='empty';
			View::render('site/redirect',array('text'=>'Вы успешно отписаны от рассылки','href'=>'/'));
		}
	}
}
?>