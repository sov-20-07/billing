<?
class Dealers{
	public static $insertFields=array('tree','modules');
	function __construct(){
		
	}
	function getUndefinedDealers(){
		$data=array();
		//$sql='SELECT * FROM {{dealers}} ORDER BY cdate';
		
		$sql = '
			SELECT {{dealers}}.* ,{{dealers_status}}.shortname as statusname FROM {{dealers}} 
			INNER JOIN {{dealers_status}} ON {{dealers}}.status = {{dealers_status}}.id
			ORDER by cdate
		';
		
		$list=DB::getPagi($sql);
		foreach($list as $item){
			$item['stores_cnt']    = DealersStores::getCount($item['id']);
			$item['consignee_cnt'] = DealersConsignee::getCount($item['id']);
			$item['balance']       = self::getBalance($item['id']);
			$item['files']         = DealersFiles::getCountFiles($item['id']);
			$item['orders']        = DealersOrders::getOrdersCountByStatus($item['id']);
			$data[]=$item;
		}
		return $data;
	}
	public static function getShortList(){
		$sql = 'SELECT name, id FROM {{dealers}} ORDER by id';
		return DB::getAll($sql);
	}
	public static function getCityList(){
		$sql = 'SELECT DISTINCT city FROM {{dealers}} ORDER by id';
		return DB::getAll($sql);
	}
	
	function getOne($id){
		$sql='SELECT * FROM {{dealers}} WHERE id='.$id.'';
		$data=DB::getRow($sql);
		//$data['statuses'] = self::getStatuses();
		return $data;
	}
	public static function getStatuses(){
		$sql='SELECT * FROM {{dealers_status}} ORDER BY num';
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
	public static function addDealer(){
		DB::escapePost();
		if(trim($_POST['pass'])!=''){
			$pass='pass=MD5(\''.$_POST['pass'].'\'), ';
		}
		if(trim($_POST['passman'])!=''){
			$passman='passman=MD5(\''.$_POST['passman'].'\'), ';
		}
		$sql='
			INSERT INTO {{dealers}}
			SET 
				company=\''.$_POST['company'].'\',
				name=\''.$_POST['name'].'\',
				job=\''.$_POST['job'].'\',
				phone=\''.$_POST['phone'].'\',
				email=\''.$_POST['email'].'\',
				manager=\''.$_POST['manager'].'\',
				emailreport=\''.$_POST['emailreport'].'\',
				'.$pass.'
				'.$passman.'
				city=\''.$_POST['city'].'\',
				brands=\''.$_POST['brands'].'\',
				status=\'0\',
				comment=\''.$_POST['comment'].'\',
				cdate=NOW();
		';
		$user=DB::exec($sql);
		return $user;
	}
	function edit(){
		DB::escapePost();
		if(trim($_POST['pass'])!=''){
			$pass='pass=MD5(\''.$_POST['pass'].'\'), ';
		}
		if(trim($_POST['passman'])!=''){
			$passman='passman=MD5(\''.$_POST['passman'].'\'), ';
		}
		$sql='
			UPDATE {{dealers}}
			SET 
				company=\''.$_POST['company'].'\',
				name=\''.$_POST['name'].'\',
				job=\''.$_POST['job'].'\',
				phone=\''.$_POST['phone'].'\',
				email=\''.$_POST['email'].'\',
				manager=\''.$_POST['manager'].'\',
				emailreport=\''.$_POST['emailreport'].'\',
				'.$pass.'
				'.$passman.'
				city=\''.$_POST['city'].'\',
				brands=\''.$_POST['brands'].'\',
				status=\''.$_POST['status'].'\',
				comment=\''.$_POST['comment'].'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
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
		/*
		$delFiles=DB::getAll($sql,'path');
		foreach($delFiles as $item){
			unlink($_SERVER['DOCUMENT_ROOT'].$item);
		}
		$dir=md5('touch'.$user);
		$dir='/u/files/dealers/'.$dir.'/';
		if(is_dir($_SERVER['DOCUMENT_ROOT'].$dir)){
			if(count(scandir($_SERVER['DOCUMENT_ROOT'].$dir))==2){
				rmdir($_SERVER['DOCUMENT_ROOT'].$dir);
			}
		}
		*/
		/*
		$sql='
			DELETE FROM {{iusers_files}} 
			WHERE iuser='.$user.'
		';
		DB::exec($sql);
		*/
		$sql='
			DELETE FROM {{dealers}}
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
		$sql='SELECT count(*) FROM {{dealers}} WHERE '.$_POST['name'].'=\''.$_POST['value'].'\'';
		if(DB::getOne($sql)>0){
			return 'notunique';
		}
	}
	
	//	статус
	public static function addStatus(){
		DB::escapePost();
		$sql='
			INSERT INTO {{dealers_status}}
			SET 
				name=\''.$_POST['name'].'\',
				shortname=\''.$_POST['shortname'].'\',
				sale=\''.$_POST['sale'].'\'
		';
		DB::exec($sql);
		$id = DB::getRow('SELECT LAST_INSERT_ID() as last_id FROM {{dealers_status}}');
		self::processIcon($id['last_id']);
	}
	public static function getStatusList(){
		$sql='SELECT * FROM {{dealers_status}} ORDER BY num';
		return DB::getAll($sql);
	}
	public static function getStatus($id){
		$sql='SELECT * FROM {{dealers_status}} WHERE id='.$id;
		return DB::getRow($sql);
	}
	public static function editStatus(){
		DB::escapePost();
		$sql='
			UPDATE {{dealers_status}}
			SET 
				name=\''.$_POST['name'].'\',
				shortname=\''.$_POST['shortname'].'\',
				sale='.intval($_POST['sale']).'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
		self::processIcon(intval($_POST['id']));
		
	}
	private static function processIcon($id){
		if (isset($_FILES['icon']) && ($_FILES['icon']['error'] == 0)) {
			move_uploaded_file($_FILES['icon']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].UPLOAD_DIR.'images/dealers_status/'.intval($id).'.png');
		}		
	}
	
