<?
class Settings{
	function getList(){
		$sql='SELECT * FROM {{settings}} WHERE parent=0 ORDER BY num';
		return DB::getPagi($sql);
	}
	function getElemList(){
		$sql='SELECT * FROM {{settings}} WHERE parent='.Funcs::$uri[2].' ORDER BY num';
		return DB::getPagi($sql);
	}
	function getEdit(){
		$sql='SELECT * FROM {{settings}} WHERE id='.$_GET['id'].'';
		return DB::getRow($sql);
	}
	function getParent(){
		$sql='SELECT * FROM {{settings}} WHERE id='.Funcs::$uri[2].'';
		return DB::getRow($sql);
	}
	function add(){
		$sql='
			INSERT INTO {{settings}}
			SET 
				parent='.$_POST['parent'].',
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				value=\''.trim($_POST['value']).'\',
				visible=1
		';
		DB::exec($sql);
	}
	function edit(){
		$sql='
			UPDATE {{settings}}
			SET 
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				value=\''.trim($_POST['value']).'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	function del(){
		$sql='
			DELETE FROM {{settings}} 
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{settings}} 
			WHERE parent='.$_GET['id'].'
		';
		DB::exec($sql);
	}
}
?>