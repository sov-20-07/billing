<?php
class DealersBalance {
	public static function getBalanceHistory($id){
		$sql='SELECT * FROM {{dealers_balance}} WHERE `dealer` =\''.$id.'\' ORDER BY `cdate` ASC';
		return DB::getAll($sql);
	}
	public static function getBalance($id){
		$sql='SELECT SUM(`sum`) as sum FROM {{dealers_balance}} WHERE `dealer` =\''.$id.'\'';
		$data = DB::getRow($sql);
		return $data['sum'];
	}
	public static function getBalanceHistoryPage($id,$page,$count){
		$sql='SELECT * 
			FROM {{dealers_balance}}
			WHERE `dealer` =\''.$id.'\'
			ORDER BY `cdate` DESC
			LIMIT '.$count*($page-1).', '.$count.'						
			';
		return DB::getAll($sql);
	}
	
}
