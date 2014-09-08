<?
class WorkController extends Site{
	function __construct(){
		$this->checkRights();
		if(is_numeric(Funcs::$uri[2])){
			unset($_SESSION['HTTP_REFERER']);
			/*$model=new Work;
			$obj=$model->getObject();
			if($obj['path']=='edit'){
				if($obj['parent']){
					$this->redirect('/work/showedit/?module='.$obj['module'].'&tree='.Funcs::$uri[2].'&parent='.$obj['parent']);
				}else{
					$this->redirect('/work/showedit/?module='.$obj['module'].'&tree='.Funcs::$uri[2].'');
				}
			}else{
				$model=new Lists;
				$data=$model->getList();
				View::render('/work/modellist',$data);
			}*/
			$model=new Work;
			$data=$model->getTree();
			//print '<pre>';print_r($data);die;
			View::render('work/catlist',$data);
		}
	}
	function getmoduleitems(){
		View::$layout='empty';
		View::render('work/moduleitems',array('modules'=>array()));
	}
	function addfield(){
		View::$layout='empty';
		View::render('work/addfield',array('modules'=>array()));
	}
	function bind(){
		$model=new Work;
		$model->bind();
		$this->redirect('/'.$_GET['parent'].'/');
	}
	function bindraz(){
		$model=new Work;
		$model->bindraz();
		$this->redirect('/'.$_GET['parent'].'/');
	}
	function showadd(){
		$module=Module::getOne($_GET['module']);
		$model=new Work;
		$fields=$model->getFields();
		$row=$model->getStandartFields();
		View::render('work/add',array('fields'=>$fields,'row'=>$row,'path'=>'add','module'=>$module));
	}
	function showedit(){
		$modul=Module::getModuleByTree($_GET['id']);
		if($modul['type']=='cat'){
			$fields=Catalog::getEditFields($_GET['id'],$modul['id']);
			$row=Work::getStandartFields($_GET['id']);
			$features=Fields::getModelFeatures($row['parent']);
		}else{
			$model=new Work;
			$fields=$model->getEditFields($_GET['id'],$modul['id']);
			$row=$model->getStandartFields($_GET['id']);
			$features=Fields::getFeatures($_GET['id']);
		}
		View::render('work/add',array('features'=>$features,'fields'=>$fields,'row'=>$row,'path'=>'edit','user'=>User::getUser($row['cuser']),'module'=>$modul));
	}
	function add(){
		DB::escapePost('data');
		$modul=Module::getModuleById($_POST['module']);
		if($modul['type']=='cat'){
			$model=new Catalog;
			$tree=$model->add();
		}else{
			$model=new Work;
			$tree=$model->add();
		}
		$this->redirect('/work/showedit/?id='.$tree);
	}
	function edit(){
		DB::escapePost('data');
		$modul=Module::getModuleById($_POST['module']);
		if($modul['type']=='cat'){
			$model=new Catalog;
			$model->edit();
		}else{
			$model=new Work;
			$model->edit();
		}
		if($modul['type']=='struct'){
			Fields::setFeatures();
		}
		//if($_POST['submitbutton']=='Применить'){
			$_SESSION['HTTP_REFERER']=$_POST['redirect'];
			$this->redirect($_SERVER['HTTP_REFERER']);
		/*}else{
			$_SESSION['HTTP_REFERER']='';
			if($_POST['redirect'] && strpos($_POST['redirect'],'tree=new')===false){
				$this->redirect($_POST['redirect']);
			}elseif($_POST['parent']){
				$this->redirect('/work/'.$_POST['parent'].'/');
			}else{
				$this->redirect('/');
			}
		}*/
	}
	function del(){
		$model=new Work;
		$model->del();
		if($_POST['redirect']){
			$this->redirect($_POST['redirect']);
		}elseif($_SERVER['HTTP_REFERER']){
			$this->redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->redirect('/work/'.$_GET['parent'].'/');
		}
	}
	function copy(){
		$model=new Work;
		$parent=$model->copy($_GET['id']);
		$this->redirect('/work/'.$parent.'/');
	}
}
?>