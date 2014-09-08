<?
class Statistic{
	public static $deliveries=array('Самовывоз','Доставка по Москве','ТМ Стрим','Доставка B2C');
	public static function getStatistic($what){
		$data=Statistic::getOrders();
		return array('list'=>$data);
	}
	public static function getOrders(){
		$data=array();
		$sql='SELECT MAX(cdate) AS maxdate, MIN(cdate) AS mindate FROM {{orders}} WHERE status=\'done\'';
		$dates=DB::getRow($sql);
		for($i=date('Y',strtotime($dates['mindate']));$i<=date('Y',strtotime($dates['maxdate']));$i++){
			for($num=0;$num<12;$num++){
				$db=date('Y-m-d 00:00:01', strtotime($i.'-'.str_repeat('0',2-strlen($num+1)).($num+1).'-01 00:00:01'));
				$de=date('Y-m-d 00:00:01', strtotime($i.'-'.str_repeat('0',2-strlen($num+1)).($num+1).'-01 00:00:01 +1 month'));
				$sql='SELECT SUM(price) FROM {{orders}} WHERE status=\'done\' AND (cdate BETWEEN \''.$db.'\' AND \''.$de.'\' )';
				$sum=DB::getOne($sql);
				if($sum!=''){
					$data[$i][str_repeat('0',2-strlen($num+1)).($num+1)]=array('name'=>Funcs::$monthsRusB[$num],'sum'=>$sum);
				}
			}
		}
		return $data;
	}
}
?>