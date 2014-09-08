<?
class Cache {
	public static function set($name,$value){
		if(CACHE==1){
			file_put_contents($_SERVER['DOCUMENT_ROOT'].CACHE_DIR.$name.'.ch',serialize($value));
		}
	}
	public static function get($name){
		if(CACHE==1){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].CACHE_DIR.$name.'.ch')){
				return unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].CACHE_DIR.$name.'.ch'));
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public static function getCountCache(){
		$data=0;
		$d = dir($_SERVER['DOCUMENT_ROOT'].CACHE_DIR);
		while (false !== ($entry = $d->read())) {
			if($entry!='.' && $entry!='..'){
				$data++;
			}
		}
		return $data;
	}
	public static function clearCache(){
		$data=0;
		$d = dir($_SERVER['DOCUMENT_ROOT'].CACHE_DIR);
		while (false !== ($entry = $d->read())) {
			if($entry!='.' && $entry!='..'){
				unlink($_SERVER['DOCUMENT_ROOT'].CACHE_DIR.$entry);
			}
		}
	}
	public static function clearOneCache(){
		$path=$_SERVER['DOCUMENT_ROOT'].CACHE_DIR.$_POST['tab'].$_POST['id'].'.ch';
		if(file_exists($path)) unlink($path);
	}
	public static function setDB($name,$value){
		$sql='DELETE FROM {{cashe}} WHERE name=\''.substr($name,0,256).'\'';
		DB::exec($sql);
		$sql='INSERT INTO {{cashe}} SET name=\''.substr($name,0,256).'\', value=\''.serialize($value).'\', cdate='.time().'';
		DB::exec($sql);
	}
	public static function getDB($name){
		$sql='SELECT value FROM {{cashe}} WHERE name=\''.substr($name,0,256).'\' AND cdate>='.(time()-60*60*24*7).'';
		//print DB::prefix($sql);
		$value=DB::getOne($sql);
		if($value){
			return unserialize($value);
		}else{
			return false;
		}
	}
}
