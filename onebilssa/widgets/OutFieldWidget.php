<?
class OutFieldWidget{
	public static $tree;
	public static $module;
	function run($id,$row,$module){
		OutFieldWidget::$tree=$id;
		OutFieldWidget::$module=$module;
		switch($row['type']){
			case 'string': 		return OutFieldWidget::getString($row); break;
			case 'integer': 	return OutFieldWidget::getInteger($row); break;
			case 'float': 		return OutFieldWidget::getFloat($row); break;
			case 'text': 		return OutFieldWidget::getTextarea($row); break;
			case 'editor': 		return OutFieldWidget::getEditor($row); break;
			case 'select': 		return OutFieldWidget::getSelect($row); break;
			case 'multiselect': return OutFieldWidget::getMultiselect($row); break;
			case 'multival': return OutFieldWidget::getMultival($row); break;
			case 'radio': 		return OutFieldWidget::getRadio($row); break;
			case 'gallery': 	return OutFieldWidget::getGallery($row); break;
		}
	}
	function getValue($path){
		if(in_array($path,OneSSA::$catalogStandart)){
			$sql='
				SELECT id, '.$path.' as value_string, '.$path.' as value_int, '.$path.' as value_float, '.$path.' as value_text
				FROM {{catalog}} WHERE tree='.OutFieldWidget::$tree.'
			';
			return DB::getRow($sql);
		}
		$sql='
			SELECT * FROM {{data}}
			WHERE tree='.OutFieldWidget::$tree.' AND path=\''.$path.'\'
		';
		return DB::getRow($sql);
	}
	function getString($row){
		$value=OutFieldWidget::getValue($row['path']);
		$row['value']=$value['value_string'];
		return View::getWidget('outfields/string',$row);
	}
	function getInteger($row){
		$value=OutFieldWidget::getValue($row['path']);
		$row['value']=$value['value_int'];
		if(in_array($row['path'],OneSSA::$catalogStandart)){
			$row['tab']='catalog';
			$row['field']=$row['path'];
		}else{
			$row['tab']='data';
			$row['field']='value_int';
		}
		$row['tree']=OutFieldWidget::$tree;
		return View::getWidget('outfields/integer',$row);
	}
	function getFloat($row){
		$value=OutFieldWidget::getValue($row['path']);
		$row['value']=$value['value_float'];
		if(in_array($row['path'],OneSSA::$catalogStandart)){
			$row['tab']='catalog';
			$row['field']=$row['path'];
		}else{
			$row['tab']='data';
			$row['field']='value_int';
		}
		$row['tree']=OutFieldWidget::$tree;
		return View::getWidget('outfields/float',$row);
	}
	function getTextarea($row){
		$value=OutFieldWidget::getValue($row['path']);
		$row['value']=$value['value_text'];
		return View::getWidget('outfields/textarea',$row);
	}
	function getEditor($row){
		$value=OutFieldWidget::getValue($row['path']);
		$row['value']=$value['value_text'];
		return View::getWidget('outfields/editor',$row);
	}
	function getRadio($row){
		$value=OutFieldWidget::getValue($row['path']);
		$row['value']=$value['value_int'];
		$row['id']=$value['id'];
		if($row['id']=='')$row['id']=0;
		$module=Module::getModuleById($row['module']);
		if($module['type']=='cat' && in_array($row['path'],OneSSA::$catalogStandart)){
			$row['tab']=$module['path'];
			$row['field']=$row['path'];	
		}else{
			$row['tab']='data';
			$row['field']='value_int';			
		}
		return View::getWidget('outfields/radio',$row);
	}
	function getSelect($row){
		$data=array();
		$value=OutFieldWidget::getValue($row['path']);
		$row['value']=$value['value_text'];
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
			$row['params']=FieldWidget::getFieldReserve($row,'params');
		}
		$params=explode('-',$row['params']);
		if(count($params)==3){
			$sql='SELECT * FROM {{'.$params[0].'}} ORDER BY num';
		}else{
			$sql='SELECT id FROM {{'.$params[0].'}} WHERE path=\''.$params[1].'\' ORDER BY num';
			$parent=DB::getOne($sql);
			if($parent=='')$parent=0;
			$sql='SELECT * FROM {{'.$params[0].'}} WHERE parent='.$parent.' ORDER BY num';
		}
		$items=DB::getAll($sql);
		foreach($items as $item){
			$data[]=array(
				'name'=>$item[$params[count($params)-1]],
				'value'=>$item[$params[count($params)-2]],
				'selected'=>$item[$params[count($params)-2]]==$row['value']?'selected':'',
			);
			if($item[$params[count($params)-2]]==$row['value'])$row['value']=$item[$params[count($params)-1]];
		}
		$row['list']=$data;
		return View::getWidget('outfields/select',$row);
	}
	function getMultiselect($row){
		$data=array();
		$value=OutFieldWidget::getValue($row['path']);
		$row['id']=$value['id'];
		$row['value']=array();
		if($row['id']=='')$row['id']=0;
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
			$row['params']=FieldWidget::getFieldReserve($row,'params');
		}
		$params=explode('-',$row['params']);
		$module=Module::getModuleByPath($params[0]);
		if($module){
			if($module['type']=='cat'){
				$sql='
					SELECT {{tree}}.* FROM {{tree}} 
					INNER JOIN {{'.$module['path'].'}} ON {{tree}}.id={{'.$module['path'].'}}.tree
					WHERE 1 ORDER BY num
				';
			}
		}else{
			if(count($params)==2){
				$sql='SELECT * FROM {{'.$params[0].'}} ORDER BY num';
			}else{
				$sql='SELECT id FROM {{'.$params[0].'}} WHERE path=\''.$params[1].'\' ORDER BY num';
				$parent=DB::getOne($sql);
				if($parent=='')$parent=0;
				$sql='SELECT * FROM {{'.$params[0].'}} WHERE parent='.$parent.' ORDER BY num';
			}
		}
		$items=DB::getAll($sql);
		$sql='SELECT id2 FROM {{relations}} WHERE modul1=\'data\' AND id1='.$row['id'].'';
		$result=DB::getAll($sql,'id2');
		foreach($items as $item){
			$data[]=array(
				'name'=>$item[$params[count($params)-1]],
				'value'=>$item['id'],
				'selected'=>in_array($item['id'],$result)?'selected':'',
			);
			if(in_array($item['id'],$result)){
				$row['value'][]=$item[$params[count($params)-1]];
			}
		}
		$row['list']=$data;
		return View::getWidget('outfields/multiselect',$row);
	}
	function getMultival($row){
		$data=array();
		$value=OutFieldWidget::getValue($row['path']);
		$row['id']=$value['id'];
		$row['value']=array();
		if($row['id']=='')$row['id']=0;
		if($row['module']){
			$row['name']=FieldWidget::getFieldReserve($row,'name');
			$row['params']=FieldWidget::getFieldReserve($row,'params');
		}
		$params=explode('-',$row['params']);
		$module=Module::getModuleByPath($params[0]);
		if($module){
			if($module['type']=='cat'){
				$sql='
					SELECT {{tree}}.* FROM {{tree}} 
					INNER JOIN {{'.$module['path'].'}} ON {{tree}}.id={{'.$module['path'].'}}.tree
					WHERE 1 ORDER BY num
				';
			}
		}else{
			if(count($params)==2){
				$sql='SELECT * FROM {{'.$params[0].'}} ORDER BY num';
			}else{
				$sql='SELECT id FROM {{'.$params[0].'}} WHERE path=\''.$params[1].'\' ORDER BY num';
				$parent=DB::getOne($sql);
				if($parent=='')$parent=0;
				$sql='SELECT * FROM {{'.$params[0].'}} WHERE parent='.$parent.' ORDER BY num';
			}
		}
		$items=DB::getAll($sql);
		$sql='SELECT id2 FROM {{relations}} WHERE modul1=\'data\' AND id1='.$row['id'].'';
		$result=DB::getAll($sql,'id2');
		foreach($items as $item){
			$data[]=array(
				'name'=>$item[$params[count($params)-1]],
				'value'=>$item['id'],
				'selected'=>in_array($item['id'],$result)?'selected':'',
			);
			if(in_array($item['id'],$result)){
				$multival='';
				if(in_array($item['id'],$result)){
					$sql='SELECT * FROM {{multival}} WHERE relations='.$item['id'].'';
					$multival=DB::getRow($sql);
					for($i=1;$i<4;$i++){
						$multival[$i]=$multival['value_string'.$i]==''?$multival['value_int'.$i]:$multival['value_string'.$i];
					}
				}
				$row['value'][]=$item[$params[count($params)-1]]/*.' ('.implode(', ',$multival).')'*/;
			}
		}
		$row['list']=$data;
		return View::getWidget('outfields/multival',$row);
	}
	function getGallery($row){
		$row['files']=array();
		$value=OutFieldWidget::getValue($row['path']);
		$row['id']=$value['id'];
		if($row['id']){
			$sql='
				SELECT id2 FROM {{relations}}
				WHERE modul1=\'data\' AND modul2=\'files\' AND id1='.$row['id'].'
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
		if(count($row['files'])>0){
			return View::getWidget('outfields/gallery',$row);
		}else{
			return '';
		}
	}
}
?>