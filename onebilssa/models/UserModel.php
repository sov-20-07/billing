<?
class User{
	public static $insertFields=array('tree','modules');
	function __construct(){
		
	}
	function getGroupList(){
		$sql='SELECT * FROM {{groups}} ORDER BY name';
		return DB::getPagi($sql);
	}
	function getUserList($order='name'){
		$sql='SELECT * FROM {{users}} ORDER BY '.$order.'';
		$users=DB::getPagi($sql);
		foreach($users as $i=>$item){
			$sql='
				SELECT {{groups}}.name FROM {{groups}}
				INNER JOIN {{relations}} ON {{groups}}.id={{relations}}.id2
				WHERE {{relations}}.modul1=\'users\' AND {{relations}}.modul2=\'groups\' AND id1='.$item['id'].'
				ORDER BY {{groups}}.name
			';
			$users[$i]['groups']=DB::getAll($sql,'name');
		}
		return $users;
	}
	function getEditGroup(){
		$sql='SELECT * FROM {{groups}} WHERE id='.$_GET['id'].'';
		$data=DB::getRow($sql);
		$sql='SELECT access FROM {{access}} WHERE module=\'tree\' AND groups='.$_GET['id'].'';
		$data['access']['tree']=DB::getAll($sql,'access');
		$sql='SELECT access FROM {{access}} WHERE module=\'modules\' AND groups='.$_GET['id'].'';
		$data['access']['modules']=DB::getAll($sql,'access');
		return $data;
	}
	function getEditUser(){
		$sql='SELECT * FROM {{users}} WHERE id='.$_GET['id'].'';
		$data=DB::getRow($sql);
		$sql='SELECT access FROM {{access}} WHERE module=\'tree\' AND users='.$_GET['id'].'';
		$data['access']['tree']=DB::getAll($sql,'access');
		$sql='SELECT access FROM {{access}} WHERE module=\'modules\' AND users='.$_GET['id'].'';
		$data['access']['modules']=DB::getAll($sql,'access');
		$sql='SELECT id2 FROM {{relations}} WHERE modul1=\'users\' AND modul2=\'groups\' AND id1='.$_GET['id'].'';
		$data['groups']=DB::getAll($sql,'id2');
		return $data;
	}
	public static function getUser($id){
		$sql='SELECT * FROM {{users}} WHERE id='.$id.'';
		$data=DB::getRow($sql);
		$sql='SELECT access FROM {{access}} WHERE module=\'tree\' AND users='.$id.'';
		$data['access']['tree']=DB::getAll($sql,'access');
		$sql='SELECT access FROM {{access}} WHERE module=\'modules\' AND users='.$id.'';
		$data['access']['modules']=DB::getAll($sql,'access');
		$sql='SELECT id2 FROM {{relations}} WHERE modul1=\'users\' AND modul2=\'groups\' AND id1='.$id.'';
		$data['groups']=DB::getAll($sql,'id2');
		return $data;
	}
	function addGroup(){
		$sql='
			INSERT INTO {{groups}}
			SET 
				name=\''.trim($_POST['name']).'\',
				cdate=NOW(),
				visible=1
		';
		$group=DB::exec($sql);
		foreach(User::$insertFields as $field){
			if(is_array($_POST[$field])){
				foreach($_POST[$field] as $item){
					$sql='
						INSERT INTO {{access}}
						SET 
							groups='.$group.',
							module=\''.$field.'\',
							access=\''.$item.'\'
					';
					DB::exec($sql);
				}
			}
		}
	}
	function editGroup(){
		$sql='
			UPDATE {{groups}}
			SET name=\''.trim($_POST['name']).'\'
			WHERE id='.$_POST['id'].'
		';
		$group=DB::exec($sql);
		$sql='
			DELETE FROM {{access}}
			WHERE groups='.$_POST['id'].'
		';
		DB::exec($sql);
		foreach(User::$insertFields as $field){
			if(is_array($_POST[$field])){
				foreach($_POST[$field] as $item){
					$sql='
						INSERT INTO {{access}}
						SET 
							groups='.$_POST['id'].',
							module=\''.$field.'\',
							access=\''.$item.'\'
					';
					DB::exec($sql);
				}
			}
		}
	}
	function delGroup(){
		$sql='
			DELETE FROM {{groups}}
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{access}}
			WHERE groups='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{relations}}
			WHERE modul1=\'users\' AND modul2=\'groups\' AND id2='.$_GET['id'].'
		';
		DB::exec($sql);
	}
	function addUser(){
		$sql='
			INSERT INTO {{users}}
			SET 
				name=\''.trim($_POST['name']).'\',
				email=\''.trim($_POST['email']).'\',
				phone=\''.trim($_POST['phone']).'\',
				login=\''.trim($_POST['login']).'\',
				pass=\''.md5(trim($_POST['pass'])).'\',
				cdate=NOW(),
				author='.$_SESSION['user']['id'].',
				visible=1
		';
		$user=DB::exec($sql);
		if(is_array($_POST['groups'])){
			foreach($_POST['groups'] as $item){
				$sql='
					INSERT INTO {{relations}}
					SET 
						modul1=\'users\',
						modul2=\'groups\',
						id1='.$user.',
						id2='.$item.'
				';
				DB::exec($sql);
			}
		}
		foreach(User::$insertFields as $field){
			if(is_array($_POST[$field])){
				foreach($_POST[$field] as $item){
					$sql='
						INSERT INTO {{access}}
						SET 
							users='.$user.',
							module=\''.$field.'\',
							access=\''.$item.'\'
					';
					DB::exec($sql);
				}
			}
		}
	}
	function editUser(){
		if(trim($_POST['pass'])){
			$pass='pass=\''.md5(trim($_POST['pass'])).'\',';
		}
		$sql='
			UPDATE {{users}}
			SET 
				name=\''.trim($_POST['name']).'\',
				email=\''.trim($_POST['email']).'\',
				phone=\''.trim($_POST['phone']).'\',
				'.$pass.'
				login=\''.trim($_POST['login']).'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{relations}}
			WHERE modul1=\'users\' AND modul2=\'groups\' AND id1='.$_POST['id'].'
		';
		DB::exec($sql);
		if(!empty($_POST['groups'])){
			foreach($_POST['groups'] as $item){
				$sql='
					INSERT INTO {{relations}}
					SET 
						modul1=\'users\',
						modul2=\'groups\',
						id1='.$_POST['id'].',
						id2='.$item.'
				';
				DB::exec($sql);
			}
		}
		$sql='
				DELETE FROM {{access}}
				WHERE users='.$_POST['id'].'
		';
		DB::exec($sql);
		foreach(User::$insertFields as $field){
			if(is_array($_POST[$field])){
				foreach($_POST[$field] as $item){
					$sql='
						INSERT INTO {{access}}
						SET 
							users='.$_POST['id'].',
							module=\''.$field.'\',
							access=\''.$item.'\'
					';
					DB::exec($sql);
				}
			}
		}		
	}
	function delUser(){
		$sql='
			DELETE FROM {{users}}
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{relations}}
			WHERE modul1=\'users\' AND modul2=\'groups\' AND id1='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{access}}
			WHERE users='.$_GET['id'].'
		';
		DB::exec($sql);
	}
	public static function getInfo($id,$field=''){
		if($id==0){
			$user['access']['modules']=array_keys(OneSSA::$modulesStandart);
			$user['name']='unknown';
			return $user;
		}
		$access=array();
		$sql='SELECT * FROM {{users}} WHERE id='.$id.'';
		$user=DB::getRow($sql);
		$sql='
				SELECT {{groups}}.* FROM {{groups}}
				INNER JOIN {{relations}} ON {{groups}}.id={{relations}}.id2
				WHERE {{relations}}.modul1=\'users\' AND {{relations}}.modul2=\'groups\' AND id1='.$id.'
				ORDER BY {{groups}}.name
		';
		$user['groups']=DB::getAll($sql);
		foreach($user['groups'] as $group){
			$sql='SELECT * FROM {{access}} WHERE groups='.$group['id'].'';
			$temp=DB::getAll($sql);
			foreach($temp as $item){
				$access[$item['module']][]=$item['access'];
			}
		}
		$sql='SELECT * FROM {{access}} WHERE users='.$id.'';
		$temp=DB::getAll($sql);
		foreach($temp as $item){
			$access[$item['module']][]=$item['access'];
		}
		$user['access']=$access;
		return $user;
	}
	public static function getTree(){
		$data=array();
		$tree=User::getFullTree();
		foreach($tree as $item){
			$sub=array();
			foreach($item['sub'] as $item2){
				$sub2=array();
				foreach($item2['sub'] as $i=>$item3){
					if($i<10){
						$sub2[]=array(
							'id'=>$item3['id'],
							'parent'=>$item3['parent'],
							'name'=>$item3['name'],
						);
					}
				}
				$sub[]=array(
					'id'=>$item2['id'],
					'parent'=>$item2['parent'],
					'name'=>$item2['name'],
					'sub'=>$sub2
				);
			}
			$data[]=array(
				'id'=>$item['id'],
				'parent'=>$item['parent'],
				'name'=>$item['name'],
				'sub'=>$sub
			);
		}
		return $data;
	}
	public static function getFullTree(){
		$data=array();
		$tree=array();
		$sql='SELECT * FROM {{tree}} WHERE 1=1 OR site<>-1 ORDER BY num ASC';
		$list=DB::getAll($sql);
		foreach($list as $item){
			Tree::$treeArray[$item['parent']][$item['id']]=$item;
		}
		foreach(Tree::$treeArray[0] as $item){
			$item['sub']=Tree::getBranch($item['id']);
			$data[]=$item;
		}
		return $data;
	}
}
?>