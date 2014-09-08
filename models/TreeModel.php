<?
class Tree{
	public $tree=array();
	public static $treeArray=array();
	public $hold='';
	function __construct(){
		
	}
	//Найти страницу по url
	public function getTreeByUrl($option='',$uri=array()){
		if(count($uri)==0){
			$uri=Funcs::$uri;
		}
		$sql='SELECT * FROM {{tree}} WHERE parent=0';
		$item=DB::getRow($sql);
		$parent=$item['id'];
		if($uri[0]!=''){
			foreach($uri as $item){
				$path=$item;
				$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND path=\''.$path.'\'';
				$item=DB::getRow($sql);
				if(!$item && is_numeric($path)){
					$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND id='.$path.'';
					$item=DB::getRow($sql);
				}
				$parent=$item['id'];
			}
		}
		$item['fields']=Fields::getFieldsByTree($item['id'],$option);
		$item['info']=Tree::getInfo($item['id']);
		return $item;
	}
	public function getTreeById($id,$option=''){
		$sql='SELECT * FROM {{tree}} WHERE id='.$id;
		$item=DB::getRow($sql);
		$item['fields']=Fields::getFieldsByTree($id,$option);
		return $item;
	}
	public static function getIdTreeByModule($path){
		$sql='SELECT id1 FROM {{relations}} WHERE modul1=\'tree\' AND modul2=\''.$path.'\' AND id2=0';
		return DB::getOne($sql);
	}
	function getTree(){
		$tree=array();
		$sql='SELECT * FROM {{tree}} WHERE parent=0';
		$item=DB::getRow($sql);
		if($item){
			$item['sub']=$this->getRecur($item['id']);
			$tree[]=$item;
		}
		return $tree;
	}
	function getRecur($parent){
		$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' ORDER BY num ASC';
		$items=DB::getAll($sql);
		foreach($items as $item){
			$item['sub']=$this->getRecur($item['id']);
			$tree[]=$item;
		}
		return $tree;
	}
	public function getInfo($id){
		$sql='
			SELECT * FROM {{relations}}
			INNER JOIN {{modules}} ON {{modules}}.path={{relations}}.modul2
			WHERE {{relations}}.modul1=\'tree\' AND {{relations}}.id1='.$id.'
			ORDER BY id2
		';
		return DB::getRow($sql);
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
	public static function getChilds($id,$condition=''){
		if(empty(Tree::$treeArray)){
			$sql='SELECT id,parent FROM {{tree}} WHERE 1=1 '.$condition.' ORDER BY num ASC';
			$list=DB::getAll($sql);
			foreach($list as $item){
				Tree::$treeArray[$item['parent']][$item['id']]=$item;
			}
		}
		if(!empty(Tree::$treeArray[$id])){
			foreach(Tree::$treeArray[$id] as $item){
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
		if(count(Tree::$treeArray[$parent])>0){
			foreach(Tree::$treeArray[$parent] as $item){
				$data[]=$item['id'];
				$data=array_merge($data,Tree::getChildsBranch($item['id']));
			}
		}
		return $data;
	}
	public static function getPathToTree($id){
		$tree=Tree::getInfo($id);
		$params=explode(';',$tree['params']);
		$sql='SELECT * FROM {{tree}} WHERE id='.$id.'';
		$row=DB::getRow($sql);
		if($params[0]!=''){
			$sql='SELECT COUNT(*) FROM {{tree}} WHERE parent='.$id.'';
			$count=DB::getOne($sql);
			if($count==0){
				$path=$row[$params[0]];
			}else{
				$path=$row['path'];
			}
		}else{
			$path=$row['path'];
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
		}else{
			return '';
		}
	}
	function getSitemap(){
		$data=array();
		$tree=array();
		$sql='SELECT * FROM {{tree}} WHERE parent<>0 AND visible=1 AND path<>\'sitemap\' AND path<>\'search\' AND path<>\'thanks\' ORDER BY num ASC';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$this->tree[$item['parent']][$item['id']]=$item;
		}
		foreach($this->tree[1] as $item){
			$path='/'.$item['path'].'/';
			$data[]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'path'=>$path,
				'sub'=>Tree::getSitemapBranch($item['id'],$path)
			);
		}
		return $data;
	}
	function getSitemapBranch($parent,$path){
		$data=array();
		if(count($this->tree[$parent])>0){
			foreach($this->tree[$parent] as $item){
				$vpath=$path.$item['path'].'/';
				$data[]=array(
					'id'=>$item['id'],
					'name'=>$item['name'],
					'path'=>$vpath,
					'sub'=>Tree::getSitemapBranch($item['id'],$vpath)
				);
			}
		}
		return $data;
	}
	public function addTree($parent,$tree,$module=''){
		$path=$tree['path'];
		if($path=='')$path=$tree['name'];
		$path=Funcs::Transliterate($path);
		if($tree['seo_title']=='')$tree['seo_title']=$tree['name'];
		if($tree['seo_keywords']=='')$tree['seo_keywords']=$tree['name'];
		if($tree['seo_description']=='')$tree['seo_description']=$tree['name'];
		$udate=$tree['udate'];
		if(trim($udate)=='')$udate=date("d.m.Y H:i:00");
		$sql='
			INSERT INTO {{tree}}
			SET
				parent='.$parent.',
				name=\''.$tree['name'].'\',
				path=\''.$path.'\',
				seo_title=\''.$tree['seo_title'].'\',
				seo_keywords=\''.$tree['seo_keywords'].'\',
				seo_description=\''.$tree['seo_description'].'\',
				udate=\''.date('Y-m-d H:i:s',strtotime($udate)).'\',
				cdate=NOW(),
				visible='.($tree['visible']==''?'0':'1').',
				menu=0,
				site='.$_SESSION['site'].'
		';
		$id=DB::exec($sql);
		if($module){
			$tree['info']['path']=$module;
		}else{
			$tree['info']=Tree::getInfo($parent);
		}
		$sql='
			INSERT INTO {{relations}}
			SET
				modul1=\'tree\',
				modul2=\''.$tree['info']['path'].'\',
				id1=\''.$id.'\',
				id2=1,
				cdate=NOW()
		';
		DB::exec($sql);
		//Tree::saveSearch($id);
		return $id;
	}
	/*public static function saveSearch($id=''){
		if($id=='')$id=$_POST['tree'];
		if($id=='')$id=$_POST['id'];
		if(is_numeric($id)){
			$sql='
				DELETE FROM {{search}}
				WHERE tree='.$id.'
			';
			DB::exec($sql);
			if($_POST['name']){
				$search=$_POST['name'].' '.$_POST['seo_title'].' '.$_POST['seo_description'].' '.$_POST['seo_keywords'];
				$search.=' '.implode(' ',$_POST['data']);
				$search=strtolower(trim(htmlspecialchars(strip_tags($search))));
				if($search){
					$sql='
						INSERT INTO {{search}}
						SET tree='.$id.', name=\''.$_POST['name'].'\', search=\''.$search.'\'
					';
					DB::exec($sql);
				}
			}
		}
	}*/
}
?>