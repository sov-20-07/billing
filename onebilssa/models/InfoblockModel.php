<?
class Infoblock{
	function __construct(){
		
	}
	function getList(){
		$sql='SELECT * FROM {{infoblock}} WHERE parent=0 ORDER BY num';
		return DB::getPagi($sql);
	}
	function getParent(){
		$sql='SELECT * FROM {{infoblock}} WHERE id='.Funcs::$uri[2].'';
		return DB::getRow($sql);
	}
	function getElemList(){
		$sql='SELECT * FROM {{infoblock}} WHERE parent='.Funcs::$uri[2].' ORDER BY num';
		return DB::getPagi($sql);
	}
	function getEdit(){
		$sql='SELECT * FROM {{infoblock}} WHERE id='.$_GET['id'].'';
		return DB::getRow($sql);
	}
	function add(){
		if($_POST['parent']=='0'){
			$sql='
				INSERT INTO {{infoblock}}
				SET 
					parent=0,
					name=\''.trim($_POST['name']).'\',
					path=\''.trim($_POST['path']).'\',
					visible=1
			';
		}else{
			$sql='
				INSERT INTO {{infoblock}}
				SET 
					parent='.$_POST['parent'].',
					name=\''.trim($_POST['name']).'\',
					path=\''.(trim($_POST['path'])==''?Funcs::Transliterate(trim($_POST['name'])):Funcs::Transliterate(trim($_POST['path']))).'\',
					description=\''.$_POST['description'].'\',
					source=\''.$_POST['source'].'\',
					type=\''.$_POST['type'].'\',
					bdate=\''.date('Y-m-d H:i:s',strtotime(trim($_POST['bdate']))).'\',
					edate=\''.date('Y-m-d H:i:s',strtotime(trim($_POST['edate']))).'\',
					visible=1
			';
		}
		DB::exec($sql);
	}
	function edit(){
		if($_POST['parent']=='0'){
			$sql='
				UPDATE {{infoblock}}
				SET 
					name=\''.trim($_POST['name']).'\',
					path=\''.trim($_POST['path']).'\'
				WHERE id='.$_POST['id'].'
			';
		}else{
			$sql='
				UPDATE {{infoblock}}
				SET 
					name=\''.trim($_POST['name']).'\',
					path=\''.(trim($_POST['path'])==''?Funcs::Transliterate(trim($_POST['name'])):Funcs::Transliterate(trim($_POST['path']))).'\',
					description=\''.$_POST['description'].'\',
					source=\''.$_POST['source'].'\',
					type=\''.$_POST['type'].'\',
					bdate=\''.date('Y-m-d H:i:s',strtotime(trim($_POST['bdate']))).'\',
					edate=\''.date('Y-m-d H:i:s',strtotime(trim($_POST['edate']))).'\'
				WHERE id='.$_POST['id'].'
			';
		}
		DB::exec($sql);
	}
	function del(){
		$sql='
			DELETE FROM {{infoblock}} 
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{infoblock}} 
			WHERE parent='.$_GET['id'].'
		';
		DB::exec($sql);
	}
}
?>