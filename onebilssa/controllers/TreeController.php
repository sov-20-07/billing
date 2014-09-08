<?
class TreeController extends Site{
	function __construct(){
		$this->checkRights();
	}
	public function add(){
		$model=new Tree;
		if(count(Index::getModuleList())==0){
			Module::createPageContent();
		}
		$model->addTree();
		$this->redirect('/');
	}
	public function edit(){
		$model=new Tree;
		$model->editTree();
		$this->redirect('/');
	}
	public function getSort(){
		$model=new Tree;
		$tree=$model->getSort();
		View::$layout='empty';
		View::render('tree/sort',array('tree'=>$tree));
	}
	public function getsearch(){
		if(trim($_POST['q'])){
			$model=new Tree;
			$tree=$model->getSearch();
			View::$layout='empty';
			View::render('tree/search',array('tree'=>$tree));
		}
	}
}
?>