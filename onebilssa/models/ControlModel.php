<?
class Control{
	function __construct(){
		
	}
	public function getList($parent=0){
		$sql='
			SELECT {{sites}}.*, {{lang}}.name AS lname, {{lang}}.value AS lvalue FROM {{sites}}
			INNER JOIN {{lang}} ON {{sites}}.lang={{lang}}.id
			WHERE {{sites}}.parent='.$parent.'
			ORDER BY {{sites}}.name
		';
		$list=DB::getPagi($sql);
		return $list;
	}
	public function getSite($id){
		$sql='
			SELECT {{sites}}.*, {{lang}}.name AS lname, {{lang}}.value AS lvalue FROM {{sites}}
			INNER JOIN {{lang}} ON {{sites}}.lang={{lang}}.id
			WHERE {{sites}}.id='.$id.'
		';
		return DB::getRow($sql);
	}
	public function getGroup($id){
		$sql='SELECT * FROM {{sites}} WHERE id='.$id.'';
		return DB::getRow($sql);
	}
	public function getGroups(){
		$sql='SELECT * FROM {{sites}} WHERE domain=\'\'';
		return DB::getAll($sql);
	}
	public function getLangList(){
		$sql='
			SELECT * FROM {{lang}}
			ORDER BY id
		';
		return DB::getPagi($sql);
	}
	public function getLang($id){
		$sql='
			SELECT * FROM {{lang}}
			WHERE id='.$id.'
		';
		return DB::getRow($sql);
	}
	function addSite(){
		$sql='
			INSERT INTO {{sites}}
			SET 
				parent='.($_POST['parent']==''?'0':$_POST['parent']).',
				name=\''.trim($_POST['name']).'\',
				domain=\''.trim($_POST['domain']).'\',
				lang='.$_POST['lang'].'
		';
		DB::exec($sql);
	}
	function addGroup(){
		$sql='
			INSERT INTO {{sites}}
			SET name=\''.trim($_POST['name']).'\'
		';
		DB::exec($sql);
	}
	function editSite(){
		$sql='
			UPDATE {{sites}}
			SET 
				parent='.($_POST['parent']==''?'0':$_POST['parent']).',
				name=\''.trim($_POST['name']).'\',
				domain=\''.trim($_POST['domain']).'\',
				lang='.$_POST['lang'].'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	function editGroup(){
		$sql='
			UPDATE {{sites}}
			SET name=\''.trim($_POST['name']).'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	function delSite(){
		$sql='
			DELETE FROM {{sites}}
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
	}
	function delGroup(){
		$sql='DELETE FROM {{sites}} WHERE id='.$_GET['id'].'';
		DB::exec($sql);
		$sql='DELETE FROM {{sites}} WHERE parent='.$_GET['id'].'';
		DB::exec($sql);
	}
	function addLang(){
		$sql='
			INSERT INTO {{lang}}
			SET 
				name=\''.trim($_POST['name']).'\',
				value=\''.trim($_POST['value']).'\'
		';
		DB::exec($sql);
	}
	function editLang(){
		$sql='
			UPDATE {{lang}}
			SET 
				name=\''.trim($_POST['name']).'\',
				value=\''.trim($_POST['value']).'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	function delLang(){
		$sql='
			DELETE FROM {{lang}}
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
	}
}
?>