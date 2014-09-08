<?
class IuserController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$model=new Iuser;
			$list=$model->getUndefinedUsers();
			View::plugin('index',array('list'=>$list));
		}
		
	}
	function group(){
		$model=new User;
		View::plugin('listgroup',array('list'=>$model->getGroupList()));
	}
	function addgroup(){
		$model=new User;
		$groups=Iuser::getGroupList();
		View::plugin('addgroup',array('formpath'=>'actaddgroup','title'=>'Добавить группу','groups'=>$groups));
	}
	function actaddgroup(){
		Iuser::addGroup();
		$this->redirect('/iuser/addgroup/');
	}
	function popup(){
		$groups=Iuser::getGroupList();
		print View::getPluginEmpty('popup/popup',array('formpath'=>'actadduser','groups'=>$groups));
	}
	function popupedit(){
		$groups=Iuser::getGroupList();
		print View::getPluginEmpty('popup/popupadd',array('formpath'=>'actadduser','title'=>'Новый пользователь','groups'=>$groups));
	}
	function popupselect(){
		$groups=Iuser::getUserList();
		print View::getPluginEmpty('popup/popupselect',array('list'=>Iuser::getUserList(),'igroups'=>Iuser::getGroupList()));
	}
	function editgroup(){
		$group=Iuser::getEditGroup();
		$groups=Iuser::getGroupList();
		View::plugin('addgroup',array('formpath'=>'acteditgroup','title'=>'Добавить группу','groups'=>$groups,'group'=>$group));
	}
	function acteditgroup(){
		Iuser::editGroup();
		$this->redirect('/iuser/addgroup/');
	}
	function actdelgroup(){
		$model=new Iuser;
		$model->delGroup();
		$this->redirect('/iuser/addgroup/');
	}
	
	function user(){
		View::plugin('listuser',array('list'=>Iuser::getUserList(),'igroups'=>Iuser::getGroupList()));
	}
	function adduser(){
		$groups=Iuser::getGroupListAll();
		View::plugin('adduser',array('formpath'=>'actadduser','tree'=>$tree,'fields'=>OneSSA::$iuserStandart,'groups'=>$groups));
	}
	function actadduser(){
		$id=Iuser::addUser();
		if($_POST['act']=='popup'){
			Orders::setOrderUser($_POST['ordrerid'],$id);
			print View::getPluginEmpty('popup/close');
		}else{
			$this->redirect('/iuser/user/');
		}
	}
	function actselectuser(){
		Orders::setOrderUser($_GET['ordrerid'],$_GET['iuserid']);
		print View::getPluginEmpty('popup/close');
	}
	function edituser(){
		$groups=Iuser::getGroupListAll();
		$user=Iuser::getUser();
		View::plugin('adduser',array('formpath'=>'actedituser','tree'=>$tree,'fields'=>OneSSA::$iuserStandart,'groups'=>$groups,'iuser'=>$user));
	}
	function actedituser(){
		Iuser::editUser();
		$this->redirect('/iuser/user/');
	}
	function actdeluser(){
		Iuser::delUser();
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	public function generatepass(){
		print Iuser::generate_password(8);
	}
	public function checkfield(){
		print Iuser::checkFieldUnique();
	}
}
?>