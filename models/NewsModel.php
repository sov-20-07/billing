<?
class News{
	public static $monthsRus=array('янв',"фев","мар","апр","мая","июн","июл","авг","сен","окт","ноя","дек");
	public static $delsalt='in45ungy0m2v';
	public static $sort=array(''=>'Свежее','comment'=>'Комментируемое','interesting'=>'Интересное','popularity'=>'Популярное');
	public function getList($id,$count=''){
		$data=array();
		$sort='ORDER BY udate DESC';
		if($_GET['sort']=='comment')$sort='ORDER BY {{sort}}.countComments DESC';
		if($_GET['sort']=='interesting')$sort='ORDER BY {{tree}}.num';
		if($_GET['sort']=='popularity')$sort='ORDER BY {{sort}}.popularity DESC';
		if($count!=''){
			$sql='SELECT * FROM {{tree}} WHERE parent='.$id.' AND visible=1 '.$sort.' LIMIT 0,'.$count;
		}elseif($_GET['d']){
			$d=explode('-',$_GET['d']);
			$db=date('Y-m-d 00:00:01', strtotime($d[0].'-'.$d[1].'-'.$d[2].' 00:00:01'));
			$de=date('Y-m-d 00:00:01', strtotime($d[0].'-'.$d[1].'-'.$d[2].' 00:00:01 +1 day'));
			$sql='
				SELECT {{tree}}.id, {{tree}}.parent FROM {{tree}}
				LEFT JOIN {{sort}} ON {{tree}}.id={{sort}}.tree
				WHERE parent='.$id.' AND visible=1 AND (udate BETWEEN \''.$db.'\' AND \''.$de.'\') 
				ORDER BY udate DESC
			';
		}elseif($_GET['tag']){
			$sql='
				SELECT {{tree}}.id, {{tree}}.parent FROM {{tree}}
				INNER JOIN ( {{data}} 
					INNER JOIN ({{relations}} 
						INNER JOIN {{reference}} ON {{relations}}.id2={{reference}}.id
					) ON {{data}}.id={{relations}}.id1
				) ON {{tree}}.id={{data}}.tree
				LEFT JOIN {{sort}} ON {{tree}}.id={{sort}}.tree
				WHERE {{tree}}.parent='.$id.' AND {{data}}.path=\'tags\' AND {{tree}}.visible=1 AND {{reference}}.name=\''.$_GET['tag'].'\'
				'.$sort.'
			';
		}else{
			$sql='
				SELECT {{tree}}.id, {{tree}}.parent FROM {{tree}} 
				LEFT JOIN {{sort}} ON {{tree}}.id={{sort}}.tree
				WHERE parent='.$id.' AND visible=1 
				'.$sort.'
			';
		}
		$list=DB::getPagi($sql,'id');
		foreach ($list as $item){
			//$data[]=News::getOne($item['id']);
			eval('$item='.Index::$rubricFlip[$item['parent']].'::getOne($item[\'id\']);');
			$data[]=$item;
		}
		return $data;
	}
	public function getOne($id){
		$sql='
			SELECT {{tree}}.*, {{sort}}.countComments, {{sort}}.popularity  FROM {{tree}} 
			LEFT JOIN {{sort}} ON {{tree}}.id={{sort}}.tree
			WHERE {{tree}}.id='.$id.'
		';
		$data=DB::getRow($sql);
		$fields=Fields::getFieldsByTree($id,'wide');
		$data['preview']=$fields['preview'];
		$data['pic']=$fields['files_gal']['image'][0]['path'];
		$data['source']=$fields['source'];
		$data['link']=$fields['link'];
		$data['tags']=News::getTags($id,$data['parent']);
		$data['path']=Tree::getPathToTree($id);
		$data['date']=News::getDate($data['udate']);
		$data['type']='news';
		if($data['countComments']==''){
			$data['countComments']=0;
			$sql='INSERT INTO {{sort}} SET tree='.$id;
			DB::exec($sql);
		}
		$sql='
			SELECT {{tree}}.* FROM {{data}} 
			INNER JOIN {{tree}} ON {{tree}}.id={{data}}.value_text
			WHERE {{data}}.tree='.$id.' AND {{data}}.path=\'author\'
		';
		$author=DB::getRow($sql);
		$author['path']='/persons/'.$author['path'].'/';
		$data['author']=$author;
		return $data;
	}
	public static function getTags($id,$parent){
		$sql='SELECT * FROM {{tree}} WHERE id='.$parent.'';
		$row=DB::getRow($sql);
		$data[]=array(
			'id'=>$row['id'],
			'name'=>$row['name'],
			'path'=>Tree::getPathToTree($row['id']),
		);
		$sql='
			SELECT DISTINCT {{reference}}.* FROM {{reference}} 
			INNER JOIN ( {{relations}} INNER JOIN {{data}} ON {{relations}}.id1={{data}}.id
				) ON {{relations}}.id2={{reference}}.id
			WHERE {{data}}.tree='.$id.' AND {{data}}.path=\'tags\'
			ORDER BY {{reference}}.num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'path'=>$data[0]['path'].'?tag='.$item['path'],
			);
		}
		return $data;
	}
	public static function getRSS(){
		$data=array();
		$id=Tree::getIdTreeByModule('news');
		$sql='SELECT * FROM {{tree}} WHERE parent='.$id.' AND visible=1 ORDER BY udate DESC LIMIT 0,10';
		$list=DB::getAll($sql);
		foreach ($list as $item){
			$field=Fields::getFieldsByTree($item['id']);
			$data[]=array(
				'id'=>$item['id'],
				'name'=>trim(strip_tags($item['name'])),
				'preview'=>strip_tags($field['preview']),
				'path'=>'http:://'.$_SERVER['HTTP_HOST'].'/about/news/'.$item['id'].'/',
				'udate'=>date("D, d M Y H:i:s O",strtotime($item['udate']))
			);
		}
		return array('list'=>$data);
	}
	public static function setSubscribers(){
		DB::escapePost();
		$sql='SELECT email FROM {{subscribers}} WHERE email=\''.$_POST["email"].'\'';
		$email=DB::getOne($sql);
		if($email){
			$text.='<b>Здравствуйте!</b><br />Вы уже зарегистрированы на подписку<br /><br />';
			$text.='Для отказа от подписки пройдите по ссылке <a href="http://'.$_SERVER['HTTP_HOST'].'/confirm/'.md5(News::$delsalt.$email).'">http://'.$_SERVER['HTTP_HOST'].'/confirm/'.md5(News::$delsalt.$email).'</a><br />';
		}else{
			$sql='
				INSERT INTO {{subscribers}}
				SET 
					email=\''.$_POST["email"].'\',
					create_date=NOW()
			';
			DB::exec($sql);
			$text.='<b>Здравствуйте!</b><br />Вы успешно зарегистрированы на подписку на сайте <a href="http://'.$_SERVER['HTTP_HOST'].'">'.$_SERVER['HTTP_HOST'].'</a><br /><br />';
			$text.='Для отказа от подписки пройдите по ссылке <a href="http://'.$_SERVER['HTTP_HOST'].'/confirm/'.md5(News::$delsalt.$email).'">http://'.$_SERVER['HTTP_HOST'].'/confirm/'.md5(News::$delsalt.$email).'</a><br />';
		}
		View::$layout='empty';
		$text=View::getRender('email/newssubscribe',array('text'=>$text));
		$mail=new Email;
		$mail->To($_POST["email"]);
		$mail->Subject('Подписка на новости на сайте '.$_SERVER['HTTP_HOST']);
		$mail->Text($text);
		$mail->Send();
	}
	public static function delSubscribers(){
		$sql='
			DELETE FROM {{subscribers}}
			WHERE MD5(CONCAT(\''.News::$delsalt.'\',email))=\''.end(Funcs::$uri).'\'
		';
		DB::exec($sql);
	}
	public static function tryDelSubscribers(){
		$sql='
			SELECT email FROM {{subscribers}}
			WHERE MD5(CONCAT(\''.News::$delsalt.'\',email))=\''.end(Funcs::$uri).'\'
		';
		return DB::getOne($sql);
	}
	public static function getNext(){
		$tree=Tree::getTreeByUrl();
		$parent=' parent='.$tree['parent'].' AND ';
		if($_GET['ids']){
			$parent=' id IN ('.$_GET['ids'].') AND ';
		}
		$sql='SELECT count(*) FROM {{tree}} WHERE '.$parent.' visible=1 AND id<>'.$tree['id'].'';
		if(DB::getOne($sql)>0){
			$sql='
				SELECT id FROM {{tree}}	
				WHERE '.$parent.' visible=1 AND id<>'.$tree['id'].' AND num>=\''.$tree['num'].'\' 
				ORDER BY num
			';
			$id=DB::getOne($sql);
			if($id){
				return Tree::getPathToTree($id).($_GET['ids']!=''?'?ids='.$_GET['ids']:'');
			}else{
				return Video::getPrev();
			}
		}
	}
	public static function getPrev(){
		$tree=Tree::getTreeByUrl();
		$parent=' parent='.$tree['parent'].' AND ';
		if($_GET['ids']){
			$parent=' id IN ('.$_GET['ids'].') AND ';
		}
		$sql='SELECT count(*) FROM {{tree}} WHERE '.$parent.' visible=1 AND id<>'.$tree['id'].'';
		if(DB::getOne($sql)>0){
			$sql='
				SELECT id FROM {{tree}}	
				WHERE '.$parent.' visible=1 AND id<>'.$tree['id'].' AND num<=\''.$tree['num'].'\'
				ORDER BY num
			';
			$id=DB::getOne($sql);
			if($id){
				return Tree::getPathToTree($id).($_GET['ids']!=''?'?ids='.$_GET['ids']:'');
			}else{
				return Video::getNext();
			}
		}
	}
	public static function getDate($date){
		$data=array('time'=>'','date'=>'');
		if(date('d.m.Y')==date('d.m.Y',strtotime($date))){
			$data['time']=date('H:i',strtotime($date));
			$data['date']='Сегодня';
		}else{
			$data['time']=date('H:i',strtotime($date));
			$data['date']=date('d',strtotime($date)).' '.Funcs::$monthsRus[date('n',strtotime($date))-1];
		}
		return $data;
	}
	public static function getTagsList($id,$element=''){
		$tempList=array();
		$uri=Funcs::$uri;
		if($element)unset($uri[count($uri)-1]);
		$data['list'][]=array(
			'id'=>$row['id'],
			'name'=>'Все',
			'path'=>'/'.implode('/',$uri).'/',
		);
		$sql='
			SELECT DISTINCT {{reference}}.* FROM {{reference}} 
			INNER JOIN ( {{relations}} 
				INNER JOIN ({{data}}
					INNER JOIN {{tree}} ON {{tree}}.id={{data}}.tree
				) ON {{relations}}.id1={{data}}.id
			) ON {{relations}}.id2={{reference}}.id
			WHERE {{tree}}.parent='.$id.' AND {{data}}.path=\'tags\'
			ORDER BY {{reference}}.num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data['list'][]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'path'=>'/'.implode('/',$uri).'/'.'?tag='.$item['path'],
			);
			$tempList[$item['name']]=$item['name'];
		}
		if(isset($tempList[$_GET['tag']])){
			$data['current']=$tempList[$_GET['tag']];
		}else{
			$data['current']='Все';
		}
		$data['tempList']=$tempList;
		return $data;
	}
	public static function getWorkFields($id){
		$data=array();
		$module=Module::getModuleByTree($id);
		$reserveFieldsList=Fields::getFieldsByModule($module['id']);
		foreach($reserveFieldsList as $item){
			$reserveFields[$item['path']]=true;
		}
		$fields=Fields::getFieldsByTree($id);
		if($fields['video'])$data[]=$fields['video'];
		if($fields['pics'])$data[]=$fields['pics'];
		$data[]=$fields['fulltext'];
		foreach($fields as $key=>$item){
			if(!isset($reserveFields[$key])){
				$data[$key]=$item;
			}
		}
		return $data;
	}
	public static function getPersonsComments($id){
		$data=array();
		$sql='
			SELECT {{tree}}.* FROM {{tree}} 
			INNER JOIN ({{data}}
				INNER JOIN {{relations}} ON {{relations}}.id1={{data}}.id
			) ON {{data}}.tree={{tree}}.id
			WHERE {{relations}}.modul1=\'data\' AND {{relations}}.id2='.$id.' AND {{relations}}.modul2=\'tree\'
				AND {{data}}.path=\'newscom\'
			ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$fields=Fields::getFieldsByTree($item['id']);
			$item['preview']=$fields['preview'];
			$item['person']=Persons::getOne($item['parent']);
			$data[]=$item;
		}
		return $data;
	}
	public static function getMore($id){
		$data=array();
		$sql='
			SELECT {{tree}}.* FROM {{tree}} 
			INNER JOIN ({{relations}}
				INNER JOIN {{data}} ON {{data}}.id={{relations}}.id1
			) ON {{relations}}.id2={{tree}}.id
			WHERE {{relations}}.modul1=\'data\' AND {{data}}.tree='.$id.' AND {{relations}}.modul2=\'tree\'
				AND {{data}}.path=\'more\' AND {{tree}}.visible=1
			ORDER BY RAND() LIMIT 0,6
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			eval('$item='.Index::$rubricFlip[$item['parent']].'::getOne($item[\'id\']);');
			$data[]=$item;
		}
		return $data;
	}
	public static function getSimilar($id){
		$data=array();
		$sql='SELECT parent FROM {{tree}} WHERE id='.$id.'';
		$parent=DB::getOne($sql);
		$sql='
			SELECT DISTINCT {{reference}}.* FROM {{reference}} 
			INNER JOIN ( {{relations}} INNER JOIN {{data}} ON {{relations}}.id1={{data}}.id
				) ON {{relations}}.id2={{reference}}.id
			WHERE {{data}}.tree='.$id.' AND {{data}}.path=\'tags\'
			ORDER BY {{reference}}.num
		';
		$list=DB::getAll($sql);
		foreach($list as $item)$tags[]=$item['id'];
		if(!empty($tags)){
			$sql='
				SELECT DISTINCT {{tree}}.* FROM {{tree}} 
				INNER JOIN ( {{data}} 
					INNER JOIN {{relations}} ON {{relations}}.id1={{data}}.id
				) ON {{data}}.tree={{tree}}.id
				WHERE {{tree}}.parent='.$parent.' AND {{tree}}.id<>'.$id.' AND {{data}}.path=\'tags\' AND {{tree}}.visible=1 
					AND {{relations}}.id2 IN ('.implode(',',$tags).')
				ORDER BY {{tree}}.num
			';
			$pp=$_SESSION['perpage'][reset(Funcs::$uri)];
			$_SESSION['perpage'][reset(Funcs::$uri)]=6;
			$list=DB::getPagi($sql);
			$_SESSION['perpage'][reset(Funcs::$uri)]=$pp;
			foreach($list as $item){
				eval('$item='.Index::$rubricFlip[$item['parent']].'::getOne($item[\'id\']);');
				$data[]=$item;
			}
		}
		return $data;
	}
	public static function getDateLink($date){
		$uri=Funcs::$uri;
		unset($uri[count($uri)-1]);
		return '/'.implode('/',$uri).'/?d='.date('Y-m-d',strtotime($date));
	}
}
?>