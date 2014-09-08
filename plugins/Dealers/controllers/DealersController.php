<?
class DealersController extends Site{
	public function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$list=DealersMain::getUndefinedDealers();
			View::plugin('index',array('list'=>$list));
		}
	}
	public function requests(){
		//die('123332');
		$list=DealersMain::getNewDealers();
		View::plugin('requests',array('list'=>$list));
	}
	public function adddealer(){
		$data['formpath']='actadddealer';
		//$data['fields']=OneSSA::$iuserStandart;
		//$data['groups']=Iuser::getGroupListAll();
		$data['statuses']=DealersMain::getStatusList();
		View::plugin('add',$data);
	}	
	public function actadddealer(){
		$id=DealersMain::addDealer(true); //force
		//if($_POST['act']=='popup'){
		//	Orders::setOrderUser($_POST['ordrerid'],$id);
		///		print View::getPluginEmpty('popup/close');
		//}else{
			$this->redirect('/dealers/');
		//}
	}
	public function actselectuser(){
		Orders::setOrderUser($_GET['ordrerid'],$_GET['iuserid']);
		print View::getPluginEmpty('popup/close');
	}
	public function edit(){
		$data=DealersMain::getOne($_GET['id']);
		$data['formpath']='actedit';
		$data['statuses']=DealersMain::getStatuses();
		View::plugin('add',$data);
	}
	public function activate(){
		DB::escapeGet();
		DealersMain::activateDealer($_GET['id']);
		$this->redirect('/dealers/requests/');
	}
	// статус дилера
	public function addstatus(){
		$list=DealersMain::getStatusList();
		View::plugin('addstatus',array('formpath'=>'actaddstatus','title'=>'Добавить статус','list'=>$list));
	}
	public function actaddstatus(){
		DealersMain::addStatus();
		$this->redirect('/dealers/addstatus/');
	}
	public function editstatus(){
		$status=DealersMain::getStatus($_GET['id']);
		$list=DealersMain::getStatusList();
		View::plugin('addstatus',array(
			'formpath'=>'acteditstatus',
			'title'=>'Редактировать статус',
			'list'=>$list,
			'status'=>$status
		));
	}
	public function acteditstatus(){
		DealersMain::editStatus();
		$this->redirect('/dealers/addstatus/');
	}	
	public function actedit(){
		DealersMain::edit();
		$this->redirect('/dealers/edit/?id='.$_POST['id']);
	}
	public function actdel(){
		DealersMain::delUser();
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	public function generatepass(){
		print Iuser::generate_password(8);
	}
	public function checkfield(){
		print DealersMain::checkFieldUnique();
	}
	
	// список городов
	public function getcities1($region){
		
	}
	
	// адреса (точки продаж) 
	public function stores() {
		$list = DealersStores::getStoresList($_GET['id']);
		$dealer = DealersMain::getOne($_GET['id']);
		View::plugin('address/storeslist',array('title'=>'Адреса Дилера (точки продаж)','list'=>$list,'dealer'=>$dealer));
	}
	public function editstore() {
		$data = DealersStores::getOne($_GET['id']);
		$dealer = DealersMain::getOne($data['dealer']);
		$statuses = DealersMain::getStatusList();
		$regions = Region::getList();

		View::plugin('address/editstore',array(
			'data'=>$data,
			'dealer'=>$dealer,
			'regions'=>$regions,
			'statuses'=>$statuses,
			'formpath'=>'acteditstore'
		));
	}
	public function acteditstore(){	
		DealersStores::editStore();
		$this->redirect('/dealers/stores/?id='.$_POST['dealer']);
	}
	public function addstore(){
		$dealer = DealersMain::getOne($_GET['id']);
		$statuses = DealersMain::getStatusList();
		$regions = DealersRegion::getRegions();
		View::plugin('address/editstore',array(
			'data'=>array('status'=>$dealer['status']),
			'dealer'=>$dealer,
			'regions'=>$regions,
			'statuses'=>$statuses,
			'formpath'=>'actaddstore'
		));
	}
	public function actaddstore(){
		DealersStores::addStore();
		$this->redirect('/dealers/stores/?id='.$_POST['dealer']);
	}
	public function actdelstore(){
		DealersStores::delStore($_GET['id']);
		$this->redirect('/dealers/stores/?id='.$_GET['dealer']);	
	}
	public function showstore(){
		DealersStores::showStore($_GET['id']);
		$this->redirect('/dealers/stores/?id='.$_GET['dealer']);	
	}
	public function hidestore(){
		DealersStores::hideStore($_GET['id'],true);
		$this->redirect('/dealers/stores/?id='.$_GET['dealer']);	
	}	

	// ГП (грузополучатели)
	public function listcons(){
		$dealer = DealersMain::getOne($_GET['id']);
		$list = DealersConsignee::getConsList($_GET['id']);
		View::plugin('consignee/list',array('list'=>$list,'dealer'=>$dealer));
	}
	public function editcons(){
		$cons = DealersConsignee::getOne($_GET['id']);
		$dealer = DealersMain::getOne($cons['dealer']);
		View::plugin('consignee/edit',array(
			'data'=>$cons,
			'dealer'=>$dealer,
			'formpath'=>'acteditcons'
			
		));		
	}
	public function acteditcons(){
		DealersConsignee::editCons();
		$this->redirect('/dealers/listcons/?id='.$_POST['dealer']);
	}
	public function addcons(){
		$dealer = DealersMain::getOne($_GET['id']);
		View::plugin('consignee/edit',array(
			'data'=>array('form'=>'1'),
			'dealer'=>$dealer,
			'formpath'=>'actaddcons'
		));				
	}
	public function actaddcons(){
		DealersConsignee::addCons();
		$this->redirect('/dealers/listcons/?id='.$_POST['dealer']);
	}
	public function actdelcons(){
		DealersConsignee::delCons();
		$this->redirect('/dealers/listcons/?id='.$_GET['dealer']);
	}
	
	private static function dbg(){
		header('Content-type: text/plain');
		echo "POST ";
		print_r($_POST);
		echo "GET ";
		print_r($_GET);
		echo "FILES ";
		print_r($_FILES);
		die();		
	}
	
	// Заказы
	public function orders(){
		$search = array();
		if ($_GET['from'] && $_GET['to']) {
			$search['from'] = $_GET['from'];
			$search['to']   = $_GET['to'];
		}
		if ($_GET['city']) $search['city'] = $_GET['city'];
		$list = DealersOrders::getOrdersList($_GET['id'],isset($_GET['status'])? $_GET['status']:'new',$search);
		View::plugin('orders/list',$list);		
	}
	public function editorder(){
		$id = $_GET['id'];
		$data = DealersOrders::getOrderProp($id);
		$data['formpath'] = 'acteditorder';
		View::plugin('orders/edit',$data);
	}
	public function acteditorder(){
		DealersOrders::editOrder();
		$this->redirect('/dealers/orders/?id='.$_POST['dealer'],$_POST['status']);
	}
	public function addorder(){
		$id = $_GET['id'];
		$data = DealersOrders::getNewOrderProp($id);
		$data['formpath'] = 'actaddorder';
		View::plugin('orders/edit',$data);
	}
	public function actaddorder(){
		DealersOrders::addOrder($_POST['dealer']);
		$this->redirect('/dealers/orders/?id='.$_POST['dealer']);
	}
	public function actdelorder(){
		DealersOrders::delOrder($_GET['id']);
		$this->redirect('/dealers/orders/?id='.$_GET['dealer']);		
	}
	public function getcatalog(){
		$data = DealersOrders::getCatalogBranch($_GET['id']);
		echo View::getPluginEmpty('orders/branch',array('data' => $data));
	}
	public function orderhistory(){
		$list = DealersOrders::getHistory($_GET['id']);
		echo View::getPluginEmpty('orders/history',array(
			'list' => $list
		));		
	}
	public function allorders(){
		$search = array();
		if ($_GET['from'] && $_GET['to']) {
			$search['from'] = $_GET['from'];
			$search['to']   = $_GET['to'];
		}
		if ($_GET['city']) $search['city'] = $_GET['city'];
		$list = DealersOrders::getOrdersList(null,isset($_GET['status'])? $_GET['status']:'new',$search);
		View::plugin('orders/allorders',$list);
	}
	
	// Баланс дилеров
	public function balance(){
		$dealer = DealersMain::getOne($_GET['id']);
		$list = DealersMain::getBalanceHistory($_GET['id']);
		$balance = DealersMain::getBalance($_GET['id']);
		View::plugin('balance/list',array(
			'list'=>$list,
			'dealer'=>$dealer,
			'balance'=>$balance
		));				
	}
	public function editbalance(){
		$dealer = DealersMain::getOne($_GET['id']);
		$data = DealersMain::getTransaction($_GET['id']);
		View::plugin('balance/edit',array(
			'data'=>$data,
			'dealer'=>$dealer,
			'formpath'=>'acteditbalance'
		));				
	}
	public function acteditbalance(){
		DealersMain::setTransaction();
		//self::dbg();
		$this->redirect('/dealers/balance/?id='.$_POST['dealer']);	
	}
	public function addbalance(){
		$dealer = DealersMain::getOne($_GET['id']);
		$now = date('Y-m-d H:i:s');
		View::plugin('balance/edit',array(
			'data'=>array('cdate'=>$now),
			'dealer'=>$dealer,
			'formpath'=>'actaddbalance'
		));				
	}
	public function actaddbalance(){
		DealersMain::addTransaction();
		//self::dbg();
		$this->redirect('/dealers/balance/?id='.$_POST['dealer']);	
	}
	public function actdelbalance(){
		DealersMain::delTransaction();		
		$this->redirect('/dealers/balance/?id='.$_GET['dealer']);
		//self::dbg();		
	}
	
	// Файлы  дилеров
	public function files(){
		$list = DealersFiles::getDealerFiles($_GET['id']);
		$dealer = DealersMain::getOne($_GET['id']);
		View::plugin('files/list',array('list'=>$list,'dealer'=>$dealer));				
	}
	public function addfile(){
		$dealer = DealersMain::getOne($_GET['id']);
		$now = date('Y-m-d H:i:s');
		View::plugin('files/edit',array(
			'data'=>array('cdate'=>$now),
			'dealer'=>$dealer,
			'formpath'=>'actaddfile'
		));			
	}
	public function actaddfile(){
		DealersFiles::uploadDealerFiles($_POST['dealer']);
		$this->redirect('/dealers/files/?id='.$_POST['dealer']);
		//self::dbg();
	}
	public function editfile(){
		//$now = date('Y-m-d H:i:s');
		$data = DealersFiles::getOneFile($_GET['id']);
		$dealer = DealersMain::getOne($data['dealer']);
		View::plugin('files/edit',array(
			'data'=>$data,
			'dealer'=>$dealer,
			'formpath'=>'acteditfile'
		));			
	}
	public function acteditfile(){
		DealersFiles::editFile();
		$this->redirect('/dealers/files/?id='.$_POST['dealer']);		
	}
	public function actdelfile(){
		DealersFiles::delFile($_GET['id']);
		$this->redirect('/dealers/files/?id='.$_GET['dealer']);
		//View::plugin('files/list',array('list'=>$list,'dealer'=>$dealer));
	}
	
}
?>
