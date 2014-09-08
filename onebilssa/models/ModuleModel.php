<?
class Module{
	function __construct(){
		
	}
	public function getList(){
		$sql='SELECT * FROM {{modules}} ORDER BY num';
		return DB::getPagi($sql);
	}
	public function getModules(){
		$sql='SELECT * FROM {{modules}} ORDER BY num';
		return DB::getAll($sql);
	}
	public function getOne($id){
		$sql='SELECT * FROM {{modules}} WHERE id='.$id.'';
		return DB::getRow($sql);
	}
	public function add(){
		$moduleCatalog='';
		if($_POST['moduleCatalog'])$moduleCatalog=', catalog=\''.$_POST['moduleCatalog'].'\'';
		$sql='
			INSERT INTO {{modules}}	
			SET
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				type=\''.trim($_POST['type']).'\',
				params=\''.trim($_POST['params']).'\'
				'.$moduleCatalog.'
		';
		$id=DB::exec($sql);
		if($_POST['type']=='spage'){
			$sql='
				INSERT INTO {{fields}} (name,path,type,module,outerf,innerf,num,required)
				VALUES
					(\'Анонс\',\'preview\',\'text\','.$id.',0,1,2,0),
					(\'Текст\',\'fulltext\',\'editor\','.$id.',0,1,3,0)
			';
			DB::exec($sql);
		}elseif($_POST['type']=='epage'){
			$sql='
				INSERT INTO {{fields}} (name,path,type,module,outerf,innerf,num,required)
				VALUES
					(\'Анонс\',\'preview\',\'text\','.$id.',0,1,2,0)
			';
			DB::exec($sql);
		}elseif($_POST['type']=='cat'){
			/*$sql='
				CREATE TABLE IF NOT EXISTS `{{'.trim($_POST['path']).'}}` (
					`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`tree` INT UNSIGNED NOT NULL ,
					`art` VARCHAR( 255 ) NOT NULL ,
					`model` VARCHAR( 255 ) NOT NULL ,
					`description` TEXT NOT NULL ,
					`yandex_description` TEXT NOT NULL ,
					`price` FLOAT NOT NULL ,
					`subprice` FLOAT NOT NULL ,
					`currencyId` VARCHAR( 3 ) NOT NULL ,
					`type` VARCHAR( 255 ) NOT NULL ,
					`vendor` INT UNSIGNED NOT NULL ,
					`typePrefix` VARCHAR( 255 ) NOT NULL ,
					`stock` BOOLEAN NOT NULL ,
					`available` BOOLEAN NOT NULL ,
					`bid` INT NOT NULL ,
					`cbid` INT NOT NULL ,
					`manufacturer_warranty` BOOLEAN NOT NULL
					) ENGINE = MYISAM ;
			';
			DB::exec($sql);*/
			$sql='
				INSERT INTO {{fields}} (name,path,type,module,outerf,innerf,num,required,params)
				VALUES
					(\'Артикул\',\'art\',\'string\','.$id.',0,11,9,0,\'\'),
					(\'Модель\',\'model\',\'string\','.$id.',1,1,1,1,\'\'),
					(\'Описание\',\'description\',\'editor\','.$id.',0,1,2,0,\'\'),
					(\'Описание на Яндекс\',\'yandex_description\',\'text\','.$id.',0,1,3,0,\'\'),
					(\'Цена\',\'price\',\'float\','.$id.',0,1,4,0,\'\'),
					(\'Цена закупки\',\'subprice\',\'float\','.$id.',0,1,5,0,\'\'),
					(\'Валюта\',\'currencyId\',\'select\','.$id.',0,1,6,0,\'settings-currency-path-name\'),
					(\'Тип\',\'type\',\'string\','.$id.',0,1,7,0,\'\'),
					(\'Производитель\',\'vendor\',\'select\','.$id.',0,1,8,0,\'settings-vendor-id-name\'),
					(\'Префикс\',\'typePrefix\',\'string\','.$id.',0,1,9,0,\'\'),
					(\'Наличие\',\'available\',\'radio\','.$id.',0,1,10,0,\'\'),
					(\'Маркет\',\'market\',\'radio\','.$id.',0,11,9,0,\'\'),
					(\'bid\',\'bid\',\'integer\','.$id.',0,1,12,0,\'\'),
					(\'cbid\',\'cbid\',\'integer\','.$id.',0,1,13,0,\'\'),
					(\'Гарантия\',\'manufacturer_warranty\',\'radio\','.$id.',0,1,14,0,\'\')
					
			';
			DB::exec($sql);
			$sql='
				INSERT INTO {{modules}}	
				SET
					name=\''.trim($_POST['name']).' разделы\',
					path=\'struct_'.trim($_POST['path']).'\',
					type=\'struct\',
					params=\''.trim($_POST['params']).'\'
			';
			$id=DB::exec($sql);
			$sql='
				INSERT INTO {{fields}} (name,path,type,module,outerf,innerf,num,required)
				VALUES
					(\'Текст\',\'fulltext\',\'editor\','.$id.',0,1,3,0)
			';
			DB::exec($sql);
		}
	}
	public function edit(){
		$moduleCatalog='';
		if($_POST['moduleCatalog'])$moduleCatalog=', catalog=\''.$_POST['moduleCatalog'].'\'';
		$sql='
			UPDATE {{modules}}
			SET
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				type=\''.trim($_POST['type']).'\',
				params=\''.trim($_POST['params']).'\'
				'.$moduleCatalog.'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	public function del(){
		$sql='
			DELETE FROM {{modules}}
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{fields}}
			WHERE module='.$_GET['id'].'
		';
		DB::exec($sql);
	}
	public function getFieldList($id='',$all=''){
		if($id=='')$id=$_GET['module'];
		$sql='SELECT * FROM {{fields}} WHERE module='.$id.' ORDER BY num';
		if($all==''){
			return DB::getPagi($sql);
		}else{
			return DB::getAll($sql);
		}
	}
	public function getFieldOne(){
		$sql='SELECT * FROM {{fields}} WHERE id='.$_GET['id'].'';
		return DB::getRow($sql);
	}
	public function fieldAdd(){
		$sql='
			INSERT INTO {{fields}}
			SET
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				type=\''.trim($_POST['type']).'\',
				module='.$_POST['module'].',
				outerf='.$_POST['outerf'].',
				innerf='.$_POST['innerf'].',
				required='.$_POST['required'].',
				params=\''.trim($_POST['params']).'\'
		';
		$id=DB::exec($sql);
	}
	public function fieldEdit(){
		$sql='
			UPDATE {{fields}}
			SET
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				type=\''.trim($_POST['type']).'\',
				outerf='.$_POST['outerf'].',
				innerf='.$_POST['innerf'].',
				required='.$_POST['required'].',
				params=\''.trim($_POST['params']).'\'
			WHERE
				id='.$_POST['id'].'
		';
		$id=DB::exec($sql);
	}
	public function fieldDel(){
		$sql='
			DELETE FROM {{fields}}
			WHERE id='.$_GET['id'].'
		';
		DB::exec($sql);
	}
	public static function getModuleByTree($id='', $razd=1){
		if($id=='')$id=$_POST['parent'];
		if($id=='')$id=Funcs::$uri[1];
		
		if(is_numeric($id)){
			$sql='SELECT * FROM {{relations}} WHERE modul1=\'tree\' AND id1=\''.$id.'\' AND id2='.$razd.'';
			$row=DB::getRow($sql);
			if(!$row){
				$sql='SELECT * FROM {{relations}} WHERE modul1=\'tree\' AND id1=\''.$id.'\'';
				$row=DB::getRow($sql);
			}
			$sql='SELECT * FROM {{modules}} WHERE path=\''.$row['modul2'].'\'';
			return DB::getRow($sql);
		}else{
			return false;
		}
	}
	public static function getModuleByPath($path){
		$sql='SELECT * FROM {{modules}} WHERE path=\''.$path.'\'';
		return DB::getRow($sql);
	}
	public static function getModuleById($id=''){
		if(is_numeric($id)){
			$sql='SELECT * FROM {{modules}} WHERE id='.$id.'';
			return DB::getRow($sql);
		}else{
			return false;
		}
	}
	public function getIdElementModule($id){
		$sql='SELECT path FROM {{modules}} WHERE id='.$id.'';
		$path=DB::getOne($sql);
		if($path!=chr(39)){		
			$sql='SELECT id FROM {{modules}} WHERE path=\''.str_replace('struct_','',$path).'\'';
			return DB::getOne($sql);
		}else{
			return '';
		}
		
	}
	public function createPageContent(){
		$sql='
			INSERT INTO {{modules}}	
			SET
				name=\'Контент\',
				path=\'page\',
				type=\'page\',
				params=\'\'
		';
		$id=DB::exec($sql);
		$sql='
			INSERT INTO {{fields}} (name,path,type,module,outerf,innerf,num,required)
			VALUES
				(\'Текст\',\'fulltext\',\'editor\','.$id.',0,1,3,0)
		';
		DB::exec($sql);
	}
}
?>