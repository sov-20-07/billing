<?
class Extra{
	public static function getVendors($id){
		$data=array();
		$tree=Tree::getInfo($id);
		if(strpos($tree['modul2'],'catalog')!=='false'){
			$module=Module::getModuleByPath('catalog');
			$field=Fields::getFieldByModule($module['id'],'vendor');
			$params=explode('-',$field['params']);
			$sql='
				SELECT {{'.$params[0].'}}.* FROM {{'.$params[0].'}}
				INNER JOIN (
					{{catalog}} INNER JOIN {{tree}} t ON {{catalog}}.tree=t.id
				) ON {{'.$params[0].'}}.id={{catalog}}.vendor
				WHERE t.parent='.$id.'
			';
			//print DB::prefix($sql);
			$list=DB::getAll($sql);
			foreach($list as $item){
				$data[$item['id']]=$item['name'];
			}
		}
		return $data;
	}
	public static function getMarket($id){
		$data=array();
		$tree=Tree::getInfo($id);
		if(strpos($tree['modul2'],'catalog')!=='false'){
			$sql='SHOW COLUMNS FROM {{catalog}}';
			$cols=DB::getAll($sql);
			$x=0;
			foreach($cols as $item){
				if($item['Field']=='market')$x=1;
			}
			if($x){
				$ids=Tree::getChilds($id);
				$ids[]=$id;
				$sql='
					SELECT COUNT(*) FROM {{catalog}}
					WHERE tree IN ('.implode(',',$ids).') AND market=1
				';
				$m1=DB::getOne($sql);
				$sql='
					SELECT COUNT(*) FROM {{catalog}}
					WHERE tree IN ('.implode(',',$ids).') AND market=0
				';
				$m2=DB::getOne($sql);
				if($m1>=$m2) return 1;
				else return 0;
			}else{
				return 0;
			}
		}
		return 0;
	}
	public static $paramCategories=array();
	function __construct(){
		//Extra::$paramCategories=$this->getParamCategories();
	}
	public function getParamCategories(){
		$data=array();
		foreach(Funcs::$referenceId['paramCategories'] as $item){
			$temps=explode("\n",$item['value']);
			foreach($temps as $temp){
				$data[$item['name']][]=trim($temp);
			}
		}
		return $data;
	}
	public static function getDate($d){
		return date('d',strtotime($d)).' '.Forum::$mon[date('n',strtotime($d))].' '.date('Y',strtotime($d)).' в '.date('H:i',strtotime($d));
	}
}
?>