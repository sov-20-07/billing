<?
class Forms{
	public static $fieldsStandart=array(
		'string'=>'Строка',
		'text'=>'Текст',
		'select'=>'Выбор',
		'radio'=>'Радио (да/нет)',
		'checkbox'=>'Чекбокс',
		'hidden'=>'Скрытое'
	);
	function __construct(){
		
	}
	function getFormsList(){
		$sql='SELECT * FROM {{forms}} ORDER BY name';
		return DB::getPagi($sql);
	}
	function getForm($id){
		$sql='SELECT * FROM {{forms}} WHERE id='.$id.'';
		return DB::getRow($sql);
	}
	function getFieldsList(){
		$sql='SELECT * FROM {{forms_fields}} ORDER BY num';
		return DB::getPagi($sql);
	}
	function getField($id){
		$sql='SELECT * FROM {{forms_fields}} WHERE id='.$id.'';
		return DB::getRow($sql);
	}
	function addForm(){
		$sql='
			INSERT INTO {{forms}}
			SET 
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				formclass=\''.trim($_POST['formclass']).'\',
				action=\''.trim($_POST['action']).'\',
				method=\''.trim($_POST['method']).'\',
				submitclass=\''.trim($_POST['submitclass']).'\',
				theme=\''.trim($_POST['theme']).'\',
				redirect=\''.trim($_POST['redirect']).'\',
				email=\''.trim($_POST['email']).'\'
		';
		$group=DB::exec($sql);
	}
	function editForm(){
		$sql='
			UPDATE {{forms}}
			SET 
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				formclass=\''.trim($_POST['formclass']).'\',
				action=\''.trim($_POST['action']).'\',
				method=\''.trim($_POST['method']).'\',
				submitclass=\''.trim($_POST['submitclass']).'\',
				theme=\''.trim($_POST['theme']).'\',
				redirect=\''.trim($_POST['redirect']).'\',
				email=\''.trim($_POST['email']).'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	function delForm(){
		$sql='
			DELETE FROM {{forms}}
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{forms_fields}}
			WHERE forms='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{forms_answers}}
			WHERE forms='.$_GET['id'].'
		';
		DB::exec($sql);
	}
	function addField(){
		$sql='
			INSERT INTO {{forms_fields}}
			SET
				forms='.$_POST['form'].',
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				type=\''.trim($_POST['type']).'\',
				options=\''.trim($_POST['options']).'\',
				required='.$_POST['required'].'
		';
		$user=DB::exec($sql);
	}
	function editField(){
		$sql='
			UPDATE {{forms_fields}}
			SET
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				type=\''.trim($_POST['type']).'\',
				options=\''.trim($_POST['options']).'\',
				required='.$_POST['required'].'
			WHERE id='.$_POST['id'].'
		';
		$user=DB::exec($sql);
	}
	function delField(){
		$sql='
			DELETE FROM {{forms_fields}}
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
	}
}
?>