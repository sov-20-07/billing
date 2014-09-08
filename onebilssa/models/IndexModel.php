<?
class Index{
	public $tree=array();
	public $left=0;
	function __construct(){
		
	}
	function getTree(){
		$sql='SELECT COUNT(*) as ctree FROM {{tree}}';
		return DB::getOne($sql);
	}
	function getModuleList(){
		$sql='SELECT * FROM {{modules}} ORDER BY num';
		return DB::getAll($sql);
	}
	function getBindModule(){
		$sql='
			SELECT * FROM {{relations}}
			WHERE modul1=\'tree\' AND id1=\''.Funcs::$uri[1].'\'
		';
		return DB::getRow($sql);
	}
	function getVersion(){
		$file=fopen($_SERVER['DOCUMENT_ROOT'].'/'.Funcs::$cdir.'/changelog.txt',r);
		$string=fgets($file,100);
		fclose($file);
		return $string;
	}
	function getCountCache(){
		$data=0;
		$d = dir($_SERVER['DOCUMENT_ROOT'].CACHE_DIR);
		while (false !== ($entry = $d->read())) {
			if($entry!='.' && $entry!='..'){
				$data++;
			}
		}
		return $data;
	}
	function clearCache(){
		$data=0;
		$d = dir($_SERVER['DOCUMENT_ROOT'].CACHE_DIR);
		while (false !== ($entry = $d->read())) {
			if($entry!='.' && $entry!='..'){
				unlink($_SERVER['DOCUMENT_ROOT'].CACHE_DIR.$entry);
			}
		}
	}
}
?>