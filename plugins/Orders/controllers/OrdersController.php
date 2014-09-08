<?
class OrdersController extends Site{
	function __construct(){
		$this->checkRights();
		//PickPoint::updateTerminals();
		Orders::getStatuses();
		Orders::getNextOrderId();
		if(Funcs::$uri[2]==''){
			$model=new Orders;
			$data=$model->getOrdersListByStatus('new');
			$data['editpath']='edit';
			View::plugin('list',$data);
		}
	}
	public function edit(){
		$model=new Orders;
		$data=$model->getOrderById(Funcs::$uri[3]);
		View::plugin('edit',$data);
	}
	public function add(){
		Orders::doAdd();
		$this->redirect('/orders/edit/'.Funcs::$uri[3].'/');
	}
	public function basket(){
		$model=new Orders;
		if(isset($_POST['q'])){
			View::$layout='empty';
			View::plugin('basketgoods',array('items'=>Orders::getBasket(),'id'=>$_POST['id']));
		}else{
			View::$layout='empty';
			View::plugin('basket');
		}
	}
	public function basketadd(){
		DB::escapeGet();
		$model=new Orders;
		$model->addBasket($_GET['id']);
		$model->recalculateOrder($_GET['id']);
		$this->redirect('/orders/edit/'.$_GET['id'].'/');
	}
	public function basketdel(){
		$model=new Orders;
		$model->delBasket($_GET['id']);
		$model->recalculateOrder($_GET['id']);
		$this->redirect('/orders/edit/'.$_GET['id'].'/');
	}
	public function dowork(){
		Orders::doWork();
		$this->redirect('/orders/');
	}
	public function statistic(){
		$model=new Statistic;
		$data=$model->getStatistic(Funcs::$uri[3]);
		View::plugin('statistic',$data);
	}
	public function toword(){
		$model=new Orders;
		$text=View::getPluginEmpty('word',$model->getOrderById($_GET['id']));
		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')){
			header('Content-Type: application/force-download');
		}else{
			header('Content-Type: application/octet-stream');
		}
		$text='<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head><body>'.$text;
		$text.='</body></html>';
		//header('Content-Length: '.strlen($text));
		header('Content-disposition: attachment; filename="Заказ_'.$_GET['id'].'.doc"');		
		echo $text;
	}
	public function printorder(){
		$model=new Orders;
		$text=View::getPluginEmpty('print',$model->getOrderById($_GET['id']));	
		echo $text;
	}
	public function dodel(){
		if($_SERVER['HTTP_REFERER']){
			$model=new Orders;
			$model->delOrder($_GET['id']);
			$uri=$_SERVER['HTTP_REFERER'];
			$uri=explode('/',$uri);
			if($uri[5]){
				$this->redirect('/orders/'.$uri[5]);
			}else{
				$this->redirect('/orders/');
			}
		}else{
			$this->redirect('/orders/');
		}
	}
	public function market(){
		$data['list']=Orders::getMarketList();
		$data['count']=Orders::getMarketListCount();
		View::plugin('market',$data);
	}
	public function editstatus(){
		if($_POST){
			Orders::setStatuses();
			$this->redirect('/orders/editstatus/');
		}elseif($_GET['act']=='del'){
			Orders::delStatuses();
			$this->redirect('/orders/editstatus/');
		}else{
			if($_GET['id']){
				$action='Редактировать статус';
			}else{
				$action='Добавить статус';
			}
			View::plugin('editstatus',array('action'=>$action));
		}
	}
	public function export(){
		Orders::export();
	}
	public function files(){
		//print 'dddddd';die;
		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')){
			header('Content-Type: application/force-download');
		}else{
			header('Content-Type: application/octet-stream');
		}
		header('Content-disposition: attachment; filename="'.Funcs::$uri[4].'"');
		$file=file_get_contents($_SERVER['DOCUMENT_ROOT'].ORDERS_DIR.md5('order'.Funcs::$uri[3]));
		print $file;
	}
	public function getdeliveryprice(){
		if($_GET['act']=='b2c'){
			$data=Delivery::getB2CpreOrder('order',$_POST['zip']);
			$data['id']=$_POST['id'];
			print View::getPluginEmpty('delivery/deliveryB2CpreOrder',$data);
		}else{
			Delivery::getDeliveryPrice();
		}
	}
	public function setdeliveryprice(){
			Delivery::setDeliveryPrice($_POST['id'],$_POST['deliveryprice']);
	}
	public function getdeliveryb2c(){
		if($_GET['act']==''){
			print View::getPluginEmpty('delivery/deliveryB2Cpopup');
		}elseif($_GET['act']=='send'){
			$data=Delivery::getB2Cupload();
			print View::getPluginEmpty('delivery/deliveryB2Cpopup',array('postal'=>$data));
		}
	}
}
?>