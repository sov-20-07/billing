<?
class Translator{
	public static function getList(){
		$data=array();
		$langs=Translator::getLanguage();
		$sql='SELECT MAX(id) FROM {{translator}} WHERE parent=0 ORDER BY text';
		$lastId=DB::getOne($sql);
		$sql='SELECT * FROM {{translator}} WHERE parent=0 ORDER BY text';
		$list=DB::getPagi($sql);
		foreach($list as $i=>$item){
			$sql='
				SELECT * FROM {{translator}}
				WHERE parent='.$item['id'].'
			';
			$rows=DB::getALL($sql);
			foreach($langs as $ii=>$lang){
				if($ii==0){
					if($item['id']==$lastId)$data[$i]['last']='last';
					$data[$i]['sub'][]=$item;
				}else{
					foreach($rows as $row){
						if($row['lang']==$lang['value'])$data[$i]['sub'][]=$row;
					}
				}
			}
		}
		return $data;
	}
	public static function getOne($id){
		$data=array();
		$sql='
			SELECT * FROM {{translator}}
			WHERE id='.$id.'
		';
		$item=DB::getRow($sql);
		$sql='
			SELECT * FROM {{translator}}
			WHERE parent='.$item['id'].'
		';
		$rows=DB::getALL($sql);
		foreach(Translator::getLanguage() as $ii=>$lang){
			if($ii==0){
				$data[$item['lang']]=$item;
			}else{
				foreach($rows as $row){
					if($row['lang']==$lang['value'])$data[$row['lang']]=$row;
				}
			}
		}
		return $data;
	}
	public static function getLanguage(){
		$sql='
			SELECT DISTINCT {{lang}}.* FROM {{lang}} 
			INNER JOIN {{sites}} ON {{lang}}.id={{sites}}.lang
			ORDER BY {{sites}}.id
		';
		return DB::getAll($sql);
	}
	public function add(){
		$i=0;
		$parent=0;
		foreach($_POST['translator'] as $key=>$item){
			if($i==0){
				$sql='
					INSERT INTO {{translator}}
					SET text=\''.$item.'\',
						lang=\''.$key.'\'
						
				';
				$parent=DB::exec($sql);
			}else{
				$sql='
					INSERT INTO {{translator}}
					SET 
						parent='.$parent.',
						text=\''.$item.'\',
						lang=\''.$key.'\'
						
				';
				DB::exec($sql);
			}
			$i++;
		}
	}
	public static function edit(){
		$sql='
			DELETE FROM {{translator}}
			WHERE parent='.Funcs::$uri[3].'
		';
		DB::exec($sql);
		$i=0;
		foreach($_POST['translator'] as $key=>$item){
			if($i==0){
				$sql='
					UPDATE {{translator}}
					SET text=\''.$item.'\'
					WHERE id='.Funcs::$uri[3].'
						
				';
				DB::exec($sql);
			}else{
				$sql='
					INSERT INTO {{translator}}
					SET 
						parent='.Funcs::$uri[3].',
						text=\''.$item.'\',
						lang=\''.$key.'\'
						
				';
				DB::exec($sql);
			}
			$i++;
		}
	}
	public static function del(){
		$sql='
			DELETE FROM {{translator}}
			WHERE id='.Funcs::$uri[3].'
		';
		DB::exec($sql);
		$sql='
			DELETE FROM {{translator}}
			WHERE parent='.Funcs::$uri[3].'
		';
		DB::exec($sql);
	}
	public static function t($text){
		$return='';
		if(is_numeric($text)){
			$sql='SELECT id FROM {{translator}} WHERE id='.$text.'';
		}else{
			$sql='SELECT id FROM {{translator}} WHERE text=\''.$text.'\'';
		}
		$parent=DB::getOne($sql);
		if($parent){
			$sql='SELECT text FROM {{translator}} WHERE (parent='.$parent.' OR id='.$parent.') AND lang=\''.Funcs::$lang.'\'';
			$tr=DB::getOne($sql);
			if($tr) $return=$tr;
			else $return=$text;
		}else{
			$return=$text;
		}
		if($_GET['translator']=='true'){ //Если есть переменная, то в скобках показан запрос
			return $return.' ('.$text.')';
		}else{
			return $return;
		}
	}
}
?>