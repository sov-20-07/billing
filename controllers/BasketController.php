<?
class BasketController extends Site{
	public $table='cat';
	public $tableSave='basket';
	function __construct(){
		if(Funcs::$uri[1]==''){
			$tree=Tree::getTreeByUrl();
			Funcs::setMeta($tree);
			$basket=new Basket;
			$tree['order']=$basket->getOrder();
			if($tree['order']['count']>0){
				/*if($_SESSION['iuser']){
					$adds=$_SESSION['iuser']['options']['address'];
					if($_POST['adds'])$adds=$_POST['adds'];
					if(is_numeric($adds)){
						$tree['reg']=Cabinet::getOneAdds($adds);
					}
					$tree['adds']=$adds;
				}*/
				$accessories=array();
				$salegoods=array();
				foreach($tree['order']['goods'] as $key=>$item){
					$accessories[]=Catalog::getAdditionalgood($key,'accessories');
				}
				foreach($accessories as $i=>$items){
					foreach($items as $ii=>$item){
						$salegoods[]=$item['tree'];
						if(key_exists($item['tree'],$tree['order']['goods'])){
							unset($accessories[$i][$ii]);
						}
					}
				}
				$tree['order']['accessories']=$accessories;
				$tree['order']['salegoods']=$salegoods;
				View::render('basket/basket',$tree);
			}else{
				View::render('basket/empty',$tree);
			}
		}elseif(count($_SESSION['goods'])==0 && Funcs::$uri[1]!='addtobasket' && $_SESSION['orderId']=='' && Funcs::$uri[1]!='addlisttobasket' && Funcs::$uri[1]!='getneworder' && Funcs::$uri[1]!='success' && Funcs::$uri[1]!='fail'){
			$this->redirect('/basket/');
		}
	}
	function addtobasket() {
		Basket::addToBasket();
		Basket::getBasket();
		/*if(strpos($_SERVER['HTTP_REFERER'],'popup')!==false){
			$this->redirect('/popup/atbf/?id='.$_POST['id']);
		}else{
			$this->redirect($_SERVER['HTTP_REFERER']);
		}*/
	}
	function addlisttobasket() {
		Basket::addListToBasket();
	}
	function sendnum() {
		$basket=new Basket;
		$basket->sendNum($_POST['id'],$_POST['num']);
	}
	function delgoods() {
		$basket=new Basket;
		$basket->delGoods($_POST['id']);
	}
	function credit() {
		Basket::credit();
	}
	function basketincrecalc(){
		Basket::getBasket();
	}
	function superclick(){
		$basket=new Basket;
		$basket->toSuperClick();
	}
	/*function toorder() {
		$basket=new Basket;
		if($_POST['registration']==1){
			$user=new User;
			$iuserId=$user->setRegistration();
			$basket->toOrder($iuserId);
		}else{
			$basket->toOrder();
		}		
		$this->redirect('/basket/thanks/');
	}*/
	public function information(){
		if($_POST){
			Basket::setStep1();
			$this->redirect('/basket/delivery/');
		}else{
			$tree['seo_title']=$tree['seo_keywords']=$tree['seo_description']='Ваши данные';
			Funcs::setMeta($tree);
			$basket=new Basket;
			$tree['order']=$basket->getOrder();
			View::render('basket/information',$tree);
		}
	}
	public function delivery(){
		if($_POST){
			Basket::setStep2();
			$this->redirect('/basket/payment/');
		}else{
			$tree['seo_title']=$tree['seo_keywords']=$tree['seo_description']='Доставка';
			Funcs::setMeta($tree);
			$basket=new Basket;
			$tree['order']=$basket->getOrder();
			$tree['region']=$basket->getRegion();
			View::render('basket/delivery',$tree);
		}
	}
	public function payment(){
		if($_POST){
			Basket::setStep3();
			$basket=new Basket;
			$basket->toOrder();
			$this->redirect('/basket/finish/');
		}else{
			$tree['seo_title']=$tree['seo_keywords']=$tree['seo_description']='Оплата';
			Funcs::setMeta($tree);
			$basket=new Basket;
			$tree['order']=$basket->getOrder();
			View::render('basket/payment',$tree);
		}
	}
	public function finish(){
		$tree['seo_title']=$tree['seo_keywords']=$tree['seo_description']='Подтверждение';
		Funcs::setMeta($tree);
		$basket=new Basket;
		$data=$basket->getConfirm($_SESSION['orderId']);
		if(isset($_GET['print'])){
			View::$layout='empty';
			View::render('basket/print',$data);
		}else{
			View::render('basket/finish',$data);
		}
	}
	public function click(){
		if($_POST){
			Basket::setStep1();
			$basket=new Basket;			
			$basket->toOrder();
			$this->redirect('/basket/thanks/?1stepover');
		}else{
			$tree['seo_title']=$tree['seo_keywords']=$tree['seo_description']='Ваши данные';
			Funcs::setMeta($tree);
			$basket=new Basket;
			$tree['order']=$basket->getOrder();
			View::render('basket/click',$tree);
		}
	}
	public function purchase(){
		if($_POST){
			$basket=new Basket;			
			$basket->setPurchase();
			$this->redirect('/basket/finish/');
		}else{
			$tree['seo_title']=$tree['seo_keywords']=$tree['seo_description']='Ваши данные';
			Funcs::setMeta($tree);
			$basket=new Basket;
			$tree['order']=$basket->getOrder();
			View::render('basket/purchase',$tree);
		}
	}
	public function thanks(){
		$tree['seo_title']=$tree['seo_keywords']=$tree['seo_description']='Спасибо за заказ';
		Funcs::setMeta($tree);
		View::render('basket/thanks');
	}
	public function getneworder(){
		$_SESSION['mydata']['payment']='3';
		$basket=new Basket;
		print $basket->saveBasket();
	}
	public function success(){
		View::render('basket/success');
	}
	public function fail(){
		Basket::fail($_REQUEST["orderId"]);
		View::render('basket/fail');
	}
}
?>