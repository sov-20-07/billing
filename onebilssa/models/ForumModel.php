<?
class Forum{
	function getList(){
		$sql='SELECT * FROM {{forum}} WHERE parent=0 ORDER BY num';
		return DB::getPagi($sql);
	}
	function getElemList(){
		$sql='SELECT * FROM {{forum}} WHERE parent='.Funcs::$uri[2].' ORDER BY num';
		return DB::getPagi($sql);
	}
	function getEdit(){
		$sql='SELECT * FROM {{forum}} WHERE id='.$_GET['id'].'';
		return DB::getRow($sql);
	}
	function add(){
		$sql='
			INSERT INTO {{forum}}
			SET 
				parent='.$_POST['parent'].',
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				message=\''.trim($_POST['value']).'\',
				cdate=NOW(),
				visible=1
		';
		DB::exec($sql);
	}
	function edit(){
		$sql='
			UPDATE {{forum}}
			SET 
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				message=\''.trim($_POST['value']).'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	function del(){
		$ids=Tree::getChilds($_GET['id']);
		$ids[]=$_GET['id'];
		$sql='
			DELETE FROM {{forum}} 
			WHERE id IN ('.implode(',',$ids).')
		';
		DB::exec($sql);
	}
	function getTop(){
		if(Funcs::$uri[2]){
			$sql='SELECT parent FROM {{forum}} WHERE id='.Funcs::$uri[2].'';
			return DB::getOne($sql);
		}
	}
}
?>