<?
class ControlController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			View::render('control/list',array('list'=>Control::getList()));
		}elseif(is_numeric(Funcs::$uri[2])){
			View::render('control/list',array('list'=>Control::getList(Funcs::$uri[2])));
		}
	}
	public function add(){
		$lang=Control::getLangList();
		$groups=Control::getGroups();
		View::render('control/add',array('formpath'=>'actadd','lang'=>$lang,'groups'=>$groups));
	}
	public function addgroup(){
		$model=new Control;
		View::render('control/addgroup',array('formpath'=>'actaddgroup'));
	}
	public function actadd(){
		$model=new Control;
		$model->addSite();
		$this->redirect('/control/');
	}
	public function actaddgroup(){
		$model=new Control;
		$model->addGroup();
		$this->redirect('/control/');
	}
	public function edit(){
		$site=Control::getSite($_GET['id']);
		$lang=Control::getLangList();
		$groups=Control::getGroups();
		View::render('control/add',array('formpath'=>'actedit','site'=>$site,'lang'=>$lang,'groups'=>$groups));
	}
	public function editgroup(){
		$model=new Control;
		$group=$model->getGroup($_GET['id']);
		View::render('control/addgroup',array('formpath'=>'acteditgroup','group'=>$group));
	}
	public function actedit(){
		$model=new Control;
		$model->editSite();
		$this->redirect('/control/');
	}
	public function acteditgroup(){
		$model=new Control;
		$model->editGroup();
		$this->redirect('/control/');
	}
	public function actdel(){
		$model=new Control;
		$model->delSite();
		$this->redirect('/control/');
	}
	public function actdelgroup(){
		Control::delGroup();
		$this->redirect('/control/');
	}
	public function lang(){
		$model=new Control;
		$lang=$model->getLangList();
		View::render('control/langlist',array('formpath'=>'actadd','list'=>$lang));
	}
	public function addlang(){
		View::render('control/addlang',array('formpath'=>'actaddlang'));
	}
	public function actaddlang(){
		$model=new Control;
		$model->addLang();
		$this->redirect('/control/lang/');
	}
	public function editlang(){
		$model=new Control;
		$lang=$model->getLang($_GET['id']);
		View::render('control/addlang',array('formpath'=>'acteditlang','lang'=>$lang));
	}
	public function acteditlang(){
		$model=new Control;
		$model->editLang();
		$this->redirect('/control/lang/');
	}
	public function actdellang(){
		$model=new Control;
		$model->delLang();
		$this->redirect('/control/lang/');
	}
}
?>