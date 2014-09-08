<?
class ForumController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$model=new Forum;
			View::render('forum/list',array('list'=>$model->getList(),'top'=>$model->getTop()));
		}elseif(is_numeric(Funcs::$uri[2])){
			$model=new Forum;
			View::render('forum/list',array('list'=>$model->getElemList(),'top'=>$model->getTop()));
		}
	}
	function showadd(){
		$parent=$_GET['parent'];
		if($parent=='')$parent=0;
		View::render('forum/add',array('formpath'=>'add','parent'=>$parent));
	}
	function showedit(){
		$model=new Forum;
		$data=$model->getEdit();
		$data['formpath']='edit';
		View::render('forum/add',$data);
	}
	function add(){
		$model=new Forum;
		$model->add();
		if($_POST['parent']!=0){
			$this->redirect('/forum/'.$_POST['parent'].'/');
		}else{
			$this->redirect('/forum/');
		}
	}
	function edit(){
		$model=new Forum;
		$model->edit();
		if($_POST['parent']!=0){
			$this->redirect('/forum/'.$_POST['parent'].'/');
		}else{
			$this->redirect('/forum/');
		}
	}
	function del(){
		$model=new Forum;
		$model->del();
		if($_GET['parent']!=0){
			$this->redirect('/forum/'.$_GET['parent'].'/');
		}else{
			$this->redirect('/forum/');
		}
	}
}
?>