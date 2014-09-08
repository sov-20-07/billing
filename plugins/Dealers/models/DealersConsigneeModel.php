<?
class DealersConsignee {
	public static function getCount($id){
		$sql = 'SELECT COUNT(*) as cnt FROM {{dealers_consignee}} WHERE dealer = '.$id;
		$ret = DB::getRow($sql);
		return $ret['cnt'];
	}
	public static function getConsList($id,$visible=false){
		$vis = ($visible) ? ' AND visible = 1' : '';
		$sql = 'SELECT * FROM {{dealers_consignee}} WHERE dealer = '.$id.$vis;
		return DB::getALL($sql);
	}
	public static function getOne($id,$dealer = null){
		$add = ($dealer == null) ? '' : ' AND `dealer`='.$dealer;
		$sql = 'SELECT * FROM {{dealers_consignee}} WHERE id = '.$id.$add;
		return DB::getRow($sql);
	}
	public static function editCons($dealer = null){
		DB::escapePost();
		DB::escapeGet();
		$add = ($dealer == null) ? ' AND dealer=\''.$_POST['dealer'].'\'' : ' AND dealer=\''.$dealer.'\'';
		$sql='
			UPDATE {{dealers_consignee}}
			SET 
				title=\''.$_POST['title'].'\',
				form=\''.$_POST['form'].'\',
				company=\''.$_POST['company'].'\',
				address=\''.$_POST['address'].'\',
				phone=\''.$_POST['phone'].'\',
				name=\''.$_POST['name'].'\',
				mobile=\''.$_POST['mobile'].'\'
			WHERE id='.$_POST['id'].$add.'
		';
		DB::exec($sql);		
	}
	public static function addCons($dealer = null){
		DB::escapePost();
		DB::escapeGet();
		$add = ($dealer == null) ? $_POST['dealer'] : $dealer;
		$sql='
			INSERT INTO {{dealers_consignee}}
			SET 
				title=\''.$_POST['title'].'\',
				form=\''.$_POST['form'].'\',
				company=\''.$_POST['company'].'\',
				address=\''.$_POST['address'].'\',
				phone=\''.$_POST['phone'].'\',
				name=\''.$_POST['name'].'\',
				mobile=\''.$_POST['mobile'].'\',
				dealer=\''.$add.'\',
				visible=1
		';
		DB::exec($sql);		
	}
	public static function delCons(){
		DB::escapeGet();
		$sql='
			DELETE FROM {{dealers_consignee}} 
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);

	}
	public static function hideCons($id){
		//обезопасимся проверяя и id дилера через сессию
		$dealer = $_SESSION['dealer']['id'];
		$sql='UPDATE {{dealers_consignee}} SET visible=0 WHERE dealer=\''.$dealer.'\' AND id='.$id;
		DB::exec($sql);
	}	
}
?>
