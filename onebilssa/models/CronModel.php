<?
class Cron{
	function __construct(){
		
	}
	function getList(){
		$sql='SELECT * FROM {{cron}} ORDER BY name';
		return DB::getPagi($sql);
	}
	function getEdit(){
		$sql='SELECT * FROM {{cron}} WHERE id='.$_GET['id'].'';
		$data=DB::getRow($sql);
		$data['timing']=explode(' ',$data['timing']);
		return $data;
	}
	function add(){
		foreach($_POST['timing'] as $key=>$item){
			$_POST['timing'][$key]=trim($item);
		}
		$sql='
			INSERT INTO {{cron}}
			SET 
				name=\''.trim($_POST['name']).'\',
				timing=\''.implode(' ',$_POST['timing']).'\',
				path=\''.trim($_POST['path']).'\',
				comment=\''.trim($_POST['comment']).'\',
				cdate=NOW(),
				user='.$_SESSION['user']['id'].',
				visible=1
		';
		DB::exec($sql);
	}
	function edit(){
		$sql='
			UPDATE {{cron}}
			SET 
				name=\''.trim($_POST['name']).'\',
				timing=\''.implode(' ',$_POST['timing']).'\',
				path=\''.trim($_POST['path']).'\',
				comment=\''.trim($_POST['comment']).'\',
				cdate=NOW(),
				user='.$_SESSION['user']['id'].'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	function del(){
		$sql='
			DELETE FROM {{cron}} 
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
	}
}
?>