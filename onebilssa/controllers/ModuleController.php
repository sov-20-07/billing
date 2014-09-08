<?
class ModuleController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$model=new Module;
			$list=$model->getList();
			View::render('module/index',array('list'=>$list));
		}
	}
	function showadd(){
		View::render('module/add',array('title'=>'Добавление модуля','path'=>'add','modules'=>Module::getList()));
	}
	function showedit(){
		View::render('module/add',array('title'=>'Редактирование модуля','path'=>'edit','item'=>Module::getOne($_GET['id']),'modules'=>Module::getList()));
	}
	function add(){
		$model=new Module;
		$model->add();
		$this->redirect('/module/');
	}
	function edit(){
		$model=new Module;
		$model->edit();
		$this->redirect('/module/');
	}
	function del(){
		$model=new Module;
		$model->del();
		$this->redirect('/module/');
	}
	function fieldlist(){
		View::render('module/fieldlist',array('list'=>Module::getFieldList(), 'module'=>Module::getOne($_GET['module'])));
	}
	function showfieldadd(){
		$field=array('outerf'=>'0','innerf'=>1,'required'=>0);
		View::render('module/fieldadd',array('title'=>'Добавление поля','path'=>'fieldadd','field'=>$field));
	}
	function showfieldedit(){
		$field=array('outerf'=>'0','innerf'=>1,'required'=>0);
		View::render('module/fieldadd',array('title'=>'Добавление поля','path'=>'fieldedit','field'=>Module::getFieldOne()));
	}
	function fieldadd(){
		$model=new Module;
		$model->fieldAdd();
		$this->redirect('/module/fieldlist/?module='.$_POST['module']);
	}
	function fieldedit(){
		$model=new Module;
		$model->fieldEdit();
		$this->redirect('/module/fieldlist/?module='.$_POST['module']);
	}
	function fielddel(){
		$model=new Module;
		$model->fieldDel();
		$this->redirect('/module/fieldlist/?module='.$_GET['module']);
	}
}
?>