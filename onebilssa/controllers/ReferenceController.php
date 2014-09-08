<?
class ReferenceController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]=='' || is_numeric(Funcs::$uri[2])){			
			$model=new Reference;
			View::render('reference/list',$model->getList());
		}
	}
	function showadd(){
		$parent=$_GET['parent'];
		if($parent=='')$parent=0;
		View::render('reference/add',array('formpath'=>'add','parent'=>$parent,'tree'=>Reference::getTree()));
	}
	function showedit(){
		$model=new Reference;
		$data=$model->getEdit();
		$data['formpath']='edit';
		$data['tree']=Reference::getTree();
		View::render('reference/add',$data);
	}
	function add(){
		$model=new Reference;
		$model->add();
		if($_POST['parent']!=0){
			$this->redirect('/reference/'.$_POST['parent'].'/');
		}else{
			$this->redirect('/reference/');
		}
	}
	function edit(){
		$model=new Reference;
		$model->edit();
		if($_POST['parent']!=0){
			$this->redirect('/reference/'.$_POST['parent'].'/');
		}else{
			$this->redirect('/reference/');
		}
	}
	function del(){
		$model=new Reference;
		$model->del();
		if($_GET['parent']!=0){
			$this->redirect('/reference/'.$_GET['parent'].'/');
		}else{
			$this->redirect('/reference/');
		}
	}
}
?>