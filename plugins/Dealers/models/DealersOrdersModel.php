<?
class DealersOrders {
	private static $catalogId = 2;
	private static $currentColor = 0;
	public static function getOrdersList($id = null,$status = 'new',$search = array()) {
		$ret = array('dealer' => null, 'dealers_list'=> null);
		$where = 'WHERE {{dealers_orders_status}}.path = \''.$status.'\'';
		if ($search['form'] && $search['to']) {
			$where .= ' AND ({{dealers_orders}}.cdate BETWEEN '.$search['from'].' AND '.$search['to'].') ';
		}
		if ($search['city']) {
			$where .= ' AND {{dealers}}.city=\''.$search['city'].'\'';
		}		
		if (!is_null($id)) {
			//$id = (isset($_GET['id'])) ? $_GET['id'] : null;			
			$where .= ' AND {{dealers_orders}}.dealer='.$id;
			$ret['dealer'] = Dealers::getOne($id);
		}
		
		$ret['statuses'] = DealersOrders::getStatusesList();
		$sql = '
			SELECT
				{{dealers_orders}}.*,
				{{dealers_orders_status}}.name as statusname,
				{{dealers_orders_status}}.path as statuspath,
				{{dealers}}.city as city,
				{{dealers}}.company as company,
				{{dealers}}.name as name
			FROM {{dealers_orders}} 
			LEFT JOIN {{dealers_orders_status}} ON {{dealers_orders}}.status = {{dealers_orders_status}}.id
			LEFT JOIN {{dealers}} ON {{dealers_orders}}.dealer = {{dealers}}.id
			'.$where.' ORDER by cdate DESC
		';
		$ret['list'] = DB::getAll($sql);
		$ret['dealers_list'] = Dealers::getShortList();
		$ret['city_list'] = Dealers::getCityList();
		//$ret['sale'] = DealersSales::calcSale()
		return $ret;
	}
	public static function getCabinetOrdersList($id) {
		$where = ' WHERE {{dealers_orders}}.dealer='.$id;
		$ret['statuses'] = DealersOrders::getStatusesList();
		$sql = '
			SELECT
				{{dealers_orders}}.*,
				{{dealers_orders_status}}.name as statusname,
				{{dealers_orders_status}}.path as statuspath,
				{{dealers_consignee}}.title as consname
			FROM {{dealers_orders}} 
			LEFT JOIN {{dealers_orders_status}} ON {{dealers_orders}}.status = {{dealers_orders_status}}.id
			LEFT JOIN {{dealers_consignee}} ON {{dealers_orders}}.cons = {{dealers_consignee}}.id
			'.$where.' ORDER by cdate
		';
		$ret['list'] = DB::getAll($sql);	
		return $ret;
	}	
	public static function getOrdersCountByStatus($dealer = null, $status = null){
		$cond = array();
		if (!is_null($dealer)) {
			$cond[] =  '{{dealers_orders}}.dealer = \''.$dealer.'\'';
		}
		if (!is_null($status)){
			$cond[] = '{{dealers_orders_status}}.path=\''.$status.'\'';
		}
		$where = (count($cond) > 0) ? ' WHERE '.implode(' AND ',$cond) : '';
		$sql='
			SELECT COUNT(*) FROM {{dealers_orders}}
			LEFT JOIN {{dealers_orders_status}} on {{dealers_orders}}.status = {{dealers_orders_status}}.id
		'.$where;
		return DB::getOne($sql);
	}
	public static function getStatusesList(){
		$sql='SELECT * FROM {{dealers_orders_status}}';
		return DB::getAll($sql);
	}
	public static function getOrderProp($id){
		$ret = array();
		DB::escapeGet();
		//$sql='SELECT * FROM {{dealers_orders}} WHERE id = '.$id;
		//$ret['order']    = DB::getRow($sql);
		$ret['order']    = self::getOne($id);
		$dealerId        = $ret['order']['dealer'];
		$ret['dealer']   = DealersMain::getOne($dealerId);
		$ret['cons']     = DealersConsignee::getConsList($dealerId,true);
		$ret['statuses'] = DealersOrders::getStatusesList();
		$ret['delivery'] = Delivery::$deliveries;
		$ret['catalog']  = self::getCatalog($ret['order']['preorder']);
		$ret['goods']    = self::getItems($id);
		//self::calcGroups($ret['catalog'],$ret['goods']);
		return $ret;
	}
	public static function getNewOrderProp($dealer){
		$ret = array();
		DB::escapeGet();
		$ret['dealer']   = Dealers::getOne($dealer);
		$ret['cons']     = DealersConsignee::getConsList($dealer,true);
		$ret['statuses'] = DealersOrders::getStatusesList();
		$ret['delivery'] = Delivery::$deliveries;
		$ret['catalog']  = self::getCatalog();
		$ret['goods']    = array();
		return $ret;		
	}
	public static function getCatalog($pre=false){
		return self::getCatalogLayer(self::$catalogId,0,$pre);
	}
	public static function editOrder() {
		self::editOrderItems();
		self::editOrderProp();
	}
	public static function editOrderProp(){
		DB::escapePost();
		//die(print_r($_POST,true));
		$id = $_POST['id'];
		$sum = self::calcOrderSum($id);
		$notififications = (isset($_POST['send_notification'])?1:0);
		$sql='UPDATE {{dealers_orders}}
			SET
				status=\''.$_POST['status'].'\',
				delivery=\''.$_POST['delivery'].'\',
				cons=\''.$_POST['cons'].'\',
				delivery_price=\''.$_POST['delivery_price'].'\',
				tracking=\''.$_POST['tracking'].'\',
				add_sale=\''.$_POST['add_sale'].'\',
				add_sale_text=\''.$_POST['add_sale_text'].'\',
				comment=\''.$_POST['comment'].'\',
				send_notification=\''.$notififications.'\',
				sale_type=\''.$_POST['sale_type'].'\',
				sum='.$sum.'
			WHERE id = \''.$id.'\'';
			//dealer=\''.$_POST['dealer'].'\',
		DB::exec($sql);
		self::addHistory($id,$_POST['old_status'],$_POST['status']);
		self::setTotalOrdersSum($_POST['dealer']);
		if (($notififications > 0) && ($_POST['old_status'] != $_POST['status'])) {
			DealersEmail::order_status($id);
		}
	}
	public static function getOne($id){
		$sql='
			SELECT {{dealers_orders}}.*, {{dealers_orders_status}}.name as statusname
			FROM {{dealers_orders}} 
			LEFT JOIN {{dealers_orders_status}} ON {{dealers_orders}}.status = {{dealers_orders_status}}.id
			WHERE {{dealers_orders}}.id = '.$id;
		return DB::getRow($sql);
	}
	public static function editOrderItems(){
		$items = $_POST['items'];
		$prices = $_POST['prices'];
		$order = $_POST['id'];
		if($_POST['add_sale']=='')$_POST['add_sale']=0;
		$sql = 'SELECT * FROM {{dealers_orders_items}} WHERE `order` = '.$order;
		$temp = DB::getAll($sql);
		$items_in_db = array();
		foreach ($temp as $item) {
			$items_in_db[$item['tree']] = $item;
		}
		$sum=0;
		foreach ($items as $key => $item) {
			$indb = isset($items_in_db[$key]);
			if (intval($item) == 0) {
				if ($indb) {
					$sql = 'DELETE FROM {{dealers_orders_items}} WHERE `tree` ='.$key.' AND `order`='.$order;
					DB::exec($sql);
				}
			} elseif (intval($item) > 0) {
				if ($indb) {
					if ($item != $items_in_db[$key]['count']) {
						$sql = 'UPDATE {{dealers_orders_items}} SET `count`= '.$item.' WHERE `tree`='.$key.' AND `order`='.$order; 
						DB::exec($sql);
					}
				} else {
					$sql = 'INSERT INTO {{dealers_orders_items}} SET
						`order` = \''.$order.'\',
						`tree` = \''.$key.'\',
						`count` = \''.$item.'\',
						`price` = \''.$prices[$key].'\'
					';
					DB::exec($sql);
				}	
			}
			$sum+=$prices[$key]*$item;
		}
		$price=$sum-$sum/100*$_POST['add_sale'];
		$sql = 'UPDATE {{dealers_orders}} SET `price`= '.$price.' WHERE `id`='.$order.'';
		DB::exec($sql);
	}
	public static function getHistory($id){
		$sql='
			SELECT t1.cdate, t2.name as old_status, t3.name as new_status FROM {{dealers_orders_history}} t1
			LEFT JOIN {{dealers_orders_status}} t2 ON t2.id = t1.old_status
			LEFT JOIN {{dealers_orders_status}} t3 ON t3.id = t1.new_status
			WHERE `order`='.$id.' ORDER by cdate DESC';
		return DB::getAll($sql);
	}
	public static function addHistory($order,$old_status, $new_status){
		if ($old_status != $new_status) {
			$sql='INSERT INTO {{dealers_orders_history}} SET
				`order`=\''.$order.'\',
				`old_status`=\''.$old_status.'\',
				`new_status`=\''.$new_status.'\',
				`cdate`=NOW()
			';
			DB::exec($sql);
		}
	}
	/*
	private static function sendNotification($order){		
		$order = DealersOrders::getOne($order);
		$dealer = DealersMain::getOne($order['dealer']);
		$mail=new Email;
		$mail->To($dealer['emailreport']);
		$mail->Subject('Изменение статуса заказа на сайте www.'.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
		$mail->Text( View::getPluginEmpty('email/order_status', array('dealer'=>$dealer,'order'=>$order)) );
		$mail->Send();
	}
	*/
	private static function getCatalogLayer($parent,$depth = 0,$pre=false){
		$sql='
			SELECT {{tree}}.id as tree_id, {{tree}}.*, {{catalog}}.* FROM {{tree}}
			LEFT JOIN {{catalog}} ON {{tree}}.id = {{catalog}}.tree
			WHERE {{tree}}.visible=1 AND parent = '.$parent.'
			ORDER BY num
		';
		$elements = DB::getAll($sql);
		$depth++;
		foreach($elements as $key => $item) {
			$sql='
				SELECT {{tree}}.id as tree_id, {{tree}}.*, {{catalog}}.* FROM {{tree}}
				LEFT JOIN {{catalog}} ON {{tree}}.id = {{catalog}}.tree
				WHERE {{tree}}.visible = 1 AND parent = '.$item['tree_id'].'
				ORDER BY num
			';
			$temp = DB::getAll($sql);
			$f=self::getFieldsByTree($item['tree_id']);
			//print Run::$colors[$f['color']]['pic'];
			if(Funcs::$uri[0]!=ONESSA_DIR){
				if($f['color'])self::$currentColor=$f['color'];
				$f['wcolor']=Run::$colors[self::$currentColor];
			}
			//print $elements[$key]['name'].' ('.$item['tree_id'].') |'.$f['numberWarehouse'].'|<br><br>';
			if($pre){
				if((isset($f['value']) || $item['preorder']==1) || (!isset($f['value']) && !isset($item['preorder']))){
					$elements[$key]['fields']=$f;
					if (!is_null($item['tree'])) {
						$elements[$key]['model']=true;
						$fields = true;
						//$elements[$key]['fields']=self::getFieldsByTree($item['tree_id']);
					} else {
						$fields = false;
					}
					if(count($temp)>0){
						$elements[$key]['sub'] = self::getCatalogLayer($item['tree_id'],$depth,$pre);
					}
					$elements[$key]['depth'] = $depth;
				}else{
					unset($elements[$key]);
				}
				if(count($elements[$key]['sub'])==0 && !$elements[$key]['fields']['value']){
					unset($elements[$key]);
				}
			}else{
				if((isset($f['value']) && $f['numberWarehouse']>0) || !isset($f['value'])){
					$elements[$key]['fields']=$f;
					if (!is_null($item['tree'])) {
						$elements[$key]['model']=true;
						$fields = true;
						//$elements[$key]['fields']=self::getFieldsByTree($item['tree_id']);
					} else {
						$fields = false;
					}
					if(count($temp)>0){
						$elements[$key]['sub'] = self::getCatalogLayer($item['tree_id'],$depth);
					}
					$elements[$key]['depth'] = $depth;
				}else{
					unset($elements[$key]);
				}
				if(count($elements[$key]['sub'])==0 && !$elements[$key]['fields']['value']){
					unset($elements[$key]);
				}
			}
		}
		return $elements;
	}
	/*
	private static function calcGroups(&$cat,$goods,$res =array()){
		$ids = implode(', ',array_keys($goods));
		$sql = 'SELECT * FROM {{tree}} WHERE `id` IN('.implode().')';
		$level = DB::getAll($sql);
		foreach ($level as $item) {
			$res[$item['parent']] += $item;
		}
	}
	*/
	private static function hasChildren($id){
		$sql='
			SELECT COUNT({{tree}}.id) as cnt, FROM {{tree}}
			WHERE {{tree}}.visible=1 AND parent = '.$id.'
			ORDER BY num
		';
		$count = DB::getAll($sql);
		return ((bool)$count[0]>0);
	}
	private static function getCatalogOne($id){
		$sql='
			SELECT {{tree}}.*, {{catalog}}.*, {{tree}}.id as id FROM {{tree}}
			LEFT JOIN {{catalog}} ON {{tree}}.id = {{catalog}}.tree
			WHERE {{tree}}.id = '.$id.'
			ORDER BY num
		';
		return DB::getRow($sql);
	}
	public static function getElementDepth($arr,$id,$depth = 0) {
		foreach ($arr as $key => $item) {
			if ($item['id'] == $id) {
				$depth++;
				return self::getElementDepth($arr,$item['parent'],$depth);
			}
		}
		return $depth;
	}
	private static function getFieldsByTree($tree){
		$sql = 'SELECT * FROM {{data}} WHERE tree='.$tree;
		$rawdata = DB::getAll($sql);
		$ret = array();
		foreach ($rawdata as $item) {
			$ret[$item['path']] = $item[Fields::$types[$item['type']]['type']];
		}
		return $ret;
	}
	private static function getItems($order){
		$sql = 'SELECT * FROM {{dealers_orders_items}} WHERE `order` = '.$order;
		$temp = DB::getAll($sql);
		$ret = array();
		foreach($temp as $item) {
			$ret[$item['tree']] = $item;
		}
		return $ret;
	}
	public static function addNewOrder($dealerId){
		DB::escapePost();
		$sum=0;
		foreach($_POST['items'] as $key=>$item){
			$sum+=$_POST['prices'][$key]*$item;
		}
		$price=$sum-$sum/100*$_SESSION['dealer']['sale'];
		//$sql='SELECT * FROM {{dealers_consignee}} WHERE id='.$_POST['cons'].'';
		$sql='
			INSERT INTO {{dealers_orders}}
			SET
				status=1,
				price=\''.$price.'\',
				sale=\''.($sum/100*$_SESSION['dealer']['sale']).'\',
				saleperc=\''.$_SESSION['dealer']['sale'].'\',
				cons=\''.$_POST['cons'].'\',
				comment=\''.$_POST['comment'].'\',
				dealer=\''.$dealerId.'\',
				preorder=\''.$_POST['preorder'].'\',
				cdate=NOW()
		';
		$orderId=DB::exec($sql);
		$dealer = DealersMain::getOne($dealerId);
		self::addItemsToOrder($_POST['items'],$orderId,$_POST['prices']);
		self::addHistory($orderId,'',1);
		
		$text='Новый заказ № '.str_repeat('0',6-strlen($orderId)).$orderId.' поступил от дилера '.$_SESSION['dealer']['company'].'';
		$mail = new Email;
		$mail->Text($text);
		$mail->Subject('Поступил заказ от дилера с сайта www.'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
		$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
		$mail->mailTo(Funcs::$conf['email']['dealers']);
		$mail->Send();
	}
	public static function addOrder($dealerId,$status = 1){
		DB::escapePost();
		$sql='INSERT INTO {{dealers_orders}}
			SET
				status=\''.$status.'\',
				delivery=\''.$_POST['delivery'].'\',
				cons=\''.$_POST['cons'].'\',
				delivery_price=\''.$_POST['delivery_price'].'\',
				tracking=\''.$_POST['tracking'].'\',
				add_sale=\''.$_POST['add_sale'].'\',
				add_sale_text=\''.$_POST['add_sale_text'].'\',
				comment=\''.$_POST['comment'].'\',
				dealer=\''.$dealerId.'\',
				cdate=NOW()
		';
		DB::exec($sql);
		$orderId = self::getLastOrderId($dealerId);		
		$dealer = DealersMain::getOne($dealerId);
		self::addItemsToOrder($_POST['items'],$orderId);
		self::addHistory($orderId,$_POST['old_status'],$status);
	}
	private static function addItemsToOrder($items,$orderId,$prices){
		$sql_parts=array();
		foreach ($items as $key => $item){
			if ($item > 0) {
				$sql_parts[]="('".$orderId."', '".$key."', '".$item."', '".$prices[$key]."')";
			}
		}
		if (count($sql_parts) > 0) {
			$sql = $sql='INSERT INTO {{dealers_orders_items}} (`order`, `tree`, `count`,`price`) VALUES '.implode(', ',$sql_parts);
			DB::exec($sql);
		}
	}
	private static function getLastOrderId($dealerId){
		$sql='SELECT id FROM {{dealers_orders}} WHERE `dealer`=\''.$dealerId.'\' ORDER by `cdate` desc LIMIT 1';
		$temp = DB::getRow($sql);
		return $temp['id'];
	}
	public static function delOrder($id) {
		$sql='DELETE FROM {{dealers_orders}} WHERE id='.$id;
		DB::exec($sql);
		$sql='DELETE FROM {{dealers_orders_history}} WHERE `order`='.$id;
		DB::exec($sql);
		$sql='DELETE FROM {{dealers_orders_items}} WHERE `order`='.$id;
		DB::exec($sql);
	}
	public static function calcOrderSum($id) {
		$items = self::getItems($id);
		//print_r($items);
		$sum = 0;
		//
		foreach ($items as $item) {			
			$f = self::getFieldsByTree($item['tree']);
			$sum += $f['basicDealerPriceUSD'] * $item['count'];
		}
		return $sum;
		//$order = self::getOrderProp($id)
	}
	public static function setTotalOrdersSum($dealer){
		$sql = '
			SELECT {{dealers_orders}}.*, {{dealers_orders_status}}.path as statuspath
			FROM {{dealers_orders}}
			LEFT JOIN {{dealers_orders_status}} ON {{dealers_orders_status}}.id = {{dealers_orders}}.status
				WHERE {{dealers_orders}}.`dealer`=\''.$dealer.'\'
				AND {{dealers_orders_status}}.path IN(\'sort\',\'done\',\'delivery\')
				AND YEAR({{dealers_orders}}.cdate) = YEAR(NOW())
		';
		$orders = DB::getAll($sql);
		$total_sum = 0;
		foreach ($orders as $item){
			$total_sum += $item['sum'];
		}
		//print_r($total_sum);
		//die($total_sum);
		$sql='UPDATE {{dealers}} SET `sum`='.$total_sum.' WHERE id='.$dealer;
		DB::exec($sql);
		//return $total_sum;
	}
	public static function formOrder($data){
		//парсим
		$items = array();
		$order = array();
		$pairs = explode(';', trim($data));
		foreach ($pairs as $pair) {
			if (trim($pair) !== '') {
				$item = explode('-',$pair);
				$items[$item[0]] = $item[1];
			}
		}
		//получаем все артикулы
		foreach ($items as $key=>$val){
			$order[] = array_merge(self::getOneArticle($key),array('count'=>$val));
		}

		return $order;
	}
	public static function getOneArticle($id) {
		//получаем информацию об одном артикуле
		$sql = '
			SELECT *, id as tree_id FROM {{tree}} WHERE id='.$id.'
		';
		$art = DB::getRow($sql);
		$art['fields'] = self::getFieldsByTree($id);
		//получаем данные родителя (модели)
		$sql = 'SELECT * FROM {{catalog}} WHERE tree = '.$art['parent'];
		$art['parent']=DB::getRow($sql);
		return $art;
	}
	public function getOneSize($id) {
		$data=array();
		$sql='SELECT * FROM {{tree}} WHERE id='.$id.'';
		$data=DB::getRow($sql);
		$data['fields']=Fields::getFieldsByTree($id);
		return $data;
	}
	public function getOrderGoods($order){
		$data=array();
		$sql='
			SELECT {{dealers_orders_items}}.*, {{tree}}.name FROM {{dealers_orders_items}} 
			INNER JOIN {{tree}} ON {{dealers_orders_items}}.tree={{tree}}.id
			WHERE {{dealers_orders_items}}.`order`='.$order.'
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$sql='SELECT parent FROM {{tree}} WHERE id='.$item['tree'].'';
			$id=DB::getOne($sql);
			$item['fields']=Fields::getFieldsByTree($item['tree']);
			$data[]=array(
				'goods'=>Catalog::getOne($id),
				'size'=>$item,
			);
		}
		return $data;
	}
}
?>
