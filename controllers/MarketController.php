<?
class MarketController extends Site{
	function __construct(){
		$model=new Market;
		//header("Content-type:text/xml");
		View::$layout='empty';
		View::render('market/list',$model->getList());
	}
}
?>