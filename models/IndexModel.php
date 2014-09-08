<?
class Index{
	function __construct(){
		
	}
	public static function getExamples(){
		$sql='
			SELECT * FROM {{tree}} 
			WHERE visible=1 AND parent=89
			ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$item['fields']=Fields::getFieldsByTree($item['id'],'gal');
			$booksize=Funcs::$referenceId['booksize'][$item['fields']['booksize']]['path'];
			$item['fields']['booksize']=Funcs::$referenceId['booksize'][$item['fields']['booksize']]['path'].' см';
			$booksize=explode('x',$booksize);
			if($booksize[0]==$booksize[1])$item['square']=1;
			else $item['square']=0;
			$data[]=$item;
		}
		return $data;
	}
	public static function getBanners(){
		$data=array();
		foreach(Funcs::$infoblockNum['mainbanners'] as $item){
			if($item['path']==1){
				$item['action']=round((Funcs::MakeTime($item['edate'])-Funcs::MakeTime($item['bdate']))/86400)+1;
				$item['end-days']=round((Funcs::MakeTime($item['edate'])-Funcs::MakeTime(date('d.m.Y H:i')))/86400)+1;
				//print $item['end-days'];
				if($item['end-days']>=0){
					if(is_numeric($item['source'])){
						$item['model']=Catalog::getOne($item['source']);
					}
					$data[$item['path']][]=$item;
				}
				//print ' = '.$item['action'].'-'.$item['end-days'].'<br>';
				//$data[$item['path']][]=$item['description'];
			}else{
				$data[$item['path']][]=$item['description'];
			}
		}
		return $data;
	}
	public static function getMainBanner(){
		$data=array();
		$data=Funcs::$infoblockNum['mainbanner'][0];
		$source=explode("\n",Funcs::$infoblockNum['mainbanner'][0]['source']);
		$data['source']=$source;
		if(is_numeric($source[1])){
			$data['model']=Catalog::getOne($source[1]);
		}
		return $data;
	}
	public static function getSale(){
		$data=array();
		$sql='
			SELECT DISTINCT {{tree}}.id FROM {{tree}} 
			INNER JOIN {{data}} ON {{tree}}.id={{data}}.tree
			WHERE {{tree}}.visible=1 AND {{data}}.value_int=1 AND {{data}}.path=\'sale\'
			ORDER BY {{tree}}.num
			LIMIT 0,12
		';
		//print DB::prefix($sql);
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=Catalog::getOne($item['id']);
		}
		return $data;
	}
	public static function getBest(){
		$data=array();
		$ids=array_merge(array(82),Tree::getChilds(82));
		$sql='
			SELECT DISTINCT {{tree}}.id FROM {{tree}}
			INNER JOIN {{catalog}} ON {{catalog}}.tree={{tree}}.id
			WHERE {{tree}}.visible=1 AND {{tree}}.parent NOT IN ('.implode(',',$ids).')
			ORDER BY {{catalog}}.rating DESC LIMIT 0,2
		';
		//print DB::prefix($sql);
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=Catalog::getOne($item['id']);
		}
		return $data;
	}
	public static function getHits(){
		$data=array();
		$ids=Tree::getChilds(2);
		$sql='
			SELECT DISTINCT {{tree}}.id FROM {{tree}}
			INNER JOIN {{catalog}} ON {{catalog}}.tree={{tree}}.id
			WHERE {{tree}}.visible=1 AND {{tree}}.parent IN ('.implode(',',$ids).') AND {{catalog}}.hit=1
			ORDER BY {{tree}}.num DESC LIMIT 0,4
		';
		//print DB::prefix($sql);
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=Catalog::getOne($item['id']);
		}
		return $data;
	}
	public static function getServices($parent){
		$data=array();
		$sql='
			SELECT * FROM {{tree}} 
			WHERE visible=1 AND parent='.$parent.' AND menu=1
			ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$item['path']=Tree::getPathToTree($item['id']);
			$fields=Fields::getFieldsByTree($item['id'],'gal');
			$data[]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'path'=>$item['path'],
				'preview'=>$fields['preview'],
				'pic'=>$fields['files_gal1']['image'][0]['path'],
				'picname'=>$fields['files_gal1']['image'][0]['name'],
			);
		}
		return $data;
	}
	public static function getContacts($parent){
		$data=array();
		$sql='
			SELECT * FROM {{tree}} 
			WHERE visible=1 AND parent='.$parent.'
			ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$fields=Fields::getFieldsByTree($item['id'],'gal');
			$pics=array();
			if(is_array($fields['files_gal1'])){
				foreach($fields['files_gal1'] as $file){
					$name=explode(' ',$file['name']);
					$if[]=$name[0];
					$if[]=$name[1];
					unset($name[0]);
					unset($name[1]);
					$job=implode(' ',$name);
					$pics[]=array(
						'path'=>$file['path'],
						'name'=>$if,
						'job'=>$job,
						'dop'=>$file['dop'],
					);
				}
			}
			$data[]=array(
				'preview'=>$fields['preview'],
				'pics'=>$pics
			);
		}
		return $data;
	}
}
?>