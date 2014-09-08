<?
class DealersRegion {
	public static function getRegions(){
		$data=array();
		$sql='SELECT * FROM {{regions}} WHERE visible=1 AND parent=0 ORDER BY name';
		$list=DB::getAll($sql);
		foreach ($list as $item){
			$data[]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'value'=>$item['value'],
				'regionCode'=>$item['regionCode'],
			);
		}
		return $data;
	}
	public static function getCities($id){
		$data=array();
		$sql='SELECT DISTINCT name FROM {{regions}} WHERE visible=1 AND parent='.$id.' ORDER BY name';
		$list=DB::getAll($sql);
		foreach($list as $item2){
			$data[]=array(
				'name'=>$item2['name']
			);
		}
		return $data;
	}
	public static function getCity($name){
		$data=array();
		$sql='SELECT * FROM {{regions}} WHERE visible=1 AND parent<>0 AND name=\''.$name.'\'';
		$data=DB::getRow($sql);
		return $data;
	}
	public static function getRegionName($id){
		$sql='SELECT name FROM {{regions}} WHERE visible=1 AND parent=0 AND id='.$id.'';
		return DB::getOne($sql);
	}
}
?>
