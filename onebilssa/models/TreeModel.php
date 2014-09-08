<?
class Tree{
	public $tree=array();
	public static $treeArray=array();
	public static $treeArrayChild=array();
	public $left=0;
	public $hold='';
	function __construct(){
		
	}
	function getTree(){
		$data=array();
		$tree=array();
		$sql='SELECT * FROM {{tree}} ORDER BY num ASC';
		$list=DB::getAll($sql);
		foreach($list as $item){
			Tree::$treeArray[$item['parent']][$item['id']]=$item;
		}
		foreach(Tree::$treeArray[0] as $item){
			$item['sub']=Tree::getBranch($item['id']);
			$data[]=$item;
		}
		return $data;
	}
	function getBranch($parent){
		$data=array();
		if(count(Tree::$treeArray[$parent])>0){
			foreach(Tree::$treeArray[$parent] as $item){
				$item['sub']=Tree::getBranch($item['id']);
				$data[]=$item;
			}
		}
		return $data;
	}
	public function addTree(){
		Tree::saveSearch();
		$path=trim($_POST['path']);
		if($path=='')$path=$_POST['name'];
		$path=Funcs::Transliterate($path);
		$seo_title=trim($_POST['seo_title']);
		$seo_keywords=trim($_POST['seo_keywords']);
		$seo_description=trim($_POST['seo_description']);
		if(trim($_POST['seo_title'])=='')$seo_title=trim($_POST['name']);
		if(trim($_POST['seo_keywords'])=='')$seo_keywords=trim($_POST['name']);
		if(trim($_POST['seo_description'])=='')$seo_description=trim($_POST['name']);
		$udate=$_POST['udate'];
		if(trim($udate)=='')$udate=date("d.m.Y H:i:00");
		if(Funcs::$prop['saveto']=='1'){
			$sql='SELECT MAX(num) FROM {{tree}} WHERE parent='.$_POST['parent'].'';
			$num=DB::getOne($sql)+10;
		}else{
			$sql='UPDATE {{tree}} SET num=num+10 WHERE parent='.$_POST['parent'].'';
			DB::exec($sql);
			$num=10;
		}
		$sql='
			INSERT INTO {{tree}}
			SET
				parent='.$_POST['parent'].',
				name=\''.trim($_POST['name']).'\',
				path=\''.$path.'\',
				seo_title=\''.$seo_title.'\',
				seo_keywords=\''.$seo_keywords.'\',
				seo_description=\''.$seo_description.'\',
				udate=\''.date('Y-m-d H:i:s',strtotime($udate)).'\',
				cdate=NOW(),
				cuser='.$_SESSION['user']['id'].',
				site='.$_SESSION['OneSSA']['site'].',
				num='.$num.',
				search=1
		';
		return DB::exec($sql);
	}
	public function editTree($id=''){
		Tree::saveSearch();
		if($id=='')$id=$_POST['id'];
		$path=trim($_POST['path']);
		if($path=='')$path=$_POST['name'];
		$path=Funcs::Transliterate($path);
		$sql='
			UPDATE {{tree}}
			SET
				parent='.$_POST['parent'].',
				name=\''.trim($_POST['name']).'\',
				path=\''.$path.'\',
				seo_title=\''.trim($_POST['seo_title']).'\',
				seo_keywords=\''.trim($_POST['seo_keywords']).'\',
				seo_description=\''.trim($_POST['seo_description']).'\',				
				udate=\''.date('Y-m-d H:i:s',strtotime($_POST['udate'])).'\',
				cuser='.$_SESSION['user']['id'].'
			WHERE id='.$id.'
		';
		return DB::exec($sql);
	}
	public function getSort(){
		$sql='
			SELECT * FROM {{tree}}
			WHERE parent='.$_POST['id'].'
			ORDER BY num ASC
		';
		return DB::getAll($sql);
	}
	public static function getParents($id){
		if(!is_numeric($id))return array();
		$data[]=$id;
		$sql='SELECT parent FROM {{tree}} WHERE id='.$id.'';
		$parent=DB::getOne($sql);
		if($parent=='')$parent=0;
		else $data[]=$parent;
		while($parent!=0){
			$sql='SELECT parent FROM {{tree}} WHERE id='.$parent.'';
			$parent=DB::getOne($sql);
			$data[]=$parent;
			if($parent=='')$parent=0;
		}
		return $data;
	}
	public static function getChilds($id){
		if(empty(Tree::$treeArrayChild)){
			$sql='SELECT id,parent FROM {{tree}} ORDER BY num ASC';
			$list=DB::getAll($sql);
			foreach($list as $item){
				Tree::$treeArrayChild[$item['parent']][$item['id']]=$item;
			}
		}
		if(!empty(Tree::$treeArrayChild[$id])){
			foreach(Tree::$treeArrayChild[$id] as $item){
				$data[]=$item['id'];
				$data=array_merge($data,Tree::getChildsBranch($item['id']));
			}
			return array_unique($data);
		}else{
			return array();
		}
	}
	function getChildsBranch($parent){
		$data=array();
		if(count(Tree::$treeArrayChild[$parent])>0){
			foreach(Tree::$treeArrayChild[$parent] as $item){
				$data[]=$item['id'];
				$data=array_merge($data,Tree::getChildsBranch($item['id']));
			}
		}
		return $data;
	}
	public static function saveSearch($id=''){
		if($id=='')$id=$_POST['tree'];
		if($id=='')$id=$_POST['id'];
		if(is_numeric($id)){
			$sql='
				DELETE FROM {{search}}
				WHERE tree='.$id.'
			';
			DB::exec($sql);
			if($_POST['name']){
				$search=$id.' '.$_POST['name'].' '.$_POST['seo_title'].' '.$_POST['seo_description'].' '.$_POST['seo_keywords'];
				if(is_array($_POST['data'])){
					$search.=' '.implode(' ',$_POST['data']);
				}
				$search=str_replace('"','',str_replace("'",'',strtolower(trim(htmlspecialchars(strip_tags($search))))));
				if($search){
					$sql='
						INSERT INTO {{search}}
						SET tree='.$id.', name=\''.$_POST['name'].'\', search=\''.$search.'\'
					';
					DB::exec($sql);
				}
			}
		}
	}
	function getSearch(){
		$tree=array();
		$sql='SELECT * FROM {{search}} WHERE search LIKE \'%'.strtolower($_POST['q']).'%\' ORDER BY cdate DESC';
		$items=DB::getAll($sql);
		foreach($items as $item){
			$tree[]=$item;
		}
		return $tree;
	}
	public static function getPathToTree($id,$param=''){
		$sql='SELECT * FROM {{tree}} WHERE id='.$id.'';
		$row=DB::getRow($sql);
		if($param!=''){
			$path=$row[$param];
		}else{
			if($row['path']!='' && ($row['path']!='index' && $row['parent']!=0)){
				$path=$row['path'];
			}
		}
		$parent=$row['parent'];
		if($parent=='')$parent=0;
		while($parent!=0){
			$sql='SELECT parent,path FROM {{tree}} WHERE id='.$parent.'';
			$row=DB::getRow($sql);
			$parent=$row['parent'];
			if($parent=='')$parent=0;
			if($parent!=0){
				$path=$row['path'].'/'.$path;
			}
		}
		if($path){
			return '/'.$path.'/';
		}
	}
	public function getInfo($id){
		$sql='
			SELECT * FROM {{relations}}
			INNER JOIN {{modules}} ON {{modules}}.path={{relations}}.modul2
			WHERE {{relations}}.modul1=\'tree\' AND {{relations}}.id1='.$id.' AND {{relations}}.id2<>0
		';
		return DB::getRow($sql);
	}
}
?>