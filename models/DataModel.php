<?
class Data{
	public static $Vendors=array();
	public static $card='';
	public function __construct(){
		self::$Vendors=$this->getVendorName();
	}
	public static function getVendorName(){
		$data=array();
		$sql='SELECT id, name FROM {{tree}} WHERE parent=8 AND visible=1';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[$item['id']]=$item['name'];
		}
		return $data;
	}
}
new Data;
?>