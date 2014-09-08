<?
class Tools{
	public static function getPropertiesList(){
		$data=array();
		$sql='SELECT * FROM {{properties}} ORDER BY id';
		$data=DB::getAll($sql);
		return $data;
	}
	public static function getRedirectsList(){
		$data=array();
		$sql='SELECT * FROM {{redirects}} ORDER BY valfrom, valto';
		$data['list']=DB::getAll($sql);
		return $data;
	}
	public static function setRedirects(){
		$sql='
			INSERT INTO {{redirects}} 
			SET valfrom=\''.$_POST['valfrom'].'\', 
				valto=\''.$_POST['valto'].'\'
		';
		DB::exec($sql);
	}
	public static function delRedirects(){
		$sql='DELETE FROM {{redirects}} WHERE id='.$_GET['id'].'';
		DB::exec($sql);
	}
	public static function saveProperties(){
		$data=array();
		foreach($_POST as $key=>$item){
			$sql='UPDATE {{properties}} SET value=\''.$item.'\' WHERE path=\''.$key.'\'';
			DB::exec($sql);
		}
	}
	public static function exportDB(){
		$path=$_SERVER['DOCUMENT_ROOT'].'/../export.sql';
		$cmd='mysqldump -u'.BDLOGIN.' -p'.BDPASS.' -h'.BDHOST.' '.BDNAME.' > '.$path.'; ls;';
		if(shell_exec($cmd)){
			header('Content-Type: text/html; charset=utf-8');
			header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: post-check=0, pre-check=0', FALSE);
			header('Pragma: no-cache');
			header('Content-transfer-encoding: binary');
			header('Content-Disposition: attachment; filename='.$_SERVER['HTTP_HOST'].'-'.date('d-m-Y').'.sql');
			header('Content-Type: application/octet-stream');
			$file=file_get_contents($path);
			unlink($path);
			print $file;
		}else{
			print 'Ошибка! Возможно у вас отключена функция shell_exec, недостаточно прав на запись файла или не хватает места на диске';
		}
	}
	public static function importDB(){
		if($_FILES['upload']['tmp_name']){
			$path=$_SERVER['DOCUMENT_ROOT'].'/../import.sql';
			move_uploaded_file($_FILES['upload']['tmp_name'],$path);
			$cmd='mysql -u'.BDLOGIN.' -p'.BDPASS.' -h'.BDHOST.' '.BDNAME.' < '.$path.'';
			try{
				shell_exec($cmd);
				unlink($path);
			}catch(Exception $e){
				print $e;
			}
		}
	}
	public static function getSql(){
		$data['tables']=array();
		$sql='SHOW TABLES';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data['tables'][]=end($item);
		}
		return $data;
	}
	public static function execSql($sql){
		if(strpos(strtolower($sql),'delete')!==false || strpos(strtolower($sql),'insert')!==false || strpos(strtolower($sql),'update')!==false){
			$q=mysql_query(DB::prefix($sql));
			if($q){
				return array(0=>array('Ответ'=>'Запрос выполнен успешно'));
			}else{
				return array(0=>array('Ошибка'=>mysql_error()));
			}
		}else{
			$data=array();
			$q=mysql_query(DB::prefix($sql));
			if($q){
				while($row=mysql_fetch_assoc($q)){
					if($one==''){
						$data[]=$row;
					}else{
						$data[]=$row[$one];
					}
				}
				return $data;
			}else{
				return array(0=>array('Ошибка'=>mysql_error()));
			}
		}
	}
}
?>