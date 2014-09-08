<?
class Iuser{
	public static $insertFields=array('tree','modules');
	function __construct(){
		
	}
	function getUndefinedUsers($order='name'){
		$sql='SELECT * FROM {{iusers}} ORDER BY cdate';
		$users=DB::getPagi($sql);
		foreach($users as $i=>$item){
			$sql='
				SELECT * FROM {{igroups}}
				WHERE id='.$item['igroup'].'
			';
			$users[$i]['igroup']=DB::getRow($sql);
		}
		return $users;
	}
	public static function getGroupList(){
		$sql='SELECT * FROM {{igroups}} ORDER BY path';
		return DB::getAll($sql);
	}
	public static function getGroupListAll(){
		$sql='SELECT * FROM {{igroups}} ORDER BY path';
		return DB::getAll($sql);
	}
	public function getGroupUsers($groups, $field = ''){
		$ids = implode(',', $groups);
		$sql = "SELECT * FROM {{iusers}} `i` INNER JOIN {{igroups}} `g` ON `g`.id = `i`.igroup
				WHERE `g`.id IN ({$ids}) AND `i`.visible = 1
		";
		return DB::getAll($sql,$field);		
	}
	public static function getUserList($order='name'){
		if($_GET['igroup'])$addsql='AND igroup='.$_GET['igroup'];
		$sql='SELECT * FROM {{iusers}} WHERE 1=1 '.$addsql.' ORDER BY '.$order.'';
		if($_GET['q']){
			$fields='';
			foreach(OneSSA::$iuserStandart as $key=>$item){
				$fields.=' '.$key.' LIKE \'%'.$_GET['q'].'%\' OR';
			}
			$fields=substr($fields,0,strlen($fields)-2);
			$sql='SELECT * FROM {{iusers}} WHERE ('.$fields.') ORDER BY '.$order.'';
		}
		$users=DB::getPagi($sql);
		foreach($users as $i=>$item){
			$sql='SELECT name FROM {{igroups}} WHERE id='.$item['igroup'];
			$users[$i]['igroup']=DB::getOne($sql);
			$sql='SELECT string_value FROM {{iusers_adds}} WHERE name=\'company\' AND iuser='.$item['id'];
			$users[$i]['company']=DB::getOne($sql);
		}
		return $users;
	}
	function getEditGroup(){
		$sql='SELECT * FROM {{igroups}} WHERE id='.$_GET['id'].'';
		$data=DB::getRow($sql);
		return $data;
	}
	function getUser($id=''){
		if($id=='')$id=$_GET['id'];
		$sql='SELECT * FROM {{iusers}} WHERE id='.$id.'';
		$data=DB::getRow($sql);
		$sql='SELECT * FROM {{iusers_files}} WHERE iuser='.$id.'';
		$data['files']=DB::getAll($sql);
		$sql='SELECT * FROM {{iusers_adds}} WHERE iuser='.$id.'';
		$adds=DB::getAll($sql);
		foreach($adds as $item){
			$data['adds'][$item['name']]=$item['string_value'];
		}
		return $data;
	}
	public static function getIuser($id){
		$sql='SELECT * FROM {{iusers}} WHERE id='.$id.'';
		$data=DB::getRow($sql);
		$sql='SELECT * FROM {{iusers_files}} WHERE iuser='.$id.'';
		$data['files']=DB::getAll($sql);
		$sql='SELECT * FROM {{iusers_adds}} WHERE iuser='.$id.'';
		$adds=DB::getAll($sql);
		foreach($adds as $item){
			$data[$item['name']]=$item['string_value'];
		}
		return $data;
	}
	public static function addGroup(){
		DB::escapePost();
		$sql='
			INSERT INTO {{igroups}}
			SET 
				name=\''.$_POST['name'].'\',
				path=\''.$_POST['path'].'\'
		';
		DB::exec($sql);
	}
	function editGroup(){
		$sql='
			UPDATE {{igroups}}
			SET 
				name=\''.$_POST['name'].'\',
				path=\''.$_POST['path'].'\'
			WHERE id='.$_POST['id'].'
		';
		$group=DB::exec($sql);
	}
	function delGroup(){
		$sql='
			DELETE FROM {{igroups}}
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			UPDATE {{iusers}}
			SET igroup=0
			WHERE igroup='.$_GET['id'].'
		';
		DB::exec($sql);
	}
	public static function addUser(){
		DB::escapePost();
		$fields='';
		foreach(OneSSA::$iuserStandart as $key=>$item){
			if($key=='pass' && trim($_POST[$key])!=''){
				$fields.=''.$key.'=MD5(\''.$_POST[$key].'\'), ';
			}else{
				$fields.=''.$key.'=\''.$_POST[$key].'\', ';
			}
		}
		if($_POST['igroup']=='')$_POST['igroup']=0;
		$sql='
			INSERT INTO {{iusers}}
			SET 
				'.$fields.'
				igroup='.$_POST['igroup'].',
				cdate=NOW(),
				visible=1
		';
		$user=DB::exec($sql);
		$data=array();
		foreach(OneSSA::$iuserStandartAdds as $title=>$items){
			foreach($items as $key=>$item){
				if($item['main']!=1){
					if($item['type']=='bool'){
						$data[$key]=$_POST[$key]==1?'1':'0';
					}else{
						$data[$key]=$_POST[$key];
					}
				}
			}
		}
		foreach($data as $key=>$item){
			$sql='
				INSERT INTO {{iusers_adds}}
				SET iuser='.$user.',
					name=\''.$key.'\',
					string_value=\''.$_POST[$key].'\'
			';
			DB::exec($sql);
		}
		Iuser::upload($user);
		return $user;
	}
	function editUser(){
		DB::escapePost();
		$fields='';
		foreach(OneSSA::$iuserStandart as $key=>$item){
			if($key=='pass' && trim($_POST[$key])!=''){
				$fields.=''.$key.'=MD5(\''.$_POST[$key].'\'), ';
			}else{
				$fields.=''.$key.'=\''.$_POST[$key].'\', ';
			}
		}
		$user=$_POST['id'];
		if($_POST['igroup']=='')$_POST['igroup']=0;
		$sql='
			UPDATE {{iusers}}
			SET 
				'.$fields.'
				igroup='.$_POST['igroup'].'
			WHERE id='.$user.'
		';
		DB::exec($sql);
		$addingSql='';
		if(count($_POST['fileIds'])>0){
			$addingSql=' AND id NOT IN ('.implode(',',$_POST['fileIds']).') ';
		}
		$sql='
			SELECT path FROM {{iusers_files}} 
			WHERE iuser='.$user.' '.$addingSql.'
		';
		$delFiles=DB::getAll($sql,'path');
		foreach($delFiles as $item){
			unlink($_SERVER['DOCUMENT_ROOT'].$item);
		}
		$dir=md5('touch'.$user);
		$dir='/u/files/iusers/'.$dir.'/';
		if(is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
			if(count(scandir($_SERVER['DOCUMENT_ROOT'].$dir))==2){
				rmdir($_SERVER['DOCUMENT_ROOT'].$dir);
			}
		}
		$sql='
			DELETE FROM {{iusers_files}} 
			WHERE iuser='.$user.' '.$addingSql.'
		';
		DB::exec($sql);
		Iuser::upload($user);
		$sql='
			DELETE FROM {{iusers_adds}} 
			WHERE iuser='.$user.'
		';
		DB::exec($sql);
		$data=array();
		foreach(OneSSA::$iuserStandartAdds as $title=>$items){
			foreach($items as $key=>$item){
				if($item['main']!=1){
					if($item['type']=='bool'){
						$data[$key]=$_POST[$key]==1?'1':'0';
					}else{
						$data[$key]=$_POST[$key];
					}
				}
			}
		}
		foreach($data as $key=>$item){
			$sql='
				INSERT INTO {{iusers_adds}}
				SET iuser='.$user.',
					name=\''.$key.'\',
					string_value=\''.$_POST[$key].'\'
			';
			DB::exec($sql);
		}
	}
	public static function upload($user){
		if(is_array($_FILES['upload']['name'])){
			$dir=md5('touch'.$user);
			$dir='/u/files/iusers/'.$dir.'/';
			if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/u/files/iusers/')){
				mkdir($_SERVER['DOCUMENT_ROOT'].'/u/files/iusers/',0777);
			}
			if(!is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
				mkdir($_SERVER['DOCUMENT_ROOT'].$dir,0777);
			}
			foreach($_FILES['upload']['name'] as $key=>$item){
				$name=$item;
				if($_POST['filename'][$key]!='')$name=$_POST['filename'][$key];
				$sql='
					INSERT INTO {{iusers_files}}
					SET 
						iuser='.$user.',
						path=\''.$dir.$item.'\',
						name=\''.$name.'\'
				';
				DB::exec($sql);
				move_uploaded_file($_FILES['upload']['tmp_name'][$key],$_SERVER['DOCUMENT_ROOT'].$dir.$item);
			}
		}
	}
	function delUser(){
		$user=$_GET['id'];
		$sql='
			SELECT path FROM {{iusers_files}} 
			WHERE iuser='.$user.'
		';
		$delFiles=DB::getAll($sql,'path');
		foreach($delFiles as $item){
			unlink($_SERVER['DOCUMENT_ROOT'].$item);
		}
		$dir=md5('touch'.$user);
		$dir='/u/files/iusers/'.$dir.'/';
		if(is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
			if(count(scandir($_SERVER['DOCUMENT_ROOT'].$dir))==2){
				rmdir($_SERVER['DOCUMENT_ROOT'].$dir);
			}
		}
		$sql='
			DELETE FROM {{iusers_files}} 
			WHERE iuser='.$user.'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{iusers}}
			WHERE id='.$user.'
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
		$model=new Tree;
		$tree=$model->getTree();
		foreach($tree as $item){
			$sub=array();
			foreach($item['sub'] as $item2){
				$sub2=array();
				foreach($item2['sub'] as $item3){
					$sub2[]=array(
						'id'=>$item3['id'],
						'parent'=>$item3['parent'],
						'name'=>$item3['name'],
					);
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
	public static function generate_password($number){  
	    $arr = array('a','b','c','d','e','f',  
	                 'g','h','i','j','k','l',  
	                 'm','n','o','p','r','s',  
	                 't','u','v','x','y','z',  
	                 'A','B','C','D','E','F',  
	                 'G','H','I','J','K','L',  
	                 'M','N','O','P','R','S',  
	                 'T','U','V','X','Y','Z',  
	                 '1','2','3','4','5','6',  
	                 '7','8','9','0');  
	    // Генерируем пароль  
	    $pass = "";  
	    for($i = 0; $i < $number; $i++)  
	    {  
	      // Вычисляем случайный индекс массива  
	      $index = rand(0, count($arr) - 1);  
	      $pass .= $arr[$index];  
	    }  
	    return $pass;  
	}
	public static function checkFieldUnique(){
		$sql='SELECT count(*) FROM {{iusers}} WHERE '.$_POST['name'].'=\''.$_POST['value'].'\'';
		if(DB::getOne($sql)>0){
			return 'notunique';
		}
	}
}
?>