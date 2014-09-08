<?
class DealersFiles{
	public static function getStorePhotos($id){
		$sql = 'SELECT * FROM {{dealers_files}} WHERE store='.$id.'';
		return DB::getAll();
	}
	public static function getDealerFiles($id){
		$sql = 'SELECT * FROM {{dealers_files}} WHERE store=0 AND dealer='.$id.'';
		return DB::getAll($sql);
	}
	public static function uploadStorePhotos($store){
		//$store_row = DealersStores::getOne($store);
		$dealer = (isset($_POST['dealer'])) ? $_POST['dealer'] : $_SESSION['dealer']['id'];
		$path = '/u/files/stores/';
		$condition = 'WHERE store ='.$store;
		self::delete($path,$condition);
		self::upload($path,$dealer,'',$store);
	}
	public static function deleteAllStorePhotos($store){
		$path = '/u/files/stores/';
		$condition = 'WHERE store ='.$store;
		self::delete($path,$condition);
	}
	public static function uploadDealerFiles($dealer){
		//$dealer = DealersStores::getOne($dealer);
		self::upload('/u/files/dealers/',$dealer,$_POST['comment']);		
	}
	private static function upload($path,$dealer,$comment,$store = 0){
		if(is_array($_FILES['upload']['name'])){
			$dir=($store > 0)
				? md5('touch'.$store)
				: md5('touch'.$dealer);
			$dir=$path.$dir.'/';
			if(!is_dir($_SERVER['DOCUMENT_ROOT'].$path)){
				mkdir($_SERVER['DOCUMENT_ROOT'].$path,0777);
			}
			if(!is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
				mkdir($_SERVER['DOCUMENT_ROOT'].$dir,0777);
			}
			$new_files = array();
			foreach($_FILES['upload']['name'] as $key=>$item){
				$filename = ($store>0) ? $item : self::processName($item,$dealer);
				$name=($_POST['filename'][$key]!='') ? $_POST['filename'][$key] : $filename;
				//die($filename);
				$sql='
					INSERT INTO {{dealers_files}}
					SET 
						dealer='.$dealer.',
						store='.$store.',
						path=\''.$dir.$filename.'\',
						name=\''.$name.'\',
						comment=\''.$comment.'\',
						cdate=NOW()
				';
				DB::exec($sql);
				move_uploaded_file($_FILES['upload']['tmp_name'][$key],$_SERVER['DOCUMENT_ROOT'].$dir.$filename);
				if ($store == 0) {
					DealersEmail::files_new($dealer,$name);
				}				
			}
		}
	}
	private static function processName($file,$dealer){
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		$filename = pathinfo($file, PATHINFO_FILENAME);
		return Funcs::Transliterate($filename).'_'.$dealer.'.'.$ext;
	}
	private static function delete($path,$condition){
		$addingSql = '';
		if(count($_POST['fileIds'])>0){
			$addingSql=' AND id NOT IN ('.implode(',',$_POST['fileIds']).') ';
		}
		$sql = 'SELECT * FROM {{dealers_files}} '.$condition.$addingSql;
		$delFiles=DB::getAll($sql,'path');
		foreach($delFiles as $item){
			unlink($_SERVER['DOCUMENT_ROOT'].$item);
		}
		$dir=md5('touch'.$user);
		$dir=$path.$dir.'/';
		if(is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
			if(count(scandir($_SERVER['DOCUMENT_ROOT'].$dir))==2){
				rmdir($_SERVER['DOCUMENT_ROOT'].$dir);
			}
		}
		$sql='DELETE FROM {{dealers_files}} '.$condition.$addingSql;
		DB::exec($sql);
	}

	private static function deletePrev($id){
		
	}
	public static function getOneFile($id){
		$sql='
			SELECT * FROM {{dealers_files}} WHERE id='.$id.'
		';
		return DB::getRow($sql);
	}
	public static function editFile(){
		DB::escapePost();
		$id = $_POST['id'];
		$name = $_POST['filename'][0];
		$pathsql='';
		if ($_FILES['upload']['error'][0] == 0) {
			$fileInfo = self::getOneFile($id);
			@unlink($_SERVER['DOCUMENT_ROOT'].$fileInfo['path']);
			$filename = self::processName($_FILES['upload']['name'][0],$fileInfo['dealer']);
			$dir = '/u/files/dealers/'.md5('touch'.$fileInfo['dealer']).'/';
			move_uploaded_file($_FILES['upload']['tmp_name'][0],$_SERVER['DOCUMENT_ROOT'].$dir.$filename);
			$pathsql=', path=\''.$dir.$filename.'\'';
		}
		$sql='
			UPDATE {{dealers_files}}
			SET 
				name=\''.(($name=='') ? $filename : $name).'\',
				comment=\''.$_POST['comment'].'\'
				'.$pathsql.'
			WHERE id='.$_POST['id'].'		
		';
		DB::exec($sql);
	}
	public static function delFile($id){
		$fileInfo = self::getOneFile($id);
		@unlink($_SERVER['DOCUMENT_ROOT'].$fileInfo['path']);
		self::cleanDir(pathinfo($fileInfo['path'],PATHINFO_DIRNAME));
		$sql='DELETE FROM {{dealers_files}} WHERE id='.$id;
		DB::exec($sql);
	}
	private static function cleanDir($dir){
		if(is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
			if(count(scandir($_SERVER['DOCUMENT_ROOT'].$dir))==2){
				rmdir($_SERVER['DOCUMENT_ROOT'].$dir);
			}
		}
	}
	public static function getCountFiles($dealer){
		$sql='SELECT COUNT(*) as cnt FROM {{dealers_files}} WHERE store=0 AND dealer='.$dealer;
		$res = DB::getRow($sql);
		return $res['cnt'];
	}
}
?>
