<?
class InfoblockController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$model=new Infoblock;
			View::render('infoblock/list',array('list'=>$model->getList()));
		}elseif(is_numeric(Funcs::$uri[2])){
			View::render('infoblock/listElem',array('list'=>Infoblock::getElemList(),'parent'=>Infoblock::getParent()));
		}
	}
	function showadd(){
		$parent=$_GET['parent'];
		if($parent=='')$parent=0;
		View::render('infoblock/add',array('formpath'=>'add','parent'=>$parent));
	}
	function showedit(){
		$model=new Infoblock;
		$data=$model->getEdit();
		$data['formpath']='edit';
		View::render('infoblock/add',$data);
	}
	function add(){
		$model=new Infoblock;
		$model->add();
		if($_POST['parent']!=0){
			$this->redirect('/infoblock/'.$_POST['parent'].'/');
		}else{
			$this->redirect('/infoblock/');
		}
	}
	function edit(){
		$model=new Infoblock;
		$model->edit();
		if($_POST['parent']!=0){
			$this->redirect('/infoblock/'.$_POST['parent'].'/');
		}else{
			$this->redirect('/infoblock/');
		}
	}
	function del(){
		$model=new Infoblock;
		$model->del();
		if($_GET['parent']!=0){
			$this->redirect('/infoblock/'.$_GET['parent'].'/');
		}else{
			$this->redirect('/infoblock/');
		}
	}
}
?>