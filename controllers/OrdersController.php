<?
class OrdersController extends Site{
	function __construct(){

	}
	public function thanks(){
			$tree=Tree::getTreeByUrl('wide');
			Funcs::setMeta($tree);
			View::render('site/page',$tree);
	}
	public function yandex(){
		Funcs::escapeGet();
		Orders::setYandex(Funcs::$uri[2]);
		$this->redirect(Funcs::$conf['additional']['yaopinions']);
	}
}
?>