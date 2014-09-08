<?
require_once $_SERVER['DOCUMENT_ROOT'].'/plugins/Orders/lib/dpd.php';
class DPD{
	public static function getPrice($item,$address,$self='false'){
		$DPD=new DPD_service;
		$arData = array(
			'delivery' => array(
				'cityId' => $address['cityId'],
				'cityName' => $address['name'],
			),
			'volume' => $item['volume'],
			'weight' => $item['weight'],
			'selfPickup'=>$self,
			//'selfDelivery'=>'true'
		);
		$cost = $DPD->getServiceCost($arData);
		$min=1000000;
		foreach($cost as $item){
			if($min>$item['cost'])$min=$item['cost'];
		}
		$x=-1;
		foreach($cost as $i=>$item){
			if($min==$item['cost'])$x=$i;
		}
		//print $cost[$x]['cost'].'*'.(int)Funcs::$reference['delivery']['risk']['value'].'<br>';
		$cost[$x]['cost']=round($cost[$x]['cost']*(float)Funcs::$reference['delivery']['risk']['value']);
		return $cost[$x];
	}
	public static function getList($region){
		if($region){
			$sql='SELECT * FROM {{terminals}} WHERE region='.$region.'';
			return DB::getAll($sql);
		}else{
			return array();
		}
	}
	public static function updateTerminals(){
		$data=array();
		$DPD=new DPD_service;
		try{
			$arTerminalsList = $DPD->getTerminalsSelfDelivery();
			//print '<pre>';print_r($arTerminalsList);die;			
			$i=0;
			$errors;
			$sql='UPDATE {{terminals}} SET visible=0 AND company=\'DPD\'';
			DB::exec($sql);
			foreach($arTerminalsList as $item){
				$sql='SELECT id FROM {{terminals}} WHERE code=\''.$item['terminal']['terminalCode'].'\'';
				$id=DB::getOne($sql);
				if(!$id){
					$temp['terminalCode'] = iconv('windows-1251','utf-8',$item['terminal']['terminalCode']);
					$temp['terminalName'] = iconv('windows-1251','utf-8',$item['terminal']['terminalName']);
					$temp['terminalAddress'] = iconv('windows-1251','utf-8',$item['terminal']['terminalAddress']);
					$cityId='';
					$regionId='';
					$sql='SELECT id FROM {{regions}} WHERE cityId='.$item['city']['cityId'].'';
					$cityId=DB::getOne($sql);
					$sql='SELECT id FROM {{regions}} WHERE regionCode='.$item['city']['regionCode'].'';
					$regionId=DB::getOne($sql);
					if($cityId && $regionId){
						$sql='
							INSERT INTO {{terminals}} 
							SET 
								region='.$regionId.',
								city=\''.$cityId.'\',
								code=\''.$temp['terminalCode'].'\',
								name=\''.$temp['terminalName'].'\',
								address=\''.$temp['terminalAddress'].'\',
								company=\'DPD\',
								visible=1
						';
						DB::exec($sql);
					}else{
						$i++;
						$errors[]=$item['regionName'];
					}
				}else{
					$sql='UPDATE {{terminals}} SET visible=1 WHERE code=\''.$item['terminal']['terminalCode'].'\'';
					DB::exec($sql);
				}
			}
			//print 'Ошибок :'.$i;
			//print '<pre>'; print_r($errors);
		}catch (Exception $e) {
			print '<pre>';print_r($e);
		}
	}
	public static function updateCities(){
		$data=array();
		$DPD=new DPD_service;
		try{
			$arCityList = $DPD->getCityList();
			$i=0;
			$errors;
			foreach($arCityList as $item){
				$item['cityName'] = iconv('windows-1251','utf-8',$item['cityName']);
				$item['regionName'] = iconv('windows-1251','utf-8',$item['regionName']);
				$sql='SELECT * FROM one_regions WHERE name LIKE \'%'. $item['regionName'].'%\'';
				$res=mysql_query($sql);
				$row=mysql_fetch_assoc($res);
				print $row['id'].' '.$row['name'].' '.$item['regionName'].'<br>';
				print $item['cityName'].'<br><hr>';
				$sql='SELECT * FROM one_regions WHERE name LIKE \'%'. $item['cityName'].'%\'';
				$res=mysql_query($sql);
				$city=mysql_fetch_assoc($res);
				if(!$city){
					$sql='
						INSERT INTO one_regions 
						SET 
							parent=\''.$row['id'].'\',
							name=\''.$item['cityName'].'\',
							cityId=\''.$item['cityId'].'\',
							visible=1
					';
					mysql_query($sql);
				}
				/*$sql='
					UPDATE one_regions 
					SET regionCode=\''.$item['regionCode'].'\'
					WHERE id='.$row['id'].'
				';
				mysql_query($sql);*/
				if(!$row){
					$i++;
					$errors[]=$item['regionName'];
				}
			}
			print 'Ошибок :'.$i;
			print '<pre>'; print_r($errors);
		}catch (Exception $e) {
			print '<pre>';print_r($e);
		}
	}
}
?>