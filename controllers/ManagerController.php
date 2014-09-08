<?
class ManagerController extends Site{
	function __construct(){
		if($_SESSION['user']){
			$seo=array();
			$seo['seo_title']='Кабинет';
			Funcs::setMeta($seo);
			if(Funcs::$uri[1]==''){
				$data=array();
				$data['orders']=Manager::getManagerList();
				View::render('manager/info',$data);
			}
		}else{
			View::render('site/redirect',array('text'=>'Доступ запрещен','href'=>'/'));
		}
	}
	public function confirm(){
		Orders::setConfirm($_GET['id']);
		Email::changeStatusBook($_GET['id'],'confirm');
		Manager::redirect($_GET['redirect']);		
	}
	public function cancelorder(){
		Manager::cancelOrder($_GET['id']);
		Email::changeStatusBook($_GET['id'],'cancelorder');
		Manager::redirect($_GET['redirect']);		
	}
	public function toprint(){
		Orders::setToprint($_GET['id']);
		Email::changeStatusBook($_GET['id'],'toprint');
		Manager::redirect($_GET['redirect']);
	}
	public function todelivery(){
		Orders::setTodelivery($_GET['id']);
		Email::changeStatusBook($_GET['id'],'todelivery');
		Manager::redirect($_GET['redirect']);
	}
	public function todone(){
		Orders::setTodone($_GET['id']);
		Email::changeStatusBook($_GET['id'],'todone');
		Manager::redirect($_GET['redirect']);
	}
	public function tosale(){
		Manager::setTosale($_GET['id']);
		Manager::redirect($_GET['redirect']);
	}
	public function books(){
		$data=array();
		$seo['seo_title']='Управление книгами';
		Funcs::setMeta($seo);
		$data['list']=Manager::getManagerBooks();
		View::render('manager/books',$data);
	}
	public function orders(){
		$data=array();
		$seo['seo_title']='Управления заказами';
		Funcs::setMeta($seo);
		if(Funcs::$uri[2]==''){
			$data['list']=Manager::getManagerOrders();
			View::render('manager/orders',$data);
		}else{
			$data=Orders::getOne(Funcs::$uri[2]);
			$data['avatar']=User::getAvatar($data['iuser']);
			View::render('manager/order',$data);
		}
	}
}
?>