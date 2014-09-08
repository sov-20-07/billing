<?
class Prepare{
	public static $fields=array();
	public static $tree=array();
	public static $module='articles';
	public static $show=0;
	public function run(){
		$fields=Module::getFieldList(6,1);
		$tree=Tree::getTree();
		
		$x=0;
		foreach($tree[0]['sub'] as $i=>$item){
			if($item['path']=='catalog')$x=$i;
		}
		$tree=$tree[0]['sub'][$x]['sub'];
		foreach($tree as $items){
			foreach($items['sub'] as $item){
				$info=Tree::getInfo($item['id']);
				if($info['type']=='cat') Prepare::$tree[]=$item;
				Prepare::getBranch($item['sub']);
			}
		}
		//print '<pre>';print_r(Prepare::$tree);die;
		//print '<pre>';
		foreach(Prepare::$tree as $item){
			$sql='
				SELECT {{reference}}.path FROM {{data}} INNER JOIN {{reference}} ON {{data}}.value_text={{reference}}.id
				WHERE {{data}}.path=\'refsizes\' AND {{data}}.tree=\''.$item['parent'].'\'
			';
			//print DB::prefix($sql);die;
			$ref=DB::getOne($sql);
			$refArr=Prepare::getSizesReference($ref);
			foreach($item['sub'] as $Csize){
				foreach($refArr as $Rkey=>$Rsize){
					if($Csize['path']==$Rsize['path']){
						unset($refArr[$Rkey]);
					}
				}
			}
			$num=10;
			if(!empty($refArr)){
				foreach($refArr as $row){
					$add=array();
					$add['tree']['site']=1;
					$add['tree']['parent']=$item['id'];
					$add['tree']['name']=$row['name'];
					$add['tree']['path']=$row['path'];
					$add['tree']['seo_title']=$row['name'];
					$add['tree']['seo_keywords']=$row['name'];
					$add['tree']['seo_description']=$row['name'];
					$add['tree']['num']=$num;
					$add['tree']['udate']=date('Y-m-d H:i:m');
					$add['tree']['visible']=1;
					$add['tree']['cdate']=date('Y-m-d H:i:m');
					$add['tree']['mdate']=date('Y-m-d H:i:m');
					foreach($fields as $field){
						$add['data'][$field['path']]=array(
							'value'=>0,
							'field'=>Fields::$types[$field['type']]['type'],
							'type'=>$field['type'],
							'path'=>$field['path'],
							'num'=>$field['num']
						);
					}
					//print_r($add);print '<br><br><br>';
					Prepare::setPage($add);
					$num+=10;
				}
			}
		}
	}
	public static function getBranch($tree){
		foreach($tree as $item){
			$info=Tree::getInfo($item['id']);
			if($info['type']=='cat') Prepare::$tree[]=$item;
			Prepare::getBranch($item['sub']);
		}
	}
	function setPage($item){
		$sql='
			INSERT INTO {{tree}} 
			SET
				parent='.$item['tree']['parent'].',
				name=\''.$item['tree']['name'].'\',
				seo_title=\''.$item['tree']['seo_title'].'\',
				seo_keywords=\''.$item['tree']['seo_keywords'].'\',
				seo_description=\''.$item['tree']['seo_description'].'\',
				site=\''.$item['tree']['site'].'\',
				path=\''.$item['tree']['path'].'\',
				visible='.$item['tree']['visible'].',
				menu=0,
				cdate=\''.$item['tree']['cdate'].'\',
				mdate=\''.$item['tree']['mdate'].'\',
				udate=\''.$item['tree']['udate'].'\',
				num='.$item['tree']['num'].'
		';
		if(Prepare::$show==1){
			print DB::prefix($sql);
		}else{
			DB::exec($sql);
		}
		$newid=mysql_insert_id();
		$sql='
			INSERT INTO {{relations}}
			SET modul1=\'tree\',
				modul2=\''.Prepare::$module.'\',
				id1='.$newid.',
				id2=1,
				cdate=NOW()
		';
		if(Prepare::$show==1){
			print DB::prefix($sql);
		}else{
			DB::exec($sql);
		}
		foreach($item['data'] as $row){
			Prepare::field($newid,$row);
		}
	}
	public static function field($tree,$item){
		$sql='
			INSERT INTO {{data}}
			SET
				tree='.$tree.',
				path=\''.$item['path'].'\',
				type=\''.$item['type'].'\',
				'.$item['field'].'=\''.$item['value'].'\',
				cdate=NOW(),
				num='.$item['num'].',
				visible=1
		';
		if(Prepare::$show==1){
			print DB::prefix($sql);
		}else{
			DB::exec($sql);
		}
	}
	public static function getSizesReference($path){
		$data=array();
		$sql='SELECT id FROM {{reference}} WHERE parent=0 AND path=\'sizes\'';
		$parent=DB::getOne($sql);
		if(!$parent) return false;
		$sql='SELECT id FROM {{reference}} WHERE parent='.$parent.' AND path=\''.$path.'\'';
		$parent=DB::getOne($sql);
		if(!$parent) return false;
		$sql='SELECT * FROM {{reference}} WHERE parent='.$parent.' ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=$item;
		}
		return $data;
	}
}
?>