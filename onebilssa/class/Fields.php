<?
class Fields{
	public static $types=array(
		'string'=>array('name'=>'Строка','path'=>'string','type'=>'value_string'),
		'integer'=>array('name'=>'Целое','path'=>'integer','type'=>'value_int'),
		'float'=>array('name'=>'Дробное','path'=>'float','type'=>'value_float'),
		'text'=>array('name'=>'Текст','path'=>'text','type'=>'value_text'),
		'editor'=>array('name'=>'Редактор','path'=>'editor','type'=>'value_text'),
		'select'=>array('name'=>'Выбор','path'=>'select','type'=>'value_text'),
		'multiselect'=>array('name'=>'Мультивыбор','path'=>'multiselect','type'=>'relations'),
		'treeselect'=>array('name'=>'Выбор по дереву','path'=>'treeselect','type'=>'relations'),
		'radio'=>array('name'=>'Да/Нет','path'=>'radio','type'=>'value_int'),
		//'password'=>array('name'=>'Пароль','path'=>'password','type'=>'value_string'),
		//'translit'=>array('name'=>'Транслит','path'=>'translit','type'=>'value_string'),
		//'date'=>array('name'=>'Дата','path'=>'date','type'=>'cdate'),
		'datetime'=>array('name'=>'Дата/время','path'=>'datetime','type'=>'value_string'),
		'gallery'=>array('name'=>'Галерея','path'=>'gallery','type'=>'gallery'),
		'multival'=>array('name'=>'Мултивыбор со значениями','path'=>'multival','type'=>'relations'),
		'treeselectval'=>array('name'=>'Выбор по дереву со значениями','path'=>'treeselectval','type'=>'relations'),
	);
	public static $additional=array(
		'string'=>array('name'=>'Строка','path'=>'string','type'=>'value_string'),
		'integer'=>array('name'=>'Целое','path'=>'integer','type'=>'value_int'),
		'float'=>array('name'=>'Дробное','path'=>'float','type'=>'value_float'),
		'text'=>array('name'=>'Текст','path'=>'text','type'=>'value_text'),
		'radio'=>array('name'=>'Да/Нет','path'=>'radio','type'=>'value_int'),
		'editor'=>array('name'=>'Редактор','path'=>'editor','type'=>'value_text'),
		'gallery'=>array('name'=>'Галерея','path'=>'gallery','type'=>'relations'),
	);
	public static $features=array(
		'fstring'=>array('name'=>'Строка','path'=>'fstring','type'=>'value_string'),
		'fnumber'=>array('name'=>'Число','path'=>'fnumber','type'=>'value_float'),
		'fcheckbox'=>array('name'=>'Да/Нет','path'=>'fcheckbox','type'=>'value_int'),
		'fgroup'=>array('name'=>'Группа','path'=>'fgroup','type'=>'value_string'),
	);
	public static $fieldsStandart=array(
		'tree_name'=>array('name'=>'Название','path'=>'name','type'=>'string'),
		'tree_udate'=>array('name'=>'Дата','path'=>'udate','type'=>'date'),
		'tree_path'=>array('name'=>'Путь','path'=>'path','type'=>'string'),
		'tree_seo_title'=>array('name'=>'Title','path'=>'seo_title','type'=>'string'),
		'tree_seo_description'=>array('name'=>'Description','path'=>'seo_description','type'=>'string'),
		'tree_seo_keywords'=>array('name'=>'Keywords','path'=>'seo_keywords','type'=>'string'),
	);
	public static $featuresField=array('fnumber','fstring','fcheckbox','fgroup');
	public static $fieldsName=array('float'=>'value_float','string'=>'value_string','integer'=>'value_int','text'=>'value_text','fnumber'=>'value_float','fstring'=>'value_string','fcheckbox'=>'value_int');
	function additional(){
		$forms=Forms::getFormsList();
		foreach($forms as $item){
			Fields::$additional[$item['path']]=$item;
		}
		return Fields::$additional;
	}
	public static function getFeaturesGroups(){
		$tree='';
		if($tree=='')$tree=$_REQUEST['id'];
		if($tree=='')$tree=$_REQUEST['tree'];
		$sql='
			SELECT * FROM {{fields}}
			WHERE type=\'group\' AND tree='.$tree.'
		';		
		return DB::getAll($sql);
	}
	public function insertFeaturesGroups(){
		DB::escapePost();
		$sql='
			INSERT INTO {{fields}}
			SET name=\''.$_POST['name'].'\',
				path=\''.$_POST['path'].'\',
				type=\'group\',
				tree='.$_POST['tree'].'
		';		
		DB::exec($sql);
	}
	public function updateFeaturesGroups(){
		DB::escapePost();
		$sql='
			UPDATE {{fields}}
			SET name=\''.$_POST['name'].'\',
				path=\''.$_POST['path'].'\'
			WHERE id='.$_POST['id'].'
		';		
		DB::exec($sql);
	}
	public function deleteFeaturesGroups(){
		DB::escapePost();
		$sql='DELETE FROM {{fields}} WHERE id='.$_POST['id'].'';
		DB::exec($sql);
		$sql='UPDATE {{fields}} SET parent=0 WHERE parent='.$_POST['id'].'';		
		DB::exec($sql);
	}
	public static function getFeatures($treeId){
		$tree=$treeId;
		if($_GET['tree'])$tree=$_GET['tree'];
		elseif($_POST['tree'])$tree=$_POST['tree'];
		$sql='SELECT * FROM {{fields}} WHERE type<>\'group\' AND tree='.$tree.' ORDER BY num';		
		return DB::getAll($sql);
	}
	public static function getModelFeatures($tree=''){
		if($tree=='')$tree=$_REQUEST['parent'];
		$groups[]=array('id'=>'0');
		$sql='SELECT * FROM {{fields}} WHERE type=\'group\' AND tree='.$tree.' ORDER BY num';
		$groups=array_merge($groups,DB::getAll($sql));
		foreach($groups as $i=>$item){
			if($item['id']!=''){
				$sql='SELECT * FROM {{fields}} WHERE parent='.$item['id'].' AND tree='.$tree.' ORDER BY num';
				$groups[$i]['list']=DB::getAll($sql);
			}
		}
		if(count($groups)==1 && count($groups[0])==0)$groups=array();
		return $groups;
	}
	public static function setFeatures(){
		if($_POST['tree']!=0 && $_POST['tree']!=''){
			$ids=array();
			if(is_array($_POST['featuresid'])){
				foreach($_POST['featuresid'] as $item)$ids[]=$item;
			}
			$sql='SELECT id FROM {{fields}} WHERE type<>\'group\' AND tree='.$_POST['tree'].' ORDER BY num';
			$all=DB::getAll($sql,'id');
			$delId=array();
			foreach($all as $allId){
				if(!in_array($allId,$ids))$delId[]=$allId;
			}
			if(!empty($delId)){
				$sql='DELETE FROM {{fields}} WHERE id IN ('.implode(',',$delId).')';
				DB::exec($sql);
				$sql='DELETE FROM {{data}} WHERE field IN ('.implode(',',$delId).')';
				DB::exec($sql);
			}
			$num=1;
			if(is_array($_POST['featuresname'])){
				foreach($_POST['featuresname'] as $key=>$item){
					$parent=0;
					if($_POST['featuresgroup'][$key])$parent=$_POST['featuresgroup'][$key];
					$filter=0;
					if($_POST['featuresfilter'][$key])$filter=$_POST['featuresfilter'][$key];
					if($_POST['featuresid'][$key]){
						$sql='
							UPDATE {{fields}}
							SET parent=\''.$parent.'\',
								name=\''.$item.'\',
								path=\''.$_POST['featurespath'][$key].'\',
								type=\''.$_POST['featurestype'][$key].'\',
								filter=\''.$filter.'\',
								filtertype=\''.$_POST['featuresfiltertype'][$key].'\',
								comment=\''.$_POST['featurescomment'][$key].'\',
								num='.$num.',
								tree='.$_POST['tree'].'
							WHERE id='.$_POST['featuresid'][$key].'
						';
					}else{
						$sql='
							INSERT INTO {{fields}}
							SET parent=\''.$parent.'\',
								name=\''.$item.'\',
								path=\''.$_POST['featurespath'][$key].'\',
								type=\''.$_POST['featurestype'][$key].'\',
								filter=\''.$filter.'\',
								filtertype=\''.$_POST['featuresfiltertype'][$key].'\',
								comment=\''.$_POST['featurescomment'][$key].'\',
								num='.$num.',
								tree='.$_POST['tree'].'
						';
					}	
					DB::exec($sql);
					$num++;
				}
			}
		}
	}
	public static function insertFeatures($tree,$fieldId,$path,$type,$value,$num){
		$value=Fields::$features[$type]['type'].'=\''.$value.'\',';
		$sql='
			INSERT INTO {{data}}
			SET 
				tree='.$tree.',
				field=\''.$fieldId.'\',
				path=\''.$path.'\',
				type=\''.$type.'\',
				'.$value.'
				cdate=NOW(),
				num='.$num.',
				visible=1
		';
		$dataId=DB::exec($sql);
	}
	function Insert($tree,$moduleId,$key,$item,$type,$num){
		$sql='SELECT * FROM {{fields}} WHERE path=\''.$key.'\' AND module='.$moduleId;
		$field=DB::getRow($sql);
		$field['params']=explode('-',$field['params']);
		if($field['type']=='')$field['type']=$type;
		if(Fields::$types[$field['type']]['type']=='value_string'){
			$value='value_string=\''.trim($item).'\',';
		}elseif(Fields::$types[$field['type']]['type']=='value_text'){
			$value='value_text=\''.$item.'\',';
		}elseif(Fields::$types[$field['type']]['type']=='value_int'){
			if($item=='')$item=0;
			$value='value_int='.$item.',';
		}elseif(Fields::$types[$field['type']]['type']=='value_float'){
			if($item=='')$item=0;
			$value='value_float='.$item.',';
		}/*elseif(Fields::$types[$field['type']]['type']=='file'){
			if($_FILES['upload']['tmp_name'][$key]){
				$file=Fields::UploadFile($key,$moduleId);
			}else{
				$file=$item;
			}
			$value='value_text=\''.$file.'\',';
		}*/
		if($field['type']=='gallery'){
			$galpathSql='';
			if(trim($_POST['galname'][$key])){
				$galpathSql='path=\''.Funcs::Transliterate($_POST['galname'][$key]).'\',';
			}
			$sql='
				UPDATE {{data}}
				SET '.$galpathSql.' num='.$num.'
				WHERE tree='.$tree.' AND path=\''.$key.'\' AND type=\''.$field['type'].'\'
			';
			DB::exec($sql);
		}else{
			$sql='
				INSERT INTO {{data}}
				SET 
					tree='.$tree.',
					path=\''.$key.'\',
					type=\''.$field['type'].'\',
					'.$value.'
					cdate=NOW(),
					num='.$num.',
					visible=1
			';
			$dataId=DB::exec($sql);
			if(Fields::$types[$field['type']]['type']=='relations'){
				foreach($item as $ii=>$id2){
					if(is_numeric($id2)){
						$sql='
							INSERT INTO {{relations}}
							SET 
								modul1=\'data\',
								modul2=\''.$field['params'][0].'\',
								id1='.$dataId.',
								id2='.$id2.',
								cdate=NOW()
						';
						DB::exec($sql);
						if($field['type']=='multival'){
							$valSql=array();
							for($mi=0;$mi<3;$mi++){
								if(is_numeric(trim($_POST['multival'][$key][$mi+$ii*3]))){
									$valSql[]=' value_int'.($mi+1).'='.$_POST['multival'][$key][$mi+$ii*3].' ';
								}else{
									$valSql[]=' value_string'.($mi+1).'=\''.$_POST['multival'][$key][$mi+$ii*3].'\' ';
								}
							}
							$sql='DELETE FROM {{multival}} WHERE data='.$dataId.' AND relations=\''.$id2.'\'';
							DB::exec($sql);
							$sql='
								INSERT INTO {{multival}}
								SET 
									data=\''.$dataId.'\',
									relations=\''.$id2.'\',
									'.implode(',',$valSql).'
							';
							DB::exec($sql);
						}
						if($field['type']=='treeselectval'){
							$sql='DELETE FROM {{multival}} WHERE data='.$dataId.' AND relations=\''.$id2.'\'';
							DB::exec($sql);
							$sql='
								INSERT INTO {{multival}}
								SET data='.$dataId.',
									relations=\''.$id2.'\',
									value_int1=\''.$_POST['treeselectval'][$key][$id2].'\' 
							';
							DB::exec($sql);
						}
					}
				}
			}
		}
	}
	public function multiupload(){
		//print_r($_FILES);die;
		$data=array();
		if($_FILES['upload']['name']){
			$userdir=substr(UPLOAD_DIR,0,strlen(UPLOAD_DIR)-1);
			if(Funcs::$prop['sitedir']==0){
				$userdir=UPLOAD_DIR.Funcs::$site;
				if(!file_exists($_SERVER['DOCUMENT_ROOT'].$userdir)){
					mkdir($_SERVER['DOCUMENT_ROOT'].$userdir,0777);
					chmod($_SERVER['DOCUMENT_ROOT'].$userdir,0777);
					mkdir($_SERVER['DOCUMENT_ROOT'].$userdir.PHOTO_DIR,0777);
					chmod($_SERVER['DOCUMENT_ROOT'].$userdir.PHOTO_DIR,0777);
					mkdir($_SERVER['DOCUMENT_ROOT'].$userdir.FILES_DIR,0777);
					chmod($_SERVER['DOCUMENT_ROOT'].$userdir.FILES_DIR,0777);
				}
			}
			$module=Module::getModuleByTree($_REQUEST['id']);
			foreach($_FILES['upload']['name'] as $key=>$name){
				$dir='';
				$outdir='';
				$filename=explode('.',$name);
				$raz=strtolower($filename[count($filename)-1]);
				unset($filename[count($filename)-1]);
				$filename=implode('',$filename);
				$filenameraz=Funcs::Transliterate($filename).'.'.$raz;
				if(in_array(strtolower($raz),array('jpeg','jpg','png','gif','bmp'))){
					$dir=$_SERVER['DOCUMENT_ROOT'].$userdir.PHOTO_DIR.$module['path'].'/';
					$outdir=$userdir.PHOTO_DIR.$module['path'].'/';
				}else{
					$dir=$_SERVER['DOCUMENT_ROOT'].$userdir.FILES_DIR.$module['path'].'/';
					$outdir=$userdir.FILES_DIR.$module['path'].'/';
				}
				if(!file_exists($dir)){
					mkdir($dir,0777);
					chmod($dir,0777);
				}			
				$dirfile=$dir.$filenameraz;
				$x=0;$i=1;
				while($x==0){
					if(file_exists($dirfile)){
						$filenameraz=Funcs::Transliterate($filename).$i.'.'.$raz;
						$dirfile=$dir.$filenameraz;
					}else{
						$x=1;
					}
					$i++;
				}
				move_uploaded_file($_FILES['upload']['tmp_name'][$key],$dirfile);
				chmod($dirfile,0777);
				$path=$outdir.$filenameraz;
				$data[]=Fields::setFile($_REQUEST['id'],$_REQUEST['path'],$path);
			}
			$list=$data;
			$data=array();
			foreach($list as $item){
				$data[]=$item['id'];
			}
		}
		return $data;
	}
	public function ckfinderupload(){
		return Fields::setFile($_REQUEST['id'],$_REQUEST['path'],$_REQUEST['filepath']);
	}
	public function setFile($treeId,$dataPath,$filePath){
		$sql='
			SELECT id FROM {{data}}
			WHERE tree='.$treeId.' AND path=\''.$dataPath.'\' AND type=\'gallery\'
		';
		$dataId=DB::getOne($sql);
		if(!$dataId){
			$sql='
				INSERT INTO {{data}}
				SET 
					tree='.$treeId.',
					path=\''.$dataPath.'\',
					type=\'gallery\',
					cdate=NOW(),
					num=0,
					visible=1
			';
			$dataId=DB::exec($sql);
		}
		$file=Funcs::getFileInfo($filePath);
		$sql='
			INSERT INTO {{files}}
			SET 
				mime=\''.$file['type'].'\',
				size='.$file['absolutesize'].',
				path=\''.$filePath.'\',
				visible=1,
				cdate=NOW()
		';
		$fileId=DB::exec($sql);
		$sql='
			INSERT INTO {{relations}}
			SET 
				modul1=\'data\',
				modul2=\'files\',
				id1='.$dataId.',
				id2='.$fileId.',
				cdate=NOW()
		';
		DB::exec($sql);
		$file['name']='';
		$file['visible']=1;
		$file['id']=$fileId;
		return array(
			'id'=>$fileId,
			'path'=>$filePath,
			'mime'=>$file['type'],
			'visible'=>1,
			'file'=>$file			
		);
	}
	public function getFile($id){
		$sql='
			SELECT path FROM {{files}}
			WHERE id='.$id.'
		';
		$filePath=DB::getOne($sql);
		$file=Funcs::getFileInfo($filePath);
		$file['name']='';
		$file['visible']=1;
		$file['id']=$id;
		return array(
			'id'=>$id,
			'path'=>$filePath,
			'mime'=>$file['type'],
			'visible'=>1,
			'file'=>$file			
		);
	}
	public function removeFile($dataId='',$id=''){
		if($dataId=='')$dataId=$_POST['dataId'];
		if($dataId=='')$dataId=$_POST['data'];
		if($id=='')$id=$_POST['id'];
		$sql='SELECT * FROM {{files}} WHERE id='.$id.'';
		$file=DB::getRow($sql);
		$sql='SELECT * FROM {{files}} WHERE path=\''.$file['path'].'\'';
		$files=DB::getAll($sql);
		$sql='SELECT * FROM {{relations}} WHERE modul1=\'data\' AND modul2=\'files\' AND id2='.$id.'';
		$relations=DB::getAll($sql);
		if(count($files)==1 && count($relations)==1){
			//unlink($_SERVER['DOCUMENT_ROOT'].$file['path']);
			$sql='DELETE FROM {{files}} WHERE id='.$id.'';
			DB::exec($sql);
		}
		$sql='
			DELETE FROM {{relations}}
			WHERE modul1=\'data\' AND modul2=\'files\' AND id1='.$dataId.' AND id2='.$id.'
		';
		DB::exec($sql);
	}
	public function editFile(){
		$sql='
			UPDATE {{files}}
			SET 
				name=\''.trim($_POST['name']).'\',
				dop=\''.trim($_POST['dop']).'\'
			WHERE id='.$_POST['id'].'
		';		
		DB::exec($sql);
	}
	public function orderFile(){
		$ids=explode(',',$_POST['ids']);
		foreach($ids as $i=>$item){
			$sql='
				UPDATE {{files}}
				SET num='.$i.'
				WHERE id='.$item.'
			';		
			DB::exec($sql);
		}
	}
	public function insertGalFile(){
		$ids=explode(',',$_POST['ids']);
		foreach($ids as $i=>$item){
			$sql='
				UPDATE {{files}}
				SET num='.$i.'
				WHERE id='.$item.'
			';
			DB::exec($sql);
		}
	}
	public function getFieldsByModule($id){
		$sql='
			SELECT * FROM {{fields}} WHERE module='.$id.' ORDER BY num
		';
		return DB::getAll($sql);
	}
	public function getFieldByModule($id,$path){
		$sql='
			SELECT * FROM {{fields}} WHERE module='.$id.' AND path=\''.$path.'\'
		';
		return DB::getRow($sql);
	}
	public function getOutFieldsByTree($opt=0){
		$modul=Module::getModuleByTree(Funcs::$uri[2],0);
		if($modul['type']=='struct'){
			$sql='
				SELECT {{tree}}.id FROM {{tree}}
				INNER JOIN {{catalog}} ON {{catalog}}.tree={{tree}}.id
				WHERE parent='.Funcs::$uri[2].'
				ORDER BY num LIMIT 0,1
			';
			if(DB::getOne($sql)){
				$modul=Module::getModuleByPath(str_replace('struct_','',$modul['path']));
			}
		}
		if(!$modul['id']){
			return array();
		}
		if($opt==0){
			$list=array_merge(Fields::$fieldsStandart,Fields::getFieldsByModule($modul['id']));
			foreach($list as $key=>$item){
				if(in_array($item['path'],OneSSA::$catalogStandart))$list[$key]['isCatalog']=true;
			}
			return $list;
		}else{
			return Fields::getFieldsByModule($modul['id']);
		}
	}
	public function removeGallery($id){
		$sql='
			SELECT id2 FROM {{relations}}
			WHERE modul1=\'data\' AND modul2=\'files\' AND id1='.$id.'
		';
		$files=DB::getAll($sql,'id2');
		foreach($files as $item){
			Fields::removeFile($id,$item);
		}
		$sql='
			DELETE FROM {{data}}
			WHERE id='.$id.'
		';
		DB::exec($sql);
	}
	public function getTreeselect($id,$treeId,$path){
		$data=array();
		$tree=array();
		$module=Tree::getInfo($treeId);
		$sql='
			SELECT * FROM {{fields}}
			WHERE module='.$module['id'].' AND path=\''.$path.'\'
		';
		$field=DB::getRow($sql);
		$data['name']=$field['name'];
		$data['params']=$field['params'];
		$params=explode('-',$data['params']);
		$module=Module::getModuleByPath($params[0]);
		if(count($params)==2){
			$sql='
				SELECT * FROM {{'.$params[0].'}} 
				ORDER BY num
			';
		}else{
			$sql='SELECT id FROM {{'.$params[0].'}} WHERE path=\''.$params[1].'\'';
			$parent=DB::getOne($sql);
			if($parent){
				$sql='
					SELECT * FROM {{'.$params[0].'}} 
					WHERE parent='.$parent.' ORDER BY num
				';
			}
		}
		$list=DB::getAll($sql);
		$left=0;
		foreach($list as $item){
			$item['value']=$item['id'];
			if($id){
				$sql='SELECT \'checked\' FROM {{relations}} WHERE modul1=\'data\' AND modul2=\''.$params[0].'\' AND id1='.$id.' AND id2='.$item['id'].'';
				$item['checked']=DB::getOne($sql);
			}
			$item['sub']=Fields::getTreeselectBranch($item['id'],$params,$id);
			$item['admin']=Fields::getTreeselectAdminField($item['id']);
			$tree[]=$item;
			
		}
		$data['list']=$tree;
		return $data;
	}
	public function getTreeselectBranch($parent,$params,$id1){
		$data=array();
		$sql='
			SELECT * FROM {{'.$params[0].'}} 
			WHERE parent='.$parent.' ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$item['value']=$item['id'];
			if($id1){
				$sql='SELECT \'checked\' FROM {{relations}} WHERE modul1=\'data\' AND modul2=\''.$params[0].'\' AND id1='.$id1.' AND id2='.$item['id'].'';
				$item['checked']=DB::getOne($sql);
			}
			$item['sub']=Fields::getTreeselectBranch($item['id'],$params,$id1);
			$item['admin']=Fields::getTreeselectAdminField($item['id']);
			$data[]=$item;
		}
		return $data;
	}
	public static function getTreeselectAdminField($id){
		$sql='SELECT value_string FROM {{data}} WHERE path=\'admin\' AND tree='.$id.'';
		return DB::getOne($sql);
	}
	public static function getFieldsByTree($id,$option=''){
		$gal=0;
		$data=array();
		$return=array();
		$sql='SELECT * FROM {{data}} WHERE tree='.$id.' AND field=0 ORDER BY num';
		$additional=DB::getAll($sql);
		foreach ($additional as $item){
			if($item['type']=='editor' || $item['type']=='text'){
				if($_SESSION['user']['panel']['edit']=='on'){
					$item['value']=$item['value_text'];
					$item['field']='value_text';
					$data[$item['path']]=View::getRenderEmpty('../'.ONESSA_DIR.'/views/onessa/field',$item);
				}else{
					$data[$item['path']]=$item['value_text'];
				}
			}elseif($item['type']=='string'){
				if($_SESSION['user']['panel']['edit']=='on'){
					$item['value']=$item['value_string'];
					$item['field']='value_string';
					$data[$item['path']]=View::getRenderEmpty('../'.ONESSA_DIR.'/views/onessa/field',$item);
				}else{
					$data[$item['path']]=$item['value_string'];
				}
			}elseif($item['type']=='integer'){
				$data[$item['path']]=$item['value_int'];
			}elseif($item['type']=='radio'){
				//$data[$item['path']]=$item['value_int'];
				$data[$item['path']]=$item['value_int']==1?'Да':'Нет';
			}elseif($item['type']=='float'){
				$data[$item['path']]=$item['value_float'];
			}elseif($item['type']=='select'){
				$data[$item['path']]=$item['value_text'];
			}elseif($item['type']=='gallery'){
				$galname=$item['path'];
				if($option=='gal'){
					$gal++;
					$galname='gal'.$gal;					
				}
				if(class_exists(GalleryWidget)){
					$data[$galname]=GalleryWidget::run($item);
					if($option=='wide' || $option=='gal'){
						$data['files_'.$galname]=GalleryWidget::$files;
					}
				}else{
					$sql='
						SELECT id FROM {{data}}
						WHERE tree='.$item['tree'].' AND path=\''.$item['path'].'\' AND type=\'gallery\'
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
								$data['files_'.$galname][$item['mime']][]=$item;
							}
						}
					}
				}
			}elseif($item['type']!='multival' && $item['type']!='multiselect' && $item['type']!='treeselectval' && $item['type']!='treeselect' && $item['type']!='select' && $item['type']!='fstring' && $item['type']!='fnumber' && $item['type']!='fcheckbox' && $item['type']!='fgroup'){
				$data[$item['type']]=FormWidget::run($item['type']);
			}
		}
		if($option!='wide'){
			foreach($data as $key=>$item){
				if(is_numeric($key)){
					$return['additional'].=$item;
				}else{
					$return[$key]=$item;
				}
			}
			return $return;
		}else{
			return $data;
		}
	}
	public static function getMultiFields($id){
		$data=array();
		$sql='SELECT * FROM {{data}} WHERE tree='.$id.' AND type IN (\'multiselect\',\'treeselect\') ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$sql='
				SELECT DISTINCT id2 FROM {{relations}}
				WHERE modul1=\'data\' AND id1=\''.$item['id'].'\'
			';
			$data[$item['path']]=DB::getAll($sql,'id2');
		}
		return $data;
	}
	public static function getFeaturesFields($id){
		$data[]=array('id'=>'0');
		$sql='SELECT parent FROM {{tree}} WHERE id='.$id.'';		
		$parent=DB::getOne($sql);
		$sql='SELECT * FROM {{fields}} WHERE type=\'group\' AND tree='.$parent.' ORDER BY num';		
		$data=array_merge($data,DB::getAll($sql));
		foreach($data as $i=>$item){
			if($item['id']!=''){
				$sql='SELECT * FROM {{fields}} WHERE parent='.$item['id'].' AND type<>\'group\' AND tree='.$parent.' ORDER BY num';
				$list=DB::getAll($sql);
				foreach($list as $row){
					$sql='
						SELECT '.Fields::$features[$row['type']]['type'].' FROM {{data}}
						WHERE tree='.$id.' AND field='.$row['id'].'
					';
					$data[$i]['list'][$row['name']]=DB::getOne($sql);
				}
			}
		}
		return $data;
	}
	public static function getFeaturesList($parent){
		$data[]=array('id'=>'0');
		$sql='SELECT * FROM {{fields}} WHERE type=\'group\' AND tree='.$parent.' ORDER BY num';		
		$data=array_merge($data,DB::getAll($sql));
		foreach($data as $i=>$item){
			if($item['id']!=''){
				$sql='SELECT * FROM {{fields}} WHERE parent='.$item['id'].' AND type<>\'group\' AND tree='.$parent.' ORDER BY num';
				$data[$i]['list']=DB::getAll($sql);
			}
		}
		return $data;
	}
	public function getReserveFieldsByModulePath($path){
		$data=array();
		$return=array();
		$sql='
			SELECT {{fields}}.* FROM {{modules}}
			INNER JOIN {{fields}} ON {{fields}}.module={{modules}}.id
			WHERE {{modules}}.path=\''.$path.'\' AND {{fields}}.innerf=1
			ORDER BY {{fields}}.num
		';
		$data=DB::getAll($sql);
		return $data;
	}
	public function getFieldInfo($moduleId,$path){
		$sql='
			SELECT * FROM {{fields}} 
			WHERE path=\''.$path.'\' AND module='.$moduleId.'
		';
		return DB::getRow($sql);
	}
	public static function insertField($tree,$path,$value){
		$module=Module::getModuleByTree($tree);
		$field=Fields::getFieldInfo($module['id'],$path);
		if(Fields::$types[$field['type']]['type']=='value_string'){
			$value='value_string=\''.trim($value).'\',';
		}elseif(Fields::$types[$field['type']]['type']=='value_text'){
			$value='value_text=\''.$value.'\',';
		}elseif(Fields::$types[$field['type']]['type']=='value_int'){
			if($item=='')$item=0;
			$value='value_int='.$value.',';
		}elseif(Fields::$types[$field['type']]['type']=='value_float'){
			if($item=='')$item=0;
			$value='value_float='.$value.',';
		}
		$sql='
			INSERT INTO {{data}}
			SET 
				tree='.$tree.',
				path=\''.$field['path'].'\',
				type=\''.$field['type'].'\',
				'.$value.'
				cdate=NOW(),
				num=0,
				visible=1
		';
		return DB::exec($sql);
	}
	public static function importSimpleField($tree,$path,$type,$row,$value,$num){
		$sql='
			INSERT INTO {{data}}
			SET
				tree='.$tree.',
				path=\''.$path.'\',
				type=\''.$type.'\',
				'.$row.'=\''.$value.'\',
				cdate=NOW(),
				num='.$num.',
				visible=1
		';
		return DB::exec($sql);
	}
	public static function updateFieldById($id,$field,$value){
		$sql='
			UPDATE {{data}}
			SET	'.$field.'=\''.$value.'\',
				cdate=NOW()
			WHERE id='.$id.'
		';
		DB::exec($sql);
	}
}
?>