	// баланс
	public static function getBalanceHistory($id){
		$sql='SELECT * FROM {{dealers_balance}} WHERE `dealer` =\''.$id.'\' ORDER BY `cdate` ASC';
		return DB::getAll($sql);
	}
	public static function getBalance($id){
		$sql='SELECT SUM(`sum`) as sum FROM {{dealers_balance}} WHERE `dealer` =\''.$id.'\'';
		$data = DB::getRow($sql);
		return $data['sum'];		
	}
	public static function getTransaction($id){
		$sql='SELECT * FROM {{dealers_balance}} WHERE `id` =\''.$id.'\'';
		return DB::getRow($sql);
	}
	public static function setTransaction(){
		DB::escapePost();
		$sql='
			UPDATE {{dealers_balance}}
			SET 
				sum=\''.$_POST['sum'].'\',
				cdate=\''.$_POST['cdate'].'\',
				comment=\''.$_POST['comment'].'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	public static function addTransaction(){
		DB::escapePost();
		self::addToBalance($_POST['dealer'],$_POST['sum'],$_POST['comment'],$_POST['cdate']);
	}
	public static function delTransaction(){
		DB::escapeGet();
		$sql='
			DELETE FROM {{dealers_balance}} 
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);		
	}
	public static function addToBalance($dealer,$sum,$comment,$cdate = null){
		$cdate = (is_null($sdate)) ? 'NOW()' : '\''.$cdate.'\'';
		$sql='
			INSERT INTO {{dealers_balance}}
			SET 
				dealer=\''.$dealer.'\',
				sum=\''.$sum.'\',
				cdate='.$cdate.',
				comment=\''.$comment.'\'
		';
		DB::exec($sql);			
	}
}
?>
