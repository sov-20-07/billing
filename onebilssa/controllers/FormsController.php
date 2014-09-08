<?
class FormsController extends Site{
	
	function __construct(){
		$this->checkRights();
		$model=new Forms;
		if(Funcs::$uri[2]==''){
			View::render('forms/index',array('list'=>$model->getFormsList()));
		}elseif(is_numeric(Funcs::$uri[2])){
			View::render('forms/listfields',array('form'=>$model->getForm(Funcs::$uri[2]),'list'=>$model->getFieldsList(Funcs::$uri[2])));
		}
	}
	function addform(){
		View::render('forms/addform',array('formpath'=>'actaddform'));
	}
	function actaddform(){
		$model=new Forms;
		$model->addForm();
		$this->redirect('/forms/');
	}
	function edit(){
		$model=new Forms;
		$form=$model->getForm($_GET['id']);
		View::render('forms/addform',array('formpath'=>'acteditform','form'=>$form));
	}
	function acteditform(){
		$model=new Forms;
		$model->editForm();
		$this->redirect('/forms/');
	}
	function actdel(){
		$model=new Forms;
		$model->delForm();
		$this->redirect('/forms/');
	}
	
	function addfield(){
		View::render('forms/addfield',array('formpath'=>'actaddfield','form'=>$_GET['form']));
	}
	function actaddfield(){
		$model=new Forms;
		$model->addField();
		$this->redirect('/forms/'.$_POST['form'].'/');
	}
	function editfield(){
		$model=new Forms;
		$field=$model->getField($_GET['id']);
		View::render('forms/addfield',array('formpath'=>'acteditfield','field'=>$field,'form'=>$field['forms']));
	}
	function acteditfield(){
		$model=new Forms;
		$model->editField();
		$this->redirect('/forms/'.$_POST['form'].'/');
	}
	function actdelfield(){
		$model=new Forms;
		$field=$model->getField($_GET['id']);
		$model->delField();
		$this->redirect('/forms/'.$field['forms'].'/');
	}
}
?>