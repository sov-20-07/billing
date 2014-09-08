<?
class FeedbackController extends Site{
	function __construct(){
		if(!in_array(Funcs::$uri[1],get_class_methods(__CLASS__))){
			$tree=Tree::getTreeByUrl('wide');
			Funcs::setMeta($tree);
			View::render('site/page',$tree);
		}
	}
	public function message(){
		if($_POST){
			$error=Feedback::sendMessage();
			if($error){
				View::render('faq/list',$tree);
			}else{
				$this->redirect('/feedback/message/?done');
			}
		}else{
			$tree=Tree::getTreeByUrl('wide');
			Funcs::setMeta($tree);
			View::render('feedback/message',$tree);
		}
	}
}
?>