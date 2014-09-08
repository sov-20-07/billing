<?
class Articles{
	public static $monthsRus=array('янв',"фев","мар","апр","мая","июн","июл","авг","сен","окт","ноя","дек");
	public static $delsalt='del08965ctnv2';
	public function getList($id,$count=''){
		DB::escapeGet();
		$data=array();
		if($count!=''){
			$sql='SELECT * FROM {{tree}} WHERE parent='.$id.' AND visible=1 ORDER BY udate DESC LIMIT 0,'.$count;
			$list=DB::getAll($sql);
		}elseif($_GET['d']){
			$d=explode('-',$_GET['d']);
			$db=date('Y-m-d 00:00:01', strtotime($d[0].'-'.$d[1].'-01 00:00:01'));
			$de=date('Y-m-d 00:00:01', strtotime($d[0].'-'.$d[1].'-01 00:00:01 +1 month'));
			$sql='
				SELECT * FROM {{tree}} 
				WHERE parent='.$id.' AND visible=1 AND (udate BETWEEN \''.$db.'\' AND \''.$de.'\') 
				ORDER BY udate DESC
			';
			$list=DB::getPagi($sql);
		}elseif($_GET['tag']){
			$sql='
				SELECT {{tree}}.* FROM {{tree}}
				INNER JOIN ( {{data}} 
					INNER JOIN ({{relations}} 
						INNER JOIN {{reference}} ON {{relations}}.id2={{reference}}.id
					) ON {{data}}.id={{relations}}.id1
				) ON {{tree}}.id={{data}}.tree
				WHERE {{tree}}.parent='.$id.' AND {{data}}.path=\'tags\' AND {{tree}}.visible=1 AND {{reference}}.name=\''.$_GET['tag'].'\'
				ORDER BY {{tree}}.udate DESC
			';
			$list=DB::getPagi($sql);
		}else{
			$sql='SELECT * FROM {{tree}} WHERE parent='.$id.' AND visible=1 ORDER BY udate DESC';
			$list=DB::getPagi($sql);
		}
		foreach ($list as $item){
			$field=Fields::getFieldsByTree($item['id'],'wide');
			$path=Tree::getPathToTree($item['id']);
			$tags=array();
			$multi=Fields::getMultiFields($item['id']);
			foreach($multi['tags'] as $tag){
				$tags[]=Funcs::$referenceId['tags'][$tag]['name'];
			}
			$data[]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'preview'=>$field['preview'],
				'path'=>$path,
				'udate'=>$item['udate'],
				'day'=>date('d',strtotime($item['udate'])),
				'mon'=>Funcs::$monthsRus[date('n',strtotime($item['udate']))-1],
				'date'=>date('d',strtotime($item['udate'])).' '.Funcs::$monthsRus[date('n',strtotime($item['udate']))-1].' '.date('Y',strtotime($item['udate'])),
				'pic'=>$field['files_gal']['image'][0]['path'],
				'tags'=>$tags
			);
		}
		return $data;
	}
	public function getOne($id){
		$field=Fields::getFieldsByTree($id);
		return $field;
	}
	public static function getTags($id){
		$data=array();
		$sql='
			SELECT DISTINCT {{reference}}.* FROM {{tree}}
			INNER JOIN ( {{data}} 
				INNER JOIN ({{relations}} 
					INNER JOIN {{reference}} ON {{relations}}.id2={{reference}}.id
				) ON {{data}}.id={{relations}}.id1
			) ON {{tree}}.id={{data}}.tree
			WHERE {{tree}}.parent='.$id.' AND {{data}}.path=\'tags\' AND {{tree}}.visible=1
			ORDER BY {{reference}}.num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=$item['name'];
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
			$text.='Для отказа от подписки пройдите по ссылке <a href="http://'.$_SERVER['HTTP_HOST'].'/confirm/'.md5(News::$delsalt.$_POST["email"]).'">http://'.$_SERVER['HTTP_HOST'].'/confirm/'.md5(News::$delsalt.$_POST["email"]).'</a><br />';
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
	public static function getNext($id,$parent,$date){
		$sql='
			SELECT id FROM {{tree}}	
			WHERE parent='.$parent.' AND visible=1 AND id<>'.$id.' AND udate>=\''.date('Y-m-d',strtotime($date)).'\' 
			ORDER BY udate DESC
		';
		$news=DB::getOne($sql);
		if($news){
			return Tree::getPathToTree($news);
		}
	}
	public static function getPrev($id,$parent,$date){
		$sql='
			SELECT id FROM {{tree}}	
			WHERE parent='.$parent.' AND visible=1 AND id<>'.$id.' AND udate<=\''.date('Y-m-d',strtotime($date)).'\' 
			ORDER BY udate DESC
		';
		$news=DB::getOne($sql);
		if($news){
			return Tree::getPathToTree($news);
		}
	}
}
?>