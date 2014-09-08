<?
require_once $_SERVER['DOCUMENT_ROOT'].'/plugins/Orders/lib/dpd.php';
class Delivery{
	public static $deliveries=array('Курьером по Москве','Курьером DPD','Самовывозом DPD','PickPoint');
	public static $postal=array('file_codes'=>'Файл ответа','file_stickers'=>'Наклейка');
	public static function getDelivery(){
		$data=Orders::getOrderById(Funcs::$uri[3]);
		if($data['address']['city']=='Москва'){
			$data['data']['courier']['cost']=Delivery::getMoscowPrice();
		}elseif($data['address']['region']=='42'){
			$data['data']['couriermo']['cost']=Delivery::getMOPrice();
		}else{
			$data['data']['multiship']=Delivery::getMultishipPrice('admin',Funcs::$uri[3]);
		}
		//$data['data']['pickpoint']=Delivery::getPickPointPrice('admin',Funcs::$uri[3]);
		//$data['data']['pickpoint']['list']=Delivery::getPickPointList('admin',Funcs::$uri[3]);
		print View::getPluginEmpty('delivery/delivery',$data);
	}
	public static function setDeliveryPrice($id,$deliveryprice){
		$sql='UPDATE {{orders}} SET deliveryprice='.$deliveryprice.' WHERE id='.$id.'';
		DB::exec($sql);
	}
	public static function getDeliveryPrice($what=''){
		$deliveryprice=0;
		if($_POST['delivery']=='Курьером по Москве'){
			if($what=='site'){
				return Delivery::getMoscowPrice();
			}else{
				print Delivery::getMoscowPrice();
			}
		}elseif($_POST['delivery']=='Курьером DPD'){
			if($what=='site'){
				return Delivery::getDPDPrice($what);
			}else{
				print Delivery::getDPDPrice($what,Funcs::$uri[3]);
			}
		}elseif($_POST['delivery']=='Самовывозом DPD'){
			if($what=='site'){
				return Delivery::getDPDPointPrice($what);
			}else{
				print Delivery::getDPDPointPrice($what,Funcs::$uri[3]);
			}
		}elseif($_POST['delivery']=='PickPoint'){
			if($what=='site'){
				return Delivery::getPickPointPrice($what);
			}else{
				print Delivery::getPickPointPrice($what,Funcs::$uri[3]);
			}
		}
	}
	public static function getMoscow($what){
		$deliveryprice=300;
		if($what=='site'){
			$order=Basket::getOrder();
		}else{
			$model=new Orders;
			$order=$model->getOrderById($_POST['id']);
		}
		if($order['sum']>3500){
			$deliveryprice=0;
		}
		return $deliveryprice;
	}
	public static function getB2C($what){
		$deliveryprice=0;
		$data=Delivery::getB2CpreOrder($what,$_POST['zip']);
		if($what=='site'){
			if($_POST['deliveryoptions']=='B2C пвз') $name='пвз';
			else $name='Курьерская доставка';
		}else{
			
		}
		foreach($data['delivery_ways'] as $item){
			if($item['Наименование']==$name){
				$deliveryprice=$item['Стоимость'];
			}
		}
		return $deliveryprice;
		
	}
	public static function getB2CpreOrder($what,$zip=''){
		$weight=0;
		if($what=='site'){
			$order=Basket::getOrder();
		}else{
			$model=new Orders;
			$order=$model->getOrderById($_POST['id']);
		}
		foreach($order['goods'] as $item){
			$weight+=$item['info']['weight']*$item['num'];
		}
		$path='http://is.b2cpl.ru/portal/client_api.ashx?client='.B2Cclient.'&key='.B2Ckey.'&func=tarif&zip='.$zip.'&weight='.$weight.'';
		$json=file_get_contents($path);
		$json=iconv("windows-1251", "utf-8",  $json);
		$data=json_decode($json, true);
		foreach($data['delivery_ways'] as $key=>$item){
			if($order['deliveryoptions']=='B2C '.$item['Наименование']) $data['delivery_ways'][$key]['checked']='checked';
		}
		return $data;
	}
	public static function getB2Cdownload($code){
		$data='Номер накладной;Номер посылки;Номер клиента;Дата заказа;Индекс;Город;Адрес;ФИО;Телефон мобильный;Телефон дополнительный;e-mail;';
		$data.='Вес посылки;Полная стоимость доставки;Стоимость доставки к оплате;Товар;Кол-во ед. товара;Полная стоимость ед. товара;';
		$data.='Стоимость ед. товара к оплате;Вес товара;Тип доставки;Доставка авиа;Хрупкий товар;Оценочная стоимость посылки;Код b2c;Условия доставки';
		$data.="\r\n";
		$sql='SELECT id FROM {{orders}} WHERE MD5(CONCAT(\'order\',id))=\''.$code.'\'';
		$id=DB::getOne($sql);
		$order=Orders::getOrderById($id);
		foreach($order as $key=>$word){
			if(!is_array($word)){
				$order[$key]=str_replace(';','',$word);
			}
		}
		$weight=0;
		foreach($order['goods'] as $item){
			$weight+=$item['info']['weight']*$item['num'];
		}
		if($option['deliveryoptions']=='B2C пвз') $type='пвз';
		else $type='курьер';
		$number=1;
		foreach($order['goods'] as $i=>$item){
			foreach($item as $key=>$word){
				if(!is_array($word)){
					$item[$key]=str_replace(';','',$word);
				}
			}
			if($i==0){
				$data.=$order['id'].';';//Номер накладной
			}else{
				$data.=';';
			}
			$data.=$order['id'].';';//Номер посылки
			if($i==0){
				$data.=$order['iuser'].';';//Номер клиента
				$data.=date('d.m.Y',strtotime($order['cdate'])).';';//Дата заказа
				$data.=$order['zip'].';';//Индекс
				$data.=$order['city'].';';//Город
				$data.=$order['address'].';';//Адрес
				$data.=$order['name'].';';//ФИО
				$data.=$order['phone'].';';//Телефон мобильный
				$data.=$order['unknown'].';';//Телефон дополнительный
				$data.=$order['email'].';';//e-mail
				$data.=$weight.';';//Вес посылки
				$data.=$order['deliveryprice'].';';//Полная стоимость доставки
				$data.='0'.';';//Стоимость доставки к оплате
			}else{
				$data.=';;;;;;;;;;;;';
			}
			$data.=$item['name'].';';//Товар
			$data.=$item['num'].';';//Кол-во ед. товара
			$data.=$item['price']*$item['num'].';';//Полная стоимость ед. товара
			$data.='0'.';';//Стоимость ед. товара к оплате
			$data.=$item['info']['weight']*$item['num'].';';//Вес товара
			if($i==0){
				$data.=$type.';';//Тип доставки
				$data.=';';//Доставка авиа
				$data.=';';//Хрупкий товар
				$data.=';';//Оценочная стоимость посылки
				$data.=';';//Код b2c
				$data.=$order['message'].';';//Условия доставки
			}else{
				$data.=';;;;;;';
			}
			if($i<count($order['goods'])-1)$data.="\r\n";
		}
		header('Accept-Ranges: bytes');
		header('Connection: keep-alive');
		header('Content-Length: '.strlen($data));
		header('Content-type: application/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="'.$code.'.csv"');
		print $data;
		//print iconv("utf-8", "windows-1251", $data);
		die;
	}
	public static function getB2Cupload(){
		//$file='http://'.$_SERVER['HTTP_HOST'].'/u/export1.csv';
		$file='http://'.$_SERVER['HTTP_HOST'].'/orders/download/'.md5('order'.$_GET['id']).'/'.md5('order'.$_GET['id']).'.csv';
		$path='http://is.b2cpl.ru/portal/client_api.ashx?client='.B2Cclient.'&key='.B2Ckey.'&func=upload&file='.$file.'&report=0&stickers=1';
		$json=file_get_contents($path);
		$data=json_decode($json, true);
		$postal=serialize($data);
		$sql='
			UPDATE {{orders}}
			SET
				postaldate=\''.date('Y-m-d').'\',
				postal=\''.$postal.'\'
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
		return $data;
	}
	public static function getTMStreem($what){
		$deliveryprice=0;
		if($what=='site'){
			$order=Basket::getOrder();
			$arrField='goods';
		}else{
			$model=new Orders;
			$order=$model->getOrderById($_POST['id']);
			$arrField='items';
		}
		$zone=0;
		foreach(Funcs::$regions as $item){
			if($_POST['region']==$item['name'])$zone=$item['path'];
		}
		if($zone>0){
			foreach($order[$arrField] as $item){
				$zprice500=Funcs::$reference['tmstream']['p'.$zone.'_500']['value'];
				$zprice=Funcs::$reference['tmstream']['p'.$zone]['value'];
				$subprice=0;
				if($item['subprice']>0){
					$subprice=$item['subprice']*Funcs::$reference['tmstream']['subprice']['value']*$item['num'];
				}
				$deliveryprice+=($zprice500+$zprice*(ceil($item['weight']/500)-1)+Funcs::$reference['tmstream']['koef']['value'])*$item['num']+$subprice;
			}
		}
		return $deliveryprice;
	}
	public static function getPickPointList($what,$orderid=0){
		$data=array();
		return $data;
	}
	public static function getPickPointPrice($what,$orderid=0){
		$deliveryprice=0;
		$delivery=Delivery::getParcel($what,$orderid);
		$deliveryprice=DPD::getPrice($delivery['data'],$delivery['address']);
		return $deliveryprice;
	}
	public static function getDPDPointList($what,$orderid=0){
		$data=array();
		if($what=='site'){
			$data=DPD::getList($_SESSION['iuser']['address'][0]['region']);
		}else{
			$sql='SELECT * FROM {{orders}} WHERE id='.$orderid;
			$order=DB::getRow($sql);
			if($order['address']){
				$order['address']=unserialize($order['address']);
			}
			$data=DPD::getList($order['address']['region']);
		}
		return $data;
	}
	public static function getDPDPointPrice($what,$orderid=0){
		$deliveryprice=0;
		$delivery=Delivery::getParcel($what,$orderid);
		$cashe='getDPDPointPrice'.serialize($delivery['data']).serialize($delivery['address']);
		if(!Cache::getDB($cashe)){
			$deliveryprice=DPD::getPrice($delivery['data'],$delivery['address'],true);
			Cache::setDB($cashe,$deliveryprice);
		}else{
			$deliveryprice=Cache::getDB($cashe);
		}
		return $deliveryprice;
	}
	public static function getDPDPrice($what,$orderid=0){
		$deliveryprice=0;
		$delivery=Delivery::getParcel($what,$orderid);
		$cashe='getDPDPrice'.serialize($delivery['data']).serialize($delivery['address']);
		if(!Cache::getDB($cashe)){
			$deliveryprice=DPD::getPrice($delivery['data'],$delivery['address']);
			Cache::setDB($cashe,$deliveryprice);
		}else{
			$deliveryprice=Cache::getDB($cashe);
		}
		return $deliveryprice;
	}
	public static function getMoscowPrice(){
		$deliveryprice=0;
		if($_SESSION['order']['sum']<Funcs::$reference['delivery']['free']['value']){
			$deliveryprice=Funcs::$reference['delivery']['courier']['value'];
		}
		return $deliveryprice;
	}
	public static function getMOPrice(){
		$deliveryprice=0;
		if($_SESSION['order']['sum']<Funcs::$reference['delivery']['free']['value']){
			$deliveryprice=Funcs::$reference['delivery']['couriermo']['value'];
		}
		return $deliveryprice;
	}
	public static function getMultishipPrice($what,$orderid=0){
		$deliveryprice=0;
		$delivery=Delivery::getParcel($what,$orderid);
		$cashe='multiship'.serialize($delivery['data']).serialize($delivery['address']);
		if(!Cache::getDB($cashe)){
			$deliveryprice=MultishipDelivery::getDeliveryPrice($delivery['data'],$delivery['address']);
			Cache::setDB($cashe,$deliveryprice);
		}else{
			$deliveryprice=Cache::getDB($cashe);
		}
		return $deliveryprice;
	}
	public static function getParcel($what,$orderid=0){
		$data=array(
			'volume'=>0,
			'weight'=>0,
			'height'=>0,
			'width'=>0,
			'length'=>0
		);
		if($what=='site'){
			$order=Basket::getOrder();
			$arrField='goods';
			$data=array(
				'volume'=>0,
				'weight'=>0,
			);
			foreach($order[$arrField] as $item){
				if($item['set']==true){
					foreach($item['goods'] as $goods){
						$temp=Catalog::getArticle($goods['sizeId']);
						$data['volume']+=$temp['height']*$temp['width']*$temp['length'];
						$data['weight']+=$temp['weight'];
						if($temp['width']>$data['width'])$data['width']=$temp['width'];
						if($temp['length']>$data['length'])$data['length']=$temp['length'];
						$data['height']+=$temp['height'];
					}
				}else{
					$temp=Catalog::getArticle($item['sizeId']);
					$data['volume']+=$temp['height']*$temp['width']*$temp['length'];
					$data['weight']+=$temp['weight'];
					if($temp['width']>$data['width'])$data['width']=$temp['width'];
					if($temp['length']>$data['length'])$data['length']=$temp['length'];
					$data['height']+=$temp['height'];
				}
			}
			$data['volume']=$data['volume']/1000000;
			$data['weight']=$data['weight']/1000;
			$address=Region::getCity($_SESSION['iuser']['address'][0]['city']);
		}else{
			$order=Orders::getOrderById($orderid);
			foreach($order['goods'] as $item){
				$temp=Goods::getSizeByName($item['tree'],$item['size']);
				$data['volume']+=$temp['height']*$temp['width']*$temp['length'];
				$data['weight']+=$temp['weight'];
				if($temp['width']>$data['width'])$data['width']=$temp['width'];
				if($temp['length']>$data['length'])$data['length']=$temp['length'];
				$data['height']+=$temp['height'];
			}
			$data['volume']=$data['volume']/1000000;
			$data['weight']=$data['weight']/1000;
			$address=IuserAddress::getCity($order['address']['city']);
		}
		return array('data'=>$data,'address'=>$address);
	}
}
?>