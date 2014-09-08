<?
class Orders{
	public static $statuses=array();
	public static $statusesPath=array();
	public static $nextOrderId=0;
	public function getOrdersListByStatus($status='',$all=''){
		$list=array();
		$status='';
		$sqlWhere='';
		if($_GET['status']!='all'){
			if($_GET['status']=='')$_GET['status']='new';
			$status='AND status=\''.$_GET['status'].'\'';
		}
		if($_GET['from'] && $_GET['to']) $sqlWhere.='AND (wdate BETWEEN \''.date('Y-m-d H:i:s',strtotime($_GET['from'])).'\' AND \''.date('Y-m-d H:i:s',strtotime($_GET['to'])).'\')';
		elseif($_GET['from'] && $_GET['to']=='') $sqlWhere.='AND wdate>\''.date('Y-m-d H:i:s',strtotime($_GET['from'])).'\'';
		elseif($_GET['from']=='' && $_GET['to']) $sqlWhere.='AND wdate<\''.date('Y-m-d H:i:s',strtotime($_GET['to'])).'\'';
		if(is_numeric($_GET['number'])) $sqlWhere.='AND id=\''.$_GET['number'].'\'';
		if($_GET['phone']) $sqlWhere.='AND phone LIKE \'%'.$_GET['phone'].'%\'';
		if($_GET['fio']) $sqlWhere.='AND name LIKE \'%'.$_GET['fio'].'%\'';
		$sql='SELECT * FROM {{orders}} WHERE 1=1 '.$status.' '.$sqlWhere.' ORDER BY wdate DESC';
		if($all==''){
			$data=DB::getPagi($sql);
		}else{
			$data=DB::getAll($sql);
		}
		$itog=0;
		foreach($data as $item){
			$temp=Orders::getOrderById($item['id']);
			$temp['reports'][0]=0;
			$temp['reports'][1]=0;
			foreach($temp['goods'] as $goods){
				$sql='SELECT tree FROM {{reports}} WHERE tree='.$goods['tree'].' AND email=\''.$item['email'].'\'';
				if(DB::getOne($sql))$temp['reports'][0]++;
				$temp['reports'][1]++;
			}
			$sql='SELECT * FROM {{orders_opinion}} WHERE orders='.$item['id'].'';
			$temp['opinion']=DB::getRow($sql);
			$list[]=$temp;
			$itog+=$item['price'];
		}
		return array('list'=>$list,'itog'=>$itog);
	}
	public static function getOrdersListCountByStatus($status){
		if($status=='all'){
			$sql='SELECT COUNT(*) FROM {{orders}}';
		}else{
			$sql='SELECT COUNT(*) FROM {{orders}} WHERE status=\''.$status.'\'';
		}
		return DB::getOne($sql);
	}
	public function getOrderById($id){
		$sql='SELECT * FROM {{orders}} WHERE id='.$id;
		$data=DB::getRow($sql);
		if($data['address']){
			$data['address']=unserialize($data['address']);
		}
		if(strpos($data['saletype'],'(')!==false){
			$data['saleperc']=explode('(',$data['saletype']);
			$data['saleperc']=explode(')',$data['saleperc'][count($data['saleperc'])-1]);
			$data['saleperc']=str_replace('%','',$data['saleperc'][0]);
		}else{
			$data['saleperc']=0;
		}
		$sql='SELECT * FROM {{iusers_bonuses}} WHERE orderid='.$id.'';
		$list=DB::getAll($sql);
		foreach($list as $item){
			if(strpos($item['reason'],'(')!==false){
				$item['perc']=explode('(',$item['reason']);
				$item['perc']=explode(')',$item['perc'][count($item['perc'])-1]);
				$item['perc']=str_replace('%','',$item['perc'][0]);
			}else{
				$item['perc']=0;
			}
			if($item['amount']>0) $data['bonusesinfo']['in']=$item;
			else $data['bonusesinfo']['out']=$item;
		}
		$data['city']=$data['address']['city'];
		$sql='SELECT * FROM {{orders_items}} WHERE orders='.$data['id'].'';
		$items=DB::getAll($sql);
		$sum=0;
		$count=0;
		$sale=0;
		$weight=0;
		$data['goods']=array();
		foreach($items as $item){
			$item['info']=Goods::getOne($item['tree']);
			$item['art']=Goods::getSizeByName($item['tree'],$item['size']);
			$data['goods'][]=$item;
			$sum+=$item['price']*$item['num'];
			$weight+=$item['info']['weight'];
			$count++;
		}
		if($data['iuser']){
			$data['client']=Iuser::getIuser($data['iuser']);
			$data['fio']=$data['client']['lastname'].' '.$data['client']['firstname'].' '.$data['client']['secondname'];
		}
		$data['sum']=$sum;
		$data['count']=$count;
		$data['weight']=$weight;
		//$data['postal']=unserialize($data['postal']);
		$data['authoradd']=User::getUser($data['authoradd']);
		$data['authoredit']=User::getUser($data['authoredit']);
		
		return $data;
	}
	public function getBasket(){
		if(strlen($_POST['q'])>2){
			$data=array();
			$sql='
				SELECT {{tree}}.id FROM {{catalog}} 
				INNER JOIN ({{search}} INNER JOIN {{tree}} ON {{search}}.tree={{tree}}.id)
				USING (tree)
				WHERE {{search}}.search LIKE \'%'.$_POST['q'].'%\' AND {{tree}}.visible=1
			';
			$temp=DB::getAll($sql,'id');
			foreach($temp as $id){
				$item=Goods::getOne($id);
				$item['sizes']=Goods::getSizes($id);
				if($item['sizes']){
					$data[]=$item;
				}
			}			
			return $data;
		}else{
			return array();
		}
	}
	public function addBasket($id){
		$size=Goods::getSize($_GET['size']);
		$sql='
			SELECT * FROM {{orders_items}} 
			WHERE orders='.$_GET['id'].' AND size=\''.$size['name'].'\' AND tree='.$_GET['tree'].'
		';
		$row=DB::getRow($sql);
		if($row){
			$sql='UPDATE {{orders_items}} SET num=\''.$_GET['num'].'\' WHERE id='.$row['id'].'';
			DB::exec($sql);
		}else{
			$sql='
				SELECT {{catalog}}.*, {{tree}}.* FROM {{catalog}} 
				INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
				WHERE {{tree}}.id ='.$_GET['tree'].'
			';
			$model=DB::getRow($sql);
			$price=Goods::getPrice($_GET['id'],$_GET['size']);
			$sql='
				INSERT INTO {{orders_items}}
				SET 
					orders='.$_GET['id'].',
					tree='.$_GET['tree'].',
					name=\''.$model['name'].'\',
					size=\''.$size['name'].'\',
					num=\''.$_GET['num'].'\',
					price=\''.$price.'\'
			';
			DB::exec($sql);
		}
	}
	public function delBasket($id){
		$price=0;
		$sql='
			SELECT * FROM {{orders_items}} 
			WHERE orders='.$_GET['id'].' AND tree='.$_GET['tree'].'
		';
		$row=DB::getRow($sql);
		$sql='DELETE FROM {{orders_items}} WHERE id='.$row['id'].'';
		DB::exec($sql);
	}
	public function recalculateOrder($id){
		$order=$this->getOrderById($id);
		$price=0;
		foreach($order['goods'] as $item){
			$price+=$item['num']*$item['price'];
		}
		$sql='UPDATE {{orders}} SET price='.$price.' WHERE id='.$id.'';
		DB::exec($sql);
	}
	public static function doAdd(){
		$sql='
			INSERT INTO {{orders}}
			SET
				cdate=NOW(),			
				wdate=NOW(),
				status=\'new\',
				authoradd='.$_SESSION['user']['id'].'
		';
		DB::exec($sql);
	}
	public function doWork(){
		//print '<pre>';print_r($_POST);die();
		$deliveryprice=trim($_POST['deliveryprice']);
		if($deliveryprice=='')$deliveryprice=0;
		$loyalty=trim($_POST['loyalty']);
		if($loyalty=='')$loyalty=0;
		$status=$_POST['status'];
		if(trim($_POST['deliveryoption']))$deliveryoption='deliveryoption=\''.trim($_POST['deliveryoption']).'\',';
		if(trim($_POST['postal']))$postal='postal=\''.trim($_POST['postal']).'\',';
		$sql='
			UPDATE {{orders}}
			SET
				info=\''.$_POST['info'].'\',
				message=\''.trim($_POST['message']).'\',
				price=\''.trim($_POST['price']).'\',
				sale=\''.trim($_POST['sale']).'\',
				balanceamount=\''.trim($_POST['balanceamount']).'\',
				bonusesamount=\''.trim($_POST['bonusesamount']).'\',
				delivery=\''.trim($_POST['delivery']).'\',
				deliveryprice='.$deliveryprice.',
				'.$deliveryoption.'
				payment=\''.trim($_POST['payment']).'\',
				loyalty='.$loyalty.',
				wdate=NOW(),
				status=\''.$status.'\',
				postaldate=\''.date('Y-m-d',strtotime(trim($_POST['postaldate']))).'\',
				'.$postal.'
				paid=\''.($_POST['paid']==''?'0':'1').'\',
				authoredit='.$_SESSION['user']['id'].'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
		/*foreach($_POST['numtree'] as $i=>$item){
			$sql='
				UPDATE {{orders_items}}
				SET
					numcards=\''.trim($_POST['numcards'][$i]).'\',
					numres=\''.trim($_POST['numres'][$i]).'\'
				WHERE orders='.$_POST['id'].' AND tree='.$item.'
			';
			DB::exec($sql);
		}*/
		if($_POST['loyalty']==1 && $status=='done' && Funcs::$conf['additional']['yaopinions']){
			$sql='SELECT * FROM {{orders}} WHERE id='.$_POST['id'].'';
			$row=DB::getRow($sql);
			//$row['yaopinions']=Funcs::$conf['additional']['yaopinions'];
			$row['yaopinions']=md5($row['id'].$row['email']);
			Sendorder::sendYandex($row);
		}
		if(file_exists($_FILES['upload']['tmp_name'])){
			if($_POST['sendfile']==1){
				Sendorder::sendFile($_POST['id']);
			}
			Orders::Upload();
		}
		if($_POST['bonusesinnew']!=$_POST['bonusesin'] && $_POST['bonusesinid']){
			$sql='UPDATE {{iusers_bonuses}} SET amount='.$_POST['bonusesinnew'].' WHERE id='.$_POST['bonusesinid'].'';
			DB::exec($sql);
		}
		$sql='SELECT * FROM {{iusers_balance}} WHERE orderid='.$_POST['id'].'';
		$balance=DB::getRow($sql);
		$_POST['balanceamount']=-1*abs($_POST['balanceamount']);
		//print $_POST['balanceamount'].'='.$balance['amount'].'';die;
		if($_POST['balanceamount']!=$balance['amount'] && $balance['id'] && $_POST['balanceamount']!=0){
			$sql='UPDATE {{iusers_balance}} SET amount='.$_POST['balanceamount'].' WHERE id='.$balance['id'].'';
			DB::exec($sql);
			$sql='UPDATE {{iusers_options}} SET balance=('.(-1*$balance['amount']).'-'.abs($_POST['balanceamount']).')+balance WHERE iuser='.$_POST['iuser'].'';
			DB::exec($sql);
		}elseif(!$balance['id'] && $_POST['balanceamount']!=0){
			$sql='
				INSERT INTO {{iusers_balance}} 
				SET iuser='.$_POST['iuser'].',
					orderid='.$_POST['id'].',
					reason=\'Покупка\',
					amount='.$_POST['balanceamount'].' ,
					cdate=NOW(),
					status=\'purchase\',
					visible=1
			';
			DB::exec($sql);
			$sql='UPDATE {{iusers_options}} SET balance='.$_POST['balanceamount'].'+balance WHERE iuser='.$_POST['iuser'].'';
			DB::exec($sql);
		}elseif($balance['id'] && $_POST['balanceamount']==0){
			$sql='DELETE FROM {{iusers_balance}} WHERE id='.$balance['id'].'';
			DB::exec($sql);
			$sql='UPDATE {{iusers_options}} SET balance=('.(-1*$balance['amount']).')+balance WHERE iuser='.$_POST['iuser'].'';
			DB::exec($sql);
		}
		if($status=='done'){
			Orders::updateBonuses($_POST['id']);
			Orders::updateBalance($_POST['id']);
		}
		if($_POST['sendemail']==1){
			if($_POST['sendgoods']==1){
				Sendorder::sendAllOrder($_POST['id']);
			}else{
				Sendorder::sendStatus($_POST['id']);
			}
		}
	}
	public static function updateBonuses($orderId){
		$sql='SELECT * FROM {{iusers_bonuses}} WHERE orderid='.$orderId.' AND visible=0';
		$list=DB::getAll($sql);
		foreach($list as $item){
			if($item['iuser']){
				$sql='UPDATE {{iusers_bonuses}} SET visible=1 WHERE id='.$item['id'].'';
				DB::exec($sql);
				$sql='UPDATE {{iusers_options}} SET bonuses='.$item['amount'].'+bonuses WHERE iuser='.$item['iuser'].'';
				DB::exec($sql);
			}
		}
	}
	public static function updateBalance($orderId){
		$sql='SELECT * FROM {{iusers_balance}} WHERE orderid='.$orderId.' AND visible=0';
		$list=DB::getAll($sql);
		foreach($list as $item){
			if($item['iuser']){
				$sql='UPDATE {{iusers_balance}} SET visible=1 WHERE id='.$item['id'].'';
				DB::exec($sql);
				$sql='UPDATE {{iusers_options}} SET balance='.$item['amount'].'+balance WHERE iuser='.$item['iuser'].'';
				DB::exec($sql);
			}
		}
	}
	public static function Upload(){
		$dir=$_SERVER['DOCUMENT_ROOT'].ORDERS_DIR;
		if(!file_exists($dir)){
			mkdir($dir,0777);
		}
		$destination=$_SERVER['DOCUMENT_ROOT'].ORDERS_DIR.md5('order'.$_POST['id']);
		move_uploaded_file($_FILES['upload']['tmp_name'],$destination);
		chmod($destination,0777);
		$sql='
			UPDATE {{orders}}
			SET	filename=\''.$_FILES['upload']['name'].'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}

	public function delOrder($id){
		$sql='DELETE FROM {{orders}} WHERE id='.$id.'';
		DB::exec($sql);
		$sql='DELETE FROM {{orders_items}} WHERE orders='.$id.'';
		DB::exec($sql);
	}
	public static function getMarketList(){
		$sql='
			SELECT {{orders}}.id, {{orders}}.name, {{orders}}.email, {{orders_opinion}}.cdate FROM {{orders_opinion}}
			INNER JOIN {{orders}} ON {{orders}}.id={{orders_opinion}}.orders
			ORDER BY {{orders_opinion}}.cdate DESC
		';
		$data=DB::getPagi($sql);
		return $data;
	}
	public static function getMarketListCount(){
		$sql='
			SELECT COUNT(*) FROM {{orders_opinion}}
			INNER JOIN {{orders}} ON {{orders}}.id={{orders_opinion}}.orders
		';
		return DB::getOne($sql);
	}
	public static function getNextOrderId(){
		$sql='SELECT AUTO_INCREMENT FROM information_schema.`TABLES` T WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME = \'{{orders}}\'';
		Orders::$nextOrderId=DB::getOne($sql);
	}
	public static function getStatuses(){
		$sql='SELECT * FROM {{orders_status}} ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $item){
			Orders::$statuses[$item['id']]=$item;
			Orders::$statusesPath[$item['path']]=$item;
		}
		Orders::$statuses[0]=array('id'=>'0','name'=>'Все','path'=>'all');
		Orders::$statusesPath['all']=array('id'=>'0','name'=>'Все','path'=>'all');
	}
	public static function setStatuses(){
		if($_POST['id']){
			$sql='
				UPDATE {{orders_status}}
				SET name=\''.$_POST['name'].'\',
					path=\''.$_POST['path'].'\'
				WHERE id='.$_POST['id'].'
			';
		}else{
			$status=end(Orders::$statuses);
			$sql='
				INSERT INTO {{orders_status}}
				SET name=\''.$_POST['name'].'\',
					path=\''.$_POST['path'].'\',
					num=\''.$status['num'].'\'
			';
		}
		DB::exec($sql);
	}
	public static function delStatuses(){
		$sql='DELETE FROM {{orders_status}} WHERE id='.$_GET['id'].'';
		DB::exec($sql);
	}
	public static function export(){
		$data='Номер заказа;Дата заявки;ID клиента;Получатель (контактное лицо);Адрес;Товар;кол-во (упаковка/шт.);Номера карт;Номера ресиверов;Дата отправки;Номер почтового отправления;Статус';
		$data.="\n";
		$array=Orders::getOrdersListByStatus('','all');
		foreach($array['list'] as $item){
			foreach($item['goods'] as $goods){
				$data.=$item['id'].';';
				$data.=$item['cdate'].';';
				$data.=$item['client']['OrionId'].';';
				$data.=str_replace(';','',str_replace('&quot;','"',$item['name'])).';';
				$data.=str_replace(';','',str_replace('&quot;','"',$item['address'])).';';
				$data.=str_replace(';','',str_replace('&quot;','"',$goods['name'])).';';
				$data.=$goods['num'].';';
				$data.=str_replace(';','',str_replace('&quot;','"',$goods['numcards'])).';';
				$data.=str_replace(';','',str_replace('&quot;','"',$goods['numres'])).';';
				$data.=$item['postaldate'].';';
				$data.=str_replace(';','',str_replace('&quot;','"',$item['postal'])).';';
				$data.=Orders::$statusesPath[$item['status']]['name'].';';
				$data.="\n";
			}
		}
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="export.csv"');
		print iconv("utf-8", "windows-1251", $data);
	}
	public static function setYandex($hash){
		$sql='SELECT * FROM {{orders}} WHERE MD5(CONCAT(id,email))=\''.$hash.'\'';
		$row=DB::getRow($sql);
		$sql='INSERT INTO {{orders_opinion}} SET orders='.$row['id'].', cdate=NOW()';
		DB::exec($sql);
	}
	public static function setOrderUser($orderId,$iuserId){
		$iuser=Iuser::getIuser($iuserId);
		$address=IuserAddress::getAddresses($iuserId);
		$sql='
			UPDATE {{orders}} 
			SET iuser='.$iuserId.',
				name=\''.$iuser['name'].'\',
				phone=\''.$iuser['phone'].'\',
				email=\''.$iuser['email'].'\',
				address=\''.serialize($address[0]).'\',
				wdate=NOW(),
				authoredit='.$_SESSION['user']['id'].'
			WHERE id='.$orderId.'
		';
		DB::exec($sql);
	}
	public static function setOrderAddress($orderId,$addressId){
		$address=IuserAddress::getAddress($addressId);
		$sql='
			UPDATE {{orders}} 
			SET
				address=\''.serialize($address).'\',
				wdate=NOW(),
				authoredit='.$_SESSION['user']['id'].'
			WHERE id='.$orderId.'
		';
		DB::exec($sql);
	}
}
?>