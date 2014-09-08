<?
class CabinetController extends Site{
	function __construct(){
		if($_SESSION['iuser']){
			$seo=array();
			$seo['seo_title']='Кабинет';
			Funcs::setMeta($seo);
			if(Funcs::$uri[1]==''){
				$data=array();
				//$data['orders']=Orders::getUserOrders();
				View::render('cabinet/info',$data);
			}
		}else{
			View::render('site/redirect',array('text'=>'Доступ запрещен','href'=>'/'));
		}
	}
	function profile(){
		$seo['seo_title']=$seo['name']='Мой профиль';
		Funcs::setMeta($seo);
		View::render('cabinet/profile',$seo);
	}
	function profilesave(){
		$model=new User;
		$model->setUpdate();
		View::$layout='empty';
		View::render('site/redirect',array('text'=>'Данные успешно изменены','href'=>'/cabinet/'));
	}
	function basket(){
		if($_POST){
			$basket=new Basket;
			$basket->toOrder();
			$this->redirect('/cabinet/basket/thanks/');
		}else{
			if(Funcs::$uri[2]=='delivery'){
				$seo['seo_title']='Условия доставки';
				Funcs::setMeta($seo);
				$basket=new Basket;
				$data['order']=$basket->getOrder();
				$data['delivery']=$basket->getDelivery($data['order']);
				View::render('cabinet/delivery',$data);
			}elseif(Funcs::$uri[2]=='thanks'){
				$seo['seo_title']='Благодарим вас за заказ!';
				Funcs::setMeta($seo);
				View::render('basket/thanks');
			}else{
				$data['seo_title']='Корзина';
				Funcs::setMeta($data);
				$basket=new Basket;
				$data['order']=$basket->getOrder();
				//$data['delivery']=$basket->getDelivery($data['order']);
				//$data['payment']=$basket->getOrder($data['order']);				
				View::render('cabinet/basket',$data);
			}
		}
	}
	function adds(){
		$data=array();
		if(Funcs::$uri[2]=='save'){
			$model=new Cabinet();
			$model->saveAdds();
			View::$layout='empty';
			View::render('site/redirect',array('text'=>'Данные успешно сохранены','href'=>'/cabinet/delivery/'));
		}elseif(Funcs::$uri[2]=='edit'){
			$data['adds']=Cabinet::getOneAdds(Funcs::$uri[3]);
		}elseif(Funcs::$uri[2]=='del'){
			$model=new Cabinet();
			$model->delAdds();
			$this->redirect('/cabinet/delivery/');
		}
		View::render('cabinet/deliveryadd',$data);
	}
	function history(){
		$model=new Cabinet();
		$data=$model->getOrdersList();
		View::render('cabinet/history',$data);
	}
	function books(){
		if(is_numeric(Funcs::$uri[2]) && !isset($_GET['preview'])){
			$data=Catalog::getOne(Funcs::$uri[2]);
			$seo['seo_title']=$data['name'];
			Funcs::setMeta($seo);
			$data['list']=Catalog::getCabinetBooksList($data['vendor']);
			View::render('cabinet/booksOne',$data);
		}elseif(is_numeric(Funcs::$uri[2]) && isset($_GET['preview'])){
			$data=Catalog::getOne(Funcs::$uri[2]);
			$seo['seo_title']=$data['name'];
			Funcs::setMeta($seo);
			View::render('cabinet/booksPreview',$data);
		}elseif(Funcs::$uri[2]=='del' && is_numeric(Funcs::$uri[3])){
			$data=Catalog::delBook(Funcs::$uri[32]);
			$this->redirect($_GET['redirect']);
		}elseif(Funcs::$uri[2]=='saleoff'){
			Catalog::saleOff($_GET['id']);
			$this->redirect($_GET['redirect']);
		}elseif(Funcs::$uri[2]=='private'){
			Catalog::saleOff($_GET['id']);
			$this->redirect($_GET['redirect']);
		}else{
			$seo['seo_title']='Мои книги';
			Funcs::setMeta($seo);
			$data['list']=Catalog::getCabinetBooksList($_SESSION['iuser']['id']);
			View::render('cabinet/books',$data);
		}
	}
	function orders(){
		if(Funcs::$uri[2]==''){
			$data['seo_title']=$data['name']='Мои заказы';
			Funcs::setMeta($data);
			$data['list']=Cabinet::getOrdersList();
			View::render('cabinet/orders',$data);
		}else{
			$data=Orders::getOne(Funcs::$uri[2]);
			$data['seo_title']=$data['name']='Закакз №'.str_repeat('0',6-strlen($data['id'])).$data['id'];
			View::render('cabinet/ordersOne',$data);
		}
	}
	function notification(){
		if($_POST){
			$model=new Cabinet();
			$model->saveNotification();
			View::$layout='empty';
			View::render('site/redirect',array('text'=>'Данные успешно сохранены','href'=>'/cabinet/notification/'));
		}else{
			$model=new Cabinet();
			$data=$model->getNotification();
			View::render('cabinet/notification',$data);
		}
	}
	function messages(){
		if($_POST){
			Funcs::escapePost();
			Message::addMessage(Funcs::$uri[2],$_POST['message']);
			$this->redirect('/cabinet/messages/'.Funcs::$uri[2].'/');
		}
		if($_GET['del']){
			Funcs::escapeGet();
			Message::delMessage($_GET['del']);
			$this->redirect('/cabinet/messages/'.Funcs::$uri[2].'/');
		}
		if(is_numeric(Funcs::$uri[2])){
			$seo['seo_title']='Сообщения';
			Funcs::setMeta($seo);
			$data=Message::getList(Funcs::$uri[2]);
			View::render('cabinet/messagesOne',$data);
		}else{
			$seo['seo_title']='Сообщения';
			Funcs::setMeta($seo);
			$data['list']=Message::getUsers();
			View::render('cabinet/messages',$data);
		}
	}
}
?>