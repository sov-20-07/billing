<?
class OnlineController extends Site{
	function __construct(){
		$tree=Tree::getTreeByUrl('wide');
		Funcs::setMeta($tree);
		if($_POST){
			if(Online::send($tree['id'])){
				$this->redirect('/online/thanks/');
			}
		}
		if(Funcs::$uri[1]==''){
			View::render('online/form',$tree);
		}else{
			View::render('site/page',$tree);
		}
	}
}
?>