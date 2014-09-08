<?
class DealersStores {
	public static function getStoresList($id = null,$visible = false) {
		$where = (is_null($id))?'':' WHERE {{dealers_stores}}.dealer='.$id;
		$where .= ($visible) ? ' AND visible = 1' : '';
		$sql = '
			SELECT {{dealers_stores}}.* ,{{dealers_status}}.shortname as statusname FROM {{dealers_stores}} 
			LEFT JOIN {{dealers_status}} ON {{dealers_stores}}.status = {{dealers_status}}.id
			'.$where.' ORDER by cdate
		';
		return DB::getAll($sql);
	}
	public static function getOne($id){
		$sql='
			SELECT {{dealers_stores}}.*, {{dealers_status}}.name as statusname
			FROM {{dealers_stores}}
			LEFT JOIN {{dealers_status}} ON {{dealers_stores}}.status = {{dealers_status}}.id
			WHERE {{dealers_stores}}.id='.$id.'
		';
		$data=DB::getRow($sql);
		$sql='SELECT * FROM {{dealers_files}} WHERE store='.$data['id'].'';
		$files = DB::getAll($sql);
		$data['files']=$files;
		return $data;
	}
	public static function getCount($id){
		$sql='SELECT COUNT(*) as cnt FROM {{dealers_stores}} WHERE dealer='.$id.'';
		$ret = DB::getRow($sql);
		return $ret['cnt'];
	}
	public static function editStore(){
		$sql='SELECT * FROM {{dealers_stores}} WHERE id='.$_POST['id'];
		$tmp=DB::getRow($sql);
		$oldstatus = $tmp['status'];
		DB::escapePost();
		$sql='
			UPDATE {{dealers_stores}}
			SET 
				title=\''.$_POST['title'].'\',
				status=\''.$_POST['status'].'\',
				region=\''.$_POST['region'].'\',
				city=\''.$_POST['city'].'\',
				street=\''.$_POST['street'].'\',
				house=\''.$_POST['house'].'\',
				work_time=\''.$_POST['work_time'].'\',
				phone=\''.$_POST['phone'].'\',
				email=\''.$_POST['email'].'\',
				contact=\''.$_POST['contact'].'\',
				contact_phone=\''.$_POST['contact_phone'].'\',
				comment=\''.$_POST['comment'].'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
		//файлы
		DealersFiles::uploadStorePhotos($_POST['id']);
		//оповещение
		if ($oldstatus != $_POST['status']) {
			DealersEmail::address_status($_POST['id']);
		}
	}
	public static function addStore(){
		DB::escapePost();
		$dealer = (isset($_POST['dealer'])) ? $_POST['dealer'] : $_SESSION['dealer']['id'];
		$sql='
			INSERT INTO {{dealers_stores}}
			SET 
				dealer=\''.$dealer.'\',
				title=\''.$_POST['title'].'\',
				status=\''.$_POST['status'].'\',
				region=\''.$_POST['region'].'\',
				city=\''.$_POST['city'].'\',
				street=\''.$_POST['street'].'\',
				house=\''.$_POST['house'].'\',
				work_time=\''.$_POST['work_time'].'\',
				phone=\''.$_POST['phone'].'\',
				email=\''.$_POST['email'].'\',
				contact=\''.$_POST['contact'].'\',
				contact_phone=\''.$_POST['contact_phone'].'\',
				comment=\''.$_POST['comment'].'\',
				visible=0
		';
		DB::exec($sql);
		$store = DB::getRow('SELECT LAST_INSERT_ID() as id FROM {{dealers_stores}}');
		DealersFiles::uploadStorePhotos($store['id']);
	}
	public static function delStore($id){
		$sql='
			DELETE FROM {{dealers_stores}} 
			WHERE id='.$id.'
		';
		DB::exec($sql);
		//удалить фотографии адреса
		DealersFiles::deleteAllStorePhotos($id);
	}
	public static function hideStore($id,$adm=false){
		//обезопасимся проверяя и id дилера через сессию
		$dealer = $_SESSION['dealer']['id'];		
		$check = ($adm) ? '' : ' AND dealer=\''.$dealer.'\'';
		$sql='UPDATE {{dealers_stores}} SET visible=0 WHERE id='.$id.$check;
		DB::exec($sql);
	}
	public static function showStore($id){
		$sql='UPDATE {{dealers_stores}} SET visible=1 WHERE id='.$id;
		DB::exec($sql);
		DealersEmail::address_new($id);
	}
}
?>
