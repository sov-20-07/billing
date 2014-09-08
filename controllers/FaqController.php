<?
class FaqController extends Site{
	function __construct(){
		if(!in_array(Funcs::$uri[1],get_class_methods(__CLASS__))){
			$tree=Tree::getTreeByUrl('wide');
			Funcs::setMeta($tree);
			$tree['list']=Faq::getList($tree['id']);
			if($_POST){
				$error=Faq::ask($tree['id']);
				if($error){
					View::render('faq/list',$tree);
				}else{
					$this->redirect('/help/faq/');
				}
			}else{
				View::render('faq/list',$tree);
			}
		}
	}
	function ask(){
		if($_POST){
			$tree=Tree::getIdTreeByModule('faq');
			$model=new Faq;
			if($model->ask($tree)===true){
				$this->redirect('/faq/thanks/');
				View::render('faq/ask',$tree);
			}
		}else{
			$tree=Tree::getTreeByUrl('wide');
			Funcs::setMeta($tree);
			$tree['rubrics']=Faq::getRubricsTree($tree['parent']);
			View::render('faq/ask',$tree);
		}
	}
	function thanks() {
		$tree=Tree::getTreeByUrl('wide');
		Funcs::setMeta($tree);
		View::render('faq/thanks',$tree);
	}
}
?>