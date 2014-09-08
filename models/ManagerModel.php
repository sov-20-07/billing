<?
class Manager{
	public static function redirect(){
		if($_GET['redirect']){
			header('Location:'.$_GET['redirect']);
		}else{
			header('Location:/manager/');
		}
	}
	public static function getManagerList(){
		$data=array();
		$sql='
			(
				SELECT {{tree}}.id, \'tree\' AS what, {{tree}}.mdate AS udate  FROM {{tree}}
				INNER JOIN {{catalog}} ON {{tree}}.id={{catalog}}.tree
				WHERE (({{catalog}}.rejected=\'\' AND {{tree}}.visible=0) OR ({{catalog}}.status=\'salereq\')) AND filecover<>\'\'
				ORDER BY {{tree}}.mdate DESC
			)UNION(
				SELECT id, \'orders\' AS what, cdate AS udate FROM {{orders}}
				WHERE status!=\'done\' AND  status!=\'cancel\'
				ORDER BY cdate DESC
			)
			ORDER BY udate DESC
			LIMIT 0,10
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			if($item['what']=='tree'){
				$data[]=Catalog::getOne($item['id']);
			}elseif($item['what']=='orders'){
				$data[]=Orders::getOne($item['id']);
			}
		}
		return $data;
	}
	public static function getManagerBooks(){
		$data=array();
		$sql='
			SELECT {{tree}}.id, \'tree\' AS what, {{tree}}.mdate AS udate  FROM {{tree}}
			INNER JOIN {{catalog}} ON {{tree}}.id={{catalog}}.tree
			WHERE (({{catalog}}.rejected=\'\' AND {{tree}}.visible=0) OR ({{catalog}}.status=\'salereq\')) AND filecover<>\'\'
			ORDER BY {{tree}}.mdate DESC
		';
		$list=DB::getPagi($sql);
		foreach($list as $item){
			$data[]=Catalog::getOne($item['id']);
		}
		return $data;
	}
	public static function getManagerOrders(){
		$data=array();
		$status='';
		if($_GET['status'] && $_GET['status']!='all')$status=' WHERE status=\''.$_GET['status'].'\' '; 
		$sql='
			SELECT id, cdate FROM {{orders}}
			'.$status.'
			ORDER BY cdate DESC
		';
		$list=DB::getPagi($sql);
		foreach($list as $item){
			$data[]=Orders::getOne($item['id']);
		}
		return $data;
	}
	public static function cancelOrder($id){
		$sql='
			UPDATE {{orders}}
			SET wdate=NOW(),
				status=\'cancel\'
			WHERE id='.$id.'
		';
		DB::exec($sql);
	}
	public static function setTosale($id){
		$sql='UPDATE {{catalog}} SET status=\'sale\' WHERE tree='.$id.'';
		DB::exec($sql);
	}
}
?>