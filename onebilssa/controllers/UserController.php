<?
class UserController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$model=new User;
			View::render('user/index',array('list'=>$model->getUserList('ldate DESC')));
		}
	}
	function group(){
		$model=new User;
		View::render('user/listgroup',array('list'=>$model->getGroupList()));
	}
	function addgroup(){
		$model=new User;
		$tree=$model->getTree();
		View::render('user/addgroup',array('formpath'=>'actaddgroup','tree'=>$tree,'modules'=>OneSSA::$modulesStandart,'group'=>array('access'=>array('tree'=>array(),'modules'=>array()))));
	}
	function actaddgroup(){
		$model=new User;
		$model->addGroup();
		$this->redirect('/user/group/');
	}
	function editgroup(){
		$model=new User;
		$tree=$model->getTree();
		$group=$model->getEditGroup();
		View::render('user/addgroup',array('formpath'=>'acteditgroup','tree'=>$tree,'modules'=>OneSSA::$modulesStandart,'group'=>$group));
	}
	function acteditgroup(){
		$model=new User;
		$model->editGroup();
		$this->redirect('/user/group/');
	}
	function actdelgroup(){
		$model=new User;
		$model->delGroup();
		$this->redirect('/user/group/');
	}
	
	function user(){
		$model=new User;
		View::render('user/listuser',array('list'=>$model->getUserList()));
	}
	function adduser(){
		$model=new User;
		$tree=$model->getTree();
		$groups=$model->getGroupList();
		View::render('user/adduser',array('formpath'=>'actadduser','tree'=>$tree,'modules'=>OneSSA::$modulesStandart,'groups'=>$groups,'user'=>array('groups'=>array(),'access'=>array('modules'=>array(),'tree'=>array()))));
	}
	function actadduser(){
		$model=new User;
		$model->addUser();
		$this->redirect('/user/user/');
	}
	function edituser(){
		$model=new User;
		$tree=$model->getTree();
		$groups=$model->getGroupList();
		$user=$model->getEditUser();
		View::render('user/adduser',array('formpath'=>'actedituser','tree'=>$tree,'modules'=>OneSSA::$modulesStandart,'groups'=>$groups,'user'=>$user));
	}
	function actedituser(){
		$model=new User;
		$model->editUser();
		$this->redirect('/user/user/');
	}
	function actdeluser(){
		$model=new User;
		$model->delUser();
		$this->redirect('/user/user/');
	}
}
?>