<?
class Forum{
	public static $mon=array('янв',"фев","мар","апр","мая","июн","июл","авг","сен","окт","ноя","дек");
	public static function getForum(){
		$data=array();
		$sql='SELECT * FROM {{forum}} WHERE parent=0 AND visible=1 ORDER BY num';
		$list=DB::getPagi($sql);
		foreach($list as $items){
			$sql='SELECT * FROM {{forum}} WHERE parent='.$items['id'].' AND visible=1 ORDER BY cdate';
			$sub=DB::getAll($sql);
			$path='/'.Funcs::$uri[0].'/'.Funcs::$uri[1].'/'.$items['path'].'/';
			foreach($sub as $key=>$item){
				$sql='SELECT * FROM {{forum}} WHERE parent='.$item['id'].' AND visible=1 ORDER BY cdate DESC';
				$message=DB::getRow($sql);
				$sub[$key]=array(
					'id'=>$item['id'],
					'name'=>$item['name'],
					'author'=>Forum::getAuthor($message['iuser']),
					'cdatewide'=>Forum::getDate($message['cdate']),
					'count'=>Forum::getCount($item['id']),
					'path'=>$path.$item['id'].'/'
				);
			}
			$data[]=array(
				'id'=>$items['id'],
				'name'=>$items['name'],
				'path'=>$path,
				'list'=>$sub
			);
		}
		return $data;
	}
	public static function getItems(){
		$data=array();
		$sql='SELECT * FROM {{forum}} WHERE parent=0 AND path=\''.Funcs::$uri[2].'\'';
		$data=DB::getRow($sql);
		$sql='SELECT * FROM {{forum}} WHERE parent='.$data['id'].' ORDER BY cdate';
		$list=DB::getPagi($sql);
		$path='/'.Funcs::$uri[0].'/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/';
		$data['list']=array();
		foreach($list as $key=>$item){
			$sql='SELECT * FROM {{forum}} WHERE parent='.$item['id'].' AND visible=1 ORDER BY cdate DESC';
			$message=DB::getRow($sql);
			$data['list'][]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'author'=>Forum::getAuthor($message['iuser']),
				'cdatewide'=>Forum::getDate($message['cdate']),
				'count'=>Forum::getCount($item['id']),
				'path'=>$path.$item['id'].'/'
			);
		}
		$data['seo_title']=$data['name'];
		return $data;
	}
	public static function getList(){
		$data=array();
		$sql='SELECT * FROM {{forum}} WHERE parent=0 AND path=\''.Funcs::$uri[2].'\'';
		$parent=DB::getRow($sql);
		$sql='SELECT * FROM {{forum}} WHERE parent='.$parent['id'].' AND id=\''.Funcs::$uri[3].'\'';
		$data=DB::getRow($sql);
		$data['list'][]=array(
			'id'=>$data['id'],
			'name'=>$data['name'],
			'message'=>$data['message'],
			'author'=>Forum::getAuthor($data['iuser']),
			'cdatewide'=>Forum::getDate($data['cdate']),
			'count'=>Forum::getCount($data['id']),
		);
		$sql='SELECT * FROM {{forum}} WHERE parent='.$data['id'].' ORDER BY cdate';
		$list=DB::getPagi($sql);
		$path='/'.Funcs::$uri[0].'/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/';
		foreach($list as $key=>$item){
			$data['list'][]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'message'=>$item['message'],
				'author'=>Forum::getAuthor($item['iuser']),
				'cdatewide'=>Forum::getDate($item['cdate']),
				'count'=>Forum::getCount($item['id']),
			);
		}
		//$data['rubrics']=Forum::getRubrics();
		$data['seo_title']=$data['name'];
		return $data;
	}
	function add(){
		if($_POST['cap_check']=='yes' && $_SESSION['iuser']['id']){
			if(Funcs::$uri[3]==''){
				$sql='SELECT id FROM {{forum}} WHERE parent=0 AND path=\''.Funcs::$uri[2].'\'';
				$parent=DB::getOne($sql);
			}else{
				$parent=Funcs::$uri[3];
			}
			$sql='
				INSERT INTO {{forum}}
				SET 
					parent='.$parent.',
					iuser=\''.$_SESSION['iuser']['id'].'\',
					name=\''.trim($_POST['name']).'\',
					message=\''.trim($_POST['message']).'\',
					cdate=NOW(),
					visible=1
			';
			DB::exec($sql);
			return false;
		}else{
			return true;
		}
	}
	function edit(){
		$sql='
			UPDATE {{forum}}
			SET 
				name=\''.trim($_POST['name']).'\',
				path=\''.trim($_POST['path']).'\',
				message=\''.trim($_POST['value']).'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	public static function del(){
		if($_SESSION['user']){
			$ids=Tree::getChilds($_GET['id']);
			$ids[]=$_GET['id'];
			$sql='
				DELETE FROM {{forum}} 
				WHERE id IN ('.implode(',',$ids).')
			';
			DB::exec($sql);
		}
	}
	public static function getCount($id){
		$sql='SELECT count(*) FROM {{forum}} WHERE parent='.$id.' AND visible=1';
		return DB::getOne($sql);
	}
	public static function getAuthor($id){
		if($id){
			$sql='SELECT * FROM {{iusers}} WHERE id='.$id.'';
			$data=DB::getRow($sql);
			if(trim($data['fname'])=='' && trim($data['lname'])==''){
				$data['name']='Пользователь';
			}else{
				$data['name']=$data['fname'].' '.$data['lname'];
			}
			return $data;
		}
	}
	public static function getDate($d){
		return date('d',strtotime($d)).' '.Forum::$mon[date('n',strtotime($d))].' '.date('Y',strtotime($d)).' в '.date('H:i',strtotime($d));
	}
	public static function getRubrics(){
		$sql='SELECT * FROM {{forum}} WHERE parent=0 AND visible=1 ORDER BY num';
		return DB::getAll($sql);
	}
	public static function getIndex(){
		$data=array();
		$sql='
			SELECT DISTINCT {{forum}}.* FROM {{forum}} 
			INNER JOIN {{forum}} f ON {{forum}}.id=f.parent
			WHERE {{forum}}.parent<>0
			ORDER BY {{forum}}.cdate DESC
			LIMIT 0,4
		';
		$list=DB::getPagi($sql);
		$path='/help/forum/';
		foreach($list as $key=>$item){
			$sql='SELECT * FROM {{forum}} WHERE parent='.$item['id'].' AND visible=1 ORDER BY cdate DESC';
			$message=DB::getRow($sql);
			$sql='SELECT path FROM {{forum}} WHERE id='.$item['parent'].'';
			$temp=DB::getOne($sql);
			$data[]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'author'=>Forum::getAuthor($message['iuser']),
				'cdatewide'=>Forum::getDate($message['cdate']),
				'count'=>Forum::getCount($item['id']),
				'path'=>$path.$temp.'/'.$item['id'].'/'
			);
		}
		return $data;
	}
}
?>