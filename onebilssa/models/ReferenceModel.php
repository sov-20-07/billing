<?
class Reference{
	public static $ids=array();
	public static $treeArray=array();
	function getList(){
		$parent=array();
		if(Funcs::$uri[2]){
			$sql='SELECT * FROM {{reference}} WHERE parent='.Funcs::$uri[2].' ORDER BY num';
			$list=DB::getPagi($sql);
			$sql='SELECT * FROM {{reference}} WHERE id='.Funcs::$uri[2].'';
			$parent=DB::getRow($sql);
		}else{
			$sql='SELECT * FROM {{reference}} WHERE parent=0 ORDER BY num';
			$list=DB::getPagi($sql);
		}
		foreach($list as $key=>$item){
			$sql='SELECT count(*) FROM {{reference}} WHERE parent='.$item['id'].'';
			$list[$key]['sub']=DB::getOne($sql);
			$sql='SELECT * FROM {{reference_files}} WHERE reference='.$item['id'].'';
			$files=DB::getAll($sql);
			foreach($files as $file){
				$file['info']=Funcs::getFileInfo($file['path']);
				$list[$key]['files'][]=$file;
			}
		}
		return array('list'=>$list,'parent'=>$parent);
	}
	function getEdit(){
		$data=array();
		$sql='SELECT * FROM {{reference}} WHERE id='.$_GET['id'].'';
		$data=DB::getRow($sql);
		$sql='SELECT * FROM {{reference_files}} WHERE reference='.$_GET['id'].'';
		$files=DB::getAll($sql);
		foreach($files as $file){
			$file['info']=Funcs::getFileInfo($file['path']);
			$data['files'][]=$file;
		}
		return $data;
		
	}
	function add(){
		if(Funcs::$prop['saveto']=='1'){
			$sql='SELECT MAX(num) FROM {{reference}} WHERE parent='.$_POST['parent'].'';
			$num=DB::getOne($sql)+10;
		}else{
			$sql='UPDATE {{reference}} SET num=num+10 WHERE parent='.$_POST['parent'].'';
			DB::exec($sql);
			$num=10;
		}
		$sql='
			INSERT INTO {{reference}}
			SET 
				parent='.$_POST['parent'].',
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				value=\''.trim($_POST[$_POST['type']]).'\',
				type=\''.trim($_POST['type']).'\',
				num=\''.$num.'\',
				visible=1
		';
		$id=DB::exec($sql);
		Reference::upload($id);
	}
	function edit(){
		$sql='
			UPDATE {{reference}}
			SET 
				parent='.trim($_POST['parent']).',
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				value=\''.trim($_POST[$_POST['type']]).'\',
				type=\''.trim($_POST['type']).'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
		$addingSql='';
		if(count($_POST['fileIds'])>0){
			$addingSql=' AND id NOT IN ('.implode(',',$_POST['fileIds']).') ';
		}
		$sql='
			SELECT path FROM {{reference_files}} 
			WHERE reference='.$_POST['id'].' '.$addingSql.'
		';
		$delFiles=DB::getAll($sql,'path');
		foreach($delFiles as $item){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$item))unlink($_SERVER['DOCUMENT_ROOT'].$item);
		}
		$dir=md5('touch'.$user);
		$dir='/u/files/reference/'.$_POST['id'].'/';
		if(is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
			if(count(scandir($_SERVER['DOCUMENT_ROOT'].$dir))==2){
				rmdir($_SERVER['DOCUMENT_ROOT'].$dir);
			}
		}
		$sql='
			DELETE FROM {{reference_files}} 
			WHERE reference='.$_POST['id'].' '.$addingSql.'
		';
		DB::exec($sql);
		Reference::upload($_POST['id']);
	}
	function del(){
		Reference::$ids[]=$_GET['id'];
		Reference::branch($_GET['id']);
		$sql='
			DELETE FROM {{reference}} 
			WHERE id IN ('.(implode(',',Reference::$ids)).')
		';
		DB::exec($sql);
		$sql='
			SELECT path FROM {{reference_files}} 
			WHERE reference IN ('.(implode(',',Reference::$ids)).')
		';
		$delFiles=DB::getAll($sql,'path');
		foreach($delFiles as $item){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$item))unlink($_SERVER['DOCUMENT_ROOT'].$item);
		}
		foreach(Reference::$ids as $id){
			$dir='/u/files/reference/'.$id.'/';
			if(is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
				if(count(scandir($_SERVER['DOCUMENT_ROOT'].$dir))==2){
					rmdir($_SERVER['DOCUMENT_ROOT'].$dir);
				}
			}
		}
		$sql='
			DELETE FROM {{reference_files}} 
			WHERE reference IN ('.(implode(',',Reference::$ids)).')
		';
		DB::exec($sql);
	}
	public static function branch($id){
		$sql='SELECT id FROM {{reference}} WHERE parent='.$id.'';
		$list=DB::getAll($sql,'id');
		foreach($list as $item){
			Reference::$ids[]=$item['id'];
			Reference::branch($item['id']);
		}
	}
	function getTree(){
		$data=array();
		$tree=array();
		$sql='SELECT * FROM {{reference}} ORDER BY num ASC';
		$list=DB::getAll($sql);
		foreach($list as $item){
			Reference::$treeArray[$item['parent']][$item['id']]=$item;
		}
		foreach(Reference::$treeArray[0] as $item){
			$item['sub']=Reference::getBranch($item['id']);
			$data[]=$item;
		}
		return $data;
	}
	function getBranch($parent){
		$data=array();
		if(count(Reference::$treeArray[$parent])>0){
			foreach(Reference::$treeArray[$parent] as $item){
				$item['sub']=Reference::getBranch($item['id']);
				$data[]=$item;
			}
		}
		return $data;
	}
	public static function upload($id){
		if(is_array($_FILES['upload']['name'])){
			$dir='/u/files/reference/'.$id.'/';
			if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/u/files/reference/')){
				mkdir($_SERVER['DOCUMENT_ROOT'].'/u/files/reference/',0777);
				/*$sql='
					CREATE TABLE IF NOT EXISTS `one_reference_files` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `reference` int(10) unsigned NOT NULL,
					  `path` varchar(255) NOT NULL,
					  `name` varchar(255) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
				';
				DB::exec($sql);*/
			}
			if(!is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
				mkdir($_SERVER['DOCUMENT_ROOT'].$dir,0777);
			}
			foreach($_FILES['upload']['name'] as $key=>$item){
				$item=explode('.',$item);
				$raz=end($item);
				unset($item[count($item)-1]);
				$item=Funcs::Transliterate(implode('',$item));
				$i=1;
				$name=$item;
				while(file_exists($_SERVER['DOCUMENT_ROOT'].$dir.$name.'.'.$raz)){
					$name=$item.$i;
					$i++;
				}
				$item=$name.'.'.$raz;
				$name=$item;
				if($_POST['filename'][$key]!='')$name=$_POST['filename'][$key];
				$sql='
					INSERT INTO {{reference_files}}
					SET 
						reference='.$id.',
						path=\''.$dir.$item.'\',
						name=\''.$name.'\'
				';
				DB::exec($sql);
				move_uploaded_file($_FILES['upload']['tmp_name'][$key],$_SERVER['DOCUMENT_ROOT'].$dir.$item);
			}
		}
	}
}
?>