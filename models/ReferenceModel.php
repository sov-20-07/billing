<?
class Reference{
	public static $tree=array();
	public static $treeArray=array();
	public static $all=array();
	public static $smartTree=array();
	function getTree(){
		$data=array();
		$sql='SELECT * FROM {{reference}} WHERE visible=1 ORDER BY num ASC';
		$list=DB::getAll($sql);
		if(!empty($list)){
			foreach($list as $item){
				$sql='SELECT * FROM {{reference_files}} WHERE reference='.$item['id'].' ORDER BY name';
				$item['files']=DB::getAll($sql);
				Reference::$treeArray[$item['parent']][$item['id']]=$item;
				Reference::$all[$item['id']]=$item;
			}
			foreach(Reference::$treeArray[0] as $item){
				$item['sub']=Reference::getBranch($item['id']);
				$data[$item['path']]=$item;
				$item['sub']=Reference::getBranch($item['id'],true);
				$lastId[$item['path']]=$item;
			}
			Reference::$smartTree=$lastId;
		}
		Reference::$tree=$data;
	}
	function getBranch($parent,$last=false){
		$data=array();
		if(count(Reference::$treeArray[$parent])>0){
			foreach(Reference::$treeArray[$parent] as $item){
				$item['sub']=Reference::getBranch($item['id'],$last);
				if($last && count($item['sub'])==0){
					$data[$item['id']]=$item;
				}else{
					$data[$item['path']]=$item;
				}
			}
		}
		return $data;
	}
}
Reference::getTree();
?>