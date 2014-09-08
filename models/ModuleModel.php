<?
class Module{
	function __construct(){
		
	}
	public function getList(){
		$sql='SELECT * FROM {{modules}} ORDER BY num';
		return DB::getPagi($sql);
	}
	public function getModules(){
		$sql='SELECT * FROM {{modules}} ORDER BY num';
		return DB::getAll($sql);
	}
	public function getOne(){
		$sql='SELECT * FROM {{modules}} WHERE id='.$_GET['id'].'';
		return DB::getRow($sql);
	}
	
	public function getFieldList(){
		$sql='SELECT * FROM {{fields}} WHERE module='.$_GET['module'].' ORDER BY num';
		return DB::getPagi($sql);
	}
	public function getFieldOne(){
		$sql='SELECT * FROM {{fields}} WHERE id='.$_GET['id'].'';
		return DB::getRow($sql);
	}
	public static function getModuleByTree($id=''){
		if($id=='')$id=$_POST['parent'];
		if($id=='')$id=Funcs::$uri[1];
		if(is_numeric($id)){
			$sql='SELECT * FROM {{relations}} WHERE modul1=\'tree\' AND id1=\''.$id.'\'';
			$row=DB::getRow($sql);
			$sql='SELECT * FROM {{modules}} WHERE path=\''.$row['modul2'].'\'';
			return DB::getRow($sql);
		}else{
			return false;
		}
	}
	public static function getModuleById($id=''){
		if(is_numeric($id)){
			$sql='SELECT * FROM {{modules}} WHERE id='.$id.'';
			return DB::getRow($sql);
		}else{
			return false;
		}
	}
}
?>