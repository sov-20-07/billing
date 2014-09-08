<?
class Market{
	public static $catalogStandart=array('art','model','description','yandex_description','price','subprice','currencyId','type','vendor','typePrefix','stock','available','bid','cbid','manufacturer_warranty','rating','popularity');
	function __construct(){
		
	}
	public function getList(){
		$start = microtime(true);
		$data=array('list'=>array(),'categories'=>array());
		$parentIds=array();
		$sql='
			SELECT DISTINCT {{catalog}}.*, {{tree}}.* FROM {{catalog}}
			INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
			WHERE {{catalog}}.market=1 AND {{catalog}}.price>0 AND {{tree}}.visible=1 AND available=1
			ORDER BY num
		';
		//print DB::prefix($sql);
		$catalog=DB::getPagi($sql);
		$fields=Fields::getReserveFieldsByModulePath($tab);
		$k=1;
		
		$date_b=explode('.', Funcs::$conf['akcia']['date_begin']);
		$date_e=explode('.', Funcs::$conf['akcia']['date_end']);
		$date_b=mktime(0,0,0,$date_b[1], $date_b[0],$date_b[2]);
		$date_e=mktime(23,59,59,$date_e[1], $date_e[0],$date_e[2]);
		$today=mktime();
		$yes=0;
		if (($today>=$date_b)&&($today<=$date_e))
		$yes=1;
		
		foreach($catalog as $i=>$model){
		$akcia='0';
		//if ($yes==1)
		//$akcia=$model['akcia'];
		
			$data['list'][]=array(
				'id'=>$model['id'],
				'parent'=>$model['parent'],
				'fields'=>Fields::getFieldsByTree($model['tree'],'wide'),
				'name'=>Market::clearInfo($model['name']),
				'path'=>Catalog::getPathToTree($model['tree']),
				'available'=>$model['available'],
				'bid'=>$model['bid'],
				'akcia'=>$akcia,
				'cbid'=>$model['cbid'],
				'typePrefix'=>$model['typePrefix'],
				'vendor'=>Funcs::$referenceId['vendor'][$model['vendor']]['name'],
				'yandex_description'=>Market::clearInfo($model['yandex_description']),
				'price'=>$model['price'],
				'local_delivery_cost'=>$model['price']<4000?'200':'0',
				'manufacturer_warranty'=>$model['manufacturer_warranty'],
			);
			$parentIds[]=$model['parent'];
			$k++;
			//echo $k.' Время выполнения скрипта '.(microtime(true) - $start).'<br />';
		}
		$parentIds=array_unique($parentIds);
		if(count($parentIds)>0){
			$sql='
				SELECT * FROM {{tree}} WHERE id IN ('.implode(',',$parentIds).')
			';
			$list=DB::getAll($sql);
			$parentIds=array();
			foreach($list as $item){
				$data['categories'][]=array(
					'id'=>$item['id'],
					'parent'=>$item['parent'],
					'name'=>$item['name'],
				);
				$parentIds[]=$item['parent'];
			}
			if(count($parentIds)>0){
				$sql='
					SELECT * FROM {{tree}} WHERE id IN ('.implode(',',$parentIds).')
				';
				$list=DB::getAll($sql);
				foreach($list as $item){
					$data['categories'][]=array(
						'id'=>$item['id'],
						'name'=>$item['name'],
					);
				}
				
			}
		}
		return $data;
	}
	function clearInfo($info) {
		$info = str_replace("&nbsp;","",$info);
		$info = str_replace("&quot;","",$info);
		$info = str_replace("&ndash;","",$info);
		$info = str_replace("&lt;","",$info);
		$info = str_replace("&middot;","",$info);
		$info = str_replace("&laquo;","",$info);
		$info = str_replace("&raquo;","",$info);
		$info = str_replace("&euro;","",$info);
		$info = str_replace("&mdash;","",$info);
		$info = str_replace("&gt;","",$info);
		$info=str_replace("<"," <",$info);
		$info=strip_tags($info);
		$info = str_replace('\n','',$info);
		$info = str_replace('\r','',$info);
		$info = str_replace('\t','',$info);
		$info = str_replace('&','&amp;',$info);
		$info = htmlspecialchars(strip_tags(trim($info)));
		return $info;		
	}
}
?>