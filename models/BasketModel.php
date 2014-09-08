<?
class Basket{
	public static function addToBasket($show=true){
		$num=0;
		$id=$_POST['id'];
		$num=$_POST['num'];
		$goods=Catalog::getOne($id);
		$_SESSION['goods'][$id]['price']=Basket::getPrice($goods,$num);
		$_SESSION['goods'][$id]['id']=$id;
		$_SESSION['goods'][$id]['num']=$num;
		if($show==true){
			//$data=Basket::getSimpleOrder();
			Basket::getBasket();die;
			//die ($data['sum'].'_'.$data['goods']);
		}
	}
	public static function addListToBasket(){
		$num=0;
		foreach($_POST['id'] as $id){
			$num=$_POST['num'][$id];
			$goods=Catalog::getOne($id);
			$_SESSION['goods'][$id]['price']=Basket::getPrice($goods,$num);
			$_SESSION['goods'][$id]['id']=$id;
			$_SESSION['goods'][$id]['num']=$num;
		}
		$data=Basket::getSimpleOrder();
		die ($data['sum'].'_'.$data['goods']);
	}
	public static function getSimpleOrder(){
		$sum=0;
		if(count($_SESSION['goods'])>0){
			foreach($_SESSION['goods'] as $goods){
				$sum+=$goods['price']*$goods['num'];
			}
		}
		return array('sum'=>$sum,'goods'=>count($_SESSION['goods']));
	}
	public function credit(){
		
		if(!empty($_POST['col']) && $_POST['col'] == 'all'){
			foreach($_SESSION['goods'] as $k=>$v){
				$summ += $v['price']*$v['num'];
				$num += $v['num'];				
			}
			$_SESSION['credit']['summ'] = $summ;
			$_SESSION['credit']['num'] = $num;
			
			$_SESSION['credit']['item_id'] = 'all';
				
		}else{
			$num=0;
			$id=$_POST['id'];
			$num=$_POST['num'];
			$goods=Catalog::getOne($id);	
			//print(intval($goods['price']/10) * $num);		
			//$_SESSION['credit']['summ'] = (intval($goods['price']/10) * $num);
			$_SESSION['credit']['summ'] = $goods['price'] * $num;
			$_SESSION['credit']['num'] = $num;
			$_SESSION['credit']['item_id'] = $id;			
		}
		
	}
	public function getOrder(){
		$data=array();
		$sum=0;
		$count=0;
		$sale=0;
		if(count($_SESSION['goods'])>0){
			foreach($_SESSION['goods'] as $key=>$item){
				$goods=Catalog::getOne($key);
				$sum+=$item['price']*$item['num'];
				$sale+=($goods['price']-$item['price'])*$item['num'];
				$count++;
				$goods['sale']=($goods['price']-$item['price'])*$item['num'];
				$goods['realprice']=$goods['price'];
				$goods['total']=$item['price']*$item['num'];
				$goods['num']=$item['num'];
				$goods['price']=$item['price'];				
				$data['goods'][$key]=$goods;
			}
			$data['sum']=$sum;
			$data['count']=$count;
			$data['sale']=$sale;
			return $data;
		}else{
			return array();
		}
	}
	public function sendNum($id, $num){
		$_SESSION['goods'][$id]['num']=$num;
		$goods=Catalog::getOne($id);
		//$_SESSION['goods'][$id]['price']=Basket::getPrice($goods,$num);
		$order=$this->getOrder();
		$text='';
		$text.=$id.';';
		$text.=number_format($order['sum'],0,',',' ').';'; //1. общая сумма
		$text.=number_format($_SESSION['goods'][$id]['price']*$num,0,',',' ').';'; //2. сумма товара
		$text.=$order['goods'][$id]['num'].';'; //3. кол-во товара
		$text.=number_format($order['goods'][$id]['total'],0,',',' ').';'; //4. итого
		$text.=number_format($_SESSION['goods'][$id]['price'],0,',',' ').';'; //5. цена товара
		$text.=number_format(($goods['price']-$_SESSION['goods'][$id]['price'])*$num,0,',',' ').';'; //6. скидка на товар
		$text.=number_format($order['sale'],0,',',' '); //7. общая скидка
		
		print $text;
	}
	public function delGoods($id){
		if(count($data)==1){
			unset($_SESSION['goods'][$id]);
		}else{
			unset($_SESSION['goods'][$id]);
		}
		$order=$this->getOrder();
		if(count($_SESSION['goods'])==0){
			die('empty');
		}else{
			print $id.';'.number_format($order['sum'],0,',',' ').';'.number_format($_SESSION['goods'][$id]['price']*$num,0,',',' ').';'.$order['goods'][$id]['num'].';'.number_format($order['goods'][$id]['total'],0,',',' ');
		}
	}
	function toSuperClick(){
		Funcs::escapePost();
		//if($_SESSION['iuser']){
			//$_SESSION['mydata']['name']=$_SESSION['iuser']['name'];
			//$_SESSION['mydata']['email']=$_SESSION['iuser']['email'];
			$_SESSION['mydata']['phone']=$_POST['phone'];
			//$_SESSION['mydata']['address']=$_SESSION['iuser']['address'];
		//}
		Basket::addToBasket(false);
		$this->toOrder();
	}
	function setPurchase(){
		Funcs::escapePost();
		$_SESSION['mydata']['name']=$_POST['name'];
		$_SESSION['mydata']['email']=$_POST['email'];
		$_SESSION['mydata']['phone']=$_POST['phone'];
		$_SESSION['mydata']['address']=($_POST['city']=='1'?'Москва':$_POST['city_name']).', '.$_POST['address'];
		$_SESSION['mydata']['delivery']=$_POST['delivery'];
		$_SESSION['mydata']['payment']=$_POST['payment'];
		$_SESSION['mydata']['city']=$_POST['city'];
		$this->toOrder();
	}
	function toOrder($iuserId=0,$id='', $send=true){
		if($id==''){
			$id=$this->saveBasket();
		}
		View::$layout='empty';
		$data=$this->getOrder();
		$data['id']=$id;
		$data['hits']=Index::getHits();
		$text=View::getRender('basket/mail',$data);
		$textadmin=View::getRender('basket/mailadmin',$data);
		$info=View::getRender('basket/mailinfo');
		$code='';
		/*if($info!='Наличными'){
			$_SESSION['code']=rand(1,9999);
			$code='<br /><br /><b>Код подтверждения:<b/> '.$_SESSION['code'];
		}*/
		$this->saveBasket($id,$text,$data,$info,$iuserId);
		if ($send){
			$mail = new Email;
			$mail->Text($textadmin);
			$mail->Subject('Поступил заказ с сайта www.'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
			$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
			$mail->To(Funcs::$conf['email']['order']);
			$mail->Send();			
			
			if($_SESSION['mydata']['email']){
				$data['client']=1;
				$text=View::getRender('basket/mail',$data);
				$info=View::getRender('basket/mailinfo');
				$mail = new Email;
				$mail->Text($text);
				$mail->Subject('Вы оставили заказ на сайте www.'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
				$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
				$mail->mailTo($_SESSION['mydata']['email']);
				$mail->Send();
			}
		}
		if(SMSuser){
			file_get_contents('http://sms.spb.su/sms.cgi?user='.SMSuser.'&pass='.SMSpass.'&phone='.Funcs::$conf['additional']['sms'].'&flash=0&message='.urlencode(iconv('utf-8','windows-1251','Заказ '.$id.' '.$_SESSION['mydata']['name'].' '.$_SESSION['mydata']['phone'])).'&from='.$_SERVER['HTTP_HOST'].'');
		}
		$_SESSION['mydata']=array();
		$_SESSION['goods']=array();
		$_SESSION['orderId']=$id;
	}
	public static function getBasket(){
		print View::getRenderEmpty('basket/basketinc',Basket::getOrder());
	}
	function saveBasket($id=0,$text='',$data=array(),$info='',$iuserId=0){
		if($id==0){
			$sql='INSERT INTO {{orders}} SET cdate=NOW(), wdate=NOW(), fdate=NOW()';
			$id=DB::exec($sql);
		}else{
			$iuser='0';
			if($_SESSION['iuser']['id']>0){
				$iuser=$_SESSION['iuser']['id'];
			}elseif($_SESSION['mydata']['email']){
				$user=new User;
				$iuser=$user->setRegistration($_SESSION['mydata']);
			}
			$sql='
				UPDATE {{orders}}
				SET
					iuser='.$iuser.',
					name=\''.$_SESSION['mydata']['name'].'\',
					phone=\''.$_SESSION['mydata']['phone'].'\',
					email=\''.$_SESSION['mydata']['email'].'\',
					zip=\''.$_SESSION['mydata']['zip'].'\',
					region=\''.$_SESSION['mydata']['region'].'\',
					address=\''.$_SESSION['mydata']['address'].'\',
					delivery=\''.$_SESSION['mydata']['delivery'].'\',
					deliveryprice=\''.$_SESSION['mydata']['deliveryprice'].'\',
					deliveryoptions=\''.$_SESSION['mydata']['deliveryoptions'].'\',
					payment=\''.$_SESSION['mydata']['payment'].'\',
					info=\''.$_SESSION['mydata']['info'].'\',
					ordertext=\''.$text.'\',
					info=\''.$info.'\',
					message=\''.trim($_POST['message']).'\',
					price='.$data['sum'].',
					sale='.$data['sale'].',
					status=\'new\'
				WHERE id='.$id.'
			';
			DB::exec($sql);
			foreach($data['goods'] as $key=>$item){
				$sql='
					INSERT INTO {{orders_items}}
					SET 
						orders='.$id.',
						tree='.$key.',
						name=\''.$item['name'].'\',
						num='.$item['num'].',
						price='.$item['price'].',
						sale='.$item['sale'].'
				';
				DB::exec($sql);
			}
		}
		return $id;
	}
	public static function getMyData(){
		$data=array();
		$data[]=$_SESSION['mydata']['name'];
		if($_SESSION['mydata']['email'])$data[]=$_SESSION['mydata']['email'];
		$data[]=$_SESSION['mydata']['phone'];
		//if($_SESSION['mydata']['address'])$data[]=$_SESSION['mydata']['address'];
		return $data;
	}
	public static function setStep1(){
		Funcs::escapePost();
		$_SESSION['mydata']['name']=$_POST['name'];
		$_SESSION['mydata']['email']=$_POST['email'];
		$_SESSION['mydata']['phone']=$_POST['phone'];
		$_SESSION['mydata']['message']=$_POST['message'];
		$_SESSION['mydata']['registration']=$_POST['registration']==''?'':'checked';
		$_SESSION['mydata']['emailreport']=$_POST['emailreport']==''?'':'checked';
		$_SESSION['mydata']['smsreport']=$_POST['smsreport']==''?'':'checked';
		
	}
	public static function setStep2(){
		Funcs::escapePost();
		$_SESSION['mydata']['delivery']=$_POST['rgr1'];
		$_SESSION['mydata']['region']=$_POST['region'];
		$_SESSION['mydata']['address']=$_POST['address'];
		$_SESSION['mydata']['save']=$_POST['save'];
	}
	public static function setStep3(){
		Funcs::escapePost();
		$_SESSION['mydata']['payment']=$_POST['rgr2'];
	}
	public static function fail($id){
		$sql='DELETE FROM {{orders}} WHERE id='.$id;
		DB::exec($sql);
		$sql='DELETE FROM {{orders_items}} WHERE orders='.$id.'';
		DB::exec($sql);
	}
	public function getConfirm($id){		
		$sql='SELECT * FROM {{orders}} WHERE id='.$id.'';
		$data=DB::getRow($sql);
		$sql='SELECT * FROM {{orders_items}} WHERE orders='.$id.'';
		$data['goods']=DB::getAll($sql);
		$sum=0;
		$count=0;
		$sale=0;
		foreach($data['goods'] as $key=>$item){
			$goods=Catalog::getOne($item['tree']);
			$sum+=$item['price']*$item['num'];
			$sale+=($goods['price']-$item['price'])*$item['num'];
			$count++;
			$goods['sale']=$item['sale'];
			$goods['realprice']=$goods['price'];
			$goods['total']=$item['price']*$item['num'];
			$goods['num']=$item['num'];
			$goods['price']=$item['price'];
			$data['goods'][$key]=$goods;
		}
		$data['sum']=$sum;
		$data['count']=$count;
		$data['sale']=$sale;
		return $data;
	}
	public static function getRegion(){
		if($_SESSION['mydata']['region']){
			$region=$_SESSION['mydata']['region'];
		}else{
			$region=file_get_contents('http://geo.one-touch.ru?ip='.$_SERVER['REMOTE_ADDR']);
			$region=explode('<br>',$region);
			$region=explode('<br />',$region[2]);
			$region=str_replace('Регион: ','',$region[0]);
			foreach(Funcs::$referenceId['regions'] as $item){
				if(strpos($region,$item['name'])!==false){
					$region=$item['name'];
				}
			}
		}
		return $region;
	}
	public static function getPrice($goods,$num){
		if($_POST['sale']==md5('saleme'.$goods['id'])){
			return $goods['supprice'];
		}else{
			return $goods['price'];
		}
		/*if(count(Funcs::$reference['sales'])>0 && $_SESSION['iuser']){
			$price=0;
			$sales=explode(',',Funcs::$reference['sales'][$goods['parent']]['value']);
			$sales[]=1000000;
			if(count($sales)>1){
				foreach($sales as $i=>$item){
					if($sales[$i+1] && (int)$item<=$num && $num<(int)$sales[$i+1]){
						$price=$goods['price'.($i+1)];
					}
				}
			}else{
				$price=$goods['price'];
			}
			return $price;
		}else{
			return $goods['price'];
		}*/
	}
}
?>