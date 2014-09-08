<?
class NotificationController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$data['list']=Notification::getList();
			$data['groups']=Notification::getGroups();
			View::plugin('list',$data);
		}
	}
	function show(){
		if(Funcs::$uri[3]){
			$model=new Notification;
			$data=$model->getEdit(Funcs::$uri[3]);
		}
		$data['formpath']='send';
		//	Получаем статусы пользователей
		$data['groups']=Iuser::getGroupList(); 
		$data['emailfrom']='robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]);
		View::plugin('send',$data);
	}
	function send(){
		DB::escapePost();
		$model=new Notification;
		$model->send();
		$this->redirect('/notification/');
	}
	function group(){
		$data=Notification::getGroup($_GET['name']);
		View::plugin('group',$data);
	}
}
?>