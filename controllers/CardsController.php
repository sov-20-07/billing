<?
class CardsController extends Site{
	function __construct(){
		if(!in_array(Funcs::$uri[2],$this->getFuncs(__CLASS__))){
			$tree=Tree::getTreeByUrl('wide');
			Funcs::setMeta($tree);
			$tree['list']=Faq::getList($tree['id']);
			View::render('cards/index',$tree);
		}elseif(!$_SESSION['iuser']){
			View::render('site/redirect',array('text'=>'Доступ запрещен','href'=>'/services/cards/'));
		}
	}
	function choose(){
		$tree['seo_title']='Выберите действие';
		Funcs::setMeta($tree);
		View::render('cards/choose',$tree);
	}
	function buy(){
		if($_POST){
			Cards::ToSessionCard();
			$this->redirect('/services/cards/basket/');
		}else{
			$tree['seo_title']='Покупка подарочной карты';
			Funcs::setMeta($tree);
			View::render('cards/buy',$tree);
		}
	}
	function basket(){
		if($_POST){
			$id=Cards::SaveCard();
			//$this->redirect('/services/cards/basket/');
		}else{
			$tree['seo_title']='Корзина';
			Funcs::setMeta($tree);
			View::render('cards/basket',$tree);
		}
	}
	function success() {
		Cards::Success();
		$tree['seo_title']='Покупка подарочной карты';
		Funcs::setMeta($tree);
		View::render('cards/fail',$tree);
	}
	function fail() {
		$tree['seo_title']='Покупка подарочной карты';
		Funcs::setMeta($tree);
		View::render('cards/fail',$tree);
	}
}
?>