<?
class FieldWidget{
	function run($row){
		if($_GET['tree']!='new'){
			switch($row['type']){
				case 'string': 			FieldWidget::getString($row); break;
				case 'integer': 		FieldWidget::getInteger($row); break;
				case 'float': 			FieldWidget::getFloat($row); break;
				case 'text': 			FieldWidget::getTextarea($row); break;
				case 'editor': 			FieldWidget::getEditor($row); break;
				case 'select': 			FieldWidget::getSelect($row); break;
				case 'multiselect':		FieldWidget::getMultiselect($row); break;
				case 'multival': 		FieldWidget::getMultival($row); break;
				case 'treeselect': 		FieldWidget::getTreeselect($row); break;
				case 'treeselectval': 	FieldWidget::getTreeselectval($row); break;
				case 'radio': 			FieldWidget::getRadio($row); break;
				case 'gallery': 		FieldWidget::getGallery($row); break;
				case 'datetime': 		FieldWidget::getDatetime($row); break;
				case '': 				break;
				default : 				FieldWidget::getForm($row); break;
			}
		}
	}
	function getFieldReserve($row,$return=''){
		$sql='
			SELECT * FROM {{fields}}
			WHERE module='.$row['module'].' AND path=\''.$row['path'].'\'
		';
		$row=DB::getRow($sql);
		if($return==''){
			return $row;
		}else{
			return $row[$return];
		}
	}
	function getString($row){
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
		}
		if(!$row['name']){
			$row['name']=$row['path'];
			$row['select']=FieldWidget::getUndefinedFieldNames($row);
		}
		$row['value']=$row['value_string'];
		View::widget('fields/string',$row);
	}
	function getDatetime($row){
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
		}
		if(!$row['name']){
			$row['name']=$row['path'];
			$row['select']=FieldWidget::getUndefinedFieldNames($row);
		}
		$row['value']=trim($row['value_string'])==''?date('d.m.Y H:i:s'):$row['value_string'];
		View::widget('fields/datetime',$row);
	}
	function getInteger($row){
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
		}
		if(!$row['name']){
			$row['name']=$row['path'];
			$row['select']=FieldWidget::getUndefinedFieldNames($row);
		}
		$row['value']=$row['value_int'];
		View::widget('fields/integer',$row);
	}
	function getFloat($row){
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
		}
		if(!$row['name']){
			$row['name']=$row['path'];
			$row['select']=FieldWidget::getUndefinedFieldNames($row);
		}
		$row['value']=$row['value_float'];
		View::widget('fields/float',$row);
	}
	function getTextarea($row){
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
		}
		if(!$row['name']){
			$row['name']=$row['path'];
			$row['select']=FieldWidget::getUndefinedFieldNames($row);
		}
		$row['value']=$row['value_text'];
		View::widget('fields/textarea',$row);
	}
	function getEditor($row){
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
		}
		if(!$row['name']){
			$row['name']=$row['path'];
			$row['select']=FieldWidget::getUndefinedFieldNames($row);
		}
		$row['path']==''?$row['path']=md5(microtime(true)):'';
		$row['value']=$row['value_text'];
		View::widget('fields/editor',$row);
	}
	function getSelect($row){
		$data=array();
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
			$row['params']=FieldWidget::getFieldReserve($row,'params');
		}
		$params=explode('-',$row['params']);
		if(count($params)==3){
			$sql='SELECT * FROM {{'.$params[0].'}} ORDER BY num';
		}elseif($row['params']){
			$sql='SELECT id FROM {{'.$params[0].'}} WHERE path=\''.$params[1].'\' ORDER BY num';
			$parent=DB::getOne($sql);
			if($parent=='')$parent=0;
			$sql='SELECT * FROM {{'.$params[0].'}} WHERE parent='.$parent.' ORDER BY num';
		}else{
			$row['list']=array();
			View::widget('fields/select',$row);
			return;
		}
		$items=DB::getAll($sql);
		foreach($items as $item){
			$data[]=array(
				'name'=>$item[$params[count($params)-1]],
				'value'=>$item[$params[count($params)-2]],
				'selected'=>$item[$params[count($params)-2]]==$row['value_text']?'selected':'',
			);
		}
		$row['list']=$data;
		View::widget('fields/select',$row);
	}
	function getMultiselect($row){
		$data=array();
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
			$row['params']=FieldWidget::getFieldReserve($row,'params');
		}
		$params=explode('-',$row['params']);
		$module=Module::getModuleByPath($params[0]);
		if($module){
			if($module['type']=='cat'){
				if(count($params)==2){
					$sql='
						SELECT {{tree}}.* FROM {{tree}} 
						INNER JOIN {{catalog}} ON {{tree}}.id={{'.$module['path'].'}}.tree
						WHERE 1 ORDER BY num
					';
				}else{
					$sql='SELECT id FROM {{tree}} WHERE path=\''.$params[1].'\' ORDER BY num';
					$id=DB::getOne($sql);
					if($id){
						$ids=array_merge(array($id),Tree::getChilds($id));
						$sql='
							SELECT {{tree}}.* FROM {{tree}} 
							INNER JOIN {{catalog}} ON {{tree}}.id={{'.$module['path'].'}}.tree
							WHERE parent IN ('.implode(',',$ids).') ORDER BY num
						';
					}
				}
			}
		}else{
			if(count($params)==2){
				$sql='SELECT * FROM {{'.$params[0].'}} ORDER BY num';
			}elseif(count($params)>2){
				$sqlparent='';
				if($params[0]=='reference')$sqlparent='AND parent=0';
				$sql='SELECT id FROM {{'.$params[0].'}} WHERE path=\''.$params[1].'\' '.$sqlparent.' ORDER BY num';
				$parent=DB::getOne($sql);
				if($parent=='')$parent=0;
				$sql='SELECT * FROM {{'.$params[0].'}} WHERE parent='.$parent.' ORDER BY num';
			}else{
				$sql='';
			}
		}
		if($sql){
			$items=DB::getAll($sql);
			$sql='SELECT id2 FROM {{relations}} WHERE modul1=\'data\' AND id1='.$row['id'].'';
			$result=DB::getAll($sql,'id2');
			foreach($items as $item){
				if($params[0]=='tree'){
					$gal=FieldWidget::getPics($item);
				}
				$data[]=array(
					'name'=>$item[$params[count($params)-1]],
					'value'=>$item['id'],
					'checked'=>in_array($item['id'],$result)?'checked':'',
					'gal'=>$gal,
				);
			}
			$row['list']=$data;
		}else{
			$row['list']=array();
		}
		View::widget('fields/multiselect',$row);
	}
	function getMultival($row){
		$data=array();
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
			$row['params']=FieldWidget::getFieldReserve($row,'params');
		}
		$params=explode('-',$row['params']);
		$module=Module::getModuleByPath($params[0]);
		if($module){
			if($module['type']=='cat'){
				if(count($params)==2){
					$sql='
						SELECT {{tree}}.* FROM {{tree}} 
						INNER JOIN {{catalog}} ON {{tree}}.id={{'.$module['path'].'}}.tree
						WHERE 1 ORDER BY num
					';
				}else{
					$sql='SELECT id FROM {{tree}} WHERE path=\''.$params[1].'\' ORDER BY num';
					$id=DB::getOne($sql);
					if($id){
						$ids=array_merge(array($id),Tree::getChilds($id));
						$sql='
							SELECT {{tree}}.* FROM {{tree}} 
							INNER JOIN {{catalog}} ON {{tree}}.id={{'.$module['path'].'}}.tree
							WHERE parent IN ('.implode(',',$ids).') ORDER BY num
						';
					}
				}
			}
		}else{
			if(count($params)==2){
				$sql='SELECT * FROM {{'.$params[0].'}} ORDER BY num';
			}elseif(count($params)>2){
				$sql='SELECT id FROM {{'.$params[0].'}} WHERE path=\''.$params[1].'\' ORDER BY num';
				$parent=DB::getOne($sql);
				if($parent=='')$parent=0;
				$sql='SELECT * FROM {{'.$params[0].'}} WHERE parent='.$parent.' ORDER BY num';
			}else{
				$sql='';
			}
		}
		if($sql){
			$items=DB::getAll($sql);
			$sql='SELECT id2 FROM {{relations}} WHERE modul1=\'data\' AND id1='.$row['id'].'';
			$result=DB::getAll($sql,'id2');
			foreach($items as $item){
				if($params[0]=='tree'){
					$gal=FieldWidget::getPics($item);
				}
				$multival='';
				if(in_array($item['id'],$result)){
					$sql='SELECT * FROM {{multival}} WHERE relations='.$item['id'].' AND data='.$row['id'].'';
					$multival=DB::getRow($sql);
					for($i=1;$i<4;$i++){
						$multival[$i]=$multival['value_string'.$i]==''?$multival['value_int'.$i]:$multival['value_string'.$i];
					}
				}
				$data[]=array(
					'name'=>$item[$params[count($params)-1]],
					'value'=>$item['id'],
					'checked'=>in_array($item['id'],$result)?'checked':'',
					'multival'=>$multival,
					'gal'=>$gal,
				);
			}
			$row['list']=$data;
		}else{
			$row['list']=array();
		}
		View::widget('fields/multival',$row);
	}
	function getTreeselect($row){
		$data=array();
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
			$row['params']=FieldWidget::getFieldReserve($row,'params');
		}
		$params=explode('-',$row['params']);
		$module=Module::getModuleByPath($params[0]);
		if(count($params)>1){
			$sql='
				SELECT  {{'.$params[0].'}}.* FROM {{'.$params[0].'}} 
				INNER JOIN {{relations}} ON {{'.$params[0].'}}.id={{relations}}.id2
				WHERE {{relations}}.modul1=\'data\' AND {{relations}}.id1='.$row['id'].' AND {{relations}}.modul2=\''.$params[0].'\'
				ORDER BY num
			';
			$list=DB::getAll($sql);
			$left=0;
			foreach($list as $item){
				$item['value']=$item['id'];
				$data[]=$item;
			}
			$row['list']=$data;
		}else{
			$row['list']=array();
		}
		View::widget('fields/treeselect',$row);
	}
	function getTreeselectval($row){
		$data=array();
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
			$row['params']=FieldWidget::getFieldReserve($row,'params');
		}
		$params=explode('-',$row['params']);
		$module=Module::getModuleByPath($params[0]);
		if(count($params)>1){
			$sql='
				SELECT  {{'.$params[0].'}}.*, {{multival}}.value_int1, {{multival}}.value_int2 FROM {{'.$params[0].'}} 
				INNER JOIN ({{relations}}
					LEFT JOIN {{multival}} ON {{multival}}.relations={{relations}}.id2 AND {{multival}}.data={{relations}}.id1
				)ON {{'.$params[0].'}}.id={{relations}}.id2
				WHERE {{relations}}.modul1=\'data\' AND {{relations}}.id1='.$row['id'].' 
				ORDER BY num
			';
			$list=DB::getAll($sql);
			$left=0;
			foreach($list as $item){
				$item['value']=$item['id'];
				$data[]=$item;
			}
			$row['list']=$data;
		}else{
			$row['list']=array();
		}
		View::widget('fields/treeselectval',$row);
	}
	function getRadio($row){
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
		}
		if(!$row['name']){
			$row['name']=$row['path'];
			$row['select']=FieldWidget::getUndefinedFieldNames($row);
		}
		$row['value']=$row['value_int'];
		View::widget('fields/radio',$row);
	}
	function getGallery($row){
		if($row['tree']!==0){
			$row['tree']=$_REQUEST['id'];
		}
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
		}
		if(!$row['name']){
			$row['name']=$row['path'];
			$row['select']=FieldWidget::getUndefinedFieldNames($row);
		}
		$row['path']==''?$row['path']=md5(microtime(true)):'';
		$row['files']=array();
		if(is_numeric($row['tree'])){
			$sql='
				SELECT id FROM {{data}}
				WHERE tree='.$row['tree'].' AND path=\''.$row['path'].'\' AND type=\'gallery\'
			';
			$dataId=DB::getOne($sql);
			if($dataId){
				$sql='
					SELECT id2 FROM {{relations}}
					WHERE modul1=\'data\' AND modul2=\'files\' AND id1='.$dataId.'
				';
				$fileId=DB::getAll($sql,'id2');
				if(count($fileId)>0){
					$sql='
						SELECT * FROM {{files}}
						WHERE id IN ('.implode(',',$fileId).')
						ORDER BY num
					';
					$temp=DB::getAll($sql);
					foreach($temp as $item){
						$item['file']=Funcs::getFileInfo($item['path']);
						$row['files'][]=$item;
					}
				}
			}
		}
		View::widget('fields/gallery',$row);
	}
	function getForm($row){
		$sql='
			SELECT name FROM {{forms}}
			WHERE path=\''.$row['type'].'\'
		';
		$row['form']=DB::getOne($sql);
		$row['value']=$row['value_int'];
		View::widget('fields/form',$row);
	}
	function getPics($row){
		$data=array();
		if($row['id']){
			$sql='
				SELECT id FROM {{data}}
				WHERE tree='.$row['id'].' AND type=\'gallery\'
			';
			$dataId=DB::getOne($sql);
			if($dataId){
				$sql='
					SELECT id2 FROM {{relations}}
					WHERE modul1=\'data\' AND modul2=\'files\' AND id1='.$dataId.'
				';
				$fileId=DB::getAll($sql,'id2');
				if(count($fileId)>0){
					$sql='
						SELECT * FROM {{files}}
						WHERE id IN ('.implode(',',$fileId).')
						ORDER BY num
					';
					$temp=DB::getAll($sql);
					foreach($temp as $item){
						$item['file']=Funcs::getFileInfo($item['path']);
						$data[]=$item;
					}
				}
			}
		}
		return $data;
	}
	function getUndefinedFieldNames($row){
		if($_POST['parent']){
			$module=Module::getModuleByTree($_POST['module']);
			$sql='SELECT DISTINCT path FROM {{fields}} WHERE module='.$module['id'].'';
			$paths=DB::getAll($sql,'path');
			/*$sql='
				SELECT DISTINCT {{data}}.path FROM {{data}}
				INNER JOIN ({{tree}} INNER JOIN {{relations}} ON {{tree}}.id={{relations}}.id1)
				ON {{data}}.tree={{tree}}.id
				WHERE {{relations}}.modul1=\'tree\' AND {{relations}}.modul2=\''.$module['path'].'\'
					AND {{data}}.path NOT IN(\''.implode('\',\'',$paths).'\')
					AND {{data}}.type=\''.$row['type'].'\'
				ORDER BY {{data}}.path
			';*/
			$sql='
				SELECT DISTINCT {{data}}.path FROM {{data}}
				INNER JOIN {{tree}}	ON {{data}}.tree={{tree}}.id
				WHERE {{tree}}.parent='.$_POST['parent'].'
					AND {{data}}.path NOT IN(\''.implode('\',\'',$paths).'\')
					AND {{data}}.type=\''.$row['type'].'\'
				ORDER BY {{data}}.path
			';
			return DB::getAll($sql,'path');
		}else{
			return array();
		}
	}
}
?>