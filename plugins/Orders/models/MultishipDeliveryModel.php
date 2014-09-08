<?
define("MULTISHIP_DEBUG", true);
require_once $_SERVER['DOCUMENT_ROOT'].'/plugins/Orders/lib/multiship/multiship.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/plugins/Orders/lib/multiship/objects/request_delivery_list.php';
class MultishipDelivery{
	public static function getDeliveryPrice($data,$address){
		$multiship=array();
		$param=array(
			'city_from'=>'Москва',
			'city_to'=>$address['name'],
			'weight'=>$data['weight'],
			'height'=>$data['height'],
			'width'=>$data['width'],
			'length'=>$data['length'],
		);
		$ms_api = MultiShip::init();
		$MultiShip_RequestDeliveryList=new MultiShip_RequestDeliveryList;
		$MultiShip_RequestDeliveryList->city_from=$param['city_from'];
		$MultiShip_RequestDeliveryList->city_to=$param['city_to'];
		$MultiShip_RequestDeliveryList->weight=$param['weight'];
		$MultiShip_RequestDeliveryList->height=$param['height'];
		$MultiShip_RequestDeliveryList->width=$param['width'];
		$MultiShip_RequestDeliveryList->length=$param['length'];
		$data=$ms_api->searchDeliveryList($MultiShip_RequestDeliveryList);
		foreach($data->data as $item){
			if(!$item->pickuppoint_id){
				$multiship[$item->delivery_name]=array(
					'id'=>(int)$item->delivery_id,
					'delivery_name'=>(string)$item->delivery_name,
					'deliver_orient_day'=>(string)$item->deliver_orient_day,
					'cost'=>round((float)$item->cost),
					'price'=>round((float)$item->cost),
				);
			}else{
				$multiship['pickup'][$item->delivery_name][]=array(
					'id'=>(int)$item->delivery_id,
					'delivery_name'=>(string)$item->delivery_name,
					'deliver_orient_day'=>(string)$item->deliver_orient_day,
					'cost'=>round((float)$item->cost),
					'price'=>round((float)$item->cost),
					'location_name'=>(string)$item->location_name,
					'address'=>(string)$item->address,
					'instruction'=>(string)$item->instruction,
					'deliveryoptions'=>(string)$item->address.', '.(string)$item->instruction,
				);
			}
		}
		return $multiship;
		/*print '<pre>';
		print_r($data);
		foreach($data->data as $item){
			print $item->delivery_name.', цена: '.$item->cost.'руб., доставка:'.$item->deliver_orient_day.'<br>';
		}*/
	}
}
?>