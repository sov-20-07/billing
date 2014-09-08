<?
class Work{
	public $tree=array();
	public $left=0;
	function bind(){
		$sql='SELECT path FROM {{modules}} WHERE id='.$_GET['module'];
		$module=DB::getOne($sql);
		$sql='
			SELECT id FROM {{relations}} 
			WHERE modul1=\'tree\' AND id1=\''.$_GET['tree'].'\' AND id2=1
		';
		$relations=DB::getOne($sql);
		if($relations){
			$sql='
				UPDATE {{relations}}
				SET
					modul1=\'tree\',
					modul2=\''.$module.'\',
					id1=\''.$_GET['tree'].'\',
					id2=\'1\',
					cdate=NOW()
				WHERE id='.$relations.'
			';
		}else{
			$sql='
				INSERT INTO {{relations}}
				SET
					modul1=\'tree\',
					modul2=\''.$module.'\',
					id1=\''.$_GET['tree'].'\',
					id2=\'1\',
					cdate=NOW()
			';
		}
		//print DB::prefix($sql);
		DB::exec($sql);
	}
	function bindraz(){
		$id=$_GET['id'];
		if(!$id)$id=0;
		$sql='SELECT path FROM {{modules}} WHERE id='.$_GET['module'];
		$module=DB::getOne($sql);
		$sql='
			SELECT id FROM {{relations}} 
			WHERE modul1=\'tree\' AND id1=\''.$_GET['tree'].'\' AND id2=0
		';
		$relations=DB::getOne($sql);
		if($relations){
			$sql='
				UPDATE {{relations}}
				SET
					modul1=\'tree\',
					modul2=\''.$module.'\',
					id1=\''.$_GET['tree'].'\',
					id2=\'0\',
					cdate=NOW()
				WHERE id='.$relations.'
			';
		}else{
			$sql='
				INSERT INTO {{relations}}
				SET
					modul1=\'tree\',
					modul2=\''.$module.'\',
					id1=\''.$_GET['tree'].'\',
					id2=\'0\',
					cdate=NOW()
			';
		}
		DB::exec($sql);
	}
	public function getFields($module=''){
		if($module=='')$module=$_GET['module'];
		$sql='SELECT * FROM {{fields}} WHERE module='.$module.' AND innerf=1 ORDER BY num';
		return DB::getAll($sql);
	}
	function getStandartFields($id=''){
		if(is_numeric($id)){
			$sql='SELECT * FROM {{tree}} WHERE id='.$id;
			$row=DB::getRow($sql);
			if($row['udate']=='0000-00-00 00:00:00')$row['udate']=date("d.m.Y H:i:00");
			return $row;
		}else{
			$row['udate']=date("d.m.Y H:i:00");
			$row['parent']=$_GET['parent'];
			return $row;
		}
	}
	public function getEditFields($treeId,$moduleId){
		$return=array();
		$data=array();
		$temp=array();
		$sql='SELECT *, '.$moduleId.' AS module FROM {{data}} WHERE tree='.$treeId.' ORDER BY num';
		$additional=DB::getAll($sql);
		foreach ($additional as $item){
			$temp[]=$item['path'];
		}
		$data=Work::getFields($moduleId);
		$sql='SELECT * FROM {{fields}} WHERE module='.$moduleId.' AND innerf=1 ORDER BY num';
		$fields=DB::getRow($sql);
		foreach($data as $key=>$item){
			/*if(in_array($item['path'],Fields::$catalogStandart)){
				$data[$key][Fields::$types[$item['type']]['type']]=$fields[$item['path']];
			}else{*/
				if(in_array($data[$key]['path'],$temp)){
					unset($data[$key]);
				}
			//}
		}
		
		$data=array_merge($data,$additional);
		if(Funcs::$prop['fieldsort']==0){
			return $data;
		}else{
			$fields=Fields::getFieldsByModule($moduleId);
			foreach($fields as $field){
				foreach($data as $item){
					if($field['path']==$item['path']){
						$return[]=$item;
					}					
				}
			}
			return $return;
		}
	}
	function add(){
		if(!is_numeric($_POST['tree'])){
			$tree=Tree::addTree();
		}else{
			$tree=Tree::editTree($_POST['tree']);
		}
		$i=0;
		if(count($_POST['data'])>0){
			foreach($_POST['data'] as $key=>$item){
				Fields::Insert($tree,$_POST['module'],$key,$item,$_POST['fieldtypes'][$i],$i);
				$i++;
			}
		}
		$sql='SELECT * FROM {{modules}} WHERE id='.$_POST['module'];
		$module=DB::getRow($sql);
		$sql='
			INSERT INTO {{relations}}
			SET
				modul1=\'tree\',
				modul2=\''.$module['path'].'\',
				id1=\''.$tree.'\',
				id2=1,
				cdate=NOW()
		';
		DB::exec($sql);
		$sql='SELECT path FROM {{modules}} WHERE id='.$module['catalog'];
		$moduleCtatalog=DB::getOne($sql);
		if($moduleCtatalog){
			$sql='
				INSERT INTO {{relations}}
				SET
					modul1=\'tree\',
					modul2=\''.$moduleCtatalog.'\',
					id1=\''.$tree.'\',
					id2=0,
					cdate=NOW()
			';
			DB::exec($sql);
		}
		return $tree;
	}
	function edit(){
		$sql='SELECT path FROM {{modules}} WHERE id='.$_POST['module'];
		$module=DB::getOne($sql);
		$sql='
			DELETE FROM {{multival}} 
			WHERE data IN (SELECT id FROM {{data}} WHERE tree='.$_POST['tree'].')
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{relations}} 
			WHERE modul1=\'data\' 
				AND id1 IN (SELECT id FROM {{data}} WHERE tree='.$_POST['tree'].' AND type<>\'gallery\')
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{data}}
			WHERE tree='.$_POST['tree'].'
				AND type<>\'gallery\'
		';
		DB::exec($sql);
		$i=0;
		if($_POST['data']){
			foreach($_POST['data'] as $key=>$item){
				Fields::Insert($_POST['tree'],$_POST['module'],$key,$item,$_POST['fieldtypes'][$i],$i);
				$i++;
			}
		}
		Tree::editTree($_POST['tree']);
	}
	function getObject(){
		$sql='
			SELECT * FROM {{relations}} 
			WHERE modul1=\'tree\' AND id1=\''.Funcs::$uri[2].'\'
		';
		$row=DB::getRow($sql);
		if($row['id2']!=0){
			$sql='
				SELECT id FROM {{modules}} 
				WHERE path=\''.$row['modul2'].'\'
			';
			$module=DB::getOne($sql);
			$sql='
				SELECT parent FROM {{tree}} 
				WHERE id=\''.Funcs::$uri[2].'\'
			';
			$parent=DB::getOne($sql);
			$sql='
				SELECT * FROM {{relations}} 
				WHERE modul1=\'tree\' AND id1=\''.$parent.'\'
			';
			$row=DB::getRow($sql);
			if($row['id2']!=0){
				return array('path'=>'edit','module'=>$module);
			}else{
				return array('path'=>'edit','module'=>$module,'parent'=>$parent);
			}
		}
	}
	function del(){
		$ids=Tree::getChilds($_GET['id']);
		$ids[]=$_GET['id'];
		foreach($ids as $id){
			Tree::saveSearch($id);
			$sql='
				SELECT * FROM {{data}} 
				WHERE type=\'gallery\' AND tree=\''.$id.'\'
			';
			$gals=DB::getAll($sql);
			foreach($gals as $item){
				if($item['id']){
					$sql='
						SELECT * FROM {{relations}} 
						WHERE modul1=\'data\' AND modul2=\'files\' AND id1=\''.$item['id'].'\'
					';
					$files=DB::getAll($sql);
					foreach($files as $file){
						$sql='
							SELECT id1 FROM {{relations}} 
							WHERE modul1=\'data\' AND modul2=\'files\' AND id1<>\''.$item['id'].'\' AND id2='.$file['id2'].'
						';
						$id1=DB::getOne($sql);
						if(!$id1){
							Fields::removeFile($item['id'],$file['id2']);
						}
					}
				}	
			}
			$sql='
				DELETE FROM {{relations}} 
				WHERE modul1=\'tree\' AND id1=\''.$id.'\'
			';
			DB::exec($sql);
			$sql='
				DELETE FROM {{data}}  
				WHERE tree=\''.$id.'\'
			';
			DB::exec($sql);
			$sql='
				DELETE FROM {{tree}} 
				WHERE id=\''.$id.'\'
			';
			DB::exec($sql);
			$sql='
				DELETE FROM {{catalog}} 
				WHERE tree=\''.$id.'\'
			';
			DB::exec($sql);
		}
	}
	function getTree($module=''){
		$items=array();
		$sql='SELECT * FROM {{tree}} WHERE id='.Funcs::$uri[2].'';
		$data=DB::getRow($sql);
		$sql='SELECT modul2 FROM {{relations}} WHERE modul1=\'tree\' AND id1='.Funcs::$uri[2].' AND id2=0';
		$path=DB::getOne($sql);
		if($path){
			$sql='SELECT * FROM {{modules}} WHERE path=\''.$path.'\'';
			$moduleraz=DB::getRow($sql);
		}
		$sql='SELECT modul2 FROM {{relations}} WHERE modul1=\'tree\' AND id1='.Funcs::$uri[2].' AND id2=1';
		$path=DB::getOne($sql);
		$sql='SELECT * FROM {{modules}} WHERE path=\''.$path.'\'';
		$module=DB::getRow($sql);
		if(!$moduleraz)$moduleraz=$module;
		$data['module']=$module;
		$data['moduleraz']=$moduleraz;
		$data['list']=array();
		$order='num';
		if(trim($_GET['sort'])!=''){
			$order=$_GET['sort'].' '.(isset($_GET['desc'])?'DESC':'');
		}
		if(strpos($data['moduleraz']['path'],'struct_')!==false && is_numeric($_GET['ve'])){
			$sql='
				SELECT {{tree}}.* FROM {{tree}}
				LEFT JOIN {{catalog}} ON {{tree}}.id={{catalog}}.tree
				WHERE {{tree}}.parent='.Funcs::$uri[2].' AND {{catalog}}.vendor='.$_GET['ve'].' ORDER BY {{tree}}'.$order.'
			';
		}else{
			$sql='SELECT * FROM {{tree}} WHERE parent='.Funcs::$uri[2].' ORDER BY '.$order.'';
		}
		$items=DB::getPagi($sql);
		$fields=Fields::getOutFieldsByTree(1);
		foreach($items as $item){
			$sql='SELECT modul2 FROM {{relations}} WHERE modul1=\'tree\' AND id1='.$item['id'].' AND id2=1';
			$path=DB::getOne($sql);
			$sql='SELECT * FROM {{modules}} WHERE path=\''.$path.'\'';
			$module=DB::getRow($sql);
			$item['udate']=date('d.m.Y H:i:s',strtotime($item['udate']));
			$item['module']=array(
				'id'=>$module['id'],
				'name'=>$module['name'],
				'path'=>$module['path'],
				'type'=>$module['type']
			);
			foreach($fields as $field){
				$text=OutFieldWidget::run($item['id'],$field,$data['module']);
				if($field['type']=='editor'){
					if(strlen(strip_tags($text))>50){
						$text=substr(strip_tags($text),0,strpos(strip_tags($text),' ',50)).'...';
					}else{
						$text=strip_tags($text);
					}
				}
				$item['fields'][$field['path']]=$text;
			}
			$data['list'][]=$item;
		}
		return $data;
	}
	function getList($module=''){
		$data=array('list'=>array());
		$items=array();
		$sql='SELECT modul2 FROM {{relations}} WHERE modul1=\'tree\' AND id1='.Funcs::$uri[2].' AND id2=0';
		$modul=DB::getOne($sql);
		if($modul==''){
			$sql='SELECT modul2 FROM {{relations}} WHERE modul1=\'tree\' AND id1='.Funcs::$uri[2].'';
			$modul=DB::getOne($sql);
		}
		$sql='SELECT id1 FROM {{relations}} WHERE modul1=\'tree\' AND modul2=\''.$modul.'\' AND id2<>0';
		$ids=DB::getAll($sql);
		foreach($ids as $item)$items[]=$item['id1'];
		if(count($items)>0){
			$sql='SELECT * FROM {{tree}} WHERE id IN ('.implode(',',$items).') ORDER BY num';
			$data['list']=DB::getPagi($sql);
		}
		$sql='SELECT id FROM {{modules}} WHERE path=\''.$modul.'\'';
		$data['module']=DB::getOne($sql);
		return $data;
	}
	function copy($id){
		$sql='
			INSERT INTO {{tree}}(parent,name,seo_title,seo_keywords,seo_description,site,path,visible,num,cdate,mdate,udate,cuser,modul,search,menu)
			SELECT parent,CONCAT(name,\' copy\'),seo_title,seo_keywords,seo_description,site,path,visible,num,NOW(),NOW(),udate,'.$_SESSION['user']['id'].',modul,search,menu FROM {{tree}} WHERE id='.$id.'
		';
		$tree=DB::exec($sql);
		$sql='SELECT parent FROM {{tree}} WHERE id='.$id.'';
		$parent=DB::getOne($sql);
		if(Funcs::$prop['saveto']=='1'){
			$sql='SELECT MAX(num) FROM {{tree}} WHERE parent='.$parent.'';
			$num=DB::getOne($sql)+10;
			$sql='UPDATE {{tree}} SET num='.$num.' WHERE id='.$tree.'';
			DB::exec($sql);
		}else{
			$sql='UPDATE {{tree}} SET num=num+10 WHERE parent='.$parent.'';
			DB::exec($sql);
			$sql='UPDATE {{tree}} SET num=10 WHERE id='.$tree.'';
			DB::exec($sql);
		}
		$sql='
			INSERT INTO {{catalog}}(tree,'.implode(',',OneSSA::$catalogStandart).')
			SELECT '.$tree.','.implode(',',OneSSA::$catalogStandart).' FROM {{catalog}} WHERE tree='.$id.'
		';
		DB::exec($sql);
		$sql='
			INSERT INTO {{search}}(name,tree,search,cdate)
			SELECT name,'.$tree.',search,NOW() FROM {{search}} WHERE tree='.$id.'
		';
		DB::exec($sql);
		$sql='
			INSERT INTO {{relations}}(modul1,modul2,id1,id2,cdate)
			SELECT modul1,modul2,'.$tree.',id2,NOW() FROM {{relations}} WHERE id1='.$id.' AND modul1=\'tree\'
		';
		DB::exec($sql);
		$sql='
			INSERT INTO {{data}}(tree,path,type,value_int,value_float,value_string,value_text,cdate,num,visible)
			SELECT '.$tree.',path,type,value_int,value_float,value_string,value_text,NOW(),num,visible FROM {{data}} WHERE tree='.$id.'
		';
		DB::exec($sql);
		$sql='
			SELECT * FROM {{data}} WHERE tree='.$tree.'
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$sql='SELECT id FROM {{data}} WHERE tree='.$id.' AND path=\''.$item['path'].'\'';
			$dataId=DB::getOne($sql);
			if($dataId){
				$sql='
					INSERT INTO {{relations}}(modul1,modul2,id1,id2,cdate)
					SELECT modul1,modul2,'.$item['id'].',id2,NOW() FROM {{relations}} WHERE id1='.$dataId.' AND modul1=\'data\'
				';
				DB::exec($sql);
			}
		}
		return $parent;
	}
}
?>