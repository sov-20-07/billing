<?
class CronController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$model=new Cron;
			View::render('cron/list',array('list'=>$model->getList()));
		}
	}
	function showadd(){
		$parent=$_GET['parent'];
		if($parent=='')$parent=0;
		View::render('cron/add',array('formpath'=>'add','timing'=>array('*','*','*','*','*','*',)));
	}
	function showedit(){
		$model=new Cron;
		$data=$model->getEdit();
		$data['formpath']='edit';
		View::render('cron/add',$data);
	}
	function add(){
		$model=new Cron;
		$model->add();
		$this->redirect('/cron/');
	}
	function edit(){
		$model=new Cron;
		$model->edit();
		$this->redirect('/cron/');
	}
	function del(){
		$model=new Cron;
		$model->del();
		$this->redirect('/cron/');
	}
}
?>