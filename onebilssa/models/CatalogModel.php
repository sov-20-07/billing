<?
class Catalog{
	public $tree=array();
	public $left=0;
	public function getEditFields($treeId,$moduleId){
		$return=array();
		$data=array();
		$temp=array();
		$sql='SELECT *, '.$moduleId.' AS module FROM {{data}} WHERE tree='.$treeId.' AND type NOT IN(\''.implode('\',\'',Fields::$featuresField).'\') ORDER BY num';
		$additional=DB::getAll($sql);
		foreach ($additional as $item){
			$temp[]=$item['path'];
		}
		$data=Work::getFields($moduleId);
		$sql='SELECT *, '.$moduleId.' AS module FROM {{catalog}} WHERE tree='.$treeId.'';
		$catalog=DB::getRow($sql);
		foreach($data as $key=>$item){
			if(in_array($item['path'],OneSSA::$catalogStandart)){
				$data[$key][Fields::$types[$item['type']]['type']]=$catalog[$item['path']];
			}else{
				if(in_array($data[$key]['path'],$temp)){
					unset($data[$key]);
				}
			}
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
	public function add(){
		$module=Module::getModuleById($_POST['module']);
		if(!is_numeric($_POST['tree'])){
			$tree=Tree::addTree();
		}else{
			$tree=Tree::editTree($_POST['tree']);
		}
		if($_POST['id']!='0'){
			$sql='
				INSERT INTO {{catalog}}
				SET tree='.$tree.'
			';
			$dataId=DB::exec($sql);
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
		}else{
			$dataId=0;
		}
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
		return $tree;
	}
	public function edit(){
		$fields=array();
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
		$module=Module::getModuleById($_POST['module']);
		Tree::editTree($_POST['tree']);
		if(isset($_POST['data']['price']))$fields['price']=$_POST['data']['price']==''?0:$_POST['data']['price'];
		if(isset($_POST['data']['subprice']))$fields['subprice']=$_POST['data']['subprice']==''?0:$_POST['data']['subprice'];
		if(isset($_POST['data']['vendor']))$fields['vendor']=$_POST['data']['vendor']==''?0:$_POST['data']['vendor'];
		if(isset($_POST['data']['available']))$fields['available']=$_POST['data']['available']==''?0:$_POST['data']['available'];
		if(isset($_POST['data']['bid']))$fields['bid']=$_POST['data']['bid']==''?0:$_POST['data']['bid'];
		if(isset($_POST['data']['cbid']))$fields['cbid']=$_POST['data']['cbid']==''?0:$_POST['data']['cbid'];
		if(isset($_POST['data']['manufacturer_warranty']))$fields['manufacturer_warranty']=$_POST['data']['manufacturer_warranty']==''?0:$_POST['data']['manufacturer_warranty'];
		foreach(OneSSA::$catalogStandart as $item){
			if(array_key_exists($item,$fields)===false){
				$fields[$item]=trim($_POST['data'][$item]);
			}
		}
		$sql='
			UPDATE {{catalog}}
			SET 
		';
		foreach($fields as $key=>$item){
			if(strpos($item,'<')===false || strpos($item,'>')===false){
				$item=str_replace('"','&quot;',str_replace("'",'&rsquo;',$item));
			}
			$sql.=$key.'=\''.$item.'\',';
		}
		$sql=substr($sql,0,strlen($sql)-1);
		$sql.='
			WHERE tree='.$_POST['tree'].'
		';
		$dataId=DB::exec($sql);
		$i=0;
		//print_r($_POST);
		foreach($_POST['data'] as $key=>$item){
			if(!in_array($key,OneSSA::$catalogStandart)){
				Fields::Insert($_POST['tree'],$_POST['module'],$key,$item,$_POST['fieldtypes'][$i],$i);
			}
			$i++;
		}
		$i=0;
		if(!empty($_POST['features'])){
			foreach($_POST['features'] as $key=>$item){
				Fields::insertFeatures($_POST['tree'],$_POST['featuresid'][$i],$key,$_POST['featurestype'][$i],$item,$i);
				$i++;
			}
		}
	}
}
?>