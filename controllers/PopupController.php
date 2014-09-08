<?
class PopupController extends Site{
	function __construct(){

	}
	function atb(){
		$model=Catalog::getOne($_GET['id']);
		$model['parentpath']=Tree::getPathToTree($model['parent']);
		$temp=Basket::getSimpleOrder();
		$model['sum']=$temp['sum'];
		$model['goods']=$temp['goods'];
		View::$layout='popup';
		View::render('popup/addtobasket',$model);
	}
	function atbf(){		
		$data=Basket::getSimpleOrder();
		View::$layout='empty';
		View::render('popup/addtobasketfinished',$data);
	}
	function avatar(){
		if($_SESSION['iuser']){
			View::$layout='popup';
			View::render('popup/avatar');
		}else{
			View::render('site/redirect',array('text'=>'Доступ запрещен','href'=>'/'));
		}
	}
	function avatarsave(){
		if($_SESSION['iuser']){
			$model=new User;
			$model->avatar();
			View::$layout='popup';
			View::render('popup/close');
		}else{
			View::render('site/redirect',array('text'=>'Доступ запрещен','href'=>'/'));
		}
	}
	function avatardel(){
		if($_SESSION['iuser']){
			$model=new User;
			$model->avatardel();
			View::$layout='popup';
			View::render('popup/close');
		}else{
			View::render('site/redirect',array('text'=>'Доступ запрещен','href'=>'/'));
		}
	}
	function sameprice(){
	Funcs::escapeGet();
	if ($_GET){
	$same_price=Catalog::getAdditionalgood($_GET['id'],'better_for_same_price');
	$data=array();
	foreach($same_price as $sid){
	$data['list'][]=Catalog::getOne($sid['id']);
	}
		View::$layout='popup';
		View::render('popup/sameprice', $data);
	}
	}
	function callback(){
		View::$layout='popup';
		View::render('popup/callback');
	}
	function sendcallback(){
		$model=new Popup;
		$model->sendCallback();
		View::$layout='popup';
		View::render('popup/close',array('href'=>'/popup/callback/'));
	}
	function sendmailback(){
		$model=new Popup;
		$model->sendMailback();
		//View::$layout='popup';
		//View::render('popup/close',array('href'=>'/popup/callback/'));
	}
	function login(){
		View::$layout='popup';
		View::render('popup/login');
	}
	function registration() {
		View::$layout='popup';
		View::render('popup/reg');
	}
	function order(){
		View::$layout='popup';
		View::render('popup/order');
	}
	function forgot(){
		View::$layout='popup';
		View::render('popup/forgot');
	}
	function sendorder(){
		$model=new Popup;
		$model->sendOrder();
		View::$layout='popup';
		View::render('popup/close',array('href'=>'/popup/callback/'));
	}
	function reject(){
		if($_SESSION['user']){
			View::$layout='popup';
			View::render('popup/reject');
		}
	}
	function rejected(){
		if($_SESSION['iuser'] || $_SESSION['user']){
			View::$layout='popup';
			View::render('popup/rejected',array('rejected'=>Orders::getReject($_GET['id'])));
		}
	}
	function setreject(){
		if($_SESSION['user']){
			if($_POST['act']=='tosale'){
				Orders::setRejectTosale($_POST['id']);
			}else{
				Orders::setReject($_POST['id']);
				Email::changeStatusBook($_POST['id'],'rejected',$_POST['rejected']);
			}
			View::$layout='popup';
			View::render('popup/close');
		}
	}
	function askprice(){
		if($_SESSION['iuser']){
			View::$layout='popup';
			View::render('popup/askprice',Catalog::getOne($_GET['id']));
		}
	}
	function setaskprice(){
		if($_SESSION['iuser']){
			Orders::toSale();
			View::$layout='popup';
			View::render('popup/close');
		}
	}
	function message(){
		if($_SESSION['iuser']){
			View::$layout='popup';
			View::render('popup/message');
		}
	}
	function sendmessage(){
		if($_SESSION['iuser']){
			Funcs::escapePost();
			Message::addMessage($_POST['touser'],$_POST['message']);
			View::$layout='popup';
			View::render('popup/loginclose');
		}
	}
	function newssubscribe(){
		News::setSubscribers();
	}
}
?>