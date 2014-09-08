<?
class Feedback{
	function getList($what=''){
		$sqlAdd='WHERE status=\'new\'';
		if($what!=''){
			$sql='SELECT * FROM {{feedback}} WHERE status=\'done\' ORDER BY fdate DESC';
		}else{
			$sql='SELECT * FROM {{feedback}} WHERE status=\'new\' ORDER BY cdate DESC';
		}
		return DB::getPagi($sql);
	}
	public static function done(){
		$sql='
			UPDATE {{feedback}}
			SET comment=\''.$_POST['comment'].'\',
				fdate=NOW(),
				author=\''.$_SESSION['user']['login'].' '.$_SESSION['user']['name'].'\',
				status=\'done\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
}
?